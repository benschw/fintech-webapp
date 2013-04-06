<?php

/**
 * @package Svc.Dwolla
 */
class Svc_Dwolla_Service {

	const BASE_URL = 'dwolla.com';

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

	protected function makeRequest($url, $body = null, $headers = array()) {
		$headers[] = "Accept: application/json; charset=utf-8";
		$headers[] = "Content-Type: application/json; charset=utf-8";
		
		$response = new Web_CurlResponse();

		Web_Curl::makeRequest(
			new Web_CurlRequest(
				Web_Curl::METHOD_POST,
				self::BASE_URL.$url,
				json_encode($body),
				$headers
			),
			$response
		);

		if ($response->getErrorNumber()) {
			throw new Svc_Dwolla_CurlErrorException(sprintf(
				"Error (%s) '%s' for '%s'", 
				$response->getErrorNumber(), $response->getErrorMessage(), $url
			));
		}

		return $response->getContent();
	}
}