<?php


class Fltk_View implements Flfc_ResponseContent {
	
	protected $text;
	
	public function __construct($text) {
		$this->text = $text;
	}
	
	public function render() {
		return $this->text;
	}


}