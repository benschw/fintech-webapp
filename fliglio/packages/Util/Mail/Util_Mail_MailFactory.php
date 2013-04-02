<?php

class Util_Mail_MailFactory {
	
	private static $driverFactory;
	
	public static function registerDriverFactory(Util_Mail_MailDriverFactory $driverFactory) {
		self::$driverFactory = $driverFactory;
	}
	
	public static function getDriver() {
		if (!isset(self::$driverFactory)) {
			throw new Util_Mail_Exception("DriverFactory Not Registered");
		}
		return self::$driverFactory->getInstance();
	}
}