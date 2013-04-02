<?php

class Util_Storage_StepsStorage extends Util_Storage_Storage {

	public static function get( $storage, $namespace ) {
		return new self( new self( $storage, $namespace ), "steps" );
	}

}