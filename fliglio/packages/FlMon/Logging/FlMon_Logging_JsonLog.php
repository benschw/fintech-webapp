<?php

/**
 * 
 * @package FlMon.Logging
 */
class FlMon_Logging_JsonLog implements FlMon_Logging_ICanLog {

	private $logstash;
	private $logFileName;

	public function __construct(array $config=array()) {
		$this->logstash    = FlMon_Logstash_Publisher::get();
		$this->logFileName = isset($config['file']) ? $config['file'] : "default.log";
	}
	
	public function write($level, $message) {
		$data = array();
		$data['time']    = date("Y.m.d H:i:s", time());
		$data['host']    = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null;
		$data['level']   = $level;
		$data['message'] = $message;

		$this->logstash->publish(new FlMon_Logstash_JsonEntry($data), $this->logFileName);
	}

	public function flush() {
	}

}