<?php

class Fliglio_BuildTools_CacheRoutesDriver {
	
	private $routes = array();
	
	public function __construct() {
	
	}
	
	public function addRouteConfig($props) {
		$this->routes[] = $this->transformConfig($props);
	}


	private function transformConfig($props) {
		if (!isset($props['name']) && !isset($props['fl_name'])) {
			throw new Exception("name is required");
		}

		foreach ($props as $key => $prop) {
			if (self::isBvitk($key)) {
				unset($props[$key]);
			} else if (self::isFliglio($key)) {
				unset($props[$key]);
				$props[substr($key, 3)] = $prop;
			}
		}

		$key   = $props['name'];
		$route = isset($props['route']) ? $props['route'] : null;
		unset($props['name']);
		unset($props['route']);
		
		$transformed = '';
		switch ($route) {
			case null :
				$transformed = sprintf("\$arr['%s'] = new Routing_CatchNoneRoute(%s);", $key, var_export($props, true));
				break;
			case "*" :
				$transformed = sprintf("\$arr['%s'] = new Routing_CatchAllRoute(%s);", $key, var_export($props, true));
				break;
			default :
				$className = strpos($route, ':') === false ? 'Routing_StaticRoute' : 'Routing_PatternRoute';
				$transformed = sprintf("\$arr['%s'] = new %s('%s',%s);", $key, $className, $route, var_export($props, true));
		}
			
		return $transformed;
	}
	
	public function __toString() {
		return sprintf("<?php \n\$arr = array(); \n%s \nreturn \$arr;\n", implode("\n", $this->routes));
	
	}

	public static function isBvitk($value) {
		return stristr($value, 'bvitk_');
	}

	public static function isFliglio($value) {
		return stristr($value, 'fl_');
	}

	public static function main(array $config) {
		$output = $config['output'];
		$inputs = $config['input'];
		
		$output = substr($output, 0, 1) == '/' ? $output : realpath(".") . '/' . $output;
		
		$raw = array();
		foreach ($inputs as $input) {
			$input  = substr($input, 0, 1) == '/' ? $input : realpath(".") . '/' . $input;
		
			$tmp  = json_decode(file_get_contents($input), true);
			if (is_null($tmp)) {
				throw new Exception(sprintf("Cannot Parse JSON in '%s'", $input));
			}
			$raw = array_merge($raw, $tmp);
		}
		$routes = array();
		
		$driver = new self();
		foreach ($raw as $route) {
			if (!isset($route["bvitk_name"])) {
				$driver->addRouteConfig($route);
			}
		}

		file_put_contents($output, (string) $driver);
		
	}
}
