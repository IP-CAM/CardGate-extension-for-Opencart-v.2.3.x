<?php 

include 'cardgate/cardgate.php';

class ControllerPaymentCardGateVisa extends ControllerPaymentCardGatePlusGeneric {
	public function index() {
		$this->_index('cardgatevisa');
	}

	public function validate() {
		return $this->_validate('cardgatevisa');
	}
}
?>