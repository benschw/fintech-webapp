<?php 
/**
 * Util_IpFilter_IpRestriction Object
 *
 * Object contains a string with varied input for allowed IP addresses and a method to determine if a given IP matches the allowed IP addresses
 *
 * @package Util.IpFilter
 * 
 */

class Util_IpFilter_IpRestriction {
	
	private $allowedLocations;
	
	public function __construct($allowedLocations) {
		$this->allowedLocations = $allowedLocations;
	}

	public function isIpAllowed($ip) {
		$ipAllowed = true;
		if ($this->allowedLocations) { 
			$masks = array_map('trim', explode(',', $this->allowedLocations));
			if (!Util_IpFilter_IpFilter::matchAny($ip, $masks)) {
				$ipAllowed = false;
			}
		}
		return $ipAllowed;
	}

}