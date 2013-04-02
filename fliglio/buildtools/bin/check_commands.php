#!/usr/bin/env php
<?php

require_once dirname(__FILE__) . '/bootstrap.php';


function usage($script) {
	$cmd = basename($script);
	
	echo "usage: $cmd [options]\n";
    echo "\n";
	echo "options:\n";
	echo "  -h           this menu\n";
	echo "  -f <file>    add (relative or absolute) file to path\n";
	echo "  -p <path>    add (relative or absolute) directory to path\n";
	echo "\n";
	echo "examples:\n";
	echo "  $cmd -f deploy/httpdocs/index.php -p deploy/app/packages/ -p deploy/app/modules/\n\n";
}
$options = getopt("i:h:f:p:");

if (!$options) {
	usage($argv[0]);
	exit(0);
}

$packages;
$routes;
$deployDir;

foreach ($options as $key => $value) {
	switch ($key) {
		case "i";
			$routes = $value;
			break;
		case "f";
			$packages = $value;
			break;
		case "p";
			$deployDir = $value;
			break;
		case "h" :
		default :
			usage($argv[0]);
			exit(0);
	}
}

// Load Route Objs
$packages = require_once $packages;
function autoLoader($class) {
	global $packages, $deployDir;
	if (isset($packages[$class])) {
		require_once $deployDir.'/'.$packages[$class];
	}
}

spl_autoload_register('autoLoader');

$commandsView = Fliglio_BuildTools_CheckCommandsDriver::main(array(
	"routes"    => include $routes,
	"packages"  => $packages,
	"deployDir" => $deployDir
));

