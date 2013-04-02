<?php


interface Web_Deps_HttpAttributesDepMapperConfig extends Fl_Dep_DependencyConfig {
	public function isHttps();
	public function getHostName();
	public function getRequestMethod();
	public function getPostType();
	public function getGetType();
}