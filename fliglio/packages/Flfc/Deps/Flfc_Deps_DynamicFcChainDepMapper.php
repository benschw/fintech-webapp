<?php

class Flfc_Deps_DynamicFcChainDepMapper implements Fl_Dep_DependencyMapper {
	
	public function configure(Fl_Dep_DependencyConfig $config) {
		$this->mapConfig($config);
	}
	private function mapConfig(Flfc_Deps_DynamicFcChainDepMapperConfig $config) {
		
		$resolvers = $config->getResolvers();
		
		foreach ($resolvers as $resolver) {
			Flfc_FcChainFactory::addResolver($resolver);
		}

	}
}