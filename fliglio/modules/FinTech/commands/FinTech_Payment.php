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
		$pin = $this->paramVal->getNotEmptyField('pin');
		// $destination = $this->paramVal->getNotEmptyField('destination', true);
		// $amount = $this->paramVal->getNotEmptyField('amount', true);
		// $notes = $this->paramVal->getNotEmptyField('notes', true);
		$marketItemId = $this->paramVal->getNotEmptyField('id');

		$c = new Mongo('localhost');
		$db = $c->selectDB('fintech');

		$market = $db->Market->findOne(array("id" => (int)$marketItemId));
		$user = $db->User->findOne(array("id" => (int)$market['userId']));
		$destination = $user['dwollaId'];
		$amount = $market['currentPrice'];
		$notes = "";

		try 
		{
			$transactionId = 0;
			try {
				$service = new Svc_Dwolla_Service();
				$transactionId = $service->sendMoney($pin, $destination, $amount, $notes);
			} catch (Exception $e) {
				//pass for demo
			}	
			$market = $db->Market->update(array("id" => (int)$marketItemId), array('$set' => array("currentPrice" => $market['currentPrice'] + .01)));

			$sess = Util_Storage_Session::singleton();
			$db->Transaction->insert(array("fbId" => $sess->oauth_id, "marketId" => (int)$marketItemId, "userId" => 2, "time" => time(), 'message' => $sess->firstName + " purchased an item"));

			return new Fltk_JsonView(array(
				"message" => "success",
				"transactionId" => $transactionId
			));
		}
		catch(Svc_Dwolla_Exception $e)
		{
			return new Fltk_JsonView(array(
				"message" => "fail",
				"err" => $e->getMessage()
			));
		}
	}	
}
