<?php 

include 'cardgate/cardgate.php';

class ControllerExtensionPaymentCardGateSpraypay extends ControllerExtensionPaymentCardGatePlusGeneric {
	public function index() {
		$this->_index('cardgatespraypay');
	}

	public function validate() {
		return $this->_validate('cardgatespraypay');
	}
}
?>