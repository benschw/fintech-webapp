<?php

/**
 * Error Handler class to convert PHP errors into exceptions
 * 
 * This is set up in Fliglio_Bootstrap
 * <code>
 * set_error_handler(array(new Fl_Core_ErrorHandler(), 'handleError')); 
 * </code>
 * 
 * @package Fl.Core
 */
class Fl_Core_ErrorHandler {

	/**
	 * Convert php error into ErrorException exception
	 * 
	 * @param int num      error code
	 * @param String str   human error message
	 * @param String file  path to file where error occurred
	 * @param int line     line number where file occurred
	 * 
	 * @throws ErrorException  the exception which the php error gets
	 *         packaged in
	 */
	public static function handleError($num, $str, $file, $line) {
	    throw new ErrorException($str, 0, $num, $file, $line);
	}

	public static function register() {
		set_error_handler(array('Fl_Core_ErrorHandler', 'handleError'));
	}
	public static function unregister() {
		restore_error_handler(array('Fl_Core_ErrorHandler', 'handleError'));
	}
}