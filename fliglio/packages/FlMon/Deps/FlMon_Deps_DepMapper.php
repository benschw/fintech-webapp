<?php

class FlMon_Deps_DepMapper implements Fl_Dep_DependencyMapper {
	
	/**
	 * @param Fl_Dep_DependencyConfig $config 
	 * @return void
	 */
	public function configure(Fl_Dep_DependencyConfig $config) {
		$this->mapConfig($config);
	}

	/**
	 * @param FlMon_Deps_DepMapperConfig $config 
	 * @return void
	 */
	private function mapConfig(FlMon_Deps_DepMapperConfig $config) {
		FlMon_Stats_Stats::configure(
			$config->getStatsHost(),
			$config->getStatsPort(),
			$config->getStatsNameSpace()
		);

		if ($config->hasDrivers()) {
			foreach ($config->getDrivers() as $driver => $cfg) {
				FlMon_Logging_Log::get()->addDriver(
					new $driver(
						isset($cfg['config']) ? $cfg['config'] : array()
					), 
					$cfg['levels']
				);
			}
		}
	}
}