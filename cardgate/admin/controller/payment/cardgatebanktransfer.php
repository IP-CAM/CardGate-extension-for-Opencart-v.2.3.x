<?php 

include 'cardgate/cardgate.php';

class ControllerPaymentCardGateBanktransfer extends ControllerPaymentCardGatePlusGeneric {
	public function index() {
		$this->_index('cardgatebanktransfer');
	}

	public function validate() {
		return $this->_validate('cardgatebanktransfer');
	}
}
?>