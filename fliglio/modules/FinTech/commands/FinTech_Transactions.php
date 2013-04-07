<?php

/**
 *
 * @package FinTech
 */
class FinTech_Transactions implements Flfc_Routable {
	/**
	 * @var Flfc_Context
	 */
	private $context;

	public function __construct(Flfc_Context $context) {
		$this->context = $context;
		$this->paramVal = clone $this->context->getRequest()->getProp('paramValidator');

		$this->routeVal = clone $this->context->getRequest()->getProp('routeValidator');
	}

	public function getTransactions() {
		$c = new Mongo('localhost');
		$db = $c->selectDB('fintech');

		$cursor = $db->Transaction->find();
		$transactions = array_values(iterator_to_array($cursor));
		return new Fltk_JsonView($transactions);
	}


	public function getMarketTransactions() {
		$c = new Mongo('localhost');
		$db = $c->selectDB('fintech');

		$cursor = $db->Transaction->find(array("marketId" => (int)$this->routeVal->getNotEmptyField('id')));
		$transactions = array_values(iterator_to_array($cursor));
		return new Fltk_JsonView($transactions);
	}

}