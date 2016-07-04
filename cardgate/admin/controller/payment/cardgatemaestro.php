<?php 

include 'cardgate/cardgate.php';

class ControllerPaymentCardGateMaestro extends ControllerPaymentCardGatePlusGeneric {
	public function index() {
		$this->_index('cardgatemaestro');
	}

	public function validate() {
		return $this->_validate('cardgatemaestro');
	}
}
?>