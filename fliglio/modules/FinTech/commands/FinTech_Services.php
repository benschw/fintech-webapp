<?php

/**
 *
 * @package FinTech
 */
class FinTech_Services implements Flfc_Routable {
	/**
	 * @var Flfc_Context
	 */
	private $context;

	public function __construct(Flfc_Context $context) {
		$this->context = $context;
		$this->paramVal = clone $this->context->getRequest()->getProp('paramValidator');

		$this->routeVal = clone $this->context->getRequest()->getProp('routeValidator');
	}

	public function getMarket() {
		$c = new Mongo('localhost');
		$db = $c->selectDB('fintech');

		$market = $db->Market->findOne(array("id" => (int)$this->routeVal->getNotEmptyField('id')));
		unset($market['_id']);
		return new Fltk_JsonView($market);
	}

	public function getMarkets() {
		$c = new Mongo('localhost');
		$db = $c->selectDB('fintech');

		$cursor = $db->Market->find();
		$markets = array_values(iterator_to_array($cursor));
		return new Fltk_JsonView($markets);
	}
	
}
