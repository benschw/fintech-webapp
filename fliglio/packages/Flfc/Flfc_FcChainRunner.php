<?php

class Flfc_FcChainRunner {
	
	private $chain;
	
	public function __construct(Flfc_App $chain = null) {
		$this->chain = $chain;
	}
	
	public function dispatchRequest(Flfc_Context $context) {
		try {
			$chain = Flfc_FcChainFactory::getChain($context);
			$chain->call($context);

		} catch (Flfc_PageNotFoundException $e) {
			$context->getRequest()->setCurrentUrl($context->getRequest()->getPageNotFoundUrl());
			$chain = Flfc_FcChainFactory::getChain($context);

			$chain->call($context);

		} catch (Flfc_InternalRedirectException $e) {
			$context->getRequest()->setCurrentUrl($e->getUrl());
			$chain = Flfc_FcChainFactory::getChain($context);

			$chain->call($context);

		} catch (Exception $e) {
			$context->getRequest()->setCurrentUrl($context->getRequest()->getErrorUrl());
			$context->getRequest()->setProp('exception', $e);
			$chain = Flfc_FcChainFactory::getChain($context);

			$chain->call($context);
		}
	
	}
	
}