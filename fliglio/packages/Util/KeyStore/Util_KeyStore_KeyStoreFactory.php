<?php


class Util_KeyStore_KeyStoreFactory {
	const TYPE_MEMCACHE = 'memcache';

	public static function get($type, $ns, array $args = array()) {
		switch ($type) {
			case self::TYPE_MEMCACHE :
				return new Util_KeyStore_MemCache_Driver($ns, $args);
				break;
			default:
				throw new Exception("Unknown type: '{$type}'");
		}
	}

}