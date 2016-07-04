<?php 

include 'cardgate/cardgate.php';

class ControllerPaymentCardGateBitcoin extends ControllerPaymentCardGatePlusGeneric {
	public function index() {
		$this->_index('cardgatebitcoin');
	}

	public function validate() {
		return $this->_validate('cardgatebitcoin');
	}
}
?>