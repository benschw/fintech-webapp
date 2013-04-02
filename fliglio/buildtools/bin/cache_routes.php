#!/usr/bin/env php
<?php

require_once dirname(__FILE__) . '/bootstrap.php';


function usage($script) {
	$cmd = basename($script);
	
	echo "usage: $cmd [options]\n";
    echo "\n";
	echo "options:\n";
	echo "  -h           this menu\n";
	echo "  -i <file>    routes config file (json)\n";
	echo "  -o <file>    output routes config file (php)\n";
	echo "\n";
	echo "examples:\n";
	echo "  $cmd -i src/fliglio/config/routes.json -o build/fliglio/cache/routes.php\n\n";
}
$options = getopt("hi:o:");

if (!$options) {
	usage($argv[0]);
	exit(0);
}

$input;
$output;

foreach ($options as $key => $value) {
	switch ($key) {
		case "i" :
			$input = $value;
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



$depsView = Fliglio_BuildTools_CacheRoutesDriver::main(array(
	"input"  => is_array($input) ? $input : array($input),
	"output" => $output 
));

