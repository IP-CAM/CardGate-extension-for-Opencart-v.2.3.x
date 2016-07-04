<?php 

include 'cardgate/cardgate.php';

class ControllerPaymentCardGateMastercard extends ControllerPaymentCardGatePlusGeneric {
	public function index() {
		$this->_index('cardgatemastercard');
	}

	public function validate() {
		return $this->_validate('cardgatemastercard');
	}
}
?>