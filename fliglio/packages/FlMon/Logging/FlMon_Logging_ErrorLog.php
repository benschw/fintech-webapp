<?php

/**
 * 
 * @package FlMon.Logging
 */
class FlMon_Logging_ErrorLog implements FlMon_Logging_ICanLog {

	public static $enabled = true;

	public function __construct(array $config=array()){
	}

	public function write($level, $message) {
		$message = is_string($message) ? $message : print_r($message, true);
		self::$enabled && error_log(sprintf("%s\t%s", $level, $message));
	}

	public function flush() {
	}

}