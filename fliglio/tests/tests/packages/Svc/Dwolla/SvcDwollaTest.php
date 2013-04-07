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
		$destination	= '812-713-9234';
		$amount			= 0.01;
		$notes			= 'PHP Library Test';

		$service = new Svc_Dwolla_Service();
		$transactionId = $service->sendMoney($pin, $destination, $amount, $notes);
	}
}