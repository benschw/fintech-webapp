<?php

class Fltk_CaptchaImage implements Flfc_ResponseContent {

	private $index;
	
	private $width      = 200;
	private $height     = 50;
	private $characters = 6;
	private $bgColor    = 'FFFFFF';
	private $noiseColor = 'EEEEEE';
	private $textColor  = '000000';

	private $font;
	private $fontSize  = 30;          // aim for something around 50% of $height 

	private $captchaCode;
	
	
	public function __construct( Web_Uri $currentUrl ) {
		$this->font = Fl_Core_Config::get()->basePath . 'media/Arial.ttf';
		$this->index = self::getIndexFromUrl( $currentUrl );

		$this->captchaCode = $this->generateCode( $this->characters );

		$lib = Fltk_Captcha::getInstance( $this->index );
		$lib->setSecurityCode( $this->captchaCode );
	}

	public static function getIndexFromUrl( $url ) {
		$parts = explode( '/', $url );
		$img   = array_pop( $parts );
		$index = substr( $img, 0, strpos( $img, '.' ) );
		return $index;
	}
	
	public static function getImagePath( $idx ) {
		return new Web_Uri( self::getImageFileName( $idx ) );
	}
	public static function getImageFileName( $idx ) {
		$salt = substr( time(), -3 );
		return sprintf( "/captcha/%s/%s.jpg", $salt, $idx );
	}


	public function render() {
		$this->fontSize = $this->height * .6;

		$image = imagecreate( (int)$this->width, (int)$this->height );
		if( !$image ) {
			throw new Exception( sprintf( 'Cannot initialize new GD image stream  %s / %s', $this->width, $this->height ) );
		}
		$bgColorArray     = $this->hex2rgb( $this->bgColor );
		$background_color = imagecolorallocate( $image, $bgColorArray[0], $bgColorArray[1], $bgColorArray[2] );

		$textColorArray   = $this->hex2rgb( $this->textColor );
		$text_color       = imagecolorallocate( $image, $textColorArray[0], $textColorArray[1], $textColorArray[2] );

		$noiseColorArray  = $this->hex2rgb($this->noiseColor );
		$noise_color      = imagecolorallocate($image, $noiseColorArray[0], $noiseColorArray[1], $noiseColorArray[2] );


		imagefill( $image, 0, 0, $background_color );

		// generate random dots in background
		// the 3 in the line below means that 1/3 of the pixels in the image will be dotted, randomly
		for( $i=0; $i< ( (int)$this->width * (int)$this->height ) / 3; $i++ ) {
			imagefilledellipse( $image, mt_rand( 0, (int)$this->width ), mt_rand( 0, (int)$this->height ), 1, 1, $noise_color );
		}

		// generate random lines in background
		for( $i=0; $i< ( (int)$this->width * (int)$this->height ) / 75; $i++ ) {
			imageline( $image, mt_rand( 0, (int)$this->width ), mt_rand( 0, (int)$this->height ), mt_rand( 0, (int)$this->width ), mt_rand( 0, (int)$this->height ), $noise_color );
		}

		// create textbox and add text
		// change these calls to die() to throw exceptions?
		$textbox = imagettfbbox( $this->fontSize, 0, $this->font, $this->captchaCode );
		if( !$textbox ) {
			throw new Exception('Error in imagettfbbox function');
		}

		$x = ((int)$this->width  - $textbox[4])/2;
		$y = ((int)$this->height - $textbox[5])/2;

		if( !imagettftext( $image, $this->fontSize, 0, $x, $y, $text_color, $this->font , $this->captchaCode ) ) {
			throw new Exception('Error in imagettftext function');
		}

		/* dump captcha image */
		header('Content-Type: image/jpeg');
		header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		imagejpeg($image);
		imagedestroy($image);
	}

	private static function hex2rgb($hex) {
		$hex = str_replace('#', '', $hex);
		/* this does not account for shorthand hex i.e. #FFF */
		if (strlen($hex) != 6){ return array(0,0,0); }
		$rgb = array();
		for ($x=0;$x<3;$x++){
			$rgb[$x] = hexdec(substr($hex,(2*$x),2));
		}
		return $rgb;
	}

	private function generateCode( $characters ) {
		$possible = '23456789bcdfghjkmnpqrstvwxyz';
		$code     = '';
		$i = 0;
		while ($i < $characters) { 
			$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
			++$i;
		}
		return $code;
	}

}