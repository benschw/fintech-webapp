<?php

class Fliglio_BuildTools_CheckCommandsDriver {
	
	const VALID_INTERFACE = 'Flfc_Routable';
	
	private $parser;
	private $packages;
	private $deployDir;
	private $errors  = array();
	private $warning = array();
	
	public function __construct($packages, $deployDir) {
		$this->packages  = $packages;
		$this->deployDir = $deployDir;
		$this->parser    = new PHPParser_Parser(new PHPParser_Lexer);
	}

	public function getErrors() {
		$out = '';
		foreach ($this->errors as $count => $errStr) {
			$out .= 'ERROR: '.$errStr.($count == (count($this->errors)-1) ? '' : "\n");
		}
		return $out;
	}

	public function getWarnings() {
		$out = '';
		foreach ($this->warning as $count => $errStr) {
			$out .= 'WARNING: '.$errStr.($count == (count($this->errors)-1) ? '' : "\n");
		}
		return $out;
	}

	public function hasErrors() {
		return count($this->errors) > 0;
	}

	public function hasWarnings() {
		return count($this->warning) > 0;
	}

	public function validateCommand($routeName, Routing_Route $route) {
		$params = $route->getParams();
		
		$cmd = null;
		if (!isset($params['module']) || !isset($params['commandGroup'])) {
			// Enforce route param security
			if ($route instanceof Routing_PatternRoute) {
				foreach ($route->getArgsToCapture() as $arg) {
					if ($arg == 'module' || $arg == 'commandGroup') {
						$this->warning[$routeName] = sprintf('Cannot enforce dynamic %s call in route "%s"', $arg, $routeName);
					}
				}
				return false;
			}
		} else {
			$cmd = $params['module'] . '_' .  $params['commandGroup'];
		}

		// If command group isn't found, there's nothing to check
		if (is_null($cmd)) {
			$this->warning[$routeName] = sprintf('Could not find module or commandGroup for route "%s"', $routeName);
			return false;
		}

		// If command group isn't found, there's nothing to check
		if (!isset($this->packages[$cmd])) {
			$this->warning[$routeName] = sprintf('Command group "%s" not found in package index!', $cmd);
			return false;
		}

		// Get src location
		$location = $this->deployDir.'/'.$this->packages[$cmd];

		// Get src
		$src = file_get_contents($location);

		// Parse src
		$stmts = $this->parser->parse($src);

		// Ensure there is only one class found in file
		if (count($stmts) > 1) {
			$this->errors[$this->packages[$cmd]] = sprintf('More than one class found in file %s', $this->packages[$cmd]);
			return false;
		}
		
		// Iterate over all interfaces and find valid interface
		foreach ($stmts[0]->implements as $interface) {
			if ($interface->toString() == self::VALID_INTERFACE) {
				return true;
			}
		}
		
		$this->errors[$cmd] = sprintf('Route command group, %s, must implement %s', $cmd, self::VALID_INTERFACE);
		return false;
	}

	/**
	 * Driver::Main()
	 *
	 * @param array $config 
	 * @return void
	 */
	public static function main(array $config) {
		$routes    = $config['routes'];
		$packages  = $config['packages'];
		$deployDir = $config['deployDir'];

		$c      = new Colors(); 
		$driver = new self($packages, $deployDir);

		foreach ($routes as $name => $route) {
			$driver->validateCommand($name, $route);
		}

		if ($driver->hasWarnings()) {
			print "Route Command Warnings:\n";
			print $driver->getWarnings();
			print "\n";
		}

		if ($driver->hasErrors()) {
			print $c->getColoredString("Route Command Errors:\n", Colors::RED);
			print $driver->getErrors();
			exit(1);
		}
	}
}

