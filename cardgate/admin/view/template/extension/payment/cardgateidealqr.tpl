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
                <button type="submit" form="form-cardgateidealqr" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-cardgateidealqr" class="form-horizontal">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $text_general; ?></a></li>
                        <li><a href="#tab-status" data-toggle="tab"><?php echo $text_order_status; ?></a></li>
                        <li><a href="#tab-info" data-toggle="tab"><?php echo $text_info; ?></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab-general">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="entry-total"><span data-toggle="tooltip" title="<?php echo $text_total; ?>"><?php echo $entry_total; ?></span></label>
                                <div class="col-sm-10">
                                    <input type="text" name="cardgateidealqr_total" value="<?php echo $cardgateidealqr_total; ?>" id="entry-total" class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="entry-geo-zone-id"><?php echo $entry_geo_zone; ?></label>
                                <div class="col-sm-10">
                                    <select name="cardgateidealqr_geo_zone_id" id="entry-geo-zone-id" class="form-control">
                                        <option value="0"><?php echo $text_all_zones; ?></option>
                                        <?php foreach ($geo_zones as $geo_zone) { ?>
                                        <?php if ($geo_zone['geo_zone_id'] == $cardgateidealqr_geo_zone_id) { ?>
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
                                    <select name="cardgateidealqr_status" id="entry-plugin-status" class="form-control">
                                        <?php if ($cardgateidealqr_status): ?>
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
                                <label class="col-sm-2 control-label" for="entry-sort-order"><?php echo $entry_sort_order; ?></label>
                                <div class="col-sm-10">
                                    <input type="text" name="cardgateidealqr_sort_order" value="<?php echo $cardgateidealqr_sort_order; ?>" id="entry-sort-order" class="form-control"/>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane " id="tab-info">
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?php echo $text_plugin_version; ?></label>
                                <div class="col-sm-10">
                                    <input type="text" name="cardgateidealqr-plugin-version" value="<?php echo $entry_plugin_version;?>" class="form-control" /> 
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
