<?php

class Routing_CatchAllRoute extends Routing_Route {

	protected $criteria;

	public function __construct( array $defaults = array() ) {
		parent::__construct( $defaults );
	}
	public function urlFor( array $params = array() ) {
		return '';
	}
	
	public function match( Web_Uri $input ) {
		return true;
	}


}