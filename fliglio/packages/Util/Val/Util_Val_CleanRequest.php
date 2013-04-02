<?php

class Util_Val_CleanRequest {
	
	protected $data = array();
	
	public function __construct( array $data = null ) {
		if( is_null( $data ) ) {
			$data = array();
		}
		$this->data = $data;
	}
	public function keys() {
		return array_keys( $this->data );
	}
	public function __get( $key ) {
		if( isset( $this->data ) ) {
			return $this->data[$key];
		} else {
			return null;
		}
	}
	public function __isset( $key ) {
		return isset( $this->data[$key] );
	}
	
	public function __set( $key, $val ) {
		$this->data[$key] = $val;
	}
	
	public function set( $var, $value ) {
		$clone = clone $this;
		$clone->data[$var] = $value;
		return $clone;
	}

	public function merge( Util_Val_CleanRequest $request ) {
		$merged = clone $this;
		foreach( $request->data AS $key => $val ) {
			$merged->$key = $val;
		}
		return $merged;
	}

}