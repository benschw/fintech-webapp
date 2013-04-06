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

	// public function testSend()
	// {
	// 	$pin			= '1138';
	// 	$destination	= 'susan.rathmann@gmail.com';
	// 	$amount			= 0.01;
	// 	$notes			= 'PHP Library Test';

	// 	$service = new Svc_Dwolla_Service();
	// 	$service->sendMoney($pin, $destination, $amount, $notes);
	// }

	public function testSimpleSend()
	{

		$Dwolla = new DwollaRestClient();
		 
		// Seed a previously generated access token
		// $Dwolla->setToken("I44Cfl8KkFxrxKwig1BjF1XKYNSDY1QIJ6YQhg68N/vqKRO0kG"); // Susi
		$Dwolla->setToken("RfExez5vQmtbNvUf+7KM6GWhB3eWxl9/eYagAmkeaGO3EucWjp"); // Ben

		/**
		 *   Send money ($1.00) to a Dwolla ID 
		 **/
		// $transactionId = $Dwolla->send('1138', '812-734-7288', 0.01); //Susi
		$transactionId = $Dwolla->send('4321', '812-734-7288', 0.01); //Ben

		if(!$transactionId) { echo "Error: {$Dwolla->getError()} \n"; } // Check for errors
		else { echo "Send transaction ID: {$transactionId} \n"; } // Print Transaction ID

	}

}