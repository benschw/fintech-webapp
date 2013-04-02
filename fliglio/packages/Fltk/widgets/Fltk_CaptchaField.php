<?php

class Fltk_CaptchaField {
	
	const INDEX_KEY = 'fl-captchaIdx';
	const CODE_KEY  = 'fl-captchaCode';

	private $captchaID;

	public $isFreeTry;
	public $button;
	
	public $hiddenField = array(
		'value' => null,
		'name'  => self::INDEX_KEY,
		'id'    => self::INDEX_KEY
	);

	public $codeField = array(
		'name'  => self::CODE_KEY,
		'id'    => self::CODE_KEY
	);

	public function __construct( Fltk_Captcha $lib ) {
		$this->captchaID   = $lib->getStorageIndex();
		$this->showCaptcha = !$lib->isFreeTry();
		
		$this->hiddenField['value'] = $this->captchaID;
		
		$this->button = new Fltk_ImageButton( FALSE, Fltk_CaptchaImage::getImagePath( $this->captchaID ), 'Captcha Image' );

	}
}

/*

<input type="hidden" value="1211298" name="roi-captchaID" id="roi-captchaID"/>

<div id="captcha">
	<h4>Security Code</h4>
	<img src="https://www.jdbank.com/blockbuilder/Captcha/load/Tal/?captchaID=1211298&amp;r=058"/>
	<p><input type="text" id="roi-captchaCode" name="roi-captchaCode"/></p>
	<p>Please enter the letters and numbers from the image above.</p>
</div>
*/