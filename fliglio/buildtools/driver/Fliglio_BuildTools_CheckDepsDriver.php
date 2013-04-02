<?php

class Fliglio_BuildTools_CheckDepsDriver {
	
	private $packages = array();
	private $hasErrors = false;
	
	public function __construct() {
	
	}
	
	public function hasErrors() {
		return $this->hasErrors;
	}
	public function setHasErrors($hasErrors) {
		$this->hasErrors = $hasErrors;
	}
	
	public function addPackage($package, $path, $deps, $declared) {
		$this->packages[] = array(
			"package"  => $package,
			"path"     => $path,
			"deps"     => $deps,
			"declared" => $declared
		);
	}

	public function getErrors() {
		$errors = "";
		if ($this->hasErrors()) {
			foreach ($this->packages as $entry) {
				$package  = $entry['package'];
				$path     = $entry['path'];
				$deps     = $entry['deps'];
				$declared = $entry['declared'];

				if (!Fliglio_BuildTools_DepLib::areDepsEqual($deps, $declared)) {

					$c = new Colors(); 
					$errors .= sprintf("Detected dependencies of package '%s' don't match those declared in '%s':\n",$package, $path);

					sort($deps);
					sort($declared);
					$notDeclared = array_diff($deps, $declared);
					$notNeeded   = array_diff($declared, $deps);

					$errors .= "\tDetected but not declared:\n";
					foreach ($notDeclared as $dep) {
						$errors .= "\t  " . $dep . "\n";
					}
					$errors .= "\tDeclared but not detected:\n";
					foreach ($notNeeded as $dep) {
						$errors .= "\t  " . $dep . "\n";
					}
				}
			}
		}
		return $errors;
	}
	
	public static function main(array $config) {
		$files = $config['files'];
		$paths = $config['paths'];
		
		$c = new Colors(); 

		$driver = new self();

		$packages = Fliglio_BuildTools_DepLib::getPackagesList($files, $paths);
		
		foreach ($packages as $package => $path) {
			$root = substr($path, 0, 1) == '/' ? "" : realpath(".") . '/';

			$deps     = array();
			$declared = array();

			try {
				if (substr($package, 0, 1) != "_") {
					$files    = Fliglio_BuildTools_DepLib::getFiles(new DirectoryIterator($path), $package);
					$deps     = Fliglio_BuildTools_DepLib::getDeps($files, array_keys($packages));
					$declared = Fliglio_BuildTools_DepLib::getDeclared($root . $path . '/bootstrap.php');
				} else {
					$inputFile = $path;
					$deps      = Fliglio_BuildTools_DepLib::getDeps(array($inputFile), array_keys($packages));
					$declared  = Fliglio_BuildTools_DepLib::getDeclared($root . $inputFile);
				}

			} catch (Exception $e) {
				print $c->getColoredString("Error Checking Deps:\n", Colors::RED);
				print $e->getMessage();
				exit(1);
			}
			$deps = array_diff($deps, array($package));
		
			sort($deps);
			sort($declared);

			$driver->addPackage($package, $path, $deps, $declared);

			if (!Fliglio_BuildTools_DepLib::areDepsEqual($deps, $declared)) {
				$driver->setHasErrors(true);
			}
		}
		if ($driver->hasErrors()) {
			print $c->getColoredString("Dependency Errors Detected:\n", Colors::RED);
			print $driver->getErrors();
			exit(1);
		}
	}
}
