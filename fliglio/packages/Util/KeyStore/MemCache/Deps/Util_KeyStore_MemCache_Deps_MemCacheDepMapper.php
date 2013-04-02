<?php

class Util_KeyStore_MemCache_Deps_MemCacheDepMapper implements Fl_Dep_DependencyMapper {
	
	public function configure(Fl_Dep_DependencyConfig $config) {
		$this->mapConfig($config);
	}
	private function mapConfig(Util_KeyStore_MemCache_Deps_MemCacheDepMapperConfig $config) {

		Util_KeyStore_MemCache_Driver::configure($config->getHost(), $config->getPort());

	}
}