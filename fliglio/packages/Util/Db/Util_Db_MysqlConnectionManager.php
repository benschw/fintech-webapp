<?php


class Util_Db_MysqlConnectionManager implements Util_Db_Connection {


	private $readConnections  = array();
	private $writeConnections = array();

	public function __construct() {
	}
	
	/**
	 * Add additional mysql connection to connection manager
	 * 
	 * Specify "read" and "write" priority.
	 * 0 means don't use ever (e.g. $write = 0 for a read only slave)
	 * prefer "1" over "2", and "2" over "3", and so on.
	 *
	 * 
	 * e.g.:
	 * $mgr->addConnection($c, 1, 2);  // local master:  commit all writes here
	 * $mgr->addConnection($c, 0, 1);  // local slave:   prefer this connection for reads but never write to it
	 * $mgr->addConnection($c, 0, 3);  // remote slave:  use this for reads, only if the local slave and local master are unavailable (never write to it)
	 * 
	 */
	public function addConnection(Util_Db_MysqlConnection $con, $write, $read) {
		if ($write != 0) {
			$this->addWriteConnection($con, $write);
		}
		if ($read != 0) {
			$this->addReadConnection($con, $read);
		}
	}

	public function getLink(array $args = null) {
		if (!is_array($args) || !isset($args['type'])) {
			throw new Util_Db_Exception("Must specify if you nead a read or write capable mysql link (not supplied)");
		}

		$con;
		if ($args['type'] == Util_Db_DatabaseDriverDecorator::READ) {
			$con = $this->getReadConnection();
		} else if ($args['type'] == Util_Db_DatabaseDriverDecorator::WRITE) {
			$con = $this->getWriteConnection();
		} else {
			throw new Util_Db_Exception("Must specify if you nead a read or write capable mysql link (supplied '".$args['type']."' is invalid)");
		}

		return $con->getLink();
	}
	
	private function addWriteConnection($con, $priority) {
		for ($i = 0; $i <= $priority; $i++) {
			if (!isset($this->writeConnections[$i])) {
				$this->writeConnections[$i] = array();
			}
		}
		$this->writeConnections[$priority][] = $con;
	}
	private function addReadConnection($con, $priority) {
		for ($i = 0; $i <= $priority; $i++) {
			if (!isset($this->readConnections[$i])) {
				$this->readConnections[$i] = array();
			}
		}
		$this->readConnections[$priority][] = $con;
	}
	private function getWriteConnection() {
		for ($i = 1; $i < count($this->writeConnections); $i++) {
			if (count($this->writeConnections[$i]) > 0) {
				return $this->writeConnections[$i][0];
			}
		}
	}
	
	private function getReadConnection() {
		for ($i = 1; $i < count($this->readConnections); $i++) {
			if (count($this->readConnections[$i]) > 0) {
				return $this->readConnections[$i][0];
			}
		}
	}
	
}