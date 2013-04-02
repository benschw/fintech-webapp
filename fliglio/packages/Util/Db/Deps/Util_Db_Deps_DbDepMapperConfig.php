<?php

interface Util_Db_Deps_DbDepMapperConfig extends Fl_Dep_DependencyConfig {

	public function getDriver();
	public function getConnection();
}