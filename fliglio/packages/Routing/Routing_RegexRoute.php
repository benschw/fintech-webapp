<?php

abstract class Routing_RegexRoute extends Routing_Route {

	protected $regex;
	
	public function __construct( $regex, array $defaults = array() ) {
		parent::__construct( $defaults );

		$this->regex = $regex;
	}
	
	
	public function match( Web_Uri $input ) {
		return (bool) preg_match( $this->regex, (string)$input, $this->capturedArgs ) ;
	}



}