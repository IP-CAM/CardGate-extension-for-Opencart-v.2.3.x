<?php 

include 'cardgate/cardgate.php';

class ControllerPaymentCardGateVpay extends ControllerPaymentCardGatePlusGeneric {
	public function index() {
		$this->_index('cardgatevpay');
	}

	public function validate() {
		return $this->_validate('cardgatevpay');
	}
}
?>