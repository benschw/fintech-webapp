<?php

class Fltk_ImageButton {
	public $id;
	public $class;

	public $src;
	public $alt;
	public $link;
	
	public function __construct( $link, $src, $alt ) {
		$this->link = $link;
		$this->src  = $src;
		$this->alt  = $alt;
	}

	public function setId( $id ) { $this->id = $id; }
	public function addClass( $class ) {
		$classes     = explode( " ", $this->class );
		$classes[]   = $class;
		$this->class = implode( " ", array_unique( $classes ) );
	}

}