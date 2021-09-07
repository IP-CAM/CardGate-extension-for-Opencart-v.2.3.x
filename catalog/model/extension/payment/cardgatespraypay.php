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
 * @copyright   Copyright (c) 2012 CardGatePlus B.V. (http://www.cardgateplus.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class ModelExtensionPaymentCardGateSpraypay extends Model {

    public function getMethod( $address, $total ) {

        $this->load->language( 'extension/payment/cardgatespraypay' );

        $query = $this->db->query( "SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . ( int ) $this->config->get( 'cardgatespraypay_geo_zone_id' ) . "' AND country_id = '" . ( int ) $address['country_id'] . "' AND (zone_id = '" . ( int ) $address['zone_id'] . "' OR zone_id = '0')" );

        if ( $this->config->get( 'cardgatespraypay_total' ) > $total ) {
            $status = false;
        } elseif ( !$this->config->get( 'cardgatespraypay_geo_zone_id' ) ) {
            $status = true;
        } elseif ( $query->num_rows ) {
            $status = true;
        } else {
            $status = false;
        }

        $title = $this->language->get( 'text_title' );

        $method_data = array();
        if ( $status ) {
            
            $method_data = array(
                'code' => 'cardgatespraypay',
                'title' => $title,
                'terms' => '',
                'sort_order' => $this->config->get( 'cardgatespraypay_sort_order' )
            );
        }

        return $method_data;
    }
}
