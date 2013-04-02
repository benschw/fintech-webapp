<?php

class Util_Val_ValidationFacade {
	private $rawRequest;
	private $coordinator;
	private $validators = array();
	private $hasValidated = false;

	public function __construct(Util_Val_RawRequest $request = null) {
		$this->rawRequest = $request;
	}
	
	public function getNotEmptyField($field, $optional = false, $message = 'Field did not validate') {
		return $this->getField(new Util_Val_NotEmptyValueSpecification(), $field, $optional, $message);
	}
	public function getField($specification, $field, $optional = false, $message = 'Field did not validate') {
		$v = clone $this;
		$v->addSingleFieldValidator($specification, $field, $message);
		if ($v->validate()) {
			return $v->getCleanRequest()->{$field};
		} else {
			if ($optional) {
				return null;
			} else {
				throw new Util_Val_ValidationInvalid($v->getErrorsString());
			}
		}
	}
	
	public function addValidator(Util_Val_Validator $validator) {
		$this->hasValidated = false;
		return $this->validators[] = $validator;
	}

	public function addObjectValidator($field = '', $message = 'Object didn\'t validate') {
		return $this->addValidator(
			new Util_Val_BasicValidator(new Util_Val_ObjectSpecification($field, $this->rawRequest), $message) 
		);
	}

	public function addEqualFieldsValidator($fields = array(), $message = 'args must be equal') {
		return $this->addValidator(
			new Util_Val_BasicValidator(new Util_Val_EqualFieldsSpecification($fields), $message) 
		);
	}

	// Simple wrappers for single field specifications & array of like values
	public function addSingleFieldValidator($specification, $field = '', $message = 'arg failed validator') {
		return $this->addValidator(
			new Util_Val_BasicValidator(new Util_Val_SingleFieldSpecification($field, $specification), $message)
		);
	}
	public function addSingleFieldArrayValidator($specification, $field = '', $message = 'arg failed validator') {
		return $this->addValidator(
			new Util_Val_BasicValidator(new Util_Val_SingleFieldArraySpecification($field, $specification), $message)
		);
	}

	// array shortcuts
	public function addZipcodeArrayValidator($field = '', $message = 'arg must be 5 digit integer') {
		return $this->addSingleFieldArrayValidator(new Util_Val_ZipcodeValueSpecification(), $field, $message);
	}
	public function addAlphaValidator($field = '', $message = 'arg must be Alpha only') {
		return $this->addSingleFieldArrayValidator(new Util_Val_AlphaValueSpecification(), $field, $message);
	}
	public function addAlphaNumArrayValidator($field = '', $message = 'arg must be Alpha-Numeric') {
		return $this->addSingleFieldArrayValidator(new Util_Val_AlphanumericValueSpecification(), $field, $message);
	}
	public function addIntArrayValidator($field = '', $message = 'arg must be Int') {
		return $this->addSingleFieldArrayValidator(new Util_Val_IntValueSpecification(), $field, $message);
	}
	public function addIntegerArrayValidator($field = '', $message = 'arg must be Integer') {
		return $this->addSingleFieldArrayValidator(new Util_Val_IntegerValueSpecification(), $field, $message);
	}
	public function addStringArrayValidator($field = '', $message = 'arg must be String') {
		return $this->addSingleFieldArrayValidator(new Util_Val_StringValueSpecification(), $field, $message);
	}
	public function addNumericArrayValidator($field = '', $message = 'arg must be Numeric') {
		return $this->addSingleFieldArrayValidator(new Util_Val_NumericValueSpecification(), $field, $message);
	}
	public function addNotEmptyArrayValidator($field = '', $message = 'arg cannot be empty') {
		return $this->addSingleFieldArrayValidator(new Util_Val_NotEmptyValueSpecification(), $field, $message);
	}
	public function addNotSetArrayValidator($field = '', $message = 'arg must be set') {
		return $this->addSingleFieldArrayValidator(new Util_Val_NotSetValueSpecification(), $field, $message);
	}

	// field shortcuts
	public function addZipcodeValidator($field = '', $message = 'arg must be 5 digit integer') {
		return $this->addSingleFieldValidator(new Util_Val_ZipcodeValueSpecification(), $field, $message);
	}
	public function addAlphaNumValidator($field = '', $message = 'arg must be Alpha-Numeric') {
		return $this->addSingleFieldValidator(new Util_Val_AlphanumericValueSpecification(), $field, $message);
	}
	public function addIntValidator($field = '', $message = 'arg must be Int') {
		return $this->addSingleFieldValidator(new Util_Val_IntValueSpecification(), $field, $message);
	}
	public function addIntegerValidator($field = '', $message = 'arg must be Integer') {
		return $this->addSingleFieldValidator(new Util_Val_IntegerValueSpecification(), $field, $message);
	}
	public function addStringValidator($field = '', $message = 'arg must be String') {
		return $this->addSingleFieldValidator(new Util_Val_StringValueSpecification(), $field, $message);
	}
	public function addNumericValidator($field = '', $message = 'arg must be Numeric') {
		return $this->addSingleFieldValidator(new Util_Val_NumericValueSpecification(), $field, $message);
	}
	public function addNotEmptyValidator($field = '', $message = 'arg cannot be empty') {
		return $this->addSingleFieldValidator(new Util_Val_NotEmptyValueSpecification(), $field, $message);
	}
	public function addNotSetValidator($field = '', $message = 'arg must be set') {
		return $this->addSingleFieldValidator(new Util_Val_NotSetValueSpecification(), $field, $message);
	}
	
	//========================================================================

	public function validate(Util_Val_RawRequest $rawRequest = null) {
		$rawRequest = (is_null($rawRequest) ? $this->rawRequest : $rawRequest);
		$this->coordinator = $this->createCoordinator($rawRequest, new Util_Val_CleanRequest());
		
		foreach($this->validators AS $validator) {
			$validator->validate($this->coordinator);
		}
		$this->hasValidated = true;
		return $this->isValid();
	}
	
	public function isValid() {
		if (!$this->hasValidated) {
			return false;
		} else {
			return count($this->coordinator->getErrors()) == 0;
		}
	}

	public function getCleanRequest() {
		if ($this->isValid() || $this->validate()) {
			return $this->coordinator->getCleanRequest();
		} else {
			throw new Util_Val_ValidationInvalid("Validator Failed on one or more fields");
		}
	}

	public function getErrors() {
		if ($this->isValid()) {
			return false;
		} else {
			return $this->coordinator->getErrors();
		}
	}
	public function getErrorsString() {
		if ($this->isValid()) {
			return false;
		} else {
			$errors = $this->coordinator->getErrors();
			$strArr = array();
			foreach($errors AS $error) {
				$strArr[] = (string)$error;
			}
			return implode("\n", $strArr);
		}
		
	}
	//========================================================================

	private function createCoordinator(Util_Val_RawRequest $raw, Util_Val_CleanRequest $clean) {
		return new Util_Val_ValidationCoordinator($raw, $clean);
	}

}