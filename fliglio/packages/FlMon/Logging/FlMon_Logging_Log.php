<?php

/**
 * 
 * @package FlMon.Logging
 */
class FlMon_Logging_Log {
	
	private static $instance;
	
	/* Log Levels */
	const ERROR   = 'FLIGLIO_ERROR';
	const WARNING = 'FLIGLIO_WARNING';
	const MESSAGE = 'FLIGLIO_MESSAGE';
	const DEBUG   = 'FLIGLIO_DEBUG';

	private $drivers = array();
	
	/**
	 * Make the constructor private so the factory method must be used
	 */
	private function __construct() {}
	
	/**
	 * Only work with one logger
	 * 
	 * @return Debug_Logging_Log get the single logger instance
	 */
	public static function get() {
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	/**
	 * Add a log driver (writer) to the logging coordinator (this class)
	 * 
	 * @param Debug_Logging_ICanLog $driver  class to perform log writes (e.g. file or 
	 *        screen)
	 * @param String[] $levels  array of levels this driver acts on (e.g.
	 *        the file logger might not write debug messages depending 
	 *        on the config)
	 */
	public function addDriver(FlMon_Logging_ICanLog $driver, array $levels=null) {
		if (is_null($levels)) {
			$levels = array(self::ERROR, self::WARNING, self::MESSAGE, self::DEBUG);
		}
		$this->drivers[] = array('driver' => $driver, 'levels' => $levels);
	}
	
	/**
	 * Log a message with specified level
	 * @param String $level    error level to log message at
	 * @param String $message  human message to log
	 */
	public function add($level, $msg) {
		$isValid = in_array(
			$level,
			array(self::ERROR, self::WARNING, self::MESSAGE, self::DEBUG)
		);

		if (!$isValid) {
			throw new FlMon_Logging_Exception(sprintf("Log Level: '%s' is not valid", $level));
		}
		// print_r($this->drivers)
		foreach ($this->drivers as $driver) {
			
			if (in_array($level, $driver['levels'])) {
				$driver['driver']->write($level, $msg);
			}
		}
	}
	
	public function flush() {
		foreach ($this->drivers as $driver) {
			$driver['driver']->flush();
		}
	}

	/**
	 * Facade methods to log a message with specific levels
	 */

	public static function error($message) {
		self::get()->add(self::ERROR, $message);
	}

	public static function warning($message) {
		self::get()->add(self::WARNING, $message);
	}

	public static function message($message) {
		self::get()->add(self::MESSAGE, $message);
	}

	public static function debug($message) {
		self::get()->add(self::DEBUG, $message);
	}

}