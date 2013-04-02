<?php

class Util_Val_BasicValidator implements Util_Val_Validator {

	private $specification;

	private $message;
	
	public function __construct( Util_Val_Specification $specification, $message = '' ) {
		$this->specification = $specification;
		$this->message       = $message;
	}

	public function withMessage( $message ) {
		$this->message = $message;
		return $this;	
	}

	// Decorator Methods to make setup simpler =====================
	public function forField( $fieldName ) {
		$this->specification->forField( $fieldName );
		return $this;
	}
	public function forFields( array $fields ) {
		$this->specification->forFields( $fields );
		return $this;
	}
	public function optional( $val = true ) {
		$this->specification->optional( $val );
		return $this;
	}
	public function getValidator() {
		return $this->specification->getValidator();
	}
	//==============================================================

	public function validate( Util_Val_ValidationCoordinator $coordinator ) {
		if( $this->specification->isSatisfiedBy( $coordinator ) ) {
			$this->specification->setValidatedField( $coordinator );
			return true;
		}
		$coordinator->addError( $this->specification->getError( $this->message) );
		return false;
	}

}