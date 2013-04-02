<?php


class Fltk_PlainTextView implements Flfc_ResponseContent, Flfc_HasHeadersToSet {
	
	protected $text;
	
	public function __construct( $text ) {
		$this->text = $text;
	}
	
	public function setHeadersOnResponse(Flfc_Response $response) {
		$response->addHeader('Content-Type', 'text/plain');
	}
	
	public function render() {
		return $this->text;
	}
}