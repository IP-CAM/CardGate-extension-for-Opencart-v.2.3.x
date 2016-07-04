<?php 

include 'cardgate/cardgate.php';

class ControllerPaymentCardGateAmex extends ControllerPaymentCardGatePlusGeneric {
	public function index() {
		$this->_index('cardgateamex');
	}

	public function validate() {
		return $this->_validate('cardgateamex');
	}
}
?>