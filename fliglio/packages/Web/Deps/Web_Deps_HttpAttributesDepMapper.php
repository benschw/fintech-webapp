<?php

class Web_Deps_HttpAttributesDepMapper implements Fl_Dep_DependencyMapper {
	
	public function configure(Fl_Dep_DependencyConfig $config) {
		$this->mapConfig($config);
	}
	private function mapConfig(Web_Deps_HttpAttributesDepMapperConfig $config) {

		/* Set Incoming Request Protocol */
		Web_HttpAttributes::setProtocol(
			$config->isHttps() ? Web_HttpAttributes::HTTPS : Web_HttpAttributes::HTTP
		);

		/* Set Incoming Request httpHost */
		Web_HttpAttributes::setHttpHost(
			$config->getHostName()
		);

		/* Set Incoming Request Method */
		switch ($config->getRequestMethod()) {
			case $config->getPostType() : 
				Web_HttpAttributes::setMethod(Web_HttpAttributes::METHOD_POST);
				break;
			case $config->getGetType() : 
				Web_HttpAttributes::setMethod(Web_HttpAttributes::METHOD_GET);
				break;
		}
	}
}