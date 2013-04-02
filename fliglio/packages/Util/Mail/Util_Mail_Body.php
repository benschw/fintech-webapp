<?php

class Util_Mail_Body {
	const TEXT_PLAIN = 'text/plain';
	const TEXT_HTML  = 'text/html';

	private $body;
	private $mime;

	public function __construct($body, $mime=self::TEXT_PLAIN) {
		$this->body = $body;
		$this->mime = $mime;
	}

	public function getContent() {
		return $this->body;
	}
	public function getMimeType() {
		return $this->mime;
	}

}