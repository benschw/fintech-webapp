<?php

/**
 * Static string formating methods
 * 
 * @package Util
 */
class Util_String {

	/**
	 * Formats a number with comma grouped thousands
	 * 
	 * @param number $num  number to be formatted
	 * @return String formatted num
	 */
	public static function numberFormat($num) {
		return number_format($num);
	}
	
	/**
	 * Formats a number to have 2 decimal places
	 * 
	 * @param number $num  number to be formatted
	 * @return String number w/ two decimal places
	 */
	public static function hundredthsFormat($num) {
		return sprintf("%01.2f", $num);
	}
	
	/**
	 * Escape html string
	 * 
	 * @param String raw html
	 * @return String escaped html string
	 */
	public static function htmlEscape($str) {
		throw new Exception("Implement");
	}
	
	/**
	 * Strip non integer characters.
	 * e.g. if a user inputs comma grouped thousands or we would rather
	 * assume an int rather then prompt user to correct their input
	 * 
	 * <code>
	 * echo Util_String::positiveIntegerFilter(-234.3);    // 2343
	 * echo Util_String::positiveIntegerFilter("-2.34,3"); // 2343
	 * </code>
	 * 
	 * @param String $str  number to be formatted
	 * @return String strip anything but integer characters
	 */
	public static function positiveIntegerFilter($str) {
		return preg_replace("/[^0-9]/", "", $str);
	}
	
	/**
	 * Formats a number to have 2 decimal places and commas separating thousands and millions.
	 * 
	 * @param number $str  number to be formatted
	 * @return String number w/ two decimal places and commas
	 */
	public static function currencyFormat($str) {
		return number_format($str, 2);
	}
}



