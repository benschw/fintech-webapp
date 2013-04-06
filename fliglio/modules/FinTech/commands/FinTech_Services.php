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
			'orgName'        => 'Austin Pets Alive',
            'marketName'     => '$25 Gift Cards to Local Restraunts',
            'discription'    => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            'orgImage'       => '/images/logos/austindog.png',
            'seoName'        => 'austin-pets-alive-gift-cards'
		));
	}

	public function getMarketItems() {

		return new Fltk_JsonView(array(
			array(
				'id' => 1,
				'orgName'        => 'Austin Pets Alive',
           		'marketName'     => '$25 Gift Cards to Local Restraunts',
            	'discription'    => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            	'orgImage'       => '/images/logos/austindog.png',
            	'seoName'        => 'austin-pets-alive-gift-cards'
			),
		));
	}
	
	
}
