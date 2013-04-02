<?php

class Util_OAuth_Consumer {
	private $key;
	private $secret;
	
	public function __construct($key, $secret) {
		$this->key = $key;
		$this->secret = $secret;
	}
	
	public function getKey() {
		return $this->key;
	}
	public function getSecret() {
		return $this->secret;
	}
	
}