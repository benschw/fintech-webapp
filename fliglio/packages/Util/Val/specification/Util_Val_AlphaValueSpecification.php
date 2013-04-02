<?php

class Util_Val_AlphaValueSpecification implements Util_Val_Specification {

	public function isSatisfiedBy( $candidate ) {
		return ctype_alpha( $candidate );
	}

}