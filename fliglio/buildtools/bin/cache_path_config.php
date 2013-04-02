#!/usr/bin/env php
<?php

require_once dirname(__FILE__) . '/bootstrap.php';


function usage($script) {
	$cmd = basename($script);
	
	echo "usage: $cmd [options]\n";
    echo "\n";
	echo "options:\n";
	echo "  -h            this menu\n";
	echo "  -p <key:path> add directory to config\n";
	echo "  -o <file>     output path config file (php)\n";
	echo "\n";
	echo "examples:\n";
	echo "  $cmd -p app:app -p httpdocs:httpdocs -p app.cache:app/cache -p app.modules:app/modules -p app.packages:app/packages -o build/core/path-config.php\n\n";
}
$options = getopt("ho:p:");

if (!$options) {
	usage($argv[0]);
	exit(0);
}

$paths  = array();
$output;

foreach ($options as $key => $value) {
	switch ($key) {
		case "p" :
			$pairs = is_array($value) ? $value : array($value);
			foreach ($pairs as $pair) {
				list($key, $val) = explode(":", $pair);
				$paths[$key] = $val;
			}
			break;
		case "o";
			$output = $value;
			break;
		case "h" :
		default :
			usage($argv[0]);
			exit(0);
	}
}
if (!$output) {
	usage($argv[0]);
	exit(0);
}


$depsView = Fliglio_BuildTools_CachePathConfigDriver::main(array(
	"output" => $output,
	"paths"  => $paths
));

