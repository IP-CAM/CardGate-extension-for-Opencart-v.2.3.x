<form class="form-horizontal">
  <fieldset id="payment">
  <legend><?php echo $text_ideal_bank_selection;  ?></legend>
  <div class="form-group required">
  	<label class="col-sm-2 control-label" for="CGP_IDEAL_ISSUER"><img src="./image/payment/cgp/ideal.png" alt="iDEAL"></label>
  	<div class="col-sm-10">
  		<select name="suboption" id="CGP_IDEAL_ISSUER" class="form-control">
  			<?php echo $text_ideal_bank_options ?>
  		</select>
  	</div>
  </div>
  </fieldset>
 </form>
  <div class="buttons">
  <div class="pull-right">
    <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" data-loading-text="Loading..." class="btn btn-primary" />
  </div>
</div>
  
<script type="text/javascript"><!--
$('#button-confirm').bind('click', function() {
	var issuerId = $('#CGP_IDEAL_ISSUER').val();
	$.ajax({
		 url: 'index.php?route=extension/payment/cardgateideal/confirm',
		type: 'get',
		data:{issuer_id:issuerId},
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