<?php

/**
 * Clone Utility - used to clone any value (array, obj, string etc...)
 *
 * @package Util
 */
class Util_Clone {

	/**
	 * Clone an Item, regardless of type
	 *
	 * @param * $value 
	 */
	public static function cloneItem($value) {
		$clone = null;
		// clone object
		if (is_object($value)) {
			$clone = self::cloneObject($value);
		// recursively clone array
		} else if (is_array($value)) {
			$clone = self::cloneArray($value);
		// assign just a plain scalar value
		} else {
			$clone = $value;
		}
		return $clone;
	}

	/**
	 * Recursively Clones an array with the help of self::cloneItem()
	 *
	 * @param array $array 
	 * @return array
	 */
	public static function cloneArray(array $array) {
		$clonedArray = array();
		$aKeys       = array_keys($array);
		$aVals       = array_values($array);

		for ($x=0; $x<count($aKeys); $x++) {
			$cloneArray[$aKeys[$x]] = self::cloneItem($aVals[$x]);
		}

		return $clonedArray;
	}

	/**
	 * Clone Object
	 *
	 * @param Object $obj 
	 * @return Object
	 */
	public static function cloneObject($obj) {
		return clone $obj;
	}

}