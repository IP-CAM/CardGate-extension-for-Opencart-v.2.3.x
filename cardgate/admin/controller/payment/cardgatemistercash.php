<?php 

include 'cardgate/cardgate.php';

class ControllerPaymentCardGateMisterCash extends ControllerPaymentCardGatePlusGeneric {
	public function index() {
		$this->_index('cardgatemistercash');
	}

	public function validate() {
		return $this->_validate('cardgatemistercash');
	}
}
?>