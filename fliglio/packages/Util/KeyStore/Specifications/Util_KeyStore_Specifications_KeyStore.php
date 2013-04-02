<?php

/**
 * 
 * @package Util.KeyStore.Specifications
 */
interface Util_KeyStore_Specifications_KeyStore {
	
	
	public function __set($key, $val);
	public function __get($key);
	public function __isset($key);
	public function __unset($key);

}
