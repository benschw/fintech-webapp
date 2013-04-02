<?php

/**
 * Required methods for the DriverDecorator to work
 * 
 * @package Util.Db
 */
interface Util_Db_DatabaseDriver {

	public function query($sql, $resource);

	public function begin($resource);
	public function commit($resource);
	public function rollback($resource);

	public function fetchIterator($result);
	public function fetchObject($result);
	public function fetchRow($result);

	public function getNumRows($result);
	public function getAffectedRows($resource);
	public function getLastInsertId($resource);

	public function seek($result, $row);
	public function freeResult($result);
	public function getLastError($resource);

	public function escapeString($str, $resource);
}