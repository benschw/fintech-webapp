<?php

/**
 * Session Wrapper
 * 
 * @package Util.Storage
 */
class Util_Storage_SessionDataStore extends Util_Storage_DataStore {
	
	private static $isSessionStarted = false;
	
	public function __construct() {
		if (!self::$isSessionStarted) {
			session_start();
			// $e;
			// try {
			// 	throw new Exception("where am i");
			// } catch (Exception $exc) {
			// 	$e = $exc;
			// }
			// error_log("start " . session_id() . " : " . print_r($_SESSION, true) . "\n".(string)$e);
			self::$isSessionStarted = true;
		}
	}
	
	public static function setSessionId( $id ) {
		if (self::$isSessionStarted) {
			session_write_close();
		}
		session_id($id);
		if (self::$isSessionStarted) {
			self::$isSessionStarted = false;
			new self();
		}
	}

	public function __clone() {
		throw new Exception("cannot clone session data store");
	}

	public function __set($key, $val) { // $session->key = $val;
		$_SESSION[$key] = $val;
	}

	public function __get($key) {
		if (!$this->__isset($key)) {
			throw new OutOfBoundsException(sprintf("Key '%s' doesn't exist", $key));
		}
		return $_SESSION[$key];
	}

	public function __isset($key) {
		return isset($_SESSION[$key]);
	}

	public function __unset($key) {
		unset($_SESSION[$key]);
	}

}
