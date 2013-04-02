<?php
/**
 *
 * @package Util.Val
 */

class Util_Val_StrongPasswordValueSpecification implements Util_Val_Specification {
		
	private $pass;
	private $login;

	public function __construct($login) {
		$this->login = $login;
	}
	
	public function isSatisfiedBy($passwordAttempt) {
		$this->pass = $passwordAttempt;
		return ($this->hasProperLength() && $this->hasUpperAndLower() && $this->hasNumbers() && $this->hasSymbols() && !$this->hasSpaces() && !$this->hasEmail()) ? true : false;
	}
	private function hasProperLength(){
		return (strlen($this->pass) >= 8) ? true : false;
	}
	private function hasUpperAndLower(){
		return (preg_match("/[A-Z]/", $this->pass) && preg_match("/[a-z]/", $this->pass)) ? true : false;
	}
	private function hasSymbols(){
		return preg_match("/[!@#$%^&*()_+\-\<\>\?\/{}\]\~]/", $this->pass) ? true : false;
	}
	private function hasNumbers(){
		return preg_match("/[0-9]/", $this->pass) ? true : false;
	}
	private function hasSpaces(){
		return preg_match("/[\s]/", $this->pass) ? true : false;
	}
	private function hasEmail(){
		return stristr($this->pass, $this->login) ? true : false;
	}
}