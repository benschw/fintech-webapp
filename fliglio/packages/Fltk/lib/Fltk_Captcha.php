<?php

class Fltk_Captcha {
	
	private $storageIndex;
	private $storage;

	public function __construct( $index ) {
		$this->storageIndex = $index;
		$session = Util_Storage_Session::singleton();
		
		if (isset($session->bvi_captcha) && isset($session->bvi_captcha->{$this->storageIndex})) {
			$this->storage = $session->bvi_captcha->{$this->storageIndex};
		} else {
			$this->reset();
		}

	}
	
	public static function getInstance( $index, $freeTries = null, $threshold = null, $timeLimit = null ) {
		$instance = new Fltk_Captcha( $index );
		
		if( !is_null( $freeTries ) ) {
			$instance->setFreeTries( $freeTries );
		}
		if( !is_null( $threshold ) ) {
			$instance->setThreshold( $threshold );
		}
		if( !is_null( $timeLimit ) ) {
			$instance->setTimeLimit( $timeLimit );
		}

		if( $instance->getTimeLimit() < ( time() - $instance->getStartTime() ) ) {
			$instance->reset();
		}

		return $instance;
	}

	public function reset() {
		$session = Util_Storage_Session::singleton();
		
		if( !isset( $session->bvi_captcha ) ) {
			$session->bvi_captcha = new stdClass();
		}
		if( !isset( $session->bvi_captcha->{$this->storageIndex} ) ) {
			$session->bvi_captcha->{$this->storageIndex} = new stdClass();
		}
		
		$this->storage = $session->bvi_captcha->{$this->storageIndex};
		$this->setStartTime( time() );
		$this->resetTries();
		return true;
	}

	public function validate( $code = null ) {
		if( $this->isFreeTry() ) {
			$this->incrementTries();
			return true;
		} else if( $this->isUnderThreshold() ) {
			$this->incrementTries();
			return $this->hasSecurityCode() && $this->isCodeValid( $code ) && $this->reset();
		} else {
			$this->incrementTries();
			throw new Exception( "Form Submitted too many times." );
		}
	}


	public function getStorageIndex() {        return $this->storageIndex; }

	public function incrementTries() {         $this->storage->tries += 1; }

	public function isFreeTry() {              return( $this->getTries() < $this->getFreeTries() ); }

	public function hasSecurityCode() {        return isset( $this->storage->securityCode ); }
	public function getSecurityCode() {        return $this->storage->securityCode; }
	public function setSecurityCode( $code ) { $this->storage->securityCode = $code; }

	public function hasStartTime() {           return isset( $this->storage->startTime ); }
	public function getStartTime() {           return $this->storage->startTime; }
	public function setStartTime($time) {      $this->storage->startTime = $time; }

	public function getTries() {               return $this->storage->tries; }
	public function resetTries() {             $this->storage->tries = 0; }

	// Number of Tries Before Captcha Kicks in (3 == 3 non captcha tries)
	public function getFreeTries() {           return $this->storage->freeTries; }
	public function setFreeTries($freeTries) { $this->storage->freeTries = $freeTries; }

	// Number of Tries within timeLimit (total tries: free & captcha'd)
	public function getThreshold() {           return $this->storage->threshold; }
	public function setThreshold($threshold) { $this->storage->threshold = $threshold; }

	// Time Before Captcha Resets (as if a new visitor)
	public function getTimeLimit() {           return $this->storage->timeLimit; }
	public function setTimeLimit($timeLimit) { $this->storage->timeLimit = $timeLimit; }



	//============================================================================

	private function isUnderThreshold() {      return( $this->getTries() <= $this->getThreshold() ); }
	private function isCodeValid( $code ) {    return $this->getSecurityCode() == $code; }


}


