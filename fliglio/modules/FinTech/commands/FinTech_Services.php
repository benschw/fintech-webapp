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

	}

	/**
	 * Foo
	 * CREATE TABLE Foo (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, val VARCHAR(256));
	 *
	 * @return Fltk_JsonView
	 */
	public function getFoo() {
#		$fooDbm = FinTech_MapperRegistry::get()->db()->get('FinTech_Foo');
#		$f = new FinTech_Foo("now it is " . date('l jS \of F Y h:i:s A'));
#		$fooDbm->save($f);
#		$foo = $fooDbm->find($f->getId());
#		assert($f->getVal() === $foo->getVal());
		
		return new Fltk_JsonView(array(
#			"bar" => $foo->getVal()
			"bar" => "baz"
		));
	}
	public function getMarket() {
		$c = new Mongo('localhost');
		$db = $c->selectDB('fintech');

		$market = $db->Market->findOne(array("id" => $this->paramVal->getNotEmptyField('id')));

<<<<<<< HEAD

=======
>>>>>>> 69c50bc8b54da52fcd84f620ba5c47422d23c154
		return new Fltk_JsonView($market);
	}

	public function getMarkets() {
		$c = new Mongo('localhost');
		$db = $c->selectDB('fintech');

		$cursor = $db->Market->find();
		$markets = array_values(iterator_to_array($cursor));
		return new Fltk_JsonView($markets);

		$arr = array();
		
<<<<<<< HEAD
		foreach ($markets as $id => $value) {
			$arr[] = $value;
=======
		foreach ($markets as $id => $market) {
			$arr[] = $market;
>>>>>>> 69c50bc8b54da52fcd84f620ba5c47422d23c154
		}

		return new Fltk_JsonView($arr[0]);
	}

	public function getHistoryItem() {
		return new Fltk_JsonView(array(
			'fbId' 	 	=> 1483899097,
			'time'   	=> time()-60*5,
			'message' 	=> 'Purchased a gift card'
		));
	}


	public function getHistoryItems() {
		return new Fltk_JsonView(array(
			array(
			'fbId' 	 	=> 1483899097,
			'time'   	=> time()-60*5,
			'message' 	=> 'Purchased a gift card'
			),
			array(
			'fbId' 	 	=> 1483899097,
			'time'   	=> time()-60*8,
			'message' 	=> 'Purchased a gift card'
			),
		));
	}
	
	
}
