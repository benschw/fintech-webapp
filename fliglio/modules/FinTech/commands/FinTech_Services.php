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
	public function getMarketItem() {

		return new Fltk_JsonView(array(
			'id' => 1,
			'title' => 'animal things',
			'description' => 'things regarding animals',
			'seoName' => 'animal-things',
			'profileImagePath' => ''
		));
	}

	public function getMarketItems() {

		return new Fltk_JsonView(array(
			array(
				'id' => 1,
				'title' => 'animal things',
				'description' => 'things regarding animals',
				'seoName' => 'animal-things',
				'profileImagePath' => ''
			),
		));
	}
	
	
}
