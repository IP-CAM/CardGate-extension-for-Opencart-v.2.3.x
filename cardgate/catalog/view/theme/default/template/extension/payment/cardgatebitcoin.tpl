<form class="form-horizontal">
  <img style="max-height: 30px;max-width: 70px;" src="./image/payment/cgp/bitcoin.svg" alt="Bitcoin">
 </form>
  <div class="buttons">
  <div class="pull-right">
    <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" data-loading-text="Loading..." class="btn btn-primary" />
  </div>
</div>
<script type="text/javascript"><!--
$('#button-confirm').bind('click', function() {
	$.ajax({
		 url: 'index.php?route=extension/payment/cardgatebitcoin/confirm',
		type: 'get',
		dataType: 'json',
		beforeSend: function() {
			$('#button-confirm').attr('disabled', true);
			$('#payment').before('<div class="alert alert-info"><i class="fa fa-info-circle"></i> Processing, please wait...</div>');
		},
		complete: function() {
			$('.alert').remove();
			$('#button-confirm').attr('disabled', false);
		},
		success: function(json) {
			 if (json['success']) {
             	location = json['redirect'];
             } 
             if (!json['success']) {
             	alert(json['error']);
             }
		}
	});
});
//--></script>