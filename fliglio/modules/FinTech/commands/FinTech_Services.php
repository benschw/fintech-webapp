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

	  	// access database
		$db = $c->selectDB('fintech');

		$market = $db->Market->findOne(array("id" => $this->paramVal->getNotEmptyField('id', true)));


		return new Fltk_JsonView($market);
	}

	public function getMarkets() {

		return new Fltk_JsonView(array(
			array(
				'id' => 1,
				'orgName'        => 'Austin Pets Alive',
           		'marketName'     => '$25 Gift Cards to Local Restraunts',
            	'discription'    => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            	'orgImage'       => '/images/logos/austindog.png',
            	'seoName'        => 'austin-pets-alive-gift-cards'
			),
			array(
				'id' => 2,
				'orgName'        => 'March of Dimes',
           		'marketName'     => '$25 Gift Cards to Local Restraunts',
            	'discription'    => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            	'orgImage'       => '/images/logos/marchofdimes.png',
            	'seoName'        => 'march-of-dimes'
			),
			array(
				'id' => 3,
				'orgName'        => 'Michael J Fox',
           		'marketName'     => '$25 Gift Cards to Local Restraunts',
            	'discription'    => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            	'orgImage'       => '/images/logos/michaeljfox.png',
            	'seoName'        => 'michael-j-fox'
			),
			array(
				'id' => 4,
				'orgName'        => 'Red Cross',
           		'marketName'     => '$25 Gift Cards to Local Restraunts',
            	'discription'    => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            	'orgImage'       => '/images/logos/redcross.png',
            	'seoName'        => 'red-cross'
			),
			array(
				'id' => 5,
				'orgName'        => 'Stand Up to Cancer',
           		'marketName'     => '$25 Gift Cards to Local Restraunts',
            	'discription'    => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            	'orgImage'       => '/images/logos/standuptocancer.png',
            	'seoName'        => 'stand-up-to-cancer'
			),
			array(
				'id' => 6,
				'orgName'        => 'American Humane',
           		'marketName'     => '$25 Gift Cards to Local Restraunts',
            	'discription'    => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            	'orgImage'       => '/images/logos/americanhumane.png',
            	'seoName'        => 'american-humane'
			),

		));
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
