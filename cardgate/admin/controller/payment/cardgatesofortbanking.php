<?php 

include 'cardgate/cardgate.php';

class ControllerPaymentCardGateSofortBanking extends ControllerPaymentCardGatePlusGeneric {
	public function index() {
		$this->_index('cardgatesofortbanking');
	}

	public function validate() {
		return $this->_validate('cardgatesofortbanking');
	}
}
?>