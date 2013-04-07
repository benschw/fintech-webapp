<?php

/**
 * @package Svc.Dwolla
 */
class Svc_Dwolla_Service {

	const BASE_URL = 'www.dwolla.com';

	private static $instance;
	private $dwolla;

	public function __construct()
	{
		$this->setUpConnection();
	}

	public static function singleton()
	{
		if (!isset($instance))
		{
			self::$instance = new self();
		}
	}

	private function setUpConnection()
	{
		$this->dwolla = new DwollaRestClient("E/fQa9d2GFCMXAsDKNfiEEqafAERRQaZ50yhXI7tVdV1Iwz6FU", "idjyPFzQrowXtbVqER9wagMKfSkuFyti9gWJpjie8ZXEMkNzu0");
	}

	public function authenticate()
	{
		$url = $this->dwolla->getAuthUrl();
		return $url;
	}

	public function sendMoney($pin, $destination, $amount, $notes = null)
	{
		$this->dwolla->setToken("RfExez5vQmtbNvUf+7KM6GWhB3eWxl9/eYagAmkeaGO3EucWjp");

		$tid = $this->dwolla->send($pin, $destination, $amount, $notes);
		if(!$tid) 
			{ 
				throw new Svc_Dwolla_Exception($this->dwolla->getError()); 
			}
		return $tid;
	}
}