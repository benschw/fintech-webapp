<?php

/**
 * 
 * @package FlMon.Logging
 */
class FlMon_Logging_ScreenLog implements FlMon_Logging_ICanLog {

	private $buffer = array();
	
	public function __construct(array $config=array()){
	}

	public function write($level, $message) {
		$message        = is_string($message) ? $message : print_r($message, true);
		$this->buffer[] = sprintf("<br /><h2>%s</h2><pre>%s</pre>", $level, $message);
	}
	
	public function flush() {
		echo implode("\n", $this->buffer);
		$this->buffer = array();
	}

}