<?php

class Util_Val_ValidationCoordinator {
	private $raw;
	private $clean;
	private $errors = array();
	
	public function __construct( Util_Val_RawRequest $raw, Util_Val_CleanRequest $clean ) {
		$this->raw   = $raw;
		$this->clean = $clean;
	}
	
	public function get( $name ) {
		return $this->raw->getForValidation( $name );
	}
	
	public function setClean( $name = false, $field ) {
		if( !$name ) {
			return false;
		}
		$this->clean = $this->clean->set( $name, $field );
	}

	public function addError( $error ) {
		$this->errors[] = $error;
	}
	
	public function getErrors() {
		return $this->errors;
	}
	
	public function getCleanRequest() {
		return $this->clean;
	}

}

