<?php

class Util_Storage_RawStorage extends Util_Storage_Storage {

	public static function get( $storage, $namespace, $rawProps = array() ) {
		$instance = new self( new self( $storage, $namespace ), "raw" );
		
		foreach( $rawProps AS $key => $value ) {
			$instance->{$key} = $value;
		}

		return $instance;
	}

}