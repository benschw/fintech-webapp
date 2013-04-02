<?php

/**
 * Flfc_Context
 *
 * @package Flfc
 */
class Flfc_Context {

	/* Flfc_Context */
	private static $instance;

	/* Flfc_Request */
	private $request;

	/* Flfc_Response */
	private $response;

	/* Flfc_Links */
	private $links;
	
	/** @deprecated */
	private $log;
	
	private $isDebug;

	/**
	 * Factory method to get current context
	 * 
	 * @return Flfc_Context current context instance
	 */
	public static function get() {
		if( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Factory method to set current context
	 * 
	 * @param  Flfc_Context $context set current context
	 * @return Flfc_Context current context instance
	 */
	public static function set(Flfc_Context $context) {
		self::$instance = $context;
		return self::get();
	}

	public function setDebug($isDebug) {                $this->isDebug = $isDebug; return $this;}
	public function isDebug() {                         return $this->isDebug; }

	public function getRequest() {                      return $this->request; }
	public function setRequest(Flfc_Request $req) {     $this->request = $req;   return $this->getRequest(); }

	public function getResponse() {                     return $this->response; }
	public function setResponse(Flfc_Response $resp) {  $this->response = $resp; return $this->getResponse(); }

	public function getUriLib() {                       return $this->links; }
	public function setUriLib(Flfc_Links $links) {      $this->links = $links;   return $this->getUriLib(); }

	/** @deprecated */
	public function getLog() {                          return $this->log; }
	/** @deprecated */
	public function setLog(FlMon_Logging_Log $log) {    $this->log = $log;       return $this->getLog(); }

}