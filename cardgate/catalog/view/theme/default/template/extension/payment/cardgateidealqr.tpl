<form class="form-horizontal">
  <img src="./image/payment/cgp/idealqr.png" alt="iDEAL QR">
 </form>
  <div class="buttons">
  <div class="pull-right">
    <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" data-loading-text="Loading..." class="btn btn-primary" />
  </div>
</div>
<script type="text/javascript"><!--
$('#button-confirm').bind('click', function() {
	$.ajax({
		 url: 'index.php?route=extension/payment/cardgateidealqr/confirm',
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