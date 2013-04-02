<?php

/**
 * Extend Fl_Mapper_AbstractRegistry so that dependency tracking will pick up
 * on the package from which a class is loaded.
 * 
 * Have to re-implement the singleton getter until php 5.3's late static 
 * binding
 * 
 * @package FinTech
 */
class FinTech_MapperRegistry extends Fl_Mapper_AbstractRegistry {

	protected static $instance;

	/**
	 *
	 * @return Audit_MapperRegistry
	 */
	public static function get() {
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}
