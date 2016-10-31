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

<div class="buttons">
    <form action="" method="POST" id="cardgate_checkout">
        <input type="hidden" name="option" value="ideal" />     
        <fieldset class="payment">
            <legend><?php echo $text_ideal_bank_selection;  ?></legend>
            <label style="position: relative;" class="method" >
            <img src="./image/payment/cgp/ideal.png" alt="iDEAL">
            </label>
            <label style="position: relative; width: 200px;" class="issuers" for="CGP_IDEAL_ISSUER">
                <select id="CGP_IDEAL_ISSUER" name="suboption">
                    <?php echo $text_ideal_bank_options ?>
                </select>
            </label>
        </fieldset>
    </form>
</div>
<div class="buttons">
  <div class="pull-right">
    <input type="button" value="<?php echo $button_confirm; ?>" id="cardgate_confirm" class="btn btn-primary" />
  </div>
</div>

<script type="text/javascript">
    
    function checkBank() {
        if ($('#CGP_IDEAL_ISSUER').val() == 0) {
            alert('Kies eerst uw iDEAL bank a.u.b.');
        } else {
            redirectClient();
        }
    }

    function redirectClient(response) {
        var issuerId = $('#CGP_IDEAL_ISSUER').val();
        $.ajax({
            type: 'GET',
            url: 'index.php?route=extension/payment/cardgateideal/confirm',
            data:{issuer_id:issuerId},
            beforeSend: function () {
                $('form#cardgate_checkout').hide();
                $('form#cardgate_checkout').before('<div class="attention"><img src="catalog/view/theme/default/image/loading.gif" alt="" /> <?php echo $redirect_message; ?></div>');
            },
            success: function (json){
                if (json['success']){
                    location = json['redirect'];
                }
                if (!json['success']){
                    alert(json['error']);
                }
            }
        });
    }
    $('#cardgate_confirm').bind('click', checkBank);
</script>