<?php

class Fltk_Window extends Fltk_Frame {

	public function __construct($title = '', $description = FALSE) {
		parent::__construct();
		
		$this->setPanel(new Fltk_WindowPanel($title, $description));
	}

}