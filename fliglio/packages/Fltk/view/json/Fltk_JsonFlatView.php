<?php

class Fltk_JsonFlatView implements Flfc_ResponseContent, Flfc_HasHeadersToSet {

	protected $data;

	public function __construct($data) {
		$this->data = $data;
	}

	public function getData() {
		return $this->data;
	}

	public function setHeadersOnResponse(Flfc_Response $response) {
		$response->addHeader('Content-Type', 'text/json');
	}

	public function render() {
		return json_encode($this->data);
	}
}