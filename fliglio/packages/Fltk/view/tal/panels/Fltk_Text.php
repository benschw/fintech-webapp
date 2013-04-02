<?php

class Fltk_Text extends Fltk_Panel {

	
	public function __construct( $string = '', $tag = false ) {
		parent::__construct( 'Fltk/Text.tpl/default' );
		
		$this->data['tagName'] = $tag;
		$this->data['content'] = $string;
	}
	
	public function getContent() { return $this->data['content']; }
	public function setContent( $val ) { 
		$this->data['content'] = $content; 
		return $this;
	}

}