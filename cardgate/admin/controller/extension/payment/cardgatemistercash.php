<?php 

include 'cardgate/cardgate.php';

class ControllerExtensionPaymentCardGateMisterCash extends ControllerExtensionPaymentCardGatePlusGeneric {
	public function index() {
		$this->_index('cardgatemistercash');
	}

	public function validate() {
		return $this->_validate('cardgatemistercash');
	}
}
?>