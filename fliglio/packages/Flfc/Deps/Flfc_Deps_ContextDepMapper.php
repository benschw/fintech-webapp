<?php

class Flfc_Deps_ContextDepMapper implements Fl_Dep_DependencyMapper {
	
	public function configure(Fl_Dep_DependencyConfig $config) {
		$this->mapConfig($config);
	}
	private function mapConfig(Flfc_Deps_ContextDepMapperConfig $config) {

		// Initialize Context
		$context = Flfc_Context::get();
		$context->setRequest(new Flfc_Request());
		$context->setResponse(new Flfc_Response());
		$context->setDebug($config->isDebugOn());

		// Set Request Uri
		$context->getRequest()->setCurrentUrl(new Web_Uri(
			'/' . ltrim($config->getRequestUri(), '/')
		));
		$context->getRequest()->setPageNotFoundUrl($config->getPageNotFoundUrl());
		$context->getRequest()->setErrorUrl($config->getErrorUrl());
		
		// Set Input stream / array on Context
		$context->getRequest()->setRawInputStream($config->getRawInputStream());
		$context->getRequest()->setParams($config->getRequestParameters());
		
		// unset $_GET, $_REQUEST, $_POST
		$config->unsetInputSuperGlobals();
	}
}