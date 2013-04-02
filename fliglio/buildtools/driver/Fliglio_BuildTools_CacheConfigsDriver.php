<?php

class Fliglio_BuildTools_CacheConfigsDriver {

	public function __construct() {}

	public static function configExtend($child, $parent) {
		foreach ($child as $key => $val) {
			if (is_object($val)) {
				$parent->$key = self::configExtend($val, isset($parent->$key) ? $parent->$key : new stdClass());
			} else {
				$parent->$key = $val;
			}
		}
		return $parent;
	}

	private static function createVo($target) {
		$vo = array();

		if (is_array($target)) {
			foreach ($target as $key => $val) {
				$vo[$key] = self::createVo($val);
			}

		} else if (is_object($target)) {
			$vo = self::createVo((array)$target);

		} else {
			$vo = $target;
		}

		return $vo;
	}

	public static function cacheConfig($configPaths, $env, $type, $outputPath) {
		$l = count($configPaths);
		$outputFileName = sprintf("%s/%s-%s.php", $outputPath, $type, $env);

		$configs = array();
		$i = 0;
		while (!is_null($env)) {
			$path = null;
			foreach ($configPaths as $configPath) {
				$p = sprintf("%s/%s-%s.json", $configPath, $type, $env);
				if (is_file($p)) {
					$path = $p;
				}
			}
			if (is_null($path)) {
				throw new Exception(sprintf("Couldn't find config file for '%s'", $env));
			}
			$tmp  = json_decode(file_get_contents($path));
			if (is_null($tmp)) {
				throw new Exception(sprintf("Cannot Parse Config JSON in '%s'", $path));
			}
			$configs[] = $tmp;

			$env = isset($tmp->extends) ? $tmp->extends : null;
		}

		$compiled = new stdClass();

		while ($config = array_pop($configs)) {
			$compiled = self::configExtend($config, $compiled);
		}

		$arr = self::createVo($compiled);

		file_put_contents($outputFileName, sprintf('<?php return %s;', var_export($arr, true)));

		return true;
	}
	
	public static function main(array $config) {
		$configPaths = $config['paths'];
		$outputPath  = $config['output'];
		
		$index = array();
		foreach ($configPaths as $configPath) {
			$iter = new DirectoryIterator($configPath);
			foreach ($iter AS $file) {
				if (strtolower(substr($file->getFilename(), -5)) == '.json') {
					$tmp  = json_decode(file_get_contents($file->getPathName()), true);
					if (is_null($tmp)) {
						throw new Exception(sprintf("Cannot Parse Config JSON in '%s'", $file->getPathName()));
					}

					if (isset($tmp['env'])) {
						self::cacheConfig($configPaths, $tmp['env'], $tmp['type'], $outputPath);
					}
				}
			}
		}
	}
}