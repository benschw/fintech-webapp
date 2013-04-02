<?php


class Fltk_Javascript implements Flfc_ResponseContent {

	private $src;

	public function __construct( $src ) {
		$this->src = $src;
	}
	
	
	public function getRendered() {
		return file_get_contents( Fl_Core_Config::get()->mediaPath . $src );
	}
	
	public function render() {
      return $this->getRendered();
	}

}