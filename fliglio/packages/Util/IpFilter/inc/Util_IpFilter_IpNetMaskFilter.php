<?php

/**
 * Represents a filter with the format '192.168.1.1/24'
 */
class Util_IpFilter_IpNetMaskFilter extends Util_IpFilter_IpFilter {
	protected $mask;
		
	public function __construct($ip, $mask = 32) {
		$this->ip = ip2long($ip);
		$this->mask = $mask;	
	}
	
	public function __toString() {
		return long2ip($this->ip) . '/' . $this->mask;
	}
		
	public function match($ip) {
		$ipLong = ip2long($ip);
		return ($ipLong & ~((1 << (32 - $this->mask)) - 1)) === ($this->ip & ~((1 << (32 - $this->mask)) - 1));
	}
	
	static public function parse($value) {
		if (preg_match('/^(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})\/(\d+)$/', $value, $matches)) {
			return new Util_IpFilter_IpNetMaskFilter($matches[1], (int) $matches[2]);
		}
		
		throw new InvalidArgumentException('Util_IpFilter_IpNetMaskFilter does not recognized IP filter format "' . $value . '".');
	}
}