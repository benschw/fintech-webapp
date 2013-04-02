<?php

/**
 * Autoloader class to manage namespace based package loading & automatic 
 * file loading
 * 
 * @package Fl.Core
 */
class Fl_Core_PackageManager {

	public static $basePath; // public for backwards compatibility, phase out
	
	/* index of classes and their cooresponding files */
	public static $index; // public for backwards compatibility, phase out

	/* relative path to package folders. e.g. array('app/packages', 'app/modules') */
	public static $paths = array(); // public for backwards compatibility, phase out


	/* array of packages that have been loaded */
	private static $packages = array();
	
	public static function configure($basePath, $index, array $paths) {
		self::$basePath = $basePath;
		self::$index    = $index;
		self::$paths    = $paths;
	}
	/**
     * Registers this instance as an autoloader.
     *
     * @param bool $prepend Whether to prepend the autoloader or not
     */
    public static function register($prepend = false) {
        spl_autoload_register(array('Fl_Core_PackageManager', 'load')); // optional args: ", true, $prepend" don't work < 5.3
    }

    /**
     * Unregisters this instance as an autoloader.
     */
    public static function unregister() {
        spl_autoload_unregister(array('Fl_Core_PackageManager', 'load'));
    }
    	
	public static function loadPackage($package) {
		self::performImport($package);
	}

	/**
	 * Magic method registered by bootstrap to find and load a class
	 * 
	 * <code>
	 * spl_autoload_register(array('Fl_Core_PackageManager', 'load'));
	 * </code>
	 * 
	 * @param String className  Class to be loaded
	 */
	public static function load($className) {
		if (!self::$index) {
			throw new Exception("Package index must be set");
		}

		$parts   = explode("_", $className);
		array_pop($parts);
		$package = implode('.', $parts);
		
		if (!in_array($package, self::$packages)) {
			self::$packages[] = $package;
			self::performImport($package);
		}
		
		if(interface_exists($className, false) || class_exists($className, false)) {
			return true;
			
		} else if (isset(self::$index[$className])) {
			require_once sprintf("%s/%s", self::$basePath, self::$index[$className]);

		} else if (!class_exists($className, false)) {
			/* don't error out if this was a class loaded by the bootstrap
			 * (and thus shouldn't be in the index)
			 */
			throw new Exception(sprintf("Class '%s' not found in index for Package '%s'", $className, $package));
		}

		return true;
	}

	/**
	 * Recursively add package to path & optionally run their bootstraps
	 *
	 * @param string $package 
	 * @return void
	 */
	private static function performImport($package) {
		$parts       = explode('.', $package);
		$packagePath = implode('/', $parts);

		foreach (self::$paths as $path) {
			$bootstrap = sprintf("%s/%s/bootstrap.php", $path, $packagePath);
			
			if (is_file($bootstrap)) {
				require_once $bootstrap;
				return;
			}
		}
	}

}