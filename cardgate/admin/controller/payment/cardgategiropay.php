<?php 

include 'cardgate/cardgate.php';

class ControllerPaymentCardGateGiropay extends ControllerPaymentCardGatePlusGeneric {
	public function index() {
		$this->_index('cardgategiropay');
	}

	public function validate() {
		return $this->_validate('cardgategiropay');
	}
}
?>