<?php

class Fliglio_BuildTools_DepLib {

	public static function getPackagesList(array $files, array $paths) {
		$packages = array();
		foreach ($paths as $path) {
			$packages = array_merge($packages, self::getPackages(new DirectoryIterator($path)));
		}
		foreach ($files as $file) {
			$packages["_" . basename($file)] = $file;
		}
		return $packages;
	}

	public static function getPackages(DirectoryIterator $iterator, array $ns = array()) {
		$index = array();

		foreach ($iterator as $file) {
			if (substr($file->getFilename(), 0, 1) != '.') {
				if ($file->isDir() && 
						ucfirst($file->getFilename()) == $file->getFilename() &&
						substr($file->getFilename(), 0, 1) != "_"
					) {
					$tmpNs = $ns;
					$tmpNs[] = $file->getFilename();

					$index[implode('.', $tmpNs)] = $file->getPathname();
					$resp = self::getPackages(new DirectoryIterator($file->getPathname()), $tmpNs);

					$index = array_merge($index, $resp);
				}
			}
		}
		return $index;
	}
	
	public static function areDepsEqual($a, $b) {
		$a = array_values($a);
		$b = array_values($b);
		sort($a);
		sort($b);
		return $a == $b;
	}

	public static function getDeclared($bootstrapPath) {
		if (!is_file($bootstrapPath)) {
			return array();
		}

		$fileContents = file_get_contents($bootstrapPath);
		
		if (strpos($fileContents, "<?php") !== 0) {
			throw new Exception("Missing PHP tag in: " . $bootstrapPath);
		}

	    $commentPattern = "/((?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:\/\/.*))/";

	    preg_match_all($commentPattern, $fileContents, $matches); // capture the comments
		$comments = '';
	    foreach($matches[0] as $id => $comment){
			$comments .= $comment;
	    }

		$requiresPattern = "/\@requires\s([\w\.]+)\s/";

	    preg_match_all($requiresPattern, $comments, $matches); // capture the comments

		$packages = array();
	    foreach($matches[1] as $id => $package){
			$packages[] = $package;
	    }

		return $packages;
	}

	public static function getDeps($files, $packages) {
		$strings = array();
		foreach ($files as $file) {
			$tokens = token_get_all(file_get_contents($file)) or die($file);
			foreach ($tokens as $token) {
				if ($token[0] == T_STRING) {
					$str = $token[1];
					foreach ($packages as $package) {
						if (strpos($str, $package . '_') === 0) {
							$parts = explode('_', $str);
							array_pop($parts);

							$strings[] = implode('.', $parts);
						}
					}
				}
			}
		}	
		$strings = array_unique($strings);

		return $strings;
	}

	public static function getFiles($iterator, $package) {
		$index = array();

		foreach ($iterator as $file) {
			if (substr($file->getFilename(), 0, 1) != '.') {
				if ($file->isDir()) {
					if (ucfirst($file->getFilename()) != $file->getFilename()) {
						$files = self::getFiles(new DirectoryIterator($file->getPathname()), $package);

						$index = array_merge($index, $files);
					}
				} else if (strtolower(substr($file->getFilename(), -4)) == '.php'){
					$index[] = $file->getPathName();
				}
			}
		}
		return $index;
	}

}

