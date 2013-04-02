<?php

class Fl_Mapper_DatabaseIndex {
	
	const KASASA             = 'kasasa';
	const SEGUNDO            = 'segundo';
	const LEADS              = 'leads';
	const CHECKINGFINDER     = 'checkingfinder';
	const REPORTING_ENDPOINT = 'reportingendpoint';
	const MVCMS              = 'mvcms';
	const MVADMIN            = 'mvadmin';
	const MOBILECMS          = 'mobileCms';
	
	private static $instance;
	
	private $databases = array();
	
	public static function singleton() {
		if (!isset(self::$instance)) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	
	public static function get() {
		return self::$instance;
	}
	
	public function setDatabase($key, $val) {
		$this->databases[$key] = $val;
	}
	
	public function getDatabase($key) {
		return $this->databases[$key];
	}
	
	public function getDatabases() {
		return $this->databases;
	}
}