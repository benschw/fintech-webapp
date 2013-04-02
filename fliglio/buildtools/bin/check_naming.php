#!/usr/bin/env php
<?php

require_once dirname(__FILE__) . '/bootstrap.php';


function usage($script) {
	$cmd = basename($script);
	
	echo "usage: $cmd [options]\n";
    echo "\n";
	echo "options:\n";
	echo "  -h           this menu\n";
	echo "  -w           display errors as warning (always return \"0\")\n";
	echo "  -f <file>    add file to path\n";
	echo "  -p <path>    add directory to path\n";
	echo "\n";
	echo "examples:\n";
	echo "  $cmd -f deploy/httpdocs/index.php -p deploy/app/packages/ -p deploy/app/modules/\n\n";
}
$options = getopt("hwp:f:");

if (!$options) {
	usage($argv[0]);
	exit(0);
}

$paths     = array();
$files     = array();
$warn      = false;

foreach ($options as $key => $value) {
	switch ($key) {
		case "w";
			$warn = true;
			break;
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



$depsView = Fliglio_BuildTools_CheckNamingDriver::main(array(
	"files" => $files,
	"paths" => $paths,
	"warn"  => $warn
));

