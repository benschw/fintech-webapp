<?php

class FlMon_Logstash_Publisher {
	private static $_path;
	private static $_instance;
	
	
	private $path;
	
	public function __construct($path) {
		$this->path = $path;
		
		$dir = new Util_Io_File($this->path);
		if (!$dir->exists()) {
			$dir->mkdir(Util_Io_File::DEFAULT_MODE, $recursive=true);
		}
	}

	public static function configure($path) {
		self::$_path    = $path;
	}

	
	public static function get() {
		if (!isset(self::$_instance)) {
			self::$_instance = new self(self::$_path);
		}
		return self::$_instance;
	}
	
	public function publish(FlMon_Logstash_Publishable $message, $logFileName) {
		error_log(
			$message->toEntryString()."\n", 
			3, 
			$this->path . '/' . $logFileName
		);
	}
}
