<?php

class Fltk_Frame extends Fltk_Component implements Flfc_ResponseContent {

	protected $panel;
	protected $globals = array();
	public function __construct() {
		parent::__construct();
	
	}

	public function getPanel() {       return $this->panel; }
	public function setPanel($val) { $this->panel = $val; return $this->panel; }

	public function setGlobal($key, $val) { $this->globals[$key] = $val; }
	public function getGlobal($key) { return $this->globals[$key]; }
	public function isGlobalSet($key) { return isset($this->globals[$key]); }
	

	/**
	 * @todo figure out a clean way to do this. We want phptal to be required
	 * but don't want a custom class that does nothing just to get picked 
	 * up by the dependency calculator
	 */
	public function render() {
		Vendor_PhpTal_Factory::init();
		$data = $this->getPanel()->getDataPackage();
		
		$template = new PHPTAL($data['template']);
		// $template->baseUrl   = Fl_Core_Config::get()->baseUrl;
		// $template->mediaUrl  = Fl_Core_Config::get()->mediaUrl;
		$template->links  = $this->getLinkManager();
		$template->g      = $this->globals;
		$template->node      = $data['data']; 
		$template->children  = $data['children'];
		$template->response  = Flfc_Context::get()->getResponse()->getProps();
		return $template->execute();
	}

	// facade functionality
	public function add(Fltk_Component $component) { return $this->panel->add($component); }
	public function setCSSID($val) { return $this->panel->setCSSID($val); }
	public function addCSSClass($val) { return $this->panel->addCSSClass($val); }
	public function getCSSID() { return $this->panel->getCSSID(); }
	public function getCSSClass() { return $this->panel->getCSSClass(); }

	protected function getLinkManager() {
		return new Fltk_LinksManager();
	}
}