<?php

class Util_Val_ObjectSpecification implements Util_Val_Specification {

	private $validator;
	
	private $fieldName;
	private $optional;
	private $request;
	
	public function __construct( $fieldName, Util_Val_RawRequest $request ) {
		$this->fieldName = $fieldName;
		$this->request   = $request;
		$this->validator = new Util_Val_ValidationFacade();
	}
	public function getValidator() {
		return $this->validator;
	}
	public function forField( $fieldName ) {
		$this->fieldName = $fieldName;
	}
	public function optional( $val = true ) {
		$this->optional = $val;
	}

	public function setValidatedField( $coordinator ) {
		if( $this->validator->isValid() ) {
			$coordinator->setClean( $this->fieldName, $this->validator->getCleanRequest() );
		}
	}
	
	public function isSatisfiedBy( $candidate ) {
		// if optional & empty, return true; else return ValueSpecification result
		if( $this->optional ) {
			$notEmpty = new Util_Val_NotEmptyValueSpecification();
			if( !$notEmpty->isSatisfiedBy( $candidate->get( $this->fieldName ) ) ) { 
				return true;
			}
		}

		$this->validator->validate( new Util_Val_RawRequest( $this->request->getForValidation( $this->fieldName ) ) );
		if( $this->validator->isValid() ) {
			return true;
		} else {
			$errors = $this->validator->getErrors();
			foreach( $errors AS $error ) {
				$candidate->addError( $error );
			}
			return false;
		}
	}

	public function getError( $message ) {
		return new Util_Val_ObjectSpecificationError( $this->fieldName, $message );
	}

}