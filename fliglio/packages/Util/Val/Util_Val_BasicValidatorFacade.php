<?php

class Util_Val_BasicValidatorFacade {

	private $errors = array();
	private $object;
	private $validator;
	private $isValidated = false;

	public function __construct( $object, Util_Val_Validator $validator ) {
		$this->object    = $object;
		$this->validator = $validator;
	}

	public function addError( $error ) {
		$this->errors[] = $error;
	}
	public function getErrors() { 
		if( !$this->isValidated ) {
			throw new Exception( "Make sure to validate checking for errors" );
		}
		return $this->errors; 
	}

	public function validate() {
		$this->errors = array();
		$this->validator->validate( $this->object, $this );
		$this->isValidated = true;
		return $this->isValid();
	}
	public function isValid() {
		return $this->isValidated && count( $this->errors ) == 0;
	}


}