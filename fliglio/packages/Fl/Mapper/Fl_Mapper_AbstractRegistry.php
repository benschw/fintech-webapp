<?php

abstract class Fl_Mapper_AbstractRegistry {

	private $dbMappers;          // database mapper
	private $jsonMappers;        // json
	private $voMappers;          // simple arrays & stdClass objects
	private $roVoMappers;        // read-only simple arrays & stdClass objects (no getFromEncoded method)
	private $httpQueryMappers;   // encoded like get or post params
	
	protected function __construct() {
		$this->dbMappers        = new Fl_Mapper_RegistryHashMap('Db');
		$this->jsonMappers      = new Fl_Mapper_RegistryHashMap('Json');
		$this->voMappers        = new Fl_Mapper_RegistryHashMap('Vo');
		$this->roVoMappers      = new Fl_Mapper_RegistryHashMap('RoVo');
		$this->httpQueryMappers = new Fl_Mapper_RegistryHashMap('HttpQuery');
	}
	
	/**
	 * Pretend this is an abstract method
	 *
	 * @return Fl_Mapper_AbstractRegistry
	 * @throws Exception  this method must be extended, an exception will be thrown if not
	 */
	public static function get() {
		throw new Exception("This class must be extended by a package specific factory!");
	}
	
	/**
	 * Setting up Multiple Database API for Data Mappers.
	 *
	 * @param MapperRegistry object $instance
	 */
	public static function postProcessMapperInstance($instance) {
		if ($instance instanceof Fl_Mapper_MultipleDatabasesApi) {
			$instance->setDatabase(Fl_Mapper_DatabaseIndex::singleton());
			$instance->__construct();
		}
		return $instance;
	}
	
	public function db() {
		return $this->dbMappers;
	}
	public function json() {
		return $this->jsonMappers;
	}
	public function vo() {
		return $this->voMappers;
	}
	public function roVo() {
		return $this->roVoMappers;
	}
	public function httpQuery() {
		return $this->httpQueryMappers;
	}

}