<?php

/**
 * @fileoverview This file transforms phpunit's version of JUnit xml to actual JUnit xml
 * 
 * This is a known bug in PHPUnit:
 * https://github.com/sebastianbergmann/phpunit/issues/237
 */


function createXmlFiles($xml, $outputDir) {
	$obj   = simplexml_load_string($xml);
	$json  = json_encode($obj);
	$array = json_decode($json, true);

	foreach ($array as $key => $testsuites) {

		if (!isset($testsuites['testsuite'])) {
			continue;
		}

		foreach ($testsuites['testsuite'] as $key => $ts) {
			$suite    = $ts['@attributes'];

			$packages = explode('/', substr($suite['file'], strpos($suite['file'], 'packages')));

			$name     = $packages[0].'.'.$packages[1].'.'.$packages[2].'.'.$suite['name'];

			$cleanXml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
			$cleanXml .= '<testsuite name="'.$name.'" tests="'.$suite['tests'].'" assertions="'.$suite['assertions'].'" failures="'.$suite['failures'].'" errors="'.$suite['errors'].'" time="'.$suite['time'].'">'."\n";

			$fileName = $outputDir.'/TESTS-'.$suite['name'].'.xml';
			$handle   = fopen($fileName, 'w');

			if (isset($ts['testcase']['@attributes'])) {
				$cleanXml .= getTestCaseXml($ts['testcase']);

			} else if (isset($ts['testcase'])) {
				foreach ($ts['testcase'] as $tc) {
					$cleanXml .= getTestCaseXml($tc);
				}
			}

			$cleanXml .= '</testsuite>'."\n";

			fwrite($handle, $cleanXml);
		}
	}
}

function getTestCaseXml($testCase) {
	$attr = $testCase['@attributes'];
	$err  = '';
	$fail = '';

	if (isset($testCase['failure'])) {
		$fail = '<failure>'.$testCase['failure'].'</failure>';
	}

	if (isset($testCase['error'])) {
		$err = '<error message="" type="Error">'.$testCase['error'].'</error>';
	}

	return "\t".'<testcase name="'.$attr['name'].'" class="'.$attr['class'].'" line="'.$attr['line'].'" assertions="'.$attr['assertions'].'" time="'.$attr['time'].'">'.
		$fail.$err.
	'</testcase>'."\n";

}



/**
 * Create JUnit Xml
 *
 * @param input phpunit style "junit" xml
 * @param ouput dir for multiple standard junit xml
 * @author Philip Whitt
 */
createXmlFiles(file_get_contents($argv[1]), $argv[2]);

