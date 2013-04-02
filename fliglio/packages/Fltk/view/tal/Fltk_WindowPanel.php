<?php

class Fltk_WindowPanel extends Fltk_Panel {

	protected $jsManager;
	protected $cssManager;
	
	protected $title;
	protected $description;
	
	
	public function __construct( $title, $description = false ) {
		parent::__construct( 'Fltk/WindowPanel.tpl' );
	
		$this->jsManager       = Fltk_JSManager::singleton();
		$this->cssManager      = Fltk_CSSManager::singleton();
		$this->title           = $title;
		$this->description = $description;
	}
	public function setTitle( $val ) {       $this->title = $val; }
	public function setDescription( $val ) { $this->description = $val; }

	public function getData() {
		$data = parent::getData();
		$data['title']             = $this->title;
		$data['description']       = $this->description;
		$data['js']                = array();
		$data['js']['scripts']     = $this->jsManager->getScripts();
		$data['js']['inline']      = $this->jsManager->getInline();
		$data['css']               = array();
		$data['css']['scripts']    = $this->cssManager->getScripts();
		$data['css']['ie6Scripts'] = $this->cssManager->getIE6Scripts();
		$data['css']['ie7Scripts'] = $this->cssManager->getIE7Scripts();
		return $data;
	}


}