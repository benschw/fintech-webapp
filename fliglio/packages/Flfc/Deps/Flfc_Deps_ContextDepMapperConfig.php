<?php


interface Flfc_Deps_ContextDepMapperConfig extends Fl_Dep_DependencyConfig {

	public function isDebugOn();
	public function getRequestUri();
	public function getRawInputStream();
	public function getRequestParameters();
	public function unsetInputSuperGlobals();
}