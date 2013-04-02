<?php

class Routing_CatchNoneRoute extends Routing_Route {

	public function __construct( array $defaults = array() ) {
		parent::__construct( $defaults );
	}
	public function urlFor( array $params = array() ) {
		return '';
	}
	
	public function match( Web_Uri $input ) {
		return false;
	}


}