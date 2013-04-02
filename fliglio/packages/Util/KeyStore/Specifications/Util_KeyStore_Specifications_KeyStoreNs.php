<?php


class Util_KeyStore_Specifications_KeyStoreNs {
	
	const NS_PATTERN = "%s_%s";
	
	public static function getNsKey($ns, $key) {
		return sprintf(self::NS_PATTERN, $ns, $key);
	}
	
}