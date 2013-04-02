<?php
/**
 * 
 * @package Flfc
 */
class Flfc_RoutingApp extends Flfc_MiddleWare {
	
	public function call(Flfc_Context $context) {
		$currentUrl = $context->getRequest()->getCurrentUrl();
		
		/* Strip trailing "/", adding back in namespace if necessary
		 */
		if (substr($currentUrl, -1) == '/' && $currentUrl != '/') {
			$redirect = new Web_Uri($currentUrl);
			if ($context->getRequest()->isPropSet("namespace")) {
				$redirect = Web_Uri::get($context->getRequest()->getProp("namespace"))->combine($redirect);
			}
			$url = new Web_Uri(sprintf("%s://%s/", Web_HttpAttributes::getProtocol(), Web_HttpAttributes::getHttpHost()));
			$url->join($redirect);
			
			$getParams = $context->getRequest()->getParams();
			if (isset($getParams["fliglio_request"])) {
				unset($getParams["fliglio_request"]);
			}
			if (isset($getParams["PHPSESSID"])) {
				unset($getParams["PHPSESSID"]);
			}
			$queryString = count($getParams) > 0 ? '?'.http_build_query($getParams) : ''; 
			
			throw new Flfc_RedirectException("stripping trailing slash", 301, rtrim((string)$url, "/").$queryString);
		}
	
		/* Register RouteMap with Context. Identify current Command
		 */
		$routeMap = new Routing_RouteMap(
			$context->getRequest()->isPropSet("namespace") ? $context->getRequest()->getProp("namespace") : null
		);
		
		$context->setUriLib(new Flfc_Links($routeMap));
		
		$route = $routeMap->getRoute($currentUrl);
		
		
		/* Register Route Parameters
		 */
		$params = $route->getParams();
		$context->getRequest()->setProp('currentRoute', $route);
		$context->getRequest()->setProp('routeParams', $params);

		/* Force pages to their designated protocol (https is default) =======
		 */
		if(Web_HttpAttributes::getProtocol() != $route->getProtocol()) {
			$url = new Web_Uri(sprintf("%s://%s/", $route->getProtocol(), Web_HttpAttributes::getHttpHost()));
			if ($context->getRequest()->isPropSet('namespace')) {
				$url->join($context->getRequest()->getProp('namespace'));
			}
			$url->join($context->getRequest()->getCurrentUrl());
			throw new Flfc_RedirectException('Change Protocol', 301, $url);
		}
		// ===================================================================

		/* Register command
		 */
		$context->getRequest()->setCommand($params['module'] . '.' .  $params['commandGroup'] . '.' . $params['command']);
		
		$this->wrappedApp->call($context);
	}
}
