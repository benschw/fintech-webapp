<?php

/**
 *
 * @package FinTech
 */
class FinTech_Payment implements Flfc_Routable {
	/**
	 * @var Flfc_Context
	 */
	private $context;
	private $paramVal;

	public function __construct(Flfc_Context $context) {
		$this->context = $context;
		
	}
	
	public function send() {
		$this->paramVal = clone $this->context->getRequest()->getProp('paramValidator');
		$pin = $this->paramVal->getNotEmptyField('pin', true);
		$destination = $this->paramVal->getNotEmptyField('destination', true);
		$amount = $this->paramVal->getNotEmptyField('amount', true);
		$notes = $this->paramVal->getNotEmptyField('notes', true);

		$service = new Svc_Dwolla_Service();
		$transactionId = $service->sendMoney($pin, $destination, $amount, $notes);

		if(isset($transactionId))
		{
			return new Fltk_JsonView(array(
				"message" => "success",
				"transactionId" => $transactionId
			));
		}
		else
		{
			return new Fltk_JsonView(array(
				"message" => "fail"
			));
		}
	}	
}
