<?php
/**
 * Mysql Driver
 * @package Fl
 */
class Util_Db_MysqlDriver implements Util_Db_DatabaseDriver {

	public function __construct() {}

	public function query($sql, $resource) {
		$result = mysqli_query($resource, $sql);
		if ($result === false) {
			throw new Exception($this->getLastError($resource) . "\n". $sql);
		}
		return $result;
	}
	
	public function insertMany($sql, $values, $resource, Util_Db_DatabaseDriverDecorator $db) {
		return $this->query($db->formatSqlforInsertMany($sql, $values), $resource);
	}

	public function begin($resource) {
		if (!mysqli_autocommit($resource, false)) {
			throw new Exception("Could not turn off auto commit");
		}
		return true;
	}
	public function commit($resource) {
		$return = mysqli_commit($resource);
		if (!mysqli_autocommit($resource, true)) {
			throw new Exception("Could not turn on auto commit");
		}
		return $return;
	}
	public function rollback($resource) {
		$return = mysqli_rollback($resource);
		if (!mysqli_autocommit($resource, true)) {
			throw new Exception("Could not turn on auto commit");
		}
		return $return;
	}
	
	public function fetchIterator($result) {
		if (!($result instanceof mysqli_result)) {
			throw new Exception("Expected mysqli_result Object");
		}
		return new Util_Db_DatabaseIterator($this, $result);
	}
	public function fetchObject($result) {
		return mysqli_fetch_object($result, 'stdClass');
	}
	public function fetchRow($result) {
		return mysqli_fetch_row($result);
	}

	public function getNumRows($result) {
		return mysqli_num_rows($result);
	}
	public function getAffectedRows($resource) {
		return mysqli_affected_rows($resource);
	}
	public function getLastInsertId($resource) {
		return mysqli_insert_id($resource);
	}

	public function seek($result, $row) {
		return mysqli_data_seek($result, $row);
	}
	public function freeResult($result) {
		return mysqli_free_result($result);
	}
	public function getLastError($resource) {
		return mysqli_error($resource);
	}
	
	public function escapeString($str, $resource) {
		return mysqli_real_escape_string($resource, $str);
	}
}

