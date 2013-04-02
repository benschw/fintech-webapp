<?php

class Util_Val_EmailValueSpecification implements Util_Val_Specification {

	public function isSatisfiedBy( $candidate ) {
		$regex = "/^((?:(?:(?:\\w[\\.\\-\\+]?)*)\\w)+)\\@((\\[[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\.)|(([a-zA-Z0-9\\-]+\\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\\]?)$/";	
		return preg_match($regex, $candidate) ? true : false;
	}

}

