<?php

/**
 * @package Flfc
 */
class Flfc_ValidationApp extends Flfc_MiddleWare {
	
	const PARAM = 'paramValidator';
	const ROUTE = 'routeValidator';
	
	public function call(Flfc_Context $context) {
		
		$request = $context->getRequest();
		
		$validator = new Util_Val_ValidationFacade(new Util_Val_RawRequest($context->getRequest()->getParams()));
		$request->setProp(self::PARAM, $validator);
		
		$validator = new Util_Val_ValidationFacade(new Util_Val_RawRequest($context->getRequest()->getProp('routeParams')));
		$request->setProp(self::ROUTE, $validator);
		
		$this->wrappedApp->call($context);
	}
}