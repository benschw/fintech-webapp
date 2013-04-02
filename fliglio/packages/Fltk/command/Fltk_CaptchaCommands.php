<?php

class Fltk_CaptchaCommands implements Flfc_Routable {

	private $context;
	
	public function __construct( Flfc_Context $context ) {
		$this->context = $context;
	}
	
	public function loadImage() {
		Fl_Core_Config::$debug = 0;
		$this->context->getResponse()->setContent(
			new Fltk_CaptchaImage( $this->context->getRequest()->getCurrentUrl() )
		);
	}
}
