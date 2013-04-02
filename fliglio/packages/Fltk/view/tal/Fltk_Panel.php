<?php

class Fltk_Panel extends Fltk_Component {

	protected $template;
	protected $templatePathIsAbsolute;
	protected $data = array();
	protected $cssID;
	protected $cssClass = array();
	
	
	protected $components = array();
	
	public function __construct( $template = 'Fltk/Panel.tpl/default') {
		parent::__construct();
		$this->template = $template;
	}
	public function isParamSet( $key ) {     return isset( $this->data[$key] ); }
	public function getParam( $key ) {       return $this->data[$key]; }
	public function setParam( $key, $val ) { $this->data[$key] = $val; return $this; }
	
	public function add( Fltk_Component $component ) {
		$this->components[] = $component;
		return $component;
	}
	public function injectPanel( Fltk_Component $component ) {
		$tmp = $this->components;
		$this->components = array();
		$inner = $this->add( $component );
		foreach( $tmp AS $comp ) {
			$inner->add( $comp );
		}
		return $component;
	}
	public function getComponents() { return $this->components; }

	public function setTemplate( $val, $relative = false ) { 
		$this->template = $val; 
		$this->templatePathIsAbsolute = !$relative;
	}
	public function isTemplatePathAbsolute() { return $this->templatePathIsAbsolute; }
	public function getTemplate() { return $this->template; }
	
	final public function getDataPackage() {
		$data  = array();
		
		if ( $this->isTemplatePathAbsolute() ) {
			$data['template'] = $this->getTemplate();
		}
		else {
			throw new Exception('app.tpl is deprecated');
			$data['template'] = Fl_Core_Config::get()->getPath('app.tpl') . '/' . $this->getTemplate();
		}
		
		$this->formatData();
		$data['data'] = $this->getData();
		$data['children'] = array();

		foreach ( $this->getComponents() AS $component ) {
			if ( !$component ) {
			}
			$data['children'][] = $component->getDataPackage();
		}
		return $data;
	}
	public function formatData() {
		$this->data['cssID']    = $this->getCSSID();
		$this->data['cssClass'] = $this->getCSSClass();
	}
	public function getData() { 
		return $this->data;
	}

	public function setCSSID( $val ) { 
		$this->cssID = $val; 
		return $this;
	}
	public function addCSSClass( $val ) { 
		if( !is_array( $val ) ) {
			$val = array( $val );
		}
		$this->cssClass = array_unique( array_merge( $this->cssClass, $val ) );
		return $this;
	}

	public function getCSSID() { return $this->cssID; }
	public function getCSSClass() { return implode( " ", $this->cssClass ); }



}