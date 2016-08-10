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
 * @author      Paul Saparov, <pavel@cardgate.com>
 * @copyright   Copyright (c) 2012 CardGatePlus B.V. (http://www.cardgateideal.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class ControllerPaymentCardGate extends Controller {

    // update plugin version also in admin/controller/payment/cardgate/cardgate.php
    public $version = '2.1.8';

    /**
     * Index action
     */
    public function _index( $payment ) {

        if ( !empty( $_SERVER['CGP_GATEWAY_URL'] ) ) {
            $data['continue'] = $_SERVER['CGP_GATEWAY_URL'];
        } else {
            if ( $this->config->get( $payment . '_test_mode' ) == 'test' ) {
                $data['continue'] = "https://secure-staging.curopayments.net/gateway/cardgate/";
            } else {
                $data['continue'] = "https://secure.curopayments.net/gateway/cardgate/";
            }
        }

        define( 'PLUGIN_VERSION', '3.0' );
        $this->load->language( 'payment/' . $payment );

        $data['button_confirm'] = $this->language->get( 'button_confirm' );
        $data['redirect_message'] = $this->language->get( 'text_redirect_message' );
        $data['text_select_payment_method'] = $this->language->get( 'text_select_payment_method' );
        $data['text_ideal_bank_selection'] = $this->language->get( 'text_ideal_bank_selection' );
        $data['text_ideal_bank_alert'] = $this->language->get( 'text_ideal_bank_alert' );
        $data['text_ideal_bank_options'] = $this->getBankOptions();
        $data['checkout_form_fields'] = $this->getCheckoutFormFields( $payment );

        if ( file_exists( DIR_TEMPLATE . $this->config->get( 'config_template' ) . '/template/payment/' . $payment . '.tpl' ) ) {
            return $this->load->view($this->config->get( 'config_template' ) . '/template/payment/' . $payment . '.tpl', $data);
        } else {     
            return $this->load->view( 'payment/' . $payment . '.tpl', $data );
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

        $calculate = $this->config->get( 'config_tax' );
        $products = $this->cart->getProducts();
        $cartitems = array();
        foreach ( $products as $product ) {
            $price_wt = $this->tax->calculate( $product['price'], $product['tax_class_id'], $calculate );
            $vat_amount = $this->tax->calculate( $product['price'], $product['tax_class_id'], $calculate ) - $product['price'];
            $item = array();
            $item['quantity'] = $product['quantity'];
            $item['sku'] = $product['model'];
            $item['name'] = $product['name'];
            $item['price'] = round( $price_wt * 100, 0 );
            $item['vat_amount'] = round( $vat_amount * 100, 0 );
            $item['vat_inc'] = 1;
            $item['type'] = 1;
            $cartitems[] = $item;
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
            $cartitems[] = $item;
        }

        $field = array();
        $field['siteid'] = $this->config->get( $payment . '_site_id' );
        $field['ref'] = $order_info['order_id'];

        $field['first_name'] = !is_null( $this->customer->getFirstname() ) ?
                $this->customer->getFirstname() : $order_info['payment_firstname'];

        $field['last_name'] = !is_null( $this->customer->getLastname() ) ?
                $this->customer->getLastname() : $order_info['payment_lastname'];

        $field['email'] = !is_null( $this->customer->getEmail() ) ?
                $this->customer->getEmail() : $order_info['email'];

        $field['phone_number'] = !is_null( $this->customer->getTelephone() ) ?
                $this->customer->getTelephone() : $order_info['telephone'];

        if ( !is_null( $address_info['address_1'] ) ) {
            $field['address'] = $address_info['address_1'] .
                    ($address_info['address_2'] ? ', ' . $address_info['address_2'] : '');
        } else {
            $field['address'] = $order_info['payment_address_1'] .
                    ($order_info['payment_address_2'] ? ', ' . $order_info['payment_address_2'] : '');
        }

        $field['city'] = !is_null( $address_info['city'] ) ?
                $address_info['city'] : $order_info['payment_city'];

        $field['country_code'] = !is_null( $address_info['iso_code_2'] ) ?
                $address_info['iso_code_2'] : $order_info['payment_iso_code_2'];

        $field['postal_code'] = !is_null( $address_info['postcode'] ) ?
                $address_info['postcode'] : $order_info['payment_postcode'];

        $field['state'] = !is_null( $address_info['zone'] ) ?
                $address_info['zone'] : $order_info['payment_zone'];

        if ( strtolower( $this->config->get( $payment . '_test_mode' ) ) == 'test' ) {
            $field['test'] = '1';
            $hash_prefix = 'TEST';
        } else {
            $hash_prefix = '';
        }

        $field['extra'] = $payment;
        $field['language'] = $this->config->get( $payment . '_gateway_language' );
        $field['return_url'] = $this->url->link( 'payment/' . $payment . '/success' );
        $field['return_url_failed'] = $this->url->link( 'payment/' . $payment . '/cancel' );
        $field['shop_name'] = 'Opencart';
        $field['shop_version'] = VERSION;
        $field['plugin_name'] = 'Opencart_CardGatePlus';
        $field['plugin_version'] = $this->version;
        $field['currency'] = $order_info['currency_code'];
        $field['amount'] = round( $order_info['total'] * $order_info['currency_value'] * 100 );
        $field['description'] = str_replace( '%id%', $order_info['order_id'], $this->config->get( $payment . '_order_description' ) );
        $field['hash'] = md5( $hash_prefix .
                $this->config->get( $payment . '_site_id' ) .
                $field['amount'] .
                $field['ref'] .
                $this->config->get( $payment . '_hash_key' ) );
        if ( count( $cartitems ) > 0 ) {
            $field['cartitems'] = serialize( $cartitems );
        }
        return $field;
    }

    /**
     * Verify the callback
     * 
     * @param array $data
     * @return boolean
     */
    protected function validate( $data ) {

        $payment = $data['extra'];

        // Load Order model
        $this->load->model( 'checkout/order' );
        $order = $this->model_checkout_order->getOrder( $data['ref'] );
        $currency = $order['currency_code'];
        $amount = round( $order['total'] * $order['currency_value'] * 100, 0 );

        $hashString = (strtolower( $this->config->get( $payment . '_test_mode' ) ) == 'test' ? 'TEST' : '') .
                $data['transaction_id'] .
                $currency .
                $amount .
                $data['ref'] .
                $data['status'] .
                $this->config->get( $payment . '_hash_key' );

        if ( md5( $hashString ) == $data['hash'] ) {
            return true;
        }
        return false;
    }

    /**
     * Setting the Order to intialized mode
     */
    public function _confirm( $payment ) {
        $this->load->language( 'payment/' . $payment );
        $this->load->model( 'checkout/order' );

        $initializedStatus = $this->config->get( $payment . '_payment_initialized_status' );
        $comment = $this->language->get( 'text_payment_initialized' );
        $this->model_checkout_order->addOrderHistory( $this->session->data['order_id'], $initializedStatus, $comment );
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
       
        $data = $_POST;
        if (count($data) == 0){
            die('No callback data to verify!');
        } 
        
        $payment = $data['extra'];
        $this->load->language( 'payment/' . $payment );

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
        $order = $this->model_checkout_order->getOrder( $data['ref'] );

        $complete_status = $this->config->get( $payment . '_payment_complete_status' );

        $comment = '';
        // Process callback
        switch ( $data['status'] ) {
            case "200":
                $status = $complete_status;
                $comment .= $this->language->get( 'text_payment_complete' );
                break;
            case "300":
            case "301":
                $status = $this->config->get( $payment . '_payment_failed_status' );
                $comment .= $this->language->get( 'text_payment_failed' );
                break;
        }

        $comment .= '  ' . $this->language->get( 'text_transaction_nr' );
        $comment .= ' ' . $data['processor_ref'];


        if ( $order['order_status_id'] != $status && $order['order_status_id'] != $complete_status ) {
            $this->model_checkout_order->addOrderHistory( $order['order_id'], $status, $comment, True );
        }

        // Display transaction_id and status
        echo $data['transaction_id'] . '.' . $data['status'];
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
        } else {
            $options = '<option value="0" selected="selected">' . $this->language->get( 'text_ideal_bank_please' ) . '</option>
         <option value="0021">Rabobank</option>
         <option value="0031">ABN Amro</option>
         <option value="0091">Friesland Bank</option>
         <option value="0721">ING</option>
         <option value="0751">SNS Bank</option>
         <option value="0">' . $this->language->get( 'text_ideal_bank_additional' ) . '</option>
         <option value="0161">Van Lanschot Bank</option>
         <option value="0511">Triodos Bank</option>
         <option value="0761">ASN Bank</option>
         <option value="0771">SNS Regio Bank</option>';
        }
        return $options;
    }

    /**
     * Fetch bank options from Card Gate
     */
    function getBankData() {
        $url = 'https://gateway.cardgateplus.com/cache/idealDirectoryRabobank.dat';
        if ( !ini_get( 'allow_url_fopen' ) || !function_exists( 'file_get_contents' ) ) {
            $result = false;
        } else {
            $result = file_get_contents( $url );
        }
        if ( $result ) {
            $aBanks = unserialize( $result );
            $aBanks[0] = '-Maak uw keuze a.u.b.-';
            return $aBanks;
        }
        return $result;
    }

}
