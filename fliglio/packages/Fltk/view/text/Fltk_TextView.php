<?php


class Fltk_TextView implements Flfc_ResponseContent {
	
	protected $text;
	
	public function __construct( $text ) {
		$this->text = $text;
	}
	
	public function render() {
		return $this->text;
	}


}