<?php

abstract class Fl_Mapper_DbMapper {
	private static $i = 0;
	protected $db;
	
	public $loadedMap;

	public function __construct($db) {
		$this->db = $db;
		$this->resetCache();
	}

	public function resetCache() {
		$this->loadedMap = array();
	}
	
	protected function cacheObject($key, $obj) {
		$this->loadedMap[$key] = $obj;
	}

	public function abstractFind($query, $id, array $args = array()) {
		if (empty($args)) {
			$args[] = $id;
		}
		
		if (!isset($this->loadedMap[$id])) {
			$rs  = $this->db->selectRecord($query, $args);
			$obj = $this->doLoad($id, $rs);
			$this->cacheObject($id, $obj);
		}
		
		return $this->loadedMap[$id];
	}
	
	protected function findStatement() {
		throw new Exception("findStatement() must be implemented by Fl_Mapper_DbMapper's subclass");
	}

	protected function doLoad($id, $rs) {
		throw new Exception("doLoad() must be implemented by Fl_Mapper_DbMapper's subclass");
	}

}

