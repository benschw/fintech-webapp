<?php

/**
 * Represents a filter with the format '192.168.1.1/255.255.255.0'
 */
class Util_IpFilter_IpMaskFilter extends Util_IpFilter_IpFilter {
	public function __construct($ip, $mask = '255.255.255.255') {
		$this->ip	= ip2long($ip);
		$this->mask = ip2long($mask);
	}
		
	public function match($ip) {
		$ipLong = ip2long($ip);
		return ($ipLong & $this->mask) === ($this->ip & $this->mask);
	}	
	
	public function __toString() {
		return long2ip($this->ip) . '/' . long2ip($this->mask);
	}
	
	static public function parse($value) {
		if (preg_match('/^(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})\/(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})$/', $value, $matches)) {
			return new Util_IpFilter_IpMaskFilter($matches[1], $matches[2]);
		}
		
		throw new InvalidArgumentException('Util_IpFilter_IpMaskFilter does not recognized IP filter format "' . $value . '".');
	}
}
