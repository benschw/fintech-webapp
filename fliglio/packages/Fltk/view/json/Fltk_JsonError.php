<?php
/* Codes:
 *  100 : unknown encoding error
 *  101 : not specified
 *  102 : missing arguments
 *  404 : action not found
 *  500 : internal server error
 */


class Fltk_JsonError extends Fltk_JsonView {

	public function __construct($message, $code = 101, $e = null) {
		$this->message = $message;
		$this->code    = $code;
		$this->e       = $e;
		
		$this->data = $this->toArray();
	}

	private function toArray() {
		$arr = array(
			'error'   => $this->code,
			'message' => $this->message
		);
		
		if (Fl_Core_Config::get()->debug && !is_null($this->e)) {
			$arr['exception'] = (string)$this->e;
		}
		return $arr;
	}

}