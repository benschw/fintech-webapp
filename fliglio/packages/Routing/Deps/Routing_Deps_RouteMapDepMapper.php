<?php

class Routing_Deps_RouteMapDepMapper implements Fl_Dep_DependencyMapper {
	
	public function configure(Fl_Dep_DependencyConfig $config) {
		$this->mapConfig($config);
	}
	private function mapConfig(Routing_Deps_RouteMapDepMapperConfig $config) {

		Routing_RouteMap::setRoutes($config->getRouteDefinitions());
	}
}