<?php

class Fl_Dep_Entry {
	private $mapper;
	private $config;
	public function __construct(Fl_Dep_DependencyMapper $mapper) {
		$this->mapper = $mapper;
	}

	public function with(Fl_Dep_DependencyConfig $config) {
		$this->config = $config;
		return $this;
	}

	public function configure() {
		$this->getMapper()->configure($this->getConfig());
		return $this;
	}

	public function getMapper() {
		return $this->mapper;
	}
	public function getConfig() {
		return $this->config;
	}


}