<?php

/**
 * @package Util
 */
class Util_Array implements Iterator, ArrayAccess {

	private $values = array();

	public function __construct($arr = array()) {
		if (is_array($arr)) {
			$this->values = $arr;
		}
	}
	public function rewind() {
		return reset($this->values);
	}
	public function current() {
		return current($this->values);
	}
	public function key() {
		return key($this->values);
	}
	public function next() {
		next($this->values);
	}
	public function valid() {
		return $this->current() !== false;
	}

	public function length() {
		return $this->count();
	}
	public function count() {
		return count($this->values);
	}


	public function offsetSet($offset, $value) {
		$this->values[$offset] = $value;
	}
	public function offsetUnset($offset) {
		unset($this->values[$offset]);
	}
	public function offsetExists($offset) {
		return isset($this->values[$offset]);
	}
	public function offsetGet($offset) {
		return $this->values[$offset];
	}

	public function push($var) {
		array_push($this->values, $var);
		return $this->count();
	}
	public function pop() {
		return array_pop($this->values);
	}
	public function unshift($var) {
		array_unshift($this->values, $var);
		return $this->count();
	}
	public function shift() {
		return array_shift($this->values);
	}

	public static function toString($arr, $iter = 0) {
		$maxDepth = 15;
		$arr = (array) $arr;
		$txt = '';
		if ($iter <= $maxDepth) {

			$length = 0;
			foreach ($arr as $key => $val) {
				$length = max($length, strlen($key));
			}

			foreach ($arr as $key => $val) {
				if (is_array($val) || is_object($val)) {
					$val = self::arrayToString($val, ++$iter);
				}
				for ($i = strlen($key); $i < $length; $i++) {
					$key = " " . $key;
				}
				$parts   = explode("\n" , $val);
				$padding = "\n   ";
				for ($i = 0; $i < $length; $i++) {
					$padding .= " ";
				}
				$val  = implode($padding, $parts);
				$txt .= sprintf("%s : %s\n", $key, $val);
			}

		} else {
			$txt = '(...)';
		}
		return $txt;
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
	public function toUtil_HashMap() {
		return new Util_HashMap($this->nativeArray());
	}

}

