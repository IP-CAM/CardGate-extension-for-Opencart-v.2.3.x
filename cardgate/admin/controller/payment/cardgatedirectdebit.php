<?php 

include 'cardgate/cardgate.php';

class ControllerPaymentCardGateDirectDebit extends ControllerPaymentCardGatePlusGeneric {
	public function index() {
		$this->_index('cardgatedirectdebit');
	}

	public function validate() {
		return $this->_validate('cardgatedirectdebit');
	}
}
?>