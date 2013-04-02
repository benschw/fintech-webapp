<?php

class Util_Val_EqualFieldsSpecification implements Util_Val_Specification {
	private $fields   = array();
	private $optional = false;
	
	public function __construct( array $fields = array() ) {
		$this->fields = $fields;
	}

	public function forFields( array $fields ) {
		$this->fields = $fields;
	}
	public function optional( $val = true ) {
		$this->optional = $val;
		return $this;
	}

	public function getValidatedField() {
		return false;
	}
	public function setValidatedField( $coordinator ) {
	}
	
	public function isSatisfiedBy( $candidate ) {
		if( count( $this->fields ) >= 2 ) {
			// if optional & all fields are empty, return true; else return ValueSpecification result
			if( $this->optional ) {
				$notEmpty = new Util_Val_NotEmptyValueSpecification();
				$notEmptyCount = 0;
				foreach( $this->fields AS $field ) {
					if( $notEmpty->isSatisfiedBy( $candidate->get( $field ) ) ) { 
						$notEmptyCount++;
					}
				}
				if( $notEmptyCount == 0 ) {
					return true;
				}
			}

			// validate ValueSpecification on each
			foreach( $this->fields AS $field ) {
				if( $candidate->get( $this->fields[0] ) != $candidate->get( $field ) ) {
					return false;
				}
			}
			return true;
		} else {
			throw new Exception( "must have at least 2 fields to conduct a Util_Val_EqualFieldsSpecification validation" );
		}
	}

	public function getError( $message ) {
		return new Util_Val_EqualFieldsSpecificationError( $this->fields, $message );
	}

}