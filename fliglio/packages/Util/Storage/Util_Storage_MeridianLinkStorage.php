<?php

class Util_Storage_MeridianLinkStorage extends Util_Storage_Storage {

	public static function get($storage, $namespace) {
		return new self(new self($storage, $namespace), "meridianLink");
	}
	
	//try to check if the value can be legally stored in the session before setting it
	//TODO: consider moving this up higher in the class hierarchy and/or abstracting it in the base storage class
	public static function legal($value){
		if(is_object($value) && get_class($value) !== 'stdClass'){
			return false;
		} elseif(is_array($value)) {
			return array_reduce($value, create_function('$in,$val', 'return ($in && '.__CLASS__.'::legal($val));'), true);
		} else {
			return true;
		}
	}
	
	public function __set($key, $value){
		//verify value is legal
		if(!self::legal($value)){
			//consider serializing it or something?
			throw new Exception("attempted to store " . get_class($value) . " as $key");
		}
		parent::__set($key, $value);
	}
}