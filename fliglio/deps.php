<?php

class FlApp_ContextConfig implements Flfc_Deps_ContextDepMapperConfig {

	private $config;
	public function __construct(){
	}
	
	public function isDebugOn() {
		return true;
	}
	public function getRequestUri() {
		if (!isset($_GET['fliglio_request'])) {
			throw new Exception("'fliglio_request' not set");
		}
		return $_GET['fliglio_request'];
	}
	public function getPageNotFoundUrl() {
		return new Web_Uri("@404");
	}
	public function getErrorUrl() {
		return new Web_Uri("@error");
	}
	public function getRawInputStream() {
		return file_get_contents('php://input');
	}
	public function getRequestParameters() {
		return $_REQUEST;
	}
	public function unsetInputSuperGlobals() {
		// unset($_REQUEST);
		// unset($_POST);
		// unset($_GET);
	}
}


class FlApp_RoutingConfig implements Routing_Deps_RouteMapDepMapperConfig {

	private $config;
	public function __construct() {
	}
	
	public function getRouteDefinitions() {
		$path = APPLICATION_ROOT . '/build/fliglio/routes.php';
		if (is_file($path)) {
			return (require_once $path);
		} else {
			return array();
		}
	}

}


class FlApp_WebConfig implements Web_Deps_HttpAttributesDepMapperConfig {
	const POST = 'post';
	const GET  = 'get';
	public function __construct() {
	}
	
	public function isHttps() {
		/* Detect & Set protocol */
		$apacheIsHttps = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on';
		$f5IsHttps     = isset($_SERVER['ROI_HTTPS_REQUEST']) && strtolower($_SERVER['ROI_HTTPS_REQUEST']) == 'on';
		return $apacheIsHttps || $f5IsHttps;
	}
	
	public function getHostName() {
		return isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : (
			isset($_SERVER['HOSTNAME']) ? $_SERVER['HOSTNAME'] : (
				isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : (
					isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : (
						'localhost'
					)
				)
			)
		);
	
	}
	public function getRequestMethod() {
		return isset($_SERVER['REQUEST_METHOD']) ? strtolower($_SERVER['REQUEST_METHOD']) : null;
	}
	public function getPostType() {
		return self::POST;
	}
	public function getGetType() {
		return self::GET;
	}

}


class FlApp_DbConfig implements Util_Db_Deps_DbDepMapperConfig, Fl_Mapper_Deps_DbRegistryMapperConfig {
	private $cfg;
	public function __construct($cfg = array()) {
		$this->cfg = $cfg;
	}
	
	public function getDriver() {
		return new Util_Db_MysqlDriver();
	}

	public function getConnection() {
		return new Util_Db_MysqlConnection( 
			$server   = $this->cfg['server'],
			$login    = $this->cfg['login'],
			$password = $this->cfg['password'],
			$database = $this->cfg['database']
		);
	}
	
	public function getDbArray() {
		return array(
			Fl_Mapper_DatabaseIndex::SEGUNDO => '',
		);
	}

}

