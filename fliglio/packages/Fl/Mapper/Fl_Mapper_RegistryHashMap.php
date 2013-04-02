<?php

class Fl_Mapper_RegistryHashMap extends Util_HashMap {
	
	private $encType;
	
	public function __construct($encType) {
		parent::__construct();
		
		$this->encType = $encType;
	}
	
	/**
	 * Since package-a might try to load a mapper for a class in package-b, 
	 * there package-b's mappers might not yet be loaded. This attempts to 
	 * load package-b with the PackageManager (whose bootstrap should
	 * register it's mappers with this HashMap)
	 */
	public function get($key) {
		if (!$this->containsKey($key)) {
			$className = $key . $this->encType . 'Mapper';
			$obj = new $className();
			$obj = Fl_Mapper_AbstractRegistry::postProcessMapperInstance($obj);
			$this->put($key, $obj);
		}
		return parent::get($key);
	}
}