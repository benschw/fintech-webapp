<?php

/**
 * Hold all config properties & provide access to environment constants like
 * paths, protocol, & host name
 * 
 * @package Fl.Core
 */
class Fl_Core_Config {
	
	private static $instance;
	
	public $settings;
	public $debug;

	private $basePath;
	private $paths = array();

	// public $baseUrl;
	// public $mediaUrl;
	      
	/**
	 * Initialize Config
	 *
	 * @param string $basePath         httpdocs root path
	 **/
	public function __construct($basePath, $settings, $paths) {
		$this->basePath = $basePath;

		$this->settings = $settings;
		$this->paths    = $paths;

		$this->debug    = isset($this->settings['settings']['debug']) && (bool) $this->settings['settings']['debug'];
	}
	
	public static function set(Fl_Core_Config $config) {
		self::$instance = $config;
	}
	
	/**
	 * Get existing instance of Fl_Core_Config
	 * 
	 * @return Fl_Core_Config  config class
	 */
	public static function get() {
		if (!self::$instance) {
			throw new Exception("Config hasn't been set up yet");
		}
		return self::$instance;
	}
	
	public function getPath($key=null, $relativePath=false) {
		$numArgs = func_num_args();
		if ($numArgs === 0) {
			return $this->basePath;
		} else {
			if ($relativePath) {
				return $this->paths[$key];
			} else {
				return $this->basePath . '/' . $this->paths[$key];
			}
		}
	}
	
	public static function extendConfig($parent, $child, $envPrefix = null) {
		foreach ($child as $key => $val) {
			if (is_array($val)) {
				$parent[$key] = self::extendConfig(
					isset($parent[$key]) ? $parent[$key] : array(),
					$val,
					$envPrefix
				);
			} else {
				$parent[$key] = !is_null($envPrefix) ? str_replace('##', $envPrefix, $val) : $val;
			}
		}
		return $parent;
	}
	
} 
