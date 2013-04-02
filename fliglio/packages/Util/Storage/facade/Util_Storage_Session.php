<?php

class Util_Storage_Session extends Util_Storage_Storage {
	
	const STORAGE_NAMESPACE = 'storage-session';

	public static function singleton() {
		return new self(new Util_Storage_SessionDataStore(), self::STORAGE_NAMESPACE);
	}

	public static function setSessionId($id) {
		Util_Storage_SessionDataStore::setSessionId($id);
	}

}