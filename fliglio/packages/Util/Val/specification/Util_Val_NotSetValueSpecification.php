<?php

class Util_Val_NotSetValueSpecification implements Util_Val_Specification {

	public function isSatisfiedBy($candidate) {
		return !is_null($candidate);
	}
}