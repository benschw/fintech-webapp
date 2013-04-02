<?php

class Util_Val_RawRequest {

	private $data = array();

	public function __construct(array $data = null) {
		if (is_null($data)) {
			$data = array();
		}
		$this->data = $data;
	}
	
	public function getForValidation($key) {
		return (isset($this->data[$key]) ? $this->data[$key] : null);
	}
	
}