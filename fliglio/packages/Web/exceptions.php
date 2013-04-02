<?php

/**
 * This will be handled to render error page & set 404 code
 * @package Web
 */
class Web_PageNotFoundException extends Exception {}

/**
 * This will be handled to redirect the page and set the specified code
 * (301, 302)
 * @package Web
 * @deprecated use Flfc_RedirectException
 */
class Web_RedirectException extends Exception {

	protected $code;
	protected $location;

	public function __construct($message, $code, $location) {
		parent::__construct($message);
		$this->code     = $code;
		$this->location = $location;
	}

	public function getStatusCode() { 
		return $this->code; 
	}

	public function getLocation() { 
		return $this->location; 
	}
}

class Web_CurlFtpFailureException extends Exception {}

