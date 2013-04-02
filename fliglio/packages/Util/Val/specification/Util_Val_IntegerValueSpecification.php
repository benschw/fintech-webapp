<?php

class Util_Val_IntegerValueSpecification implements Util_Val_Specification {

	public function isSatisfiedBy( $candidate ) {
		return is_int( $candidate ) || preg_match( "/^-?[0-9]+$/", $candidate );
	}


}