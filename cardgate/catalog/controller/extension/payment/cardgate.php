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
    var $version = '2.3.2';
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
     * Check and register the Order and set to intialized mode
     */
    public function _confirm( $payment ) {
        $json = array();
        try {
            include 'cardgate-clientlib-php/init.php';
            $this->load->model( 'checkout/order' );
            $this->load->model( 'account/address' );

            $order_info = $this->model_checkout_order->getOrder( $this->session->data['order_id'] );
            $address_info = $this->model_account_address->getAddress( $this->customer->getAddressId() );

            $amount = ( int ) round( $order_info['total'] * $order_info['currency_value'] * 100, 0 );
            $currency = strtoupper( $order_info['currency_code'] );
            $option = substr( $payment, 8 );

            $oCardGate = new cardgate\api\Client( ( int ) $this->config->get( 'cardgate_merchant_id' ), $this->config->get( 'cardgate_api_key' ), ($this->config->get( 'cardgate_test_mode' ) == 'test' ? TRUE : FALSE ) );
            $oCardGate->setIp( $_SERVER['REMOTE_ADDR'] );
            $oCardGate->setLanguage( $this->language->get('code'));
            $oCardGate->version()->setPlatformName( 'Opencart' );
            $oCardGate->version()->setPlatformVersion( VERSION );
            $oCardGate->version()->setPluginName( 'Opencart_CardGate' );
            $oCardGate->version()->setPluginVersion( $this->version );
            
            $iSiteId = ( int ) $this->config->get( 'cardgate_site_id' );

            $oTransaction = $oCardGate->transactions()->create( $iSiteId, $amount, $currency );

            // Configure payment option.
            $oTransaction->setPaymentMethod( $oCardGate->methods()->get( $option ) );
            if ( 'ideal' == $option ) {
                $oTransaction->setIssuer( $_GET['issuer_id'] );
            }

            // Configure customer.
            $oCustomer = $oTransaction->getCustomer();
            $oCustomer->setEmail( !is_null( $this->customer->getEmail() ) ?
                            $this->customer->getEmail() : $order_info['email']  );
            $oCustomer->address()->setFirstName( !is_null( $this->customer->getFirstname() ) ?
                            $this->customer->getFirstname() : $order_info['payment_firstname']  );
            $oCustomer->address()->setLastName( !is_null( $this->customer->getLastname() ) ?
                            $this->customer->getLastname() : $order_info['payment_lastname']  );
            if ( !is_null( $address_info['address_1'] ) ) {
                $oCustomer->address()->setAddress( $address_info['address_1'] .
                        ($address_info['address_2'] ? ', ' . $address_info['address_2'] : '') );
            } else {
                $oCustomer->address()->setAddress( $order_info['payment_address_1'] .
                        ($order_info['payment_address_2'] ? ', ' . $order_info['payment_address_2'] : '') );
            }
            $oCustomer->address()->setZipCode( !is_null( $address_info['postcode'] ) ?
                            $address_info['postcode'] : $order_info['payment_postcode']  );
            $oCustomer->address()->setCity( !is_null( $address_info['city'] ) ?
                            $address_info['city'] : $order_info['payment_city']  );
            $oCustomer->address()->setCountry( !is_null( $address_info['iso_code_2'] ) ?
                            $address_info['iso_code_2'] : $order_info['payment_iso_code_2']  );

            if ( $this->cart->hasShipping() ) {
                if ( $this->customer->isLogged() ) {
                    $this->load->model( 'account/address' );
                    $shipping_address = $this->session->data['shipping_address'];
                } elseif ( isset( $this->session->data['guest'] ) ) {
                    $shipping_address = $this->session->data['guest']['shipping'];
                }

                $oCustomer->shippingAddress()->setFirstName( $shipping_address['firstname'] );
                $oCustomer->shippingAddress()->setLastName( $shipping_address['lastname'] );
                $oCustomer->shippingAddress()->setAddress( $shipping_address['address_1'] .
                        ($shipping_address['address_2'] ? ', ' . $shipping_address['address_2'] : '') );
                $oCustomer->shippingAddress()->setZipCode( $shipping_address['postcode'] );
                $oCustomer->shippingAddress()->setCity( $shipping_address['city'] );
                $oCustomer->shippingAddress()->setCountry( $shipping_address['iso_code_2'] );
            }

            $calculate = $this->config->get( 'config_tax' );
            $products = $this->cart->getProducts();
            $cart_item_total = 0;
            $vat_total = 0;
            $shipping_tax = 0;
            
            foreach ( $this->cart->getProducts() as $product ) {
                $price = round( $this->tax->calculate( $product['price'], $product['tax_class_id'], FALSE ) * 100, 0 );
                $price_wt = round( $this->tax->calculate( $product['price'], $product['tax_class_id'], TRUE ) * 100, 0 );
                $vat = $this->tax->getTax( $price, $product['tax_class_id'] );
                $vat_perc = round( $vat / $product['price'], 2 );
                $vat_per_item = round( $price_wt - $price, 0 );
                $oItem = $oCart->addItem( \cardgate\api\Item::TYPE_PRODUCT, $product['model'], $product['name'], $product['quantity'], $price_wt );
                $oItem->setVat( $vat_perc );
                $oItem->setVatAmount( $vat_per_item );
                $oItem->setVatIncluded( 1 );
                $vat_total += round( $vat_per_item * $product['quantity'], 0 );
                $cart_item_total += round( $price * $product['quantity'], 0 );
            }

            if ( $this->cart->hasShipping() && !empty( $this->session->data['shipping_method'] ) ) {
                $shipping_data = $this->session->data['shipping_method'];
                $price = round( $this->tax->calculate( $shipping_data['cost'], $shipping_data['tax_class_id'], FALSE ) * 100 );
                $price_wt = round( $this->tax->calculate( $shipping_data['cost'], $shipping_data['tax_class_id'], TRUE ) * 100 );
                $vat = $this->tax->getTax( $shipping_data['cost'], $shipping_data['tax_class_id'] );
                $vat_perc = round( $vat / $shipping_data['cost'], 2 );
                $vat_per_item = round( $price_wt - $price, 0 );
                $shipping_tax = $vat_per_item;
                $oItem = $oCart->addItem( \cardgate\api\Item::TYPE_SHIPPING, $shipping_data['code'], $shipping_data['title'], 1, $price_wt );
                $oItem->setVat( $vat_perc );
                $oItem->setVatAmount( $vat_per_item );
                $oItem->setVatIncluded( 1 );
                $vat_total += $vat_per_item;
                $cart_item_total += round( $price * 1, 0 );
            }

            if ( isset( $this->session->data['voucher'] ) && $this->session->data['voucher'] > 0 ) {
                $code = $this->session->data['voucher'];
                $voucher_query = $this->db->query( "SELECT `voucher_id`, `amount` FROM `" . DB_PREFIX . "voucher` WHERE `code` = '" . $code . "'" );
                $voucher = $voucher_query->row;
                $sku = 'voucher_id_' . $voucher['voucher_id'];
                $price = round( ( int ) -1 * $voucher['amount'] * 100, 0 );
                $oItem = $oCart->addItem( \cardgate\api\Item::TYPE_DISCOUNT, $sku, 'gift_certificate', 1, $price );
                $oItem->setVat( 0 );
                $oItem->setVatIncluded( 0 );
                $cart_item_total += $price;
            }

            if ( isset( $this->session->data['coupon'] ) && $this->session->data['coupon'] > 0 ) {
                $order_id = ( int ) $this->session->data['order_id'];
                $code = $this->session->data['coupon'];
                $coupon_query = $this->db->query( "SELECT `code`, `value`, `title` FROM `" . DB_PREFIX . "order_total` WHERE `code` = 'coupon' AND `order_id`=" . $order_id );
                $coupon = $coupon_query->row;
                $price = round( $coupon['value'] * 100, 0 );
                $oItem = $oCart->addItem( \cardgate\api\Item::TYPE_DISCOUNT, $coupon['code'], $coupon['title'], 1, $price );
                $oItem->setVat( 0 );
                $oItem->setVatIncluded( 0 );
                $cart_item_total += $price;
            }

            $item_difference = $amount - $cart_item_total;

            $aTaxTotals = $this->cart->getTaxes();
            $tax_total = 0;
            foreach ( $aTaxTotals as $total ) {
                $tax_total += $total;
            }

            $tax_total = round( $tax_total * 100, 0 );
            $tax_total += $shipping_tax;

            $tax_difference = $tax_total - $vat_total;

            if ( $tax_difference != 0 ) {
                $item = array();
                $price = $tax_difference;
                $oItem = $oCart->addItem( \cardgate\api\Item::TYPE_PAYMENT, 'VAT_correction', 'correction', 1, $tax_difference );
                $oItem->setVat( 100 );
                $oItem->setVatAmount( $tax_difference );
                $oItem->setVatIncluded( 1 );
            }
            $item_difference = $amount - $cart_item_total - $vat_total - $tax_difference;

            if ( $item_difference != 0 ) {
                $item = array();
                $price = $item_difference;
                $oItem = $oCart->addItem( \cardgate\api\Item::TYPE_PRODUCT, 'pr_correction', 'correction', 1, $item_difference );
                $oItem->setVat( 0 );
                $oItem->setVatAmount( 0 );
                $oItem->setVatIncluded( 1 );
            }
            $oTransaction->setCallbackUrl( $this->url->link( 'extension/payment/cardgategeneric/control' ) );
            $oTransaction->setSuccessUrl( $this->url->link( 'extension/payment/' . $payment . '/success' ) );
            $oTransaction->setFailureUrl( $this->url->link( 'extension/payment/' . $payment . '/cancel' ) );
            $oTransaction->setReference( $order_info['order_id'] );
            $oTransaction->setDescription( str_replace( '%id%', $order_info['order_id'], $this->config->get( 'cardgate_order_description' ) ) );
            $oTransaction->register();

            $sActionUrl = $oTransaction->getActionUrl();

            if ( NULL !== $sActionUrl ) {

                $json['success'] = true;
                $json['redirect'] = trim( $sActionUrl );
                $this->load->language( 'extension/payment/cardgate' );
                $this->load->model( 'checkout/order' );

                $initializedStatus = $this->config->get( 'cardgate_payment_initialized_status' );
                $comment = $this->language->get( 'text_payment_initialized' );
                $this->model_checkout_order->addOrderHistory( $this->session->data['order_id'], $initializedStatus, $comment );
            } else {
                $json['success'] = false;
                $json['error'] = 'CardGate error: ' . htmlspecialchars( $oException_->getMessage() );
            }
        } catch ( cardgate\api\Exception $oException_ ) {
            $json['success'] = false;
            $json['error'] = 'CardGate error: ' . htmlspecialchars( $oException_->getMessage() );
        }

        $this->response->addHeader( 'Content-Type: application/json' );
        $this->response->setOutput( json_encode( $json ) );
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

        $data = $_REQUEST;

        // mail('richard@cardgate.com','data', print_r(array_values($data),true));

        try {

            include 'cardgate-clientlib-php/init.php';
            $sSiteKey = $this->config->get( 'cardgate_hash_key' );

            $oCardGate = new cardgate\api\Client( ( int ) $this->config->get( 'cardgate_merchant_id' ), $this->config->get( 'cardgate_api_key' ), ($this->config->get( 'cardgate_test_mode' ) == 'test' ? TRUE : FALSE ) );
            $oCardGate->setIp( $_SERVER['REMOTE_ADDR'] );

            if ( FALSE == $oCardGate->transactions()->verifyCallback( $data, $sSiteKey ) ) {
                $store_name = $this->config->get( 'config_name' );
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
                die( 'invalid callback' );
            } else {
                $this->load->language( 'extension/payment/cardgate' );
                $this->load->model( 'checkout/order' );
                $order = $this->model_checkout_order->getOrder( $data['reference'] );
                $complete_status = $this->config->get( 'cardgate_payment_complete_status' );
                $comment = '';

                $waiting = false;
                if ( $data['code'] == '0' || ($data['code'] >= '700' && $data['code'] <= '710') ) {
                    $waiting = true;
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

                if ( ($order['order_status_id'] != $status && $order['order_status_id'] != $complete_status) || ($waiting = true && $order['order_status_id'] != $complete_status) ) {
                    $this->model_checkout_order->addOrderHistory( $order['order_id'], $status, $comment, true );
                }

                // Display transaction_id and status
                echo $data['transaction'] . '.' . $data['code'];
            }
        } catch ( cardgate\api\Exception $oException_ ) {
            echo htmlspecialchars( $oException_->getMessage() );
        }
    }

    /**
     * Fetch bank option data from cardgate
     */
    public function getBankOptions() {

        try {

            include 'cardgate-clientlib-php/init.php';

            $oCardGate = new cardgate\api\Client( ( int ) $this->config->get( 'cardgate_merchant_id' ), $this->config->get( 'cardgate_api_key' ), ($this->config->get( 'cardgate_test_mode' ) == 'test' ? TRUE : FALSE ) );
            $oCardGate->setIp( $_SERVER['REMOTE_ADDR'] );

            $aIssuers = $oCardGate->methods()->get( cardgate\api\Method::IDEAL )->getIssuers();
        } catch ( cardgate\api\Exception $oException_ ) {
            $aIssuers[0] = ['id' => 0, 'name' => htmlspecialchars( $oException_->getMessage() ) ];
        }

        $options = '';
        foreach ( $aIssuers as $aIssuer ) {
            $options .= '<option value="' . $aIssuer['id'] . '">' . $aIssuer['name'] . '</option>';
        }
        return $options;
    }

    public function returnJson( $message ) {
        $json = array();
        $json['success'] = false;
        $json['error'] = $message;
        $this->response->addHeader( 'Content-Type: application/json' );
        $this->response->setOutput( json_encode( $json ) );
    }

}
