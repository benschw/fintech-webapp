<?php
/**
 *
 * @package Util.Val
 */

class Util_Val_DateValueSpecification implements Util_Val_Specification {
	
	public function isSatisfiedBy($date) {
		$dateParse = date_parse($date);
		return count($dateParse['errors']) ? false : true;
	}

}