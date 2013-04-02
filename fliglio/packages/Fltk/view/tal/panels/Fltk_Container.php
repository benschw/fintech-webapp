<?php

class Fltk_Container extends Fltk_Panel {

	
	public function __construct( $tag = false, $template = 'Fltk/Container.tpl/default' ) {
		parent::__construct( $template );
		$this->data['tagName'] = $tag;
	}

	public function getTagName() { return $this->data['tagName']; }
	public function setTagName( $tag ) {
		$this->data['tagName'] = $tag;
		return $this;
	}
}