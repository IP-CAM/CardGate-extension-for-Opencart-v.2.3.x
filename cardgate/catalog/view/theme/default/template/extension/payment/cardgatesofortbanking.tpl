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
        <input type="hidden" name="option" value="directebanking" />
        <img src="./image/payment/cgp/sofortbanking.png" alt="SofortBanking">
    </form>
</div>
<div class="buttons">
  <div class="pull-right">
    <input type="button" value="<?php echo $button_confirm; ?>" id="cardgate-confirm" onclick="redirectClient()" class="btn btn-primary" />
  </div>
</div>

<script type="text/javascript">

    function redirectClient(response) {
        $.ajax({
            type: 'GET',
            url: 'index.php?route=extension/payment/cardgatesofortbanking/confirm',
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
</script>