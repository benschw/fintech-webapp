<?php

class Util_Val_EqualFieldsSpecificationError {

	private $fields = array();
	private $message;

	public function __construct( array $fields, $message = '' ) {
		$this->fields  = $fields;
		$this->message = $message;
	}

	public function getFields() { return $this->fields; }
	public function getError() { return $this->message; }
	
	public function __toString() {
		return implode( ', ', $this->fields ) . " : {$this->message}";
	}

}