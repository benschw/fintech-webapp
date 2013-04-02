<?php

class Fliglio_BuildTools_CachePathConfigDriver {
	
	private $paths = array();

	public function __construct() {
	}
	
	public function addPath($key, $val) {
		$this->paths[$key] = $val;
	}
	
	public function __toString() {

		return sprintf("<?php return %s;\n", var_export($this->paths, true))	;
	}

	public static function main(array $config) {
		$paths  = $config['paths'];
		$output = $config['output'];
		
		$driver = new self();
		foreach ($paths as $key => $val) {
			$driver->addPath($key, $val);
		}
		
		file_put_contents($output, (string) $driver);
	}
}