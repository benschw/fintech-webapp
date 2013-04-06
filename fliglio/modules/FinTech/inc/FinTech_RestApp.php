<?php

class FinTech_RestApp extends Flfc_MiddleWare {
	
	public function call(Flfc_Context $context) {
		list($module, $commandGroup, $command) = explode('.', $context->getRequest()->getCommand());

		if ($module == 'FinTech' && $commandGroup == 'Services') {
			$method = $_SERVER['REQUEST_METHOD'];

			switch ($method) {
				case 'PUT':
					$command = 'put' . ucfirst($command);
	    			break;
	    		case 'POST':
					$command = 'post' . ucfirst($command);
	    			break;
				case 'GET':
					$command = 'get' . ucfirst($command);
	    			break;
				case 'DELETE':
					$command = 'delete' . ucfirst($command);
	    			break;
			}

			$context->getRequest()->setCommand($module . '.' .  $commandGroup . '.' . $command);
		}

		$this->wrappedApp->call($context);
	}
}
