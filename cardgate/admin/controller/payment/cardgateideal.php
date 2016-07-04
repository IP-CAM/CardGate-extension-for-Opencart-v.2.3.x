<?php 

include 'cardgate/cardgate.php';

class ControllerPaymentCardGateIdeal extends ControllerPaymentCardGatePlusGeneric {
	public function index() {
		$this->_index('cardgateideal');
	}

	public function validate() {
		return $this->_validate('cardgateideal');
	}
}
?>