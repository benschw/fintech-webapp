<?php

class Flfc_Deps_FcChainDepMapper implements Fl_Dep_DependencyMapper {
	
	public function configure(Fl_Dep_DependencyConfig $config) {
		$this->mapConfig($config);
	}
	private function mapConfig(Flfc_Deps_FcChainDepMapperConfig $config) {

		Flfc_FcChainFactory::setChain($config->getChain());

	}
}