<?php
/**
 *
 * @package Util.Val
 */

class Util_Val_NameValueSpecification implements Util_Val_Specification {
	
	protected $name;
	
	public function isSatisfiedBy($name) {
		$this->name = $name;
		return ($this->hasProperLength() && !$this->hasNumbers() && !$this->hasSymbols()) ? true : false;
	}
	
	protected function hasProperLength(){
		return (strlen($this->name) >= 2 && strlen($this->name) < 32) ? true : false;
	}
	
	protected function hasSymbols(){
		return preg_match("/[!@#$%^&*()_+<>?\/{}\]\~]/", $this->name) ? true : false;
	}
	
	protected function hasNumbers(){
		return preg_match("/[1-9]/", $this->name) ? true : false;
	}
}

