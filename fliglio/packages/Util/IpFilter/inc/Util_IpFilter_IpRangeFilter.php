<?php

/**
 * Represents a filter with the format '192.168.1.1-192.168.255.255'
 */
class Util_IpFilter_IpRangeFilter extends Util_IpFilter_IpFilter {
	protected $to;
	
	public function __construct($ip, $to) {
		$this->ip = ip2long($ip);
		$this->to = ip2long($to);
	}
	
	public function __toString() {
		return long2ip($this->ip) . '-' . long2ip($this->to);
	}	
	
	public function match($ip) {
	    $ipLong = ip2long($ip);
	    return ($ipLong >= $this->ip) && ($ipLong <= $this->to);
	}	
	
	static public function parse($value) {
		if (preg_match('/^(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})-(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})$/', $value, $matches)) {
			return new Util_IpFilter_IpRangeFilter($matches[1], $matches[2]);
		}
		
		throw new InvalidArgumentException('Util_IpFilter_IpRangeFilter does not recognized IP filter format "' . $value . '".');
	}
}
