<?php

/**
 * Cache Permissions
 * 
 * Expects the following json array format:
 * <json>
 * {
 * 	 "module"      : string,
 * 	 "checkpoints" : [{
 * 	 		"commandGroup" : string,
 * 	 		"authGroup"    : string,
 * 	 		"commands"     : { method : action },
 * 	 		...
 * 	 }]
 * }
 * </json>
 * 
 */

class Fliglio_BuildTools_CachePermissionsDriver {
	
	private $configData = array();
	
	public function __construct() {
	
	}

	public function addConfig($file) {
		$json = file_get_contents($file);
		$arr  = json_decode($json, true);
		if (is_null($arr)) {
			throw new Exception(sprintf("Cannot Parse permissions JSON in '%s'", $file));
		}
		$this->configData[] = $this->transformConfig($arr);
	
	}

	private function transformConfig($data) {
		if (!isset($data['module']) || !isset($data['checkpoints'])) {
			throw new Exception("Permissions array is not set up correctly, see fliglio-packages/cache-permissions.php for more info. Module & Checkpoints fail.");
		}

		$checkpoints = "array(\n";
		foreach ($data["checkpoints"] as $prop) {
			if (!isset($prop['commandGroup']) || !isset($prop['authGroup']) || !isset($prop['commands']) && !is_array($prop['commands'])) {
				throw new Exception("Permissions array is not set up correctly, see fliglio-packages/cache-permissions.php for more info");
			}

			$checkpoints .= "\t'".$prop['commandGroup']."' => array(\n";
			foreach ($prop['commands'] as $method => $action) {
				$obj = "new Bvi_SegAuth_Permission('".$data["module"]."', '".$prop["commandGroup"]."', '".$method."', '".$action."', '".$prop['authGroup']."')";
				$checkpoints .= "\t\t\t'".$method."' => $obj,\n";
			}
			$checkpoints .= "\t\t),\n";
		}
		$checkpoints .= ")";

		return "\$arr['".$data['module']."'] = ".$checkpoints . ";";
	}

	public function __toString() {
		return sprintf("<?php \n\$arr = array();\n%s \nreturn \$arr;", implode("\n\n", $this->configData));
	}

	public static function main(array $config) {
		$inputfolder = $config['input'];
		$outputFile  = $config['output'];
	
		$driver = new self();
		
		if (is_dir($inputfolder)) {
			foreach(scandir($inputfolder) as $file) {
				$info = pathinfo($inputfolder.$file);
				if ($info['extension'] == 'json') {
					$driver->addConfig($inputfolder.$file);
				}
			}
		} else {
			print "NOTICE: no permissions to cache; generating empty permissions profile.\n";
		}
		file_put_contents($outputFile, (string) $driver);
	
	}
}