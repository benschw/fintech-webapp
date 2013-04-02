<?php

class Fltk_CSSManager {
	protected static $instance;

	protected $paths = array();
	protected $ie6 = array();
	protected $ie7 = array();
	public function __construct() {

	}
	public static function singleton() {
		if (!isset(self::$instance)) {
			$className = __CLASS__;
			self::$instance = new $className;
		}
		return self::$instance;
	}

	public function __clone() {
		throw( new Exception( "cannot clone object, it is singleton" ) );
	}
	
	public function getScripts() {
		$format = '<link rel="stylesheet" type="text/css" href="%s" />';
		$tmp = array();
		foreach( $this->paths AS $path ) {
			$tmp[] = vsprintf( $format, $path );
		}
		return $tmp;
	}
	
	public function getIE6Scripts() {
		$format = '<!--[if lt IE 7]><link rel="stylesheet" type="text/css" href="%s" /><![endif]-->';
		$tmp = array();
		foreach( $this->ie6 AS $path ) {
			$tmp[] = vsprintf( $format, $path );
		}
		return $tmp;
	}
	public function getIE7Scripts() {
		$format = '<!--[if gte IE 7]><link rel="stylesheet" type="text/css" href="%s" /><![endif]-->';
		$tmp = array();
		foreach( $this->ie7 AS $path ) {
			$tmp[] = vsprintf( $format, $path );
		}
		return $tmp;
	}
	

	public function addScript( Web_Uri $script ) {
		if( !in_array( $script, $this->paths ) ) {
			$this->paths[] = $script;
		}
	}
	public function addIE6Script( Web_Uri $script ) {
		if( !in_array( $script, $this->ie6 ) ) {
			$this->ie6[] = $script;
		}
	}
	public function addIE7Script( Web_Uri $script ) {
		if( !in_array( $script, $this->ie7 ) ) {
			$this->ie7[] = $script;
		}
	}


}