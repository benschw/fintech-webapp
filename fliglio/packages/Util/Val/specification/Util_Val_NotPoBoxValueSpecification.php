<?php

class Util_Val_NotPoBoxValueSpecification implements Util_Val_Specification {

	public function isSatisfiedBy( $candidate ) {
		return !preg_match("/^\s*((P(OST)?.?\s*(O(FF(ICE)?)?)?.?\s+(B(IN|OX))?)|B(IN|OX))/i", $candidate);
	}

}

