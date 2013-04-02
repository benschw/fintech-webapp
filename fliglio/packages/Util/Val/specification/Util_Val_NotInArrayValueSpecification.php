<?php

class Util_Val_NotInArrayValueSpecification implements Util_Val_Specification {
	
	private $toMatch;
	
	public function __construct( array $toMatch ) {
		$this->toMatch = $toMatch;
	}

	public function isSatisfiedBy( $candidate ) {
		return !in_array( $candidate, $this->toMatch );
	}
	
}