<?php

/**
 * @requires Fl.Core
 * @requires Flfc
 * @requires Flfc.Deps
 * @requires Fl.Dep
 * @requires Routing.Deps
 * @requires Fl.Mapper.Deps
 * @requires Util.Db.Deps
 * @requires Web.Deps
 * 
 */
define("APPLICATION_ROOT", dirname(dirname(dirname(dirname(__FILE__)))));

define('FB_APP_ID', '511024752291042');
define('FB_APP_SECRET', 'ca8c167d9d843ea56f837d4e0dd37585');


// load composer
require_once sprintf("%s/vendor/autoload.php", APPLICATION_ROOT);

// Load Package Manager
require_once sprintf("%s/fliglio/packages/Fl/Core/bootstrap.php", APPLICATION_ROOT);

Fl_Core_PackageManager::configure(
	APPLICATION_ROOT,
	(require_once sprintf("%s/build/fliglio/package-index.php", APPLICATION_ROOT)),
	array(
		sprintf("%s/fliglio/packages/", APPLICATION_ROOT), 
		sprintf("%s/fliglio/modules/", APPLICATION_ROOT)
	)
);

Fl_Core_PackageManager::register();
Fl_Core_ErrorHandler::register();


// Inject Deps

require_once APPLICATION_ROOT . "/fliglio/deps.php";

Fl_Dep_Map::singleton()
	->satisfy(new Routing_Deps_RouteMapDepMapper())
	->with(new FlApp_RoutingConfig())
	->configure();


Fl_Dep_Map::singleton()
	->satisfy(new Web_Deps_HttpAttributesDepMapper())
	->with(new FlApp_WebConfig())
	->configure();


// Configure Database
Fl_Dep_Map::singleton()
	->satisfy(new Util_Db_Deps_DbDepMapper())
	->with(new FlApp_DbConfig(array(
		"server" => "localhost",
		"login"  => "root",
		"password" => "",
		"database" => "FinTech"
	)))
	->configure();

Fl_Dep_Map::singleton()
	->satisfy(new Fl_Mapper_Deps_DbRegistryMapper())
	->with(new FlApp_DbConfig())
	->configure();


// Load Front Controller Chain

$chain = new Flfc_DebugApp(new Flfc_HttpApp(new Flfc_RoutingApp(new Flfc_ValidationApp(new Flfc_ModuleApp()))));

$resolver = new Flfc_DefaultFcChainResolver($chain);

Flfc_FcChainFactory::addResolver($resolver);


// Run App

// $chainRunner = new Flfc_FcChainRunner();
// $chainRunner->dispatchRequest(Flfc_Context::get());
