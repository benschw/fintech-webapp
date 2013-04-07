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

		if($sort == "top")
		{
			$cursor = $db->Transaction->aggregate(array('$group'=> array('_id' => '$marketId', 'totalCount' => array('$sum' => 1))), 
													array('$sort'=>array('totalCount' => -1)));
			$markets = array();
			foreach ($cursor as $id => $value) 
			{
				$markets[] = $db->Market->findOne(array("id" => $id));
			}
		}
		else
		{	
			$cursor = $db->Market->find();	
			$markets = array_values(iterator_to_array($cursor));		
		}
		
		return new Fltk_JsonView($markets);
	}

	
	
}
