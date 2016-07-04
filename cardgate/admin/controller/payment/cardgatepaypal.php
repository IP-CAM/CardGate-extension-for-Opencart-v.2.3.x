<?php 

include 'cardgate/cardgate.php';

class ControllerPaymentCardGatePayPal extends ControllerPaymentCardGatePlusGeneric {
	public function index() {
		$this->_index('cardgatepaypal');
	}

	public function validate() {
		return $this->_validate('cardgatepaypal');
	}
}
?>