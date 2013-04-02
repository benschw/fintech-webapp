<?php

interface Util_KeyStore_MemCache_Deps_MemCacheDepMapperConfig extends Fl_Dep_DependencyConfig {
	public function getHost();
	public function getPort();
}