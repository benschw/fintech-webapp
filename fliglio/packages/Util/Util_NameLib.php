<?php
/**
 * Utilities to generate unique names
 * 
 * @package Util
 */
class Util_NameLib {

	/**
	 * Get unique version of a requested name.
	 * Increment a counter and append it to "base" until a unique name is
	 * found. A name is unique if it doesn't exist in the names array.
	 * 
	 * @param String[] $names  array of current names
	 * @param String   $base   desired name
	 * @param String   base + a number to make it unique
	 */
	public static function getNewName(array $names, $base) {

		if ($names) {
			sort($names);
		} else {
			$names = array();
		}

		$l = count($names) + 1;
		for ($i = 1; $i <= $l; $i++) {
			$test = $base . ($i == 1 ? "" : " {$i}");
			if (!in_array($test, $names)) {
				return $test;
			}
		}

		return $base;
	}

	/**
	 * Get unique copy-name of a requested name.
	 * Append the word "copy" and increment a counter and append it to 
	 * "base" until a unique name is found. A name is unique if it 
	 * doesn't exist in the names array.
	 * 
	 * @param String[] $names  array of current names
	 * @param String   $base   desired name
	 * @param String   base + copy & a number to make it unique
	 */
	public static function getCopyName(array $names, $base) {
		$newBase = $base;
		$nameArr = explode(" ", $base);

		if ($nameArr[count($nameArr) - 1] == 'copy') {

			array_pop($nameArr);
			$newBase = implode(" ", $nameArr);

		} else if ($nameArr[count($nameArr) - 2] == 'copy') {

			array_pop($nameArr);
			array_pop($nameArr);
			$newBase = implode(" ", $nameArr);

		}
		$tryForMain = self::getNewName($names, $newBase);
		if ($tryForMain == $newBase) {
			return $newBase;
		} else {
			return self::getNewName($names, $newBase . ' copy');
		}
	}

	/**
	 * Get unique name of a requested filename for a given path.
	 * Increment a counter and append it the filename (respecting extension) 
	 * until a unique name is found. A name is unique if it doesn't exist 
	 * in the names array.
	 * 
	 * @param String $destPath        oath to make filename unique in
	 * @param String $desiredFileName desired filename
	 * @param String   unique version (add a counter to the end) of fileName
	 */
	public static function getCleanFileName($destPath, $desiredFileName) {
		if (!is_dir($destPath)) { 
			throw new Exception("directory to create file in does not exist"); 
		}
		if (!is_writable($destPath)) { 
			throw new Exception("directory to create file in is not writable"); 
		}
		$destPath  = rtrim($destPath, '/') . '/';
		$parts     = explode('.', $desiredFileName);
		$extension = strtolower(array_pop($parts));
		$baseName  = preg_replace("/\s+/", "-", implode('.', $parts));
		$baseName  = preg_replace("/[^a-z0-9\-]/i", "", $baseName);

		$i = 0;
		
		do {
			$testFile = sprintf( 
				"%s%s.%s", 
				$baseName, 
				$i == 0 ? '' : $i,
				$extension
			);
			if (!is_file($destPath . $testFile)) {
				return $testFile;
			}
		} while (++$i && ($i < 100));

		throw new Exception("Infinite Loop Detected while trying to find a unique file name");
	}

}
