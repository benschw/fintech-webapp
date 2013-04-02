<?php

/**
 * Access & Request tokens
 * 
 * @package FlAuthLib
 */

class Util_OAuth_Token {

	private $key;
	private $secret;

	public function __construct($key, $secret = null) {
		$this->key = $key;
		$this->secret = $secret;
	}

	public static function getNew() {
		return new self(uniqid(), uniqid());
	}

	public function getKey() {
		return $this->key;
	}
	public function getSecret() {
		return $this->secret;
	}


	public function __tostring() {
		return Util_OAuth_Util::buildHttpQuery(array(
			'oauth_token'              => $this->getKey(),
			'oauth_token_secret'       => $this->getSecret(),
		));
	}

}
