<?php

/**
 * Library for generating urls in a standardized way
 * 
 * @package Fl
 */
class Flfc_Links {
	private $routes;

	/**
	 * Set up object
	 * 
	 * @param Routing_RouteMap $routes  resource to create and analyize links
	 */
	public function __construct(Routing_RouteMap $routes) {
		$this->routes = $routes;
	}
	
	/**
	 * Get route key for supplied url 
	 * 
	 * @param Web_Uri $url url to calculate RouteKey from
	 * @return String route key of supplied url
	 */
	public function getKeyFromUrl(Web_Uri $url) {
		return $this->routes->getRouteKey($url);
	}

	/**
	 * Generate a url with a route key and optional parameters
	 * 
	 * @param String $key route key
	 * @param String[] $params optional extra parameters
	 * @return Web_Uri url for supplied arguments
	 */
	public function urlFor($key, $params = array()) {
		return $this->routes->urlFor($key, $params);
	}

	/**
	 * Get route for given route key
	 * 
	 * @param String $key route key
	 * @return Routing_Route route for requested route key
	 */
	public function getRoute($key) {
		return $this->routes->getRouteByKey($key);
	}
	
	/**
	 * Get all route keys
	 * 
	 * @return String[] array of route keys
	 */
	public function getRouteKeys() {
		return $this->routes->getRouteKeys();
	}

}