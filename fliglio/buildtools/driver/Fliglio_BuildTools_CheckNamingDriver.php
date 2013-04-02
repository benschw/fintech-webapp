<?php

class Fliglio_BuildTools_CheckNamingDriver {

	private $idx;
	
	public function __construct() {
	
	}
	
	public function getIndex() {
		return $this->idx;
	}
	
	public function addPackage($package, $path, $files) {
		$this->idx[$package] = array(
			"path"   => $path,
			"files"  => $files,
			"errors" => $this->testPackage($package, $path, $files)
		);
	}
	
	private function testPackage($package, $path, $files) {
		$errors = array();

		$ns = explode(".", $package);
		
		$packageRoot = $path;// . '/' . implode("/", $ns);
		// error_log($packageRoot);
		$packageRootLen = strlen($packageRoot);
		foreach ($files as $filePath) {
			$fileName = basename($filePath);
			
			
			// if filename starts with lowercase character, do a different set of checks
			if (ctype_lower(substr($fileName, 0, 1))) {

			} else {
				// Test that the expected package root is indeed it's package root
				if (substr($filePath, 0, $packageRootLen) != $packageRoot) {
					$errors[] = $filePath . " doesn't seem to be in the correct package directory.";
				} else {
				
					// Test that the declared package matches the folder structure
					$pathParts = explode("/", $path);
					$flag = false;
					for ($i = count($ns) - 1; $i > 0; $i--) {

						if (array_pop($pathParts) != $ns[$i]) {
							$flag = true;
							$errors[] = $ns . " doesn't match folder structure";
						}
					}
				
					// Test that the filename matches the package it belongs to
					if (!$flag) {
						$fileNs = explode("_", basename($filePath, ".php"));
						array_pop($fileNs);

						if ($ns != $fileNs) {
							$errors[] = $fileName . " doesn't belong to package: " . $package;

						// Test Contents of file for accuracy
						} else {

							$errors = array_merge($errors, $this->testFileContents($filePath));
						}

					}
				}
			}
		}
		
		return $errors;
	}

	private function testFileContents($filePath) {
		$errors = array();
		
		$parser        = new PHPParser_Parser(new PHPParser_Lexer);
		$prettyPrinter = new PHPParser_PrettyPrinter_Zend;


		$collector    = new Fliglio_BuildTools_ParserCollector($filePath);
		$traverser    = new PHPParser_NodeTraverser;
		$traverser->addVisitor($collector);

		try {
			$stmts = $parser->parse(file_get_contents($filePath));
		} catch (Exception $e) {
			echo "PHP SYNTAX ERROR in file ".$filePath;
			throw new Exception("PHP SYNTAX ERROR");
		}

		$stmts = $traverser->traverse($stmts);

		$file    = $collector->getFile();
		$classes = $collector->getClasses();
		if (count($classes) != 1) {
			$errors[] = count($classes) . " classes found in " . $filePath;
		} else {
			$class    = $classes[0];
			$fileName = basename($filePath);
			if ($class . '.php' != $fileName) {
				$errors[] = "Filename " . $fileName . " doesn't match containing class " . $class;
			}
			
		}
		
		return $errors;
	}

	public static function main(array $config) {
		$files = $config['files'];
		$files = array(); // not doing anything with files yet
		$paths = $config['paths'];
		$warn  = $config['warn'];
	
		$c = new Colors(); 

		$driver = new self();

		$packages = Fliglio_BuildTools_DepLib::getPackagesList($files, $paths);

		foreach ($packages as $package => $path) {

			$deps     = array();
			$declared = array();

			$files    = Fliglio_BuildTools_DepLib::getFiles(new DirectoryIterator($path), $package);

			$driver->addPackage($package, $path, $files);
		}
		$fail = false;
		foreach ($driver->getIndex() as $package => $data) {
			// print_r($data);
			if (count($data['errors']) != 0) {
				$fail = true;
				if ($warn) {
					print "WARNING: ";
				} else {
					print "ERROR: ";
				}
				print "Problems detected in package " . $package . "\n";
				foreach ($data['errors'] as $error) {
					print "\t" . $error . "\n";
				}
			}
		}
		
		if (!$warn && $fail) {
			exit(1);
		}
		
	}
}