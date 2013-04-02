#!/usr/bin/env php
<?php

require_once dirname(__FILE__) . '/bootstrap.php';


function usage($script) {
	$cmd = basename($script);
	
	echo "usage: $cmd [options]\n";
    echo "\n";
	echo "options:\n";
	echo "  -h           this menu\n";
	echo "  -p <path>    add (relative or absolute) directory to path\n";
	echo "  -o <path>    output config path\n";
	echo "\n";
	echo "examples:\n";
	echo "  $cmd -p src/fliglio/config/ -p src/fliglio/core-config/ -o build/fliglio/cache\n\n";
}
$options = getopt("hp:o:");

if (!$options) {
	usage($argv[0]);
	exit(0);
}

$paths = array();
$output;

foreach ($options as $key => $value) {
	switch ($key) {
		case "p" :
			$paths = is_array($value) ? $value : array($value);
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



$depsView = Fliglio_BuildTools_CacheConfigsDriver::main(array(
	"paths"  => $paths,
	"output" => $output 
));

