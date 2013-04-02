<?php

/**
 * HashMap (follows Java api)
 *
 * @package Util
 */
class Util_HashMap {

	private $values;

	/**
	 * Constructs a new HashMap with the same mappings as the specified Map.
	 *
	 * @param array $arr 
	 */
	public function __construct(array $arr=array()) {
		$this->values = $arr;
	}
	
	public function clear() {
		$this->values = array();
	}

	public function isEmpty() {
		return empty($this->values);
	}

	public function containsKey($key) {
		return array_key_exists($key, $this->values);
	}

	public function containsValue($value) {
		return in_array($value, $this->values);
	}
	
	public function get($key) {
		if (!$this->containsKey($key)) {
			throw new OutOfBoundsException(sprintf("Key '%s' doesn't exist", $key));
		}
		return $this->values[$key];
	}
	
	public function put($key, $value) {
		$prevValue = $this->containsKey($key) ? $this->get($key) : null;
		$this->values[$key] = $value;
		return $prevValue;
	}

	public function putAll(array $arr) {
		foreach ($arr as $key => $value) {
			$this->put($key, $value);
		}
	}

	public function remove($key) {
		if (!$this->containsKey($key)) {
			throw new OutOfBoundsException(sprintf("Key '%s' doesn't exist", $key));
		}
		$value = $this->get($key);
		unset($this->values[$key]); 
		return $value;
	}

	public function size() {
		return count($this->values);
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

	public function toUtil_Object() {
		return new Util_Object($this->nativeArray());
	}
	public function toUtil_Array() {
		return new Util_Array($this->nativeArray());
	}
}
