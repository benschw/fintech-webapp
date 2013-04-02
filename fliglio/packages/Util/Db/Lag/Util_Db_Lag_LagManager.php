<?php

class Util_Db_Lag_LagManager {
	const KEYSTORE_NS = "mysql-lag-cache";
	
	private static $instance;
	
	private $keyStore;
	
	private function __construct() {
		$this->keyStore = Util_KeyStore_KeyStoreFactory::get(
			Util_KeyStore_KeyStoreFactory::TYPE_MEMCACHE, 
			self::KEYSTORE_NS,
			array("expire" => 0)
		);
	}
	
	public static function singleton() {
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}
	}


	public function cacheLag($host, $user, $password) {
		if (!defined("LAG_CACHE_CRON")) {
			throw new Exception('this should only be run by the "lagcacher" cron');
		}

		$lag       = -1;
		$lagPassed = false;

		try {
			$db = new mysqli('localhost', 'my_user', 'my_password', 'my_db');
			if ($db->connect_error) {
			    throw new Exception("Connect Error: ({$db->connect_errno}) {$db->connect_error}");
			}
		
		
			$result = $db->query("SHOW SLAVE STATUS");
			if ($result){
				if ($result->num_rows == 0) {
					throw new Exception("No results returned from query");
				}
			    while ($row = $result->fetch_object()){
			        $user_arr[] = $row;
			    }
		
			    // Free result set
			    $result->close();
			    $db->next_result();
			} else {
				throw new Exception("Query Error: {$db->error}");
			}
		
			$db->close();
			$lagPassed = true;
		} catch (Exception $e) {
		
		}
	}

}