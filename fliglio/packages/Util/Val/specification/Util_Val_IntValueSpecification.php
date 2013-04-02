<?php

class Util_Val_IntValueSpecification implements Util_Val_Specification {

	public function isSatisfiedBy( $candidate ) {
		return is_int( $candidate );
	}


}