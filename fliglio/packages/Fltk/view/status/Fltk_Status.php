<?php
/**
 * @package Fltk.Status
 * 
 * 0 : success
 * 1 : error, unknown
 * 2 : missing required field
 * 3 : conflict, aborted
 * 4 : request wasn't understood
 * 5 : authentication problem, suspected hacking
 * 6 : authentication problem, suspected not logged in
 * 
 */
class Fltk_Status implements Flfc_ResponseContent {
	
	private $statusCode;
	private $debugMessage;
	private $results;
	private $alertMessage;
	private $detailsMessage;
	
	public function __construct($statusCode, $debugMessage = '', $results = false, $alertMessage = null) {
		$this->statusCode   = (int)$statusCode;
		$this->debugMessage = $debugMessage;
		$this->results      = $results;
		$this->alertMessage = $alertMessage;
	}
	
	public static function init($statusCode, $debugMessage = '', $results = false, $alertMessage = null) {
		return new Fltk_Status($statusCode, $debugMessage, $results, $alertMessage);
	}
	
	public function setAlert($message) {
		$this->alertMessage = $message;
	}
	
	public function setDetails($message) {
		$this->detailsMessage = $message;
	}
		
	public function getStatus() {
		$data = array(
			'status'  => $this->getStatusCode(),
			'debug'   => (string)$this->debugMessage,
			'results' => $this->results,
			'alert'   => $this->alertMessage
		);
		
		if ($this->detailsMessage) {
			$data['details'] = $this->detailsMessage;
		}
		return $data;
	}
	
	public function getResults() {
		return $this->results;
	}
	
	public function getStatusCode() {
		return $this->statusCode;
	}
	
	public function render() {
		return $this->getStatus();
	}
	
	public static function load(array $data) {
		$status = new Fltk_Status($data['status'], $data['debug'], $data['results'], $data['alert']);
		
		if (isset($data['details'])) {
			$status->setDetails($data['details']);
		}
		return $status;
	}
}