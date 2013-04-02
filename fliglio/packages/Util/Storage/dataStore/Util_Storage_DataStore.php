<?php

/**
 * Session Wrapper
 * 
 * @package Util.Storage
 */
class Util_Storage_DataStore {
	
	private $values;
	
	public function __construct() {
		$this->values = array();
	}
	
	public function __set($key, $val) {
		$this->values[$key] = $val;
	}

	public function __get($key) {
		if (!$this->__isset($key)) {
			throw new OutOfBoundsException(sprintf("Key '%s' doesn't exist", $key));
		}
		return $this->values[$key];
	}

	public function __isset($key) {
		return isset($this->values[$key]);
	}

	public function __unset($key) {
		unset($this->values[$key]);
	}

}
