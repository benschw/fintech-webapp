<?php

/**
 *
 * @package FinTech
 */
class FinTech_Ui implements Flfc_Routable {
	/**
	 * @var Flfc_Context
	 */
	private $context;

	public function __construct(Flfc_Context $context) {
		$this->context = $context;
		
	}
	
	/**
	 * Handle errors (in production, just do a 404 page)
	 *
	 * @return Fltk_Window
	 */
	public function handleError() {
		$this->context->getResponse()->setStatus(500);
		
		$msg = $this->context->getRequest()->getProp('exception')->getMessage();
		
		return new Fltk_JsonView(array(
			"error" => $msg
		));
	}

	/**
	 * 404 - Page Not Found
	 * 
	 * @return Fltk_Window
	 */
	public function pageNotFound() {
		$this->context->getResponse()->setStatus(404);
		
		return new Fltk_JsonView(array(
			"error" => "Page Not Found"
		));
	}
	
	
}
