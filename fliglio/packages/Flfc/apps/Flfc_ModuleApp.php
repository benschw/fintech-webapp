<?php
/**
 * 
 * @package Flfc
 */
class Flfc_ModuleApp extends Flfc_App {
	
	public function call(Flfc_Context $context) {
		list($module, $commandGroup, $command) = explode('.', $context->getRequest()->getCommand());
		$className = "{$module}_{$commandGroup}";
		
		$instance  = new $className($context);
		
		if (!method_exists($instance, $command)) {
			throw new Flfc_CommandNotFoundException("Command '{$command}' does not exist (".$context->getRequest()->getCommand().")");
		}
		
		if (!($instance instanceof Flfc_Routable)) {
			throw new Flfc_CommandNotRoutable("CommandGroups must implement Flfc_Routable: " . get_class($instance));
		}
		
		$to = $instance->{$command}();
		
		if (is_object($to)) {
			$reflector = new ReflectionClass(get_class($to));
			if ($reflector->implementsInterface("Flfc_ResponseContent")) {
				$context->getResponse()->setContent($to);
			}
		}
		
		return $to;
	}
}
