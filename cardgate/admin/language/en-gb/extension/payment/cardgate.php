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
 * @copyright   Copyright (c) 2014 CardGatePlus B.V. (http://www.cardgateplus.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

// Heading
$_['heading_title']          = 'Cardgate Generic';

// Text 
$_['text_general']           = 'General';
$_['text_order_status']      = 'Order Status';
$_['text_info']              = 'Info';
$_['text_payment']           = 'Payment';
$_['text_success']           = 'Success: You have modified Cardgate Generic account details!';
$_['text_cardgate']          = '<a onclick="window.open(\'http://www.cardgate.com/\');"><img src="view/image/payment/cardgateplus.png" alt="Cardgate Generic" title="Cardgate Generic" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_test_mode']         = 'Test mode';
$_['text_live_mode']         = 'Live mode';
$_['text_language_dutch']    = 'Dutch';
$_['text_language_english']  = 'English';
$_['text_language_german']   = 'German';
$_['text_language_french']   = 'French';
$_['text_language_spanish']  = 'Spanish';
$_['text_language_greek']    = 'Greek';
$_['text_language_croatian'] = 'Croatian';
$_['text_language_italian']  = 'Italian';
$_['text_language_czech']    = 'Czech';
$_['text_language_russian']  = 'Russian';
$_['text_language_swedish']  = 'Swedish';
$_['text_set_order_status']  = 'Set Order Status';
$_['text_author']            = '<a href="http://www.cardgate.com/" target="_blank">www.cardgate.com</a>';
$_['text_test_mode_help']    = 'Switching between test and live mode. If you don\'t have an account, sign up at http://www.cardgate.com/" .';
$_['text_site_id']           = 'Fill in your Site ID number. You can find your Site ID number at your CardGate Merchant Backoffice.';
$_['text_hash_key']          = 'Fill in your Hashkey. If you use the Hashkey, make sure it is the same as in your CardGate Merchant Backoffice.';
$_['text_merchant_id']       = 'Fill in your Merchant ID number. You can find your Merchant ID number at your CardGate Merchant Backoffice.';
$_['text_api_key']           = 'Fill in you Merchant API Key. This hs been given to you by your account manager';
$_['text_gateway_language']  = 'Setting a default language interface of the gateway.';
$_['text_order_description'] = 'Payment description that will be shown to the customer in the gateway screen. Variables: <b>%id%</b> = Order ID';
$_['text_total']             = 'The checkout total the order must reach before this payment method becomes active.';
$_['text_control_url']       = 'Control Url:';
$_['text_plugin_version']    = 'Plugin version';
$_['text_author']            = 'Author:';

// Entry
$_['entry_test_mode']         = 'Test/Live Mode:';
$_['entry_site_id']           = 'Site ID:';
$_['entry_hash_key']           = 'Hash key:';
$_['entry_merchant_id']       = 'Merchant ID:';
$_['entry_api_key']           = 'Merchant API key:';
$_['entry_payment_methods']   = 'Payment methods:';
$_['entry_gateway_language']  = 'Gateway Language:';
$_['entry_order_description'] = 'Order Description:';
$_['entry_total']             = 'Total:';
$_['entry_geo_zone']          = 'Geo Zone:';

$_['entry_payment_initialized_status'] = 'Payment in progress status:';
$_['entry_payment_complete_status']    = 'Payment complete status:';
$_['entry_payment_failed_status']      = 'Payment failed status:';
$_['entry_payment_fraud_status']       = 'Payment fraud status:';

$_['entry_plugin_status']    = 'Plugin Status:';
$_['entry_sort_order']       = 'Sort Order:';
$_['entry_version_status']   = 'Plugin Version:';
$_['entry_author']           = '<a href="http_//www.cardgate.com">cardgate</a>';

// Error
$_['error_permission']       = 'Warning: You do not have permission to modify payment Card Gate Plus!';
$_['error_site_id']          = 'Site ID Required.';
$_['error_merchant_id']      = 'Merchant ID Required.';
$_['error_api_key']          = 'Merchant API key Required.';
$_['error_payment_method']   = 'Please select at least one payment method.';