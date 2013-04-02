<?php


class Util_IpFilter_MatchAnyRequirement implements Util_IpFilter_Requirement {
	private $patterns;
	
	public function __construct(array $patterns) {
		$this->patterns = $patterns;
	}

	public function match($ip) {
		foreach ($this->patterns as $pattern) {
			if (Util_IpFilter_IpFilter::parse($pattern)->match($ip)) {
				return true;
			}
		}
	}
}
