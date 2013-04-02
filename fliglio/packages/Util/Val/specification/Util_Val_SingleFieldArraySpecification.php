<?php

class Util_Val_SingleFieldArraySpecification extends Util_Val_SingleFieldSpecification {

	public function isSatisfiedBy( $candidate ) {
		// if optional & empty, return true; else return ValueSpecification result
		$notEmpty = new Util_Val_NotEmptyValueSpecification();

		if( $this->optional ) {
			if( !$notEmpty->isSatisfiedBy( $candidate->get( $this->fieldName ) ) ) { 
				return true;
			}
		}
		$arr = $candidate->get( $this->fieldName );
		if( is_array( $arr ) ) {
			foreach( $arr AS $val ) {
				if( !$this->valueSpecification->isSatisfiedBy( $val ) ) {
					if( $this->optional ) { // if optional, allow empties to be ignored
						if( $notEmpty->isSatisfiedBy( $val ) ) { 
							return false;
						}
					}
				}
			}
			return true;
		}
		return false;
	}

}