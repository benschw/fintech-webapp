<?php

class Util_Val_SingleFieldSpecificationError {

	private $field;
	private $message;

	public function __construct( $field, $message = '' ) {
		$this->field   = $field;
		$this->message = $message;
	}

	public function getField() { return $this->field; }
	public function getError() { return $this->message; }

	public function __toString() {
		return "{$this->field} : {$this->message}";
	}

}