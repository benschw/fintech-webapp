<?php

class Util_Storage_Storage {

	protected $namespace;
	protected $storage;

	protected function __construct($storage, $namespace) {
		// @todo verify namespace is legal variable name
		
		$this->storage   = $storage;
		$this->namespace = $namespace;
		
		$this->init();
	}
	private function init() {
		if(!isset($this->storage->{$this->namespace})) {
			$this->storage->{$this->namespace} = new stdClass();
		}
	}
	public static function get($storage, $namespace) {
		return new self($storage, $namespace);
	}
	public function reset() {
		$this->init();
		unset($this->storage->{$this->namespace});
	}
	public function __set($key, $val) {
		$this->init();
		return $this->storage->{$this->namespace}->{$key} = $val;
	}
	public function __get($key) {
		$this->init();
		return $this->storage->{$this->namespace}->{$key};
	}
	
	public function __isset($key) {
		$this->init();
		return isset($this->storage->{$this->namespace}->{$key});
	}
	
	public function __unset($key) {
		$this->init();
		unset($this->storage->{$this->namespace}->{$key});
	}
	
	public function getNamespace() { 
		return $this->namespace; 
	}
}