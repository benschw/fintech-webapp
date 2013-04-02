<?php

class Util_Val_StringValueSpecification implements Util_Val_Specification {

	public function isSatisfiedBy( $candidate ) {
		return is_string( $candidate );
	}

}