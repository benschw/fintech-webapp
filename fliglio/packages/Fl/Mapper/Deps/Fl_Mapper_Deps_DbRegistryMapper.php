<?php


class Fl_Mapper_Deps_DbRegistryMapper implements Fl_Dep_DependencyMapper{

	public function configure(Fl_Dep_DependencyConfig $config) {
		$this->mapConfig($config);
	}
	private function mapConfig(Fl_Mapper_Deps_DbRegistryMapperConfig $config) {
	
		/* Set Databases */
		$arr = $config->getDbArray();
		
		$dbIndex = Fl_Mapper_DatabaseIndex::singleton();
		
		foreach ($arr as $key => $val) {
			$dbIndex->setDatabase($key, $val);
		}
	
	
	}
}

