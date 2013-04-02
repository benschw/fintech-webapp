<?php

class Flfc_RedirectException extends Exception {

	protected $code;
	protected $location;
	public function __construct( $message, $code, $location ) {
		parent::__construct( $message );
		$this->code = $code;
		$this->location = $location;
	}
	public function getStatusCode() { return $this->code; }
	public function getLocation() { return $this->location; }
}

class Flfc_PageNotFoundException extends Exception {}

class Flfc_CommandNotFoundException extends Exception {}

class Flfc_ResponseException extends Exception {}

class Flfc_CommandNotRoutable extends Exception {}
	
class Flfc_InternalRedirectException extends Exception {
	private $url;
	public function __construct($url) {
		$this->url = $url;
	}
	public function getUrl() {
		return $this->url;
	}
}