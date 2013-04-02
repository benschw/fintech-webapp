<?php

class Fltk_JSManager {
	protected static $instance;

	protected $paths = array();
	protected $inline = array();

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
		return $this->paths;
	}
	public function getInline() {
		return implode( "\n", $this->inline );
	}
	
	public function addScript( Web_Uri $script ) {
		if( !in_array( $script, $this->paths ) ) {
			$this->paths[] = $script;
		}
	}
	
	public function addInline( $js ) {
		$this->inline[] = $js;
	}

}