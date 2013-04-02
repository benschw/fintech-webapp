<?php
/**
 * Fltk_Flares
 *
 * Keep track of notices of varying levels to be displayed on next page
 * (e.g. validation errors on a reloaded form)
 * 
 * Store array of messages & error level combinations in session which can 
 * be flushed to the screen. These are one time use only, so the session
 * store is reset every time the notices are retrieved.
 * 
 * @package Fltk
 **/

class Fltk_Flares {

	private static $instance;

	const MESSAGE = 'message';
	const WARNING = 'warning';
	const ERROR   = 'error';
	
	private $storage;
	private $namespace = 'Fltk_flareStorage';
	
	/**
	 * sets reference to our storage namespace in session
	 *
	 * Sets to the class a reference to the storage and make sure that
	 * location in the storage is initialized as an array.
	 *
	 * Method is private because you must use "get" to get an instance
	 */
	private function __construct() {
		$this->storage = Util_Storage_Session::singleton();
		if( !isset( $this->storage->{$this->namespace} ) ) {
			$this->reset();
		}
	}
	
	/**
	 * Initializes & retreives object
	 *
	 * Since this class wraps the session, making it a singleton makes sense
	 * to make it clear that the messages are persistent
	 */
	public static function get() {
		if( !self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	/**
	 * Add notice to session
	 *
	 * @param $type     error level
	 * @param $message  notice text
	 *
	 * @return Fltk_Flares  This instance (for method chaining)
	 */
	public function addNotice( $type, $message ) {
		$notices = $this->storage->{$this->namespace};
		$notices[] = array(
			'type'    => $type,
			'message' => $message,
		);
		$this->storage->{$this->namespace} = $notices;
		return $this;
	}

	/**#@+
	 *  Facade Method
	 * 
	 *  Provide shortcuts to adding notices of different types.
	 *
	 *  @param  string  $message  Notice text
	 */
	public static function message( $message ) {
		self::get()->addNotice( Fltk_Flares::MESSAGE, $message );
	}
	public static function warn( $message ) {
		self::get()->addNotice( Fltk_Flares::WARNING, $message );
	}
	public static function error( $message ) {
		self::get()->addNotice( Fltk_Flares::ERROR, $message );
	}
	/**#@-*/
	
	/**
	 * Get all notices that have been saved up
	 *
	 * On each page load, look for any notices from the previous page.
	 * Output any to the screen and clear the queue
	 */
	public function getNotices() {
		$notices = $this->storage->{$this->namespace};
		$this->reset();
		return $notices;
	}

	/**
	 * Resets the notices stored in session to an empty array
	 */
	public function reset() {
		$this->storage->{$this->namespace} = array();
	}

}