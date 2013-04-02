<?php

/**
 *
 * @package Web
 */
class Web_CurlResponse {

	private $content;
	private $httpCode;
	private $effectiveUrl;
	private $errorNumber;
	private $errorMessage;

	public function __construct() {
	
	}

	public function getContent() {
		return $this->content;
	}
	public function getHttpCode() {
		return $this->httpCode;
	}
	public function getEffectiveUrl(){
		return $this->effectiveUrl;
	}
	public function getErrorNumber() {
		return $this->errorNumber;
	}
	public function getErrorMessage() {
		return $this->errorMessage;
	}

	public function setContent($content) {
		$this->content = $content;
	}
	public function setHttpCode($httpCode) {
		$this->httpCode = $httpCode;
	}
	public function setEffectiveUrl($effectiveUrl){
		$this->effectiveUrl = $effectiveUrl;
	}
	public function setErrorNumber($errorNumber) {
		$this->errorNumber = $errorNumber;
	}
	public function setErrorMessage($errorMessage) {
		$this->errorMessage = $errorMessage;
	}

}