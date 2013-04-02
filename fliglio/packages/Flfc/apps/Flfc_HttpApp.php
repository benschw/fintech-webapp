<?php
/**
 * 
 * @package Flfc
 */
class Flfc_HttpApp extends Flfc_MiddleWare {
	public function call(Flfc_Context $context) {

		$context->getResponse()->addHeader("X-Server", isset($_SERVER["HOSTNAME"]) ? $_SERVER["HOSTNAME"] : 'Unknown');

//		$context->getResponse()->setProp('flares', Fltk_Flares::get());

		/* Set up headers
		 */
		if (function_exists('apache_request_headers')) {
			$headers = apache_request_headers();
		} else {
			$headers = array();
			foreach ($_SERVER as $key => $val) {
				if (substr($key, 0, 5) == 'HTTP_') {
					$key = substr($key, 5);
					$headers[strtolower(str_replace('_', '-', $key))] = $val;
				} else if (strtolower($key) == 'authorization') {
					$headers['authorization'] = $val;
				}
					
			}
		}

		foreach ($headers as $key => $val) {
			$context->getRequest()->addHeader($key, $val);
		}
		
		/* Call Child App
		 */
		try {
			$this->wrappedApp->call($context);
		} catch (Flfc_RedirectException $e) {
			$context->getResponse()->addHeader("Location", (string)$e->getLocation());
			$context->getResponse()->setStatus($e->getStatusCode());
		}

		$response = $context->getResponse();

		$status = $response->getStatus();

		if ($status->code != 200) {
			$response->addHeader("HTTP/1.1 " . $status->code, $status->message);
		}
		
		if ($response->getContent() instanceof Flfc_HasHeadersToSet) {
			$response->getContent()->setHeadersOnResponse($response);
		}
		
		$headers = $response->getHeaders();
		
		foreach ($headers AS $key => $val) {
			header($key . ": " . $val);
		}

		if ($response->getContent()) {
			switch (true) {
				case $response->getContent() instanceof Flfc_Streamable :
					$response->getContent()->stream();
					break;
				case $response->getContent() instanceof Flfc_ResponseContent :
					print $response->getContent()->render();
					break;
			}
		}
	}
}
