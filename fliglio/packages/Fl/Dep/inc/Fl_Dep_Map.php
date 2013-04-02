<?php

class Fl_Dep_Map {
	
	private static $inst;
	
	private $idx = array();
	
	public static function singleton() {
		if (!isset(self::$inst)) {
			self::$inst = new self();
		}
		return self::$inst;
	}

	public function satisfy(Fl_Dep_DependencyMapper $mapper) {
		$key = get_class($mapper);
		$this->idx[$key] = new Fl_Dep_Entry($mapper);
		return $this->idx[$key];
	}
	
	public function getEntry($key) {
		return $this->idx[$key];
	}
}