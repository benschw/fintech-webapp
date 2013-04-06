<?php

/**
 * @group int
 */
class SvcDwollaTest extends PHPUnit_Framework_TestCase {
	
	public function testCreateInstance() {
		$service = new Svc_Dwolla_Service();
		$this->assertTrue(isset($service));
	}

	public function testAuthentication()
	{
		$service = new Svc_Dwolla_Service();
		$var = $service->authenticate();
		$this->assertTrue(isset($var));
	}

	public function testSend()
	{
		$pin			= '4321';
		$destination	= 'susan.rathmann@gmail.com';
		$amount			= 0.01;
		$notes			= 'PHP Library Test';

		$service = new Svc_Dwolla_Service();
		$service->sendMoney($pin, $destination, $amount, $notes);
	}

}