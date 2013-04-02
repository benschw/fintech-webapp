<?php

class Util_KeyStore_MemCache_Driver implements Util_KeyStore_Specifications_KeyStore {
	private static $host;
	private static $port;
	private static $connection;
	
	private static $defaultExpire = 0; // forever, but not guaranteed; can explicitely set up to 2592000 (30 days)
	
	private $ns;
	private $memCache;
	private $expire;
		
	public static function configure($host, $port) {
		self::$host = $host;
		self::$port = $port;
	}
	
	private static function getConnection() {
		if (!isset(self::$host) || !isset(self::$port)) {
			throw new Exception("Util_KeyStore_MemCache_Driver not configured");
		}
		if (!isset(self::$instance)) {
			self::$connection = new Memcache();
			if (!self::$connection->connect(self::$host, self::$port)) {
				throw new Exception("Counldn't connect to memcache server");
			}
		}
		return self::$connection;
	}
	
	
	public function __construct($ns, array $args = array()) {
		$this->ns = $ns;
		$this->expire = isset($args['expire']) ? $args['expire'] : self::$defaultExpire;
		
		$this->memCache = self::getConnection();
	}

	public function __set($key, $val) {
		if (!$this->replace($key, $val)) {
			return $this->memCache->add(
				Util_KeyStore_Specifications_KeyStoreNs::getNsKey($this->ns, $key),
				$val,
				MEMCACHE_COMPRESSED,
				$this->expire
			);
		}
		return true;
	}
	
	private function replace($key, $val) {
		return $this->memCache->replace(
			Util_KeyStore_Specifications_KeyStoreNs::getNsKey($this->ns, $key),
			$val,
			MEMCACHE_COMPRESSED,
			$this->expire
		);
	}
	
	public function __get($key) {
		return $this->memCache->get(
			Util_KeyStore_Specifications_KeyStoreNs::getNsKey($this->ns, $key)
		);
		
	}
	public function __isset($key) {
		return $this->memCache->get(
			Util_KeyStore_Specifications_KeyStoreNs::getNsKey($this->ns, $key)
		) !== false;
	
	}
	public function __unset($key) {
		return $this->memCache->delete(
			Util_KeyStore_Specifications_KeyStoreNs::getNsKey($this->ns, $key)
		);
	
	}

}