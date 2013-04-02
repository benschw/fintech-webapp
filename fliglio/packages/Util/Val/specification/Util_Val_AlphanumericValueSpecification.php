<?php

class Util_Val_AlphanumericValueSpecification implements Util_Val_Specification {

	public function isSatisfiedBy( $candidate ) {
		return ctype_alnum( $candidate );
	}

}