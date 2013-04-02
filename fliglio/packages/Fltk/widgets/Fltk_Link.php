<?php


class Fltk_Link {
	public $id;
	public $class;

	public $href;
	public $title;
	public $content;
	public $target;
	
	public function __construct( Web_Uri $url, $content = null, $target = null ) {
		$this->setURL( $url );
		$this->setContent( $content );
		$this->setTarget( $target );
	}

	public function getUrl() {     return (string)$this->url; }
	public function getTitle() {   return $this->title; }
	public function getContent() { return $this->content; }
	public function getTarget() {  return $this->target; }

	public function getId() {      return $this->id; }
	public function getClass() {   return $this->class; }

	public function setUrl( Web_Uri $val ) { $this->href    = $val; }
	public function setTitle( $val ) {      $this->title   = $val; }
	public function setContent( $val ) {    $this->content = $val; }
	public function setTarget( $val ) {     $this->target  = $val; }

	public function setID( $id ) {          $this->id      = $id; }
	public function addClass( $class ) {
		$classes = explode( " ", $this->class );
		$classes[] = $class;
		$this->class = implode( " ", array_unique( $classes ) );
	}


}