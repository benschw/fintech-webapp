<?php

/**
 * Database Library.
 * 
 * Decorates database drivers providing format methods & unifying interface
 *
 * @package Fl 
 */
class Util_Db_DatabaseDriverDecorator {
	
	const READ         = 'r';
	const WRITE        = 'w';
	
	private $driver;
	private $connection;

	private $linkLocked = false;
	private $lockedLink;

	public function __construct(Util_Db_DatabaseDriver $driver, Util_Db_Connection $connection) {
		$this->driver     = $driver;
		$this->connection = $connection;
	}
	
	private function query($sql, $link) {
		try {
			return $this->driver->query($sql, $link);
		} catch (Exception $e) {
			throw new Util_Db_QueryException($e->getMessage(), $e->getCode());
		}
	}
	
	/**
	 * get access to underlying driver in case you know what you're doing and 
	 * want to do something outside of the core API defined in this class
	 * (e.g. sqlite in unit testing)
	 *
	 * @return Util_Db_DatabaseDriver
	 */
	public function getDriver() {
		return $this->driver;
	}
	
	/**
	 * @return Util_Db_Connection
	 */
	public function getConnection() {
		return $this->connection;
	}
	
	//========================================================================
	// Errors
	//========================================================================
	public function getLastError() {
		return $this->driver->getLastError($this->connection->getLink());
	}
	
	//========================================================================
	// Manage "Mysql Link" Resources
	//========================================================================
	private function getLink($type) {
		if ($this->linkLocked) {
			return $this->lockedLink;
		} else {
			return $this->connection->getLink(array("type" => $type));
		}
	}
	
	private function lockLink($link) {
		$this->linkLocked = true;
		$this->lockedLink = $link;
	}
	private function unlockLink() {
		$this->linkLocked = false;
		$this->lockedLink = null;
	}
	
	//========================================================================
	// Transactions
	//========================================================================
	public function begin() {
		if ($this->linkLocked) {
			throw new Exception("Can't begin transaction, link is locked");
		}
		$link = $this->getLink(self::WRITE);
		$this->lockLink($link);
		return $this->driver->begin($link);
	}
	public function commit() {
		if (!$this->linkLocked) {
			throw new Exception("Can't end transaction, link is not locked");
		}
		$return = $this->driver->commit($this->getLink(self::WRITE));
		$this->unlockLink();
		return $return;
	}
	public function rollback() {
		if (!$this->linkLocked) {
			throw new Exception("Can't end transaction, link is not locked");
		}
		$return = $this->driver->rollback($this->getLink(self::WRITE));
		$this->unlockLink();
		return $return;
	}

	//========================================================================
	// Select
	//========================================================================
	public function select($sql, array $values = array()) {
		$locked = $this->linkLocked;
		$link   = $this->getLink(self::READ);
		$locked || $this->lockLink($link);

		$resultResource = $this->query(
			$this->formatSql($sql, $values), 
			$link
		);
		$iter = $this->driver->fetchIterator($resultResource);
		
		$locked || $this->unlockLink();
		return $iter;
	}
	public function selectRecord( $sql, array $values = array() ) {
		$locked = $this->linkLocked;
		$link   = $this->getLink(self::READ);
		$locked || $this->lockLink($link);

		$resultResource = $this->query(
			$this->formatSql($sql, $values), 
			$link
		);
		$record = $this->driver->fetchObject($resultResource);
		$this->driver->freeResult($resultResource);

		$locked || $this->unlockLink();
		return $record;
	}
	public function selectField( $sql, array $values = array() ) {
		$locked = $this->linkLocked;
		$link   = $this->getLink(self::READ);
		$locked || $this->lockLink($link);

		$resultResource = $this->query(
			$this->formatSql($sql, $values), 
			$link
		);
		list($result) = $this->driver->fetchRow($resultResource);  
		$this->driver->freeResult($resultResource);

		$locked || $this->unlockLink();
		return $result;
	}
	public function selectColumn($sql, array $values = array()) {
		$locked = $this->linkLocked;
		$link   = $this->getLink(self::READ);
		$locked || $this->lockLink($link);

		$resultResource = $this->query(
			$this->formatSql($sql, $values), 
			$link
		);
		$results = array();
		while (list($result) = $this->driver->fetchRow($resultResource)) {
			$results[] = $result;
		}
		$this->driver->freeResult($resultResource);
		
		$locked || $this->unlockLink();
		return $results;
	}
	
	//========================================================================
	// Modify
	//========================================================================
	public function createDatabase($sql) {
		$locked = $this->linkLocked;
		$link   = $this->getLink(self::WRITE);
		$locked || $this->lockLink($link);

		$resultResource = $this->query($sql, $link);

		$locked || $this->unlockLink();
	}
	public function dropDatabase($sql) {
		$locked = $this->linkLocked;
		$link   = $this->getLink(self::WRITE);
		$locked || $this->lockLink($link);

		$resultResource = $this->query($sql, $link);

		$locked || $this->unlockLink();
	}

	public function createTable($sql) {
		$locked = $this->linkLocked;
		$link   = $this->getLink(self::WRITE);
		$locked || $this->lockLink($link);

		$resultResource = $this->query($sql, $link);
		
		$locked || $this->unlockLink();
	}
	public function dropTable($sql) {
		$locked = $this->linkLocked;
		$link   = $this->getLink(self::WRITE);
		$locked || $this->lockLink($link);
		
		$resultResource = $this->query($sql, $link);
		
		$locked || $this->unlockLink();
	}
	
	public function update($sql, array $values = array()) {
		$locked = $this->linkLocked;
		$link   = $this->getLink(self::WRITE);
		$locked || $this->lockLink($link);

		$resultResource = $this->query($this->formatSql($sql, $values), $link);
		$rows = $this->driver->getAffectedRows($link);
		
		$locked || $this->unlockLink();
		return $rows;
	}
	public function insert($sql, array $values = array()) {
		$locked = $this->linkLocked;
		$link   = $this->getLink(self::WRITE);
		$locked || $this->lockLink($link);

		$resultResource = $this->query($this->formatSql($sql, $values), $link);
		$id = $this->driver->getLastInsertId($link);

		$locked || $this->unlockLink();
		return $id;
	}
	public function insertMany($sql, array $values = array()) {
		$locked = $this->linkLocked;
		$link   = $this->getLink(self::WRITE);
		$locked || $this->lockLink($link);

		$link           = $this->getLink(self::WRITE);
		$resultResource = $this->driver->insertMany($sql, $values, $link, $this);

		$id = $this->driver->getLastInsertId($link);

		$locked || $this->unlockLink();
		return $id;
	}	
	public function delete($sql, array $values = array()) {
		$locked = $this->linkLocked;
		$link   = $this->getLink(self::WRITE);
		$locked || $this->lockLink($link);

		$resultResource = $this->query($this->formatSql($sql, $values), $link);
		$rows = $this->driver->getAffectedRows($link);
		
		$locked || $this->unlockLink();
		return $rows;
	}
	
	//========================================================================
	// Helper
	//========================================================================	
	public function formatSqlforInsertMany($sql, array $values) {
		$clean = $sql;
		if (count($values) > 0) {
			list($escaped, $valueFormat) = explode('VALUES', $sql);

			$formattedValueArr = array();
			foreach ($values as $set) {
				$formattedValueArr[] = $this->formatSql($valueFormat, $set);
			}
			$clean = $escaped . " VALUES " . implode(", ", $formattedValueArr);
		}
		return $clean;
	}
	public function formatSql($sql, array $values) {
		$clean = $sql;
		if (count($values) > 0) {
			$escaped = array_map(array($this, 'sanitizeValue'), $values);
			try {
				if (!stristr($sql, '%%')) {
					$sql = str_replace('%', '%%', $sql); 
				}

				$formatString = preg_replace("/\?/", "%s", $sql); 
				$clean = vsprintf($formatString, $escaped);
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}
		return $clean;
	}
	public function sanitizeValue($val) {
		$clean = null;
		if (is_bool($val)) {
			$clean = (int) $val;
		} else if (is_int($val) || is_float($val)) {
			$clean = $val;
		} else if (is_array($val)) {
			$clean = implode(',', array_map(array($this, 'sanitizeValue'), $val));
		} else if (is_null($val)) {
			$clean = "null";
		} else if (strtoupper($val) == "IS NOT NULL") {
			$clean = "IS NOT NULL";
		} else if (strtoupper($val) == "IS NULL") {
			$clean = "IS NULL";
		} else {
			$clean = "'" . $this->driver->escapeString($val, $this->getLink(self::READ)) . "'";
		}
		return $clean;
	}
}

