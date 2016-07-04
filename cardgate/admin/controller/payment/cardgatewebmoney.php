<?php 

include 'cardgate/cardgate.php';

class ControllerPaymentCardGateWebmoney extends ControllerPaymentCardGatePlusGeneric {
	public function index() {
		$this->_index('cardgatewebmoney');
	}

	public function validate() {
		return $this->_validate('cardgatewebmoney');
	}
}
?>