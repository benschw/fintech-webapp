<?php

/**
 * 
 * @package FlMon.Logging
 */
class FlMon_Logging_TmpLog implements FlMon_Logging_ICanLog {

	private static $instance;

	private $log = array();

	public function __construct(array $config=array()){
	}

	public static function get() {
		if(!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function write( $level, $message ) {
		$this->log[] = array(
			'level' => $level,
			'message' => $message
		);
		return TRUE;
	}
	
	public function getMessages() {
	
	}
	public function toArray() {
		return $this->log;
	}

	public function flush() {
	}

}