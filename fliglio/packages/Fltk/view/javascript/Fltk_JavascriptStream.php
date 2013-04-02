<?php


class Fltk_JavascriptStream implements Flfc_ResponseContent {

	private $script;

	public function __construct( $script ) {
		$this->script = $script;
	}
	
	public function render() {
      return $this->script;
	}

}