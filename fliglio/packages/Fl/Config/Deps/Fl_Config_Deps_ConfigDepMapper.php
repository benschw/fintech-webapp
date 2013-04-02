<?php

class Fl_Config_Deps_ConfigDepMapper implements Fl_Dep_DependencyMapper {
	
	public function configure(Fl_Dep_DependencyConfig $config) {
		$this->mapConfig($config);
	}
	private function mapConfig(Fl_Config_Deps_ConfigDepMapperConfig $config) {

		Fl_Core_Config::set(new Fl_Core_Config(
			$config->getBasePath(), 
			Fl_Core_Config::extendConfig($config->getAppSettings(), $config->getEnvSettings(), $config->getEnvPrefix()), 
			$config->getPaths()
		));
	}
}