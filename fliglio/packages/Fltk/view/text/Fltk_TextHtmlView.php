<?php

/**
 * @package Fltk
 */
class Fltk_TextHtmlView implements Flfc_ResponseContent, Flfc_HasHeadersToSet {

	private $text;

	public function __construct($text) {
		$this->text = $text;
	}

	public function setHeadersOnResponse(Flfc_Response $response) {
		$response->addHeader('Content-Type', 'text/html');
	}

	public function render() {
		return $this->text;
	}
}