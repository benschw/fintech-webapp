<?php

class FlMon_Stats_Stats {
	private static $inst;

	private static $host;
	private static $port;
	private static $ns;
	
	public static function configure($host, $port, $ns) {
		self::$host = $host;
		self::$port = $port;
		self::$ns   = $ns;
	}
	
	private function __construct() {}


	public static function get() {
		if (is_null(self::$host)) {
			throw new FlMon_Stats_Exception("Stats Lib not configured");
		}
		if (!isset(self::$inst)) {
			self::$inst = new self();
		}
		return self::$inst;
	}


	public function timing($stat, $time, $sampleRate=1) {
		$this->send($stat, "$time|ms", $sampleRate);
	}
	public function update($stat, $delta=1, $sampleRate=1) {
		$this->send($stat, "$delta|c", $sampleRate);
	}

	public function sendOne($key, $val, $sampleRate) {
		$this->send(array($key => $val), $sampleRate);
	}

	public function send($sampledData, $sampleRate) {
		try {
			$fp = fsockopen("udp://" . self::$host, self::$port, $errno, $errstr);
			if (!$fp) { 
				return; 
			}
			foreach ($sampledData as $stat => $value) {
				fwrite($fp, self::$ns . ".$stat:$value");
		    }
		    fclose($fp);
		} catch (Exception $e) {
		}
	}
	
}