<?php


interface FlMon_Deps_DepMapperConfig extends Fl_Dep_DependencyConfig {

	public function getDrivers();
	public function hasDrivers();
	public function getStatsHost();
	public function getStatsPort();
	public function getStatsNameSpace();

}