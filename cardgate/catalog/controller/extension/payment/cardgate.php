<?php

/**
 * Opencart CardGatePlus payment extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category    Payment
 * @package     Payment_CardGatePlus
 * @author      Richard Schoots, <info@cardgate.com>
 * @copyright   Copyright (c) 2016 CardGatePlus B.V. (http://www.cardgate.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class ControllerExtensionPaymentCardGate extends Controller {

    /**
     * Index action
     */
    public function _index( $payment ) {

        $this->load->language( 'extension/payment/' . $payment );

        $data['button_confirm'] = $this->language->get( 'button_confirm' );
        $data['redirect_message'] = $this->language->get( 'text_redirect_message' );
        $data['text_select_payment_method'] = $this->language->get( 'text_select_payment_method' );
        $data['text_ideal_bank_selection'] = $this->language->get( 'text_ideal_bank_selection' );
        $data['text_ideal_bank_alert'] = $this->language->get( 'text_ideal_bank_alert' );
        $data['text_ideal_bank_options'] = $this->getBankOptions();

        if ( file_exists( DIR_TEMPLATE . $this->config->get( 'config_template' ) . '/template/payment/' . $payment . '.tpl' ) ) {
            return $this->load->view( $this->config->get( 'config_template' ) . '/template/payment/' . $payment . '.tpl', $data );
        } else {
            return $this->load->view( 'extension/payment/' . $payment . '.tpl', $data );
        }
    }

    /**
     * Creates input fields
     * 
     * @return array 
     */
    protected function getCheckoutFormFields( $payment ) {

        $this->load->model( 'checkout/order' );
        $this->load->model( 'account/address' );

        $order_info = $this->model_checkout_order->getOrder( $this->session->data['order_id'] );

        $address_info = $this->model_account_address->getAddress( $this->customer->getAddressId() );
        $amount = round( $order_info['total'] * $order_info['currency_value'] * 100, 0 );


        $calculate = $this->config->get( 'config_tax' );
        $products = $this->cart->getProducts();
        $cart_item_total = 0;
        $cart_items = array();

        $product_query = $this->db->query( "SELECT `name`, `model`, `price`, `quantity`, `tax` / `price` * 100 AS 'tax_rate' FROM `" . DB_PREFIX . "order_product` WHERE `order_id` = " . ( int ) $order_info['order_id'] . " UNION ALL SELECT '', `code`, `amount`, '1', 0.00 FROM `" . DB_PREFIX . "order_voucher` WHERE `order_id` = " . ( int ) $order_info['order_id'] );

        foreach ( $product_query->rows as $product ) {
            $item = array();
            $item['quantity'] = $product['quantity'];
            $item['sku'] = $product['model'];
            $item['name'] = $product['name'];
            $item['price'] = round( $product['price'] * 100, 0 );
            $item['vat'] = round( $product['tax_rate'], 2 );
            $item['vat_inc'] = 0;
            $item['type'] = 1;
            $cart_items[] = $item;
            $cart_item_total += round( $item['quantity'] * $item['price'] * (1 + $item['vat'] / 100) );
        }

        if ( !empty( $this->session->data['shipping_method'] ) ) {
            $shipping_data = $this->session->data['shipping_method'];
            $shipping_wt = $this->tax->calculate( $shipping_data['cost'], $shipping_data['tax_class_id'], $calculate );
            $item = array();
            $item['quantity'] = 1;
            $item['sku'] = $shipping_data['code'];
            $item['name'] = $shipping_data['title'];
            $item['price'] = round( $shipping_wt * 100, 0 );
            $item['vat_amount'] = round( ($shipping_wt - $shipping_data['cost']) * 100, 0 );
            $item['vat_inc'] = 1;
            $item['type'] = 2;
            $cart_items[] = $item;
            $cart_item_total += round( $item['quantity'] * $item['price'] );
        }

        if ( isset( $this->session->data['voucher'] ) && $this->session->data['voucher'] > 0 ) {
            $code = $this->session->data['voucher'];
            $voucher_query = $this->db->query( "SELECT `voucher_id`, `amount` FROM `" . DB_PREFIX . "voucher` WHERE `code` = '" . $code . "'" );
            $voucher = $voucher_query->row;
            $item = array();
            $item['quantity'] = 1;
            $item['sku'] = 'voucher_id_' . $voucher['voucher_id'];
            $item['name'] = 'gift_certificate';
            $item['price'] = round( ( int ) -1 * $voucher['amount'] * 100, 0 );
            $item['vat'] = 0;
            $item['vat_inc'] = 0;
            $item['type'] = 4;
            $cart_items[] = $item;
            $cart_item_total += round( $item['quantity'] * $item['price'] );
        }
        
        if ( isset( $this->session->data['coupon'] ) && $this->session->data['coupon'] > 0 ) {
            $order_id = (int)$this->session->data['order_id'];
            $code = $this->session->data['coupon'];
            $coupon_query = $this->db->query( "SELECT `code`, `value`, `title` FROM `" . DB_PREFIX . "order_total` WHERE `code` = 'coupon' AND `order_id`=".$order_id );
            $coupon = $coupon_query->row;
            $item = array();
            $item['quantity'] = 1;
            $item['sku'] = $coupon['code'];
            $item['name'] = $coupon['title'];
            $item['price'] = round($coupon['value'] * 100, 0 );
            $item['vat'] = 0;
            $item['vat_inc'] = 0;
            $item['type'] = 4;
            $cart_items[] = $item;
            $cart_item_total += round( $item['quantity'] * $item['price'] );
        }

        $item_difference = $amount - $cart_item_total;

        if ( $item_difference != 0 ) {
            $item = array();
            $item['quantity'] = 1;
            $item['sku'] = 'VAT_correction';
            $item['name'] = 'correction';
            $item['price'] = $item_difference;
            $item['vat_amount'] = 0;
            $item['vat_inc'] = 1;
            $item['type'] = 4;
            $cart_items[] = $item;
        }

        if ( !empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif ( !empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        $request = array();
        $request['site_id'] = $this->config->get( 'cardgate_site_id' );
        $request['url_success'] = $this->url->link( 'extension/payment/' . $payment . '/success' );
        $request['url_failure'] = $this->url->link( 'extension/payment/' . $payment . '/cancel' );
        $request['url_callback'] = $this->url->link( 'extension/payment/cardgategeneric/control' );
        $request['reference'] = $order_info['order_id'];
        $request['amount'] = $amount;
        $request['currency_id'] = strtoupper( $order_info['currency_code'] );
        $request['description'] = str_replace( '%id%', $order_info['order_id'], $this->config->get( 'cardgate_order_description' ) );
        $request['ip'] = $ip;
        $request['cartitems'] = $cart_items;

        $request['consumer']['firstname'] = !is_null( $this->customer->getFirstname() ) ?
                $this->customer->getFirstname() : $order_info['payment_firstname'];

        $request['consumer']['lastname'] = !is_null( $this->customer->getLastname() ) ?
                $this->customer->getLastname() : $order_info['payment_lastname'];

        $request['consumer']['email'] = !is_null( $this->customer->getEmail() ) ?
                $this->customer->getEmail() : $order_info['email'];

        $request['consumer']['phone'] = !is_null( $this->customer->getTelephone() ) ?
                $this->customer->getTelephone() : $order_info['telephone'];

        if ( !is_null( $address_info['address_1'] ) ) {
            $request['consumer']['address'] = $address_info['address_1'] .
                    ($address_info['address_2'] ? ', ' . $address_info['address_2'] : '');
        } else {
            $request['consumer']['address'] = $order_info['payment_address_1'] .
                    ($order_info['payment_address_2'] ? ', ' . $order_info['payment_address_2'] : '');
        }

        $request['consumer']['city'] = !is_null( $address_info['city'] ) ?
                $address_info['city'] : $order_info['payment_city'];

        $request['consumer']['country_id'] = !is_null( $address_info['iso_code_2'] ) ?
                $address_info['iso_code_2'] : $order_info['payment_iso_code_2'];

        $request['consumer']['zipcode'] = !is_null( $address_info['postcode'] ) ?
                $address_info['postcode'] : $order_info['payment_postcode'];

        $request['consumer']['state'] = !is_null( $address_info['zone'] ) ?
                $address_info['zone'] : $order_info['payment_zone'];

        $request['version']['shop_name'] = 'Opencart';
        $request['version']['shop_version'] = VERSION;
        $request['version']['plugin_name'] = 'Opencart_CardGatePlus';
        $request['version']['plugin_version'] = $this->config->get( 'cardgate_plugin_version' );
        return $request;
    }

    /**
     * Verify the callback
     * 
     * @param array $data
     * @return boolean
     */
    protected function validate( $data ) {

        $payment = 'cardgate' . $data['pt'];

        // Load Order model
        $this->load->model( 'checkout/order' );
        $order = $this->model_checkout_order->getOrder( $data['reference'] );
        $currency = $order['currency_code'];
        $amount = round( $order['total'] * $order['currency_value'] * 100, 0 );
        if ( '1' == $data['testmode'] ) {
            $sPrefix = 'TEST';
        } else {
            $sPrefix = '';
        }

        $hashString = $sPrefix .
                $data['transaction'] .
                $currency .
                $amount .
                $data['reference'] .
                $data['code'] .
                $this->config->get( 'cardgate_hash_key' );

        if ( md5( $hashString ) == $data['hash'] ) {
            return true;
        }
        return false;
    }

    /**
     * Setting the Order to intialized mode
     */
    public function _confirm( $payment ) {

        $fields = $this->getCheckoutFormFields( $payment );
        if ( $payment == 'cardgateideal' ) {
            $fields['issuer_id'] = $_GET['issuer_id'];
        }

        $payment = substr( $payment, 8 );
        $merchant_id = $this->config->get( 'cardgate_merchant_id' );
        $api_key = $this->config->get( 'cardgate_api_key' );
        $json_data = json_encode( $fields );
        $test = ($this->config->get( 'cardgate_test_mode' ) == 'test' ? true:false);
        $return = $this->send( $merchant_id, $api_key, $this->getUrl($test).'/rest/v1/curo/payment/' . $payment . '/', $json_data );
        $oData = json_decode( $return );

        $json = array();
        if ( $oData->success ) {
            if ( $oData->payment->action == 'redirect' ) {
                $json['success'] = true;
                $json['redirect'] = $oData->payment->url;
                $this->load->language( 'extension/payment/cardgate' );
                $this->load->model( 'checkout/order' );
                $initializedStatus = $this->config->get( 'cardgate_payment_initialized_status' );
                $comment = $this->language->get( 'text_payment_initialized' );
                $this->model_checkout_order->addOrderHistory( $this->session->data['order_id'], $initializedStatus, $comment );
            }
        }

        if ( !$oData->success ) {
            $json['success'] = false;
            $json['error'] = 'CardGate error: ' . $oData->error->message;
        }

        $this->response->addHeader( 'Content-Type: application/json' );
        $this->response->setOutput( json_encode( $json ) );
    }

    public function send( $sMerchant, $sAPI_Key, $sUrl, $sData ) {

        $ch = curl_init();

        curl_setopt( $ch, CURLOPT_URL, $sUrl );
        curl_setopt( $ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
        curl_setopt( $ch, CURLOPT_USERPWD, $sMerchant . ':' . $sAPI_Key );
        curl_setopt( $ch, CURLOPT_PORT, 443 );

        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, TRUE );
        curl_setopt( $ch, CURLOPT_TIMEOUT, 60 );
        curl_setopt( $ch, CURLOPT_HEADER, FALSE );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json'
        ] );

        curl_setopt( $ch, CURLOPT_POST, TRUE );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $sData );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, TRUE ); // verify SSL peer
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 2 ); // check for valid common name and verify host

        $response = curl_exec( $ch );

        if ( !$response ) {
            $result = curl_error( $ch );
        } else {
            $result = $response;
        }

        curl_close( $ch );

        return $result;
    }

    /**
     * After a failed transaction a customer will be send here
     */
    public function cancel() {
        // Load the cart
        $this->response->redirect( $this->url->link( 'checkout/cart' ) );
    }

    /**
     * After a successful transaction a customer will be send here
     */
    public function success() {
        // Clear the cart
        $this->cart->clear();
        $this->response->redirect( $this->url->link( 'checkout/success' ) );
    }

    /**
     * Control URL called by gateway
     */
    public function control() {

        $data = $_GET;
        if ( count( $data ) == 0 ) {
            die( 'No callback data to verify!' );
        }

        $payment = $data['pt'];
        $this->load->language( 'extension/payment/cardgate' );

        $store_name = $this->config->get( 'config_name' );

        // Verify callback hash
        if ( !$this->validate( $data ) ) {
            // notify admin of validation fail
            $mail = new Mail();
            $mail->protocol = $this->config->get( 'config_mail_protocol' );
            $mail->parameter = $this->config->get( 'config_mail_parameter' );
            $mail->hostname = $this->config->get( 'config_smtp_host' );
            $mail->username = $this->config->get( 'config_smtp_username' );
            $mail->password = $this->config->get( 'config_smtp_password' );
            $mail->port = $this->config->get( 'config_smtp_port' );
            $mail->timeout = $this->config->get( 'config_smtp_timeout' );
            $mail->setTo( $this->config->get( 'config_email' ) );
            $mail->setFrom( $this->config->get( 'config_email' ) );
            $mail->setSender( $store_name );
            $mail->setSubject( html_entity_decode( 'Hash check fail ' . $store_name ), ENT_QUOTES, 'UTF-8' );
            $mail->setText( html_entity_decode( 'A payment was not completed because of a hash check fail. Please see the details below.' . print_r( $data, true ) . 'It could be that the amount or currency does not match for this order.', ENT_QUOTES, 'UTF-8' ) );
            $mail->send();
            exit();
        }

        // Load Order model
        $this->load->model( 'checkout/order' );
        $order = $this->model_checkout_order->getOrder( $data['reference'] );

        $complete_status = $this->config->get( 'cardgate_payment_complete_status' );
        $comment = '';


        if ( $data['code'] == '0' || ($data['code'] > '700' && $data['code'] <= '710') ) {
            $status = $this->config->get( 'cardgate_payment_initialized_status' );
            $this->language->get( 'text_payment_initialized' );
            switch ( $data['code'] ) {
                case '700':
                    $comment.= 'Transaction is waiting for user action. ';
                    break;
                case '701':
                    $comment.= 'Waiting for confirmation. ';
                    break;
                case '710':
                    $comment.= 'Waiting for confirmation recurring. ';
                    break;
            }
        }

        if ( $data['code'] >= '200' && $data['code'] < '300' ) {
            $status = $complete_status;
            $comment .= $this->language->get( 'text_payment_complete' );
        }

        if ( $data['code'] >= '300' && $data['code'] < '400' ) {
            if ( $data['code'] == '309' ) {
                $status = $order['order_status_id'];
            } else {
                $status = $this->config->get( 'cardgate_payment_failed_status' );
                $comment .= $this->language->get( 'text_payment_failed' );
            }
        }

        $comment .= '  ' . $this->language->get( 'text_transaction_nr' );
        $comment .= ' ' . $data['transaction'];

        if ( $order['order_status_id'] != $status && $order['order_status_id'] != $complete_status ) {
            $this->model_checkout_order->addOrderHistory( $order['order_id'], $status, $comment, True );
        }

        // Display transaction_id and status
        echo $data['transaction'] . '.' . $data['code'];
    }

    /**
     * Fetch bank option data from cardgate
     */
    public function getBankOptions() {
        $options = '';
        $aOptions = $this->getBankData();
        if ( $aOptions ) {
            foreach ( $aOptions as $key => $value ) {
                $options .= '<option value="' . $key . '">' . $value . '</option>';
            }
        }
        return $options;
    }

    /**
     * Fetch bank options from Card Gate
     */
    function getBankData() {

        $merchant_id = $this->config->get( 'cardgate_merchant_id' );
        $api_key = $this->config->get( 'cardgate_api_key' );
        $test = ($this->config->get( 'cardgate_test_mode' ) == 'test' ? true:false);
        $json_data = json_encode( array() );

        $return = $this->send( $merchant_id, $api_key, $this->getUrl($test).'/rest/v1/curo/ideal/issuers/', $json_data );
        $oData = json_decode( $return );
        $banks = array();
        if ( $oData->success ) {
            $data = $oData->issuers;
            foreach ( $data as $k => $v ) {
                $banks[$v->id] = $v->name;
            }
            return $banks;
        }
        return false;
    }
    
    /**
     * Fetch gateway url
     * @param boolean $test
     * @return string
     */
    private function getUrl($test){
        if ($test){
            return 'https://secure-staging.curopayments.net';
        } else {
            return 'https://secure.curopayments.net';
        }
    }
}
