<?php 

include 'cardgate/cardgate.php';

class ControllerPaymentCardGateKlarna extends ControllerPaymentCardGatePlusGeneric {
	public function index() {
		$this->_index('cardgateklarna');
	}

	public function validate() {
		return $this->_validate('cardgateklarna');
	}
}
?>