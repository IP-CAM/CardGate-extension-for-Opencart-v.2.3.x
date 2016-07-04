<?php 

include 'cardgate/cardgate.php';

class ControllerPaymentCardGatePrzelewy24 extends ControllerPaymentCardGatePlusGeneric {
	public function index() {
		$this->_index('cardgateprzelewy24');
	}

	public function validate() {
		return $this->_validate('cardgateprzelewy24');
	}
}
?>