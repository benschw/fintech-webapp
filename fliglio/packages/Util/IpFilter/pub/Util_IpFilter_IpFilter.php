<?php

class Util_IpFilter_IpFilter {
	protected $ip;
	
	public function __construct($ip) {
		$this->ip = ip2long($ip);
	}

	public function match($ip) {
		$ipLong = ip2long($ip);
		return $ipLong === $this->ip;
	}
	
	public function __toString() {
		return long2ip($this->ip);
	}

	static public function matchAll($ip, array $patterns) {
		$req = new Util_IpFilter_MatchAllRequirement($patterns);
		return $req->match($ip);
	}
	
	static public function matchAny($ip, array $patterns) {
		$req = new Util_IpFilter_MatchAnyRequirement($patterns);
		return $req->match($ip);
	}
		
	static public function parse($value) {
		if ($value instanceof Util_IpFilter_IpFilter) {
			return $value;
		}
		
		if (preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/', $value)) {
			return new Util_IpFilter_IpFilter($value);
		} else {
			foreach (array('Util_IpFilter_IpMaskFilter', 'Util_IpFilter_IpRangeFilter', 'Util_IpFilter_IpNetMaskFilter') as $className) {
				try {
					return call_user_func($className . '::parse', $value);
				} catch (InvalidArgumentException $e) {
					// try the next one
					continue;
				}
			}
		}
		
		throw new InvalidArgumentException('Unrecognized IP filter format "' . $value . '".');
	}
}
