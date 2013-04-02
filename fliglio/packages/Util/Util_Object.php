<?php

/**
 * Works like stdClass but with keys() method
 * 
 * @package Util
 */
class Util_Object {
	
	/* store magic properties */
	protected $values = array();
	
	public function __set( $key, $val ) {
		$this->values[$key] = $val;
	}

	public function __get( $key ) {
		return $this->values[$key];
	}

	public function __isset( $key ) {
		return isset( $this->values[$key] );
	}
	
	public function __unset($key) {
		unset($this->values[$key]);
	}
	

	public function keys() {
		return array_keys($this->values);
	}
	public function values() {
		return array_values($this->values);
	}
	public function toArray() {
		return $this->values;
	}

	public function toUtil_HashMap() {
		return new Util_HashMap($this->nativeArray());
	}
	public function toUtil_Array() {
		return new Util_Array($this->toArray());
	}

}
