<?php

/**
 * PlainText Closure View 
 * - setting header to text/plain of a closure view
 *
 * @package Fltk
 */
class Fltk_PlainTextClosureView extends Fltk_ClosureView {
	
	public function setHeadersOnResponse(Flfc_Response $response) {
		$response->addHeader('Content-Type', 'text/plain');
	}
}