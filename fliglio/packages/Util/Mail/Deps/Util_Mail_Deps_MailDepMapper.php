<?php

class Util_Mail_Deps_MailDepMapper implements Fl_Dep_DependencyMapper {
	
	public function configure(Fl_Dep_DependencyConfig $config) {
		$this->mapConfig($config);
	}
	private function mapConfig(Util_Mail_Deps_MailDepMapperConfig $config) {
	
		Util_Mail_MailFactory::registerDriverFactory($config->getDriverFactory());
	}
}