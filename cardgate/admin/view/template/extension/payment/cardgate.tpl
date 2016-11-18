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
                <button type="submit" form="form-cardgate" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-cardgate" class="form-horizontal">
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
                                    <select name="cardgate_test_mode" id="entry-test-mode" class="form-control">
                                        <?php if ($cardgate_test_mode == "test"): ?>
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
                                    <input type="text" name="cardgate_site_id" value="<?php echo $cardgate_site_id; ?>" placeholder="<?php echo $entry_site_id; ?>" id="entry-site-id" class="form-control" />
                                    <?php if ($error_site_id) { ?>
                                    <div class="text-danger"><?php echo $error_site_id; ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="entry-merchant-id"><span data-toggle="tooltip" title="<?php echo $text_merchant_id; ?>"><?php echo $entry_merchant_id; ?></span></label>
                                <div class="col-sm-10">
                                    <input type="text" name="cardgate_merchant_id" value="<?php echo $cardgate_merchant_id; ?>" placeholder="<?php echo $entry_merchant_id; ?>" id="entry-merchant-id" class="form-control" />
                                    <?php if ($error_merchant_id) { ?>
                                    <div class="text-danger"><?php echo $error_merchant_id; ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="entry-api-key"><span data-toggle="tooltip" title="<?php echo $text_api_key; ?>"><?php echo $entry_api_key; ?></span></label>
                                <div class="col-sm-10">
                                    <input type="text" name="cardgate_api_key" value="<?php echo $cardgate_api_key; ?>" placeholder="<?php echo $entry_api_key; ?>" id="entry-site-id" class="form-control" />
                                    <?php if ($error_api_key) { ?>
                                    <div class="text-danger"><?php echo $error_api_key; ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="entry-order-description"><span data-toggle="tooltip" title="<?php echo $text_order_description; ?>"><?php echo $entry_order_description; ?></span></label>
                                <div class="col-sm-10">
                                    <?php if (!empty($cardgate_order_description)): ?>
                                    <input type="text" name="cardgate_order_description" value="<?php echo $cardgate_order_description; ?>" id="entry-site-id" class="form-control"/>
                                    <?php else: ?>
                                    <input type="text" name="cardgate_order_description" value="Order %id%" id="entry-site-id" class="form-control"/>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="entry-plugin-status"><?php echo $entry_plugin_status; ?></label>
                                <div class="col-sm-10">
                                    <select name="cardgate_status" id="entry-plugin-status" class="form-control">
                                        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-status">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="entry-payment-initialized-status"><?php echo $entry_payment_initialized_status ?></label>
                                <div class="col-sm-10">
                                    <select name="cardgate_payment_initialized_status" id="entry-payment-initialized-status" class="form-control">
                                        <?php foreach ($order_statuses as $order_status) { ?>
                                        <?php if ($order_status['order_status_id'] == $cardgate_payment_initialized_status) { ?>
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
                                    <select name="cardgate_payment_complete_status" id="entry-payment-complete-status" class="form-control">
                                        <?php foreach ($order_statuses as $order_status) { ?>
                                        <?php if ($order_status['order_status_id'] == $cardgate_payment_complete_status) { ?>
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
                                    <select name="cardgate_payment_failed_status" id="entry-payment-failed-status" class="form-control">
                                        <?php foreach ($order_statuses as $order_status) { ?>
                                        <?php if ($order_status['order_status_id'] == $cardgate_payment_failed_status) { ?>
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
                                    <select name="cardgate_payment_fraud_status" id="entry-payment-fraud-status" class="form-control">
                                        <?php foreach ($order_statuses as $order_status) { ?>
                                        <?php if ($order_status['order_status_id'] == $cardgate_payment_fraud_status) { ?>
                                        <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane " id="tab-info">
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?php echo $text_control_url; ?></label>
                                <div class="col-sm-10">
                                    <input type="text" name="cardgate-control-url" value="<?php echo $text_site_url;?>" class="form-control" /> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?php echo $text_plugin_version; ?></label>
                                <div class="col-sm-10">
                                    <input type="text" name="cardgate_plugin_version" value="<?php echo $entry_plugin_version;?>" class="form-control" /> 
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
