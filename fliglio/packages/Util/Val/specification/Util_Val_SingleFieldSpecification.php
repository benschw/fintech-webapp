<?php

class Util_Val_SingleFieldSpecification implements Util_Val_Specification {

	protected $fieldName;
	protected $optional = false;
	protected $valueSpecification;
	
	public function __construct( $fieldName, Util_Val_Specification $specification ) {
		$this->fieldName          = $fieldName;
		$this->valueSpecification = $specification;
	}

	public function forField( $fieldName ) {
		$this->fieldName = $fieldName;
	}

	public function optional( $val = true ) {
		$this->optional = $val;
	}

	public function setValidatedField( $coordinator ) {
		if( $this->optional ) {
			$notEmpty = new Util_Val_NotEmptyValueSpecification();
			if( !$notEmpty->isSatisfiedBy( $coordinator->get( $this->fieldName ) ) ) { 
				return;
			}
		}
		$coordinator->setClean( $this->fieldName, $coordinator->get( $this->fieldName ) );
	}
	
	public function isSatisfiedBy( $candidate ) {
		// if optional & empty, return true; else return ValueSpecification result
		if( $this->optional ) {
			$notEmpty = new Util_Val_NotEmptyValueSpecification();
			if( !$notEmpty->isSatisfiedBy( $candidate->get( $this->fieldName ) ) ) { 
				return true;
			}
		}
		return $this->valueSpecification->isSatisfiedBy( $candidate->get( $this->fieldName ) );
	}

	public function getError( $message ) {
		return new Util_Val_SingleFieldSpecificationError( $this->fieldName, $message );
	}

}