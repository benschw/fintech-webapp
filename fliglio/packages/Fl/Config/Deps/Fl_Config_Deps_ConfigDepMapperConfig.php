<?php


interface Fl_Config_Deps_ConfigDepMapperConfig extends Fl_Dep_DependencyConfig {

	public function getBasePath();
	public function getPaths();
	public function getEnvSettings();
	public function getAppSettings();
	public function getEnvPrefix();
}