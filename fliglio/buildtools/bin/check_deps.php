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
$options = getopt("hp:f:");

if (!$options) {
	usage($argv[0]);
	exit(0);
}

$paths     = array();
$files     = array();

foreach ($options as $key => $value) {
	switch ($key) {
		case "f";
			$files = is_array($value) ? $value : array($value);
			break;
		case "p" :
			$paths = is_array($value) ? $value : array($value);
			break;
		case "h" :
		default :
			usage($argv[0]);
			exit(0);
	}
}



$depsView = Fliglio_BuildTools_CheckDepsDriver::main(array(
	"files" => $files,
	"paths" => $paths 
));

