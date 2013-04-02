<?php
/**
 * Extend Fl_Mapper_AbstractRegistry so that dependency tracking will pick up
 * on the package from which a class is loaded.
 * 
 * Have to re-implement the singleton getter until php 5.3's late static 
 * binding
 *
 * @package Util.IpFilter.MapperRegistry
 */
class Util_IpFilter_MapperRegistry extends Fl_Mapper_AbstractRegistry {
	
	protected static $instance;

	/**
	 * Get single instance of Util_IpFilter_MapperRegistry to keep track
	 * of data mappers (which in turn may be doing their own caching.)
	 *
	 * @return Util_IpFilter_MapperRegistry
	 */
	public static function get() {
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}