<?php

class Util_Db_Deps_DbDepMapper implements Fl_Dep_DependencyMapper {
	
	public function configure(Fl_Dep_DependencyConfig $config) {
		$this->mapConfig($config);
	}
	private function mapConfig(Util_Db_Deps_DbDepMapperConfig $config) {
	
		/* Configure Database Factory */

		Util_Db_DbFactory::setDriver($config->getDriver());
		Util_Db_DbFactory::setConnection($config->getConnection());
	}
}