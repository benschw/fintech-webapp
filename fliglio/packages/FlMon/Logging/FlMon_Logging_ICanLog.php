<?php

/**
 * Interface for log drivers.
 * 
 * @package FlMon.Logging
 */
interface FlMon_Logging_ICanLog {

	public function __construct(array $config=array());

	/**
	 * 
	 * Levels:
	 * <code>
	 *     Debug_Logging_Log::ERROR
	 *     Debug_Logging_Log::WARNING
	 *     Debug_Logging_Log::MESSAGE
	 *     Debug_Logging_Log::DEBUG
	 * </code>
	 * 
	 * @param String $level    error level
	 * @param String $message  human message to log
	 */
	public function write($level, $message);

	/**
	 * If there is anything to flush, flush it
	 */
	public function flush();
}