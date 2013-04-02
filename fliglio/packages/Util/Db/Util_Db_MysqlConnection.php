<?php


class Util_Db_MysqlConnection implements Util_Db_Connection{

	private $resource;
	
	private $server;
	private $login;
	private $password;
	private $defaultDatabase;

	public function __construct($server, $login, $password, $defaultDatabase) {
		$this->server          = $server;
		$this->login           = $login;
		$this->password        = $password;
		$this->defaultDatabase = $defaultDatabase;
	}
	
	/** 
	 * args not used here - added to interface for "mysql-multi" driver to
	 * speficy whether a link is needed for a read or write
	 */
	public function getLink(array $args = null) {
		if (is_null($this->resource)) {
			$this->resource = mysqli_connect($this->server, $this->login, $this->password, $this->defaultDatabase);
			
			if (mysqli_connect_errno()) {
				throw new Exception("Can't connect to $this->server / $this->defaultDatabase: " . mysqli_connect_error());
			}
			
			if (!$this->resource) {
			    throw new Exception("Error setting up mysqli connection: " . mysqli_error($this->resource));
			}
		}
		return $this->resource;
	}
}