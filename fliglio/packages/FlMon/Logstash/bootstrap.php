<?php

/**
 * 
 * @ requires Vendor.GelfPhp
 * @requires Util.Io
 */


	
Vendor_GelfPhp_Factory::init();


interface FlMon_Logstash_Publishable {
	public function toEntryString();
}