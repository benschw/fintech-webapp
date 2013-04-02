<?php

/**
 * 
 * @package Fl
 */
abstract class Flfc_MiddleWare extends Flfc_App {
	protected $wrappedApp;
	
	public function __construct(Flfc_App $appToWrap) {
		$this->wrappedApp = $appToWrap;
	}
}
