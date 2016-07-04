<?php 

include 'cardgate/cardgate.php';

class ControllerPaymentCardGateAfterpay extends ControllerPaymentCardGatePlusGeneric {
	public function index() {
		$this->_index('cardgateafterpay');
	}

	public function validate() {
		return $this->_validate('cardgateafterpay');
	}
}
?>