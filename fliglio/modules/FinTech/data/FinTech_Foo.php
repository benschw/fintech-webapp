<?php

class FinTech_Foo {
	
	private $id;
	private $val;
	
	public function __construct($val, $id = null) {
		$this->id = $id;
		$this->val = $val;
	}
	public function setId($id) {
		$this->id = $id;
	}
	public function setVal($val) {
		$this->val = $val;
	}

	public function getId() {
		return $this->id;
	}
	public function getVal() {
		return $this->val;
	}

}