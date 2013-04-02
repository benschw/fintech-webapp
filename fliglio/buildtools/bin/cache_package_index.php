#!/usr/bin/env php
<?php

require_once dirname(__FILE__) . '/bootstrap.php';


function usage($script) {
	$cmd = basename($script);
	
	echo "usage: $cmd [options]\n";
    echo "\n";
	echo "options:\n";
	echo "  -h           this menu\n";
	echo "  -r <path>    set the path-root for the index\n";
	echo "  -p <path>    add directory to path (relative to path-root)\n";
	echo "  -o <file>    output package index file (php)\n";
	echo "\n";
	echo "examples:\n";
	echo "  $cmd -r deploy/ -p deploy/app/modules -p deploy/app/packages -o build/fliglio/cache/package-index.php\n\n";
}
$options = getopt("hr:p:o:");

if (!$options) {
	usage($argv[0]);
	exit(0);
}

$paths  = array();
$output;
$root;

foreach ($options as $key => $value) {
	switch ($key) {
		case "r";
			$root = $value;
			break;
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



$depsView = Fliglio_BuildTools_CachePackageIndexDriver::main(array(
	"root"   => $root,
	"paths"  => $paths,
	"output" => $output 
));

