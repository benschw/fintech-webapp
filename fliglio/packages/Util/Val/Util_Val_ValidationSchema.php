<?php

class Util_Val_ValidationSchema {

	final public function __construct() {}

	public function getCleanRequest( Util_Val_ValidationFacade $validator ) {

		$this->addSpecifications( $validator );
		
		if( $this->validate( $validator ) ) {
			if( $validator->validate() ) {
				return $validator->getCleanRequest();
			} else {
				$strArr = array();
				$errors = $validator->getErrors();
				foreach( $errors AS $error ) {
					$strArr[] = (string)$error;
				}
				throw new Exception( implode( "\n", $strArr ) );
			}
		} else {
			// throw new Exception("Failed ValidationSchema.validate()");
			throw new Util_Val_ValidationInvalid( "Failed ValidationSchema.validate()" );
		}
	}

	protected function addSpecifications( Util_Val_ValidationFacade $validator ) {}

	protected function validate( Util_Val_ValidationFacade $validator ) { return true; }

}