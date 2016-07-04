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
 * @copyright   Copyright (c) 2014 CardGatePlus B.V. (http://www.cardgate.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
?><?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-cardgatewebmoney" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a> </div>
            <h1><?php echo $heading_title; ?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        <?php if (isset($error['error_warning'])) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error['error_warning']; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo 'Edit '.$heading_title; ?><br /><br /></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-cardgatewebmoney" class="form-horizontal">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $text_general; ?></a></li>
                        <li><a href="#tab-status" data-toggle="tab"><?php echo $text_order_status; ?></a></li>
                        <li><a href="#tab-info" data-toggle="tab"><?php echo $text_info; ?></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab-general">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="entry-test-mode"><span data-toggle="tooltip" title="<?php echo $text_test_mode_help; ?>"><?php echo $entry_test_mode; ?></span></label>
                                <div class="col-sm-10">
                                    <select name="cardgatewebmoney_test_mode" id="entry-test-mode" class="form-control">
                                        <?php if ($cardgatewebmoney_test_mode == "test"): ?>
                                        <option value="live"><?php echo $text_live_mode; ?></option>
                                        <option value="test" selected="selected"><?php echo $text_test_mode; ?></option>
                                        <?php else: ?>
                                        <option value="live" selected="selected"><?php echo $text_live_mode; ?></option>
                                        <option value="test"><?php echo $text_test_mode; ?></option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="entry-site-id"><span data-toggle="tooltip" title="<?php echo $text_site_id; ?>"><?php echo $entry_site_id; ?></span></label>
                                <div class="col-sm-10">
                                    <input type="text" name="cardgatewebmoney_site_id" value="<?php echo $cardgatewebmoney_site_id; ?>" placeholder="<?php echo $entry_site_id; ?>" id="entry-site-id" class="form-control" />
                                    <?php if ($error_site_id) { ?>
                                    <div class="text-danger"><?php echo $error_site_id; ?></div>
                                    <?php } ?>
                                </div>

                            </div>

                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="entry-hash-key"><span data-toggle="tooltip" title="<?php echo $text_hash_key; ?>"><?php echo $entry_hash_key; ?></span></label>
                                <div class="col-sm-10">
                                    <input type="text" name="cardgatewebmoney_hash_key" value="<?php echo $cardgatewebmoney_hash_key; ?>" id="entry-hash-key" class="form-control" />
                                    <?php if ($error_hash_key) { ?>
                                    <div class="text-danger"><?php echo $error_hash_key; ?></div>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="cardgatewebmoney_gateway_language"><span data-toggle="tooltip" title="<?php echo $text_gateway_language; ?>"><?php echo $entry_gateway_language; ?></span></label>
                                <div class="col-sm-10">
                                    <select name="cardgatewebmoney_gateway_language" id="cardgatewebmoney_gateway_language" class="form-control">
                                        <?php
                                        $lang_options = array(
                                        'nl' => $text_language_dutch,
                                        'en' => $text_language_english,
                                        'de' => $text_language_german,
                                        'fr' => $text_language_french,
                                        'es' => $text_language_spanish,
                                        'gr' => $text_language_greek,
                                        'hr' => $text_language_croatian,
                                        'it' => $text_language_italian,
                                        'cz' => $text_language_czech,
                                        'ru' => $text_language_russian,
                                        'se' => $text_language_swedish,                                    
                                        );
                                        foreach ($lang_options as $key => $text):
                                        ?>
                                        <option value="<?php echo $key?>"<?php echo ($cardgatewebmoney_gateway_language == $key) ? ' selected="selected"':''; ?>><?php echo $text; ?></option>
                                        <?php  endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="entry-order-description"><span data-toggle="tooltip" title="<?php echo $text_order_description; ?>"><?php echo $entry_order_description; ?></span></label>
                                <div class="col-sm-10">
                                    <?php if (!empty($cardgatewebmoney_order_description)): ?>
                                    <input type="text" name="cardgatewebmoney_order_description" value="<?php echo $cardgatewebmoney_order_description; ?>" id="entry-site-id" class="form-control"/>
                                    <?php else: ?>
                                    <input type="text" name="cardgatewebmoney_order_description" value="Order %id%" id="entry-site-id" class="form-control"/>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="entry-total"><span data-toggle="tooltip" title="<?php echo $text_total; ?>"><?php echo $entry_total; ?></span></label>
                                <div class="col-sm-10">
                                    <input type="text" name="cardgatewebmoney_total" value="<?php echo $cardgatewebmoney_total; ?>" id="entry-total" class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="entry-geo-zone-id"><?php echo $entry_geo_zone; ?></label>
                                <div class="col-sm-10">
                                    <select name="cardgatewebmoney_geo_zone_id" id="entry-geo-zone-id" class="form-control">
                                        <option value="0"><?php echo $text_all_zones; ?></option>
                                        <?php foreach ($geo_zones as $geo_zone) { ?>
                                        <?php if ($geo_zone['geo_zone_id'] == $cardgatewebmoney_geo_zone_id) { ?>
                                        <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="entry-plugin-status"><?php echo $entry_plugin_status; ?></label>
                                <div class="col-sm-10">
                                    <select name="cardgatewebmoney_status" id="entry-plugin-status" class="form-control">
                                        <?php if ($cardgatewebmoney_status): ?>
                                        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                        <option value="0"><?php echo $text_disabled; ?></option>
                                        <?php else: ?>
                                        <option value="1"><?php echo $text_enabled; ?></option>
                                        <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-status">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="entry-payment-initialized-status"><?php echo $entry_payment_initialized_status ?></label>
                                <div class="col-sm-10">
                                    <select name="cardgatewebmoney_payment_initialized_status" id="entry-payment-initialized-status" class="form-control">
                                        <?php foreach ($order_statuses as $order_status) { ?>
                                        <?php if ($order_status['order_status_id'] == $cardgatewebmoney_payment_initialized_status) { ?>
                                        <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="entry-payment-complete-status"><?php echo $entry_payment_complete_status ?></label>
                                <div class="col-sm-10">
                                    <select name="cardgatewebmoney_payment_complete_status" id="entry-payment-complete-status" class="form-control">
                                        <?php foreach ($order_statuses as $order_status) { ?>
                                        <?php if ($order_status['order_status_id'] == $cardgatewebmoney_payment_complete_status) { ?>
                                        <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="entry-payment-failed-status"><?php echo $entry_payment_failed_status ?></label>
                                <div class="col-sm-10">
                                    <select name="cardgatewebmoney_payment_failed_status" id="entry-payment-failed-status" class="form-control">
                                        <?php foreach ($order_statuses as $order_status) { ?>
                                        <?php if ($order_status['order_status_id'] == $cardgatewebmoney_payment_failed_status) { ?>
                                        <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="entry-payment-fraud-status"><?php echo $entry_payment_fraud_status ?></label>
                                <div class="col-sm-10">
                                    <select name="cardgatewebmoney_payment_fraud_status" id="entry-payment-fraud-status" class="form-control">
                                        <?php foreach ($order_statuses as $order_status) { ?>
                                        <?php if ($order_status['order_status_id'] == $cardgatewebmoney_payment_fraud_status) { ?>
                                        <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="entry-sort-order"><?php echo $entry_sort_order; ?></label>
                                <div class="col-sm-10">
                                    <input type="text" name="cardgatewebmoney_sort_order" value="<?php echo $cardgatewebmoney_sort_order; ?>" id="entry-sort-order" class="form-control"/>
                                </div>
                            </div>


                        </div>
                        <div class="tab-pane " id="tab-info">
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?php echo $text_control_url; ?></label>
                                <div class="col-sm-10">
                                    <input type="text" name="cardgatewebmoney-control-url" value="<?php echo $text_site_url;?>" class="form-control" /> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?php echo $text_plugin_version; ?></label>
                                <div class="col-sm-10">
                                    <input type="text" name="cardgatewebmoney-plugin-version" value="<?php echo $entry_plugin_version;?>" class="form-control" /> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?php echo $text_author; ?></label>
                                <div class="col-sm-10">
                                    <a href="http://cardgate.com" class="form-control">http://cardgate.com</a> 
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php echo $footer; ?>
