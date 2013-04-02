<?php

class Fltk_LinksManager {
	
	protected $links;

	public function __construct() {
		$links = Flfc_Context::get()->getUriLib();

		$keys = $links->getRouteKeys();
		foreach( $keys AS $key ) {
			$route = $links->getRoute( $key );
			if( get_class( $route ) == "Routing_StaticRoute" ) {
				$this->$key = new Fltk_Link( $route->urlFor() );
			}
		}
	}

	public function __set( $key, $val ) {
		$this->links[$key] = $val;
	}
	public function __get( $key ) {
		return $this->links[$key];
	}
	public function __isset( $key ) {
		return isset( $this->links[$key] );
	}

}