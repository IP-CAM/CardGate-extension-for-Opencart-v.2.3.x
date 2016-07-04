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
* @copyright   Copyright (c) 2013 CardGatePlus B.V. (http://www.cardgateplus.com)
* @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
?>
<style type="text/css">
    fieldset {
        border: 1px solid #e3e4e6;
        border: none;
        float: left;
        margin-bottom: 1em;
        margin-right: 0.6em;
        padding: 1em 1em 0 1em;
    }

    fieldset.payment {
        float: none;
        width: inherit;
        padding: 10px 5px 20px 30px;
    }

    legend {
        color: #636466;
        font-size: 1em;
        font-weight: bold;
    }

    label {
        cursor: pointer;
        float: left;
        display: block;
        width: 110px;
        height: 60px;
        padding: 20px 5px 0px 5px;
        margin: 2px;
        text-align: center;
        border: 0px solid #fff;
        -moz-border-radius: 5px; 
        -webkit-border-radius: 5px;
        font-weight: normal;
    }

    label.selected {
        background-color: #E9F1F7;
    }

    label img{
        width: auto;
    }

    label:hover {
        background: #eee;
    }

    label input {
        display: none;
    }
</style>

<div class="buttons">
    <form action="<?php echo $continue; ?>" method="POST" id="cardgate_checkout">
        <?php foreach ($checkout_form_fields as $field => $value): ?>
        <input type="hidden" name="<?php echo $field; ?>" value="<?php echo $value; ?>" />
        <?php endforeach; ?>
        <input type="hidden" name="option" value="creditcard" />
        <img src="./image/cgp/mastercard.png" alt="MasterCard">
    </form>
</div>
<div class="buttons">
  <div class="pull-right">
    <input type="button" value="<?php echo $button_confirm; ?>" id="cardgate-confirm" onclick="redirectClient()" class="btn btn-primary" />
  </div>
</div>

<script type="text/javascript">

    function redirectClient() {
        $.ajax({
            type: 'GET',
            url: 'index.php?route=payment/cardgatemastercard/confirm',
            beforeSend: function() {
                $('form#cardgate_checkout').hide();
                $('form#cardgate_checkout').before('<div class="attention"><img src="catalog/view/theme/default/image/loading.gif" alt="" /> <?php echo $redirect_message; ?></div>');
            },
            success: function() {
                $('form#cardgate_checkout').submit();
            }
        });
    }
</script>