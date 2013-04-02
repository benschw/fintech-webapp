<?php

class Util_Val_NumericValueSpecification implements Util_Val_Specification {

	public function isSatisfiedBy( $candidate ) {
		return is_numeric( $candidate );
	}

}