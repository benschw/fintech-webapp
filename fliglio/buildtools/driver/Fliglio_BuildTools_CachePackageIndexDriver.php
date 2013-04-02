<?php

class Fliglio_BuildTools_CachePackageIndexDriver {
	private $root;
	private $index;
	
	public function __construct($root) {
		$this->root  = rtrim($root, "/");
		$this->index = new stdClass();
	}
	public function getIndex() {
		return $this->index;
	}

	public function addPathToIndex($path) {
		$path = trim($path, "/");
		$this->indexPath($path, new DirectoryIterator($this->root . '/' . $path));
	
	}
	private function indexPath($path, $iterator) {

		foreach ($iterator as $file) {
			$firstChar = substr($file->getFilename(), 0, 1);
			if ($firstChar != '.' && $firstChar != '_') {

				if ($file->isDir()) {

					$this->indexPath($path, new DirectoryIterator($file->getPathname()));

				} else if (strtoupper($firstChar) == $firstChar){

					$fullPath = $iterator->getPathname();

					$fileName      = basename($fullPath);
					$fileNameParts = explode(".", $fileName);
					if (count($fileNameParts) == 2) {
						$className     = $fileNameParts[0];
						$extension     = $fileNameParts[1];

						if ($extension == 'php') {
							$this->index->{$className} = ltrim(substr($fullPath, strlen($this->root)), "/");
						}
					}
				}

			}
		}
	}
	
	public function __toString() {
		return sprintf('<?php return %s;', var_export((array) $this->getIndex(), true));
	}
	
	public static function main(array $config) {
		$root   = $config['root'];
		$paths  = $config['paths'];
		$output = $config['output'];
		
		$driver = new self($root);
		
		$rootLen = strlen($root);
		foreach ($paths as $path) {
			if (substr($path, 0, $rootLen) == $root) {
				$path = substr($path, $rootLen);
			}
			
			$driver->addPathToIndex($path);
		}

		file_put_contents($output, (string) $driver);
	}
}