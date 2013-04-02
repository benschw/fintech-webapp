<?php

class Colors {
	
	const GREEN   = 'green';
	const RED     = 'red';
	const WHITE   = 'white';
	const MAGENTA = 'magenta';
	
	private $fgColors = array();
	private $bgColors = array();

	public function __construct() {
		$this->fgColors[self::RED]     = '0;31';
		$this->fgColors[self::MAGENTA] = '0;35';
		$this->fgColors[self::GREEN]   = '0;32';
		$this->fgColors[self::WHITE]   = '1;37';

		// Set up shell colors
		// $this->fgColors['black'] = '0;30';
		// $this->fgColors['dark_gray'] = '1;30';
		// $this->fgColors['blue'] = '0;34';
		// $this->fgColors['light_blue'] = '1;34';
		// $this->fgColors['light_green'] = '1;32';
		// $this->fgColors['cyan'] = '0;36';
		// $this->fgColors['light_cyan'] = '1;36';
		// $this->fgColors['light_red'] = '1;31';
		// $this->fgColors['light_magenta'] = '1;35';
		// $this->fgColors['brown'] = '0;33';
		// $this->fgColors['yellow'] = '1;33';
		// $this->fgColors['light_gray'] = '0;37';
		// 
		// $this->bgColors['black'] = '40';
		// $this->bgColors['red'] = '41';
		// $this->bgColors['green'] = '42';
		// $this->bgColors['yellow'] = '43';
		// $this->bgColors['blue'] = '44';
		// $this->bgColors['magenta'] = '45';
		// $this->bgColors['cyan'] = '46';
		// $this->bgColors['light_gray'] = '47';
	}

	// Returns colored string
	public function getColoredString($string, $fgColor = null, $bgColor = null) {
		$colored_string = "";

		// Check if given foreground color found
		if (isset($this->fgColors[$fgColor])) {
			$colored_string .= "\033[" . $this->fgColors[$fgColor] . "m";
		}
		// Check if given background color found
		if (isset($this->bgColors[$bgColor])) {
			$colored_string .= "\033[" . $this->bgColors[$bgColor] . "m";
		}

		// Add string and end coloring
		$colored_string .=  $string . "\033[0m";

		return $colored_string;
	}


}

