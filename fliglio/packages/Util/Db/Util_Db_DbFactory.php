<?php

/**
 * Factory class to manage & access db driver instance
 * 
 * @package Fl
 */
class Util_Db_DbFactory {
	
	/* Configuration */
	private static $driver;
	private static $connection;

	/* Db Facade instance */
	private static $instance;
	

	/* Configure Driver */
	public static function setDriver(Util_Db_DatabaseDriver $driver) {
		self::$driver = $driver;
	}
	/* Configure Connection */
	public static function setConnection(Util_Db_Connection $connection) {
		self::$connection = $connection;
	}

	/**
	 * Provide access to db library, ensuring that there is only one instance
	 * 
	 * @return Util_Db_DatabaseDriverDecorator db decorator instance
	 */
	public static function get() {
		if (!isset(self::$instance)) {
			self::$instance = new Util_Db_DatabaseDriverDecorator(self::$driver, self::$connection);
		}
		
		return self::$instance;
	}
	
	public static function unsetInstance() {
		self::$instance = null;
	}
}