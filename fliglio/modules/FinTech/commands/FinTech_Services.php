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
		$sort = $this->paramVal->getNotEmptyField('sort', true);

		$c = new Mongo('localhost');
		$db = $c->selectDB('fintech');

		$markets = array();
		if ($sort == "topp") {
			$txns = $db->Transaction->find();	

			$cnt = array();
			foreach ($txns as $txn) {
				$cnt[$txn['marketId']] = (isset($cnt[$txn['marketId']]) ? $cnt[$txn['marketId']] : 0) + 1;
			}
			sort($cnt);
			$order = array_keys($cnt);

			$cursor = $db->Market->find();	
			$ms = array_values(iterator_to_array($cursor));		

			foreach ($order as $mid) {
				foreach ($ms as $market) {
					if ($market['id'] == $mid) {
						$markets[] = $market;
					}
				}
			}



		} else {	
			$cursor = $db->Market->find();	
			$markets = array_values(iterator_to_array($cursor));		
		}
		
		return new Fltk_JsonView($markets);
	}

	
	
}
