<?php

class FlMon_Logstash_Deps_DepMapper implements Fl_Dep_DependencyMapper {
	
	/**
	 * @param Fl_Dep_DependencyConfig $config 
	 * @return void
	 */
	public function configure(Fl_Dep_DependencyConfig $config) {
		$this->mapConfig($config);
	}

	/**
	 * @param FlMon_Logstash_Deps_DepMapperConfig $config 
	 * @return void
	 */
	private function mapConfig(FlMon_Logstash_Deps_DepMapperConfig $config) {
		FlMon_Logstash_Publisher::configure(
			$config->getPath()
		);
	}
}