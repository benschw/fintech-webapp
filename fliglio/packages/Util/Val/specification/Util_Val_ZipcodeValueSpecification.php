<?php

class Util_Val_ZipcodeValueSpecification implements Util_Val_Specification {

	public function isSatisfiedBy( $candidate ) {
		$integer = new Util_Val_IntegerValueSpecification();
		return $integer->isSatisfiedBy( $candidate ) && $this->inZipcodeTable( $candidate );
	}
	
	protected function inZipcodeTable( $candidate ) {
		return Util_Db_DbFactory::get()->selectField( 
			"SELECT count(*) 
			   FROM geo.Zipcode 
			  WHERE ZIP_CODE = ?", 
			array( (string)$candidate ) 
		) != 0;
	}

}