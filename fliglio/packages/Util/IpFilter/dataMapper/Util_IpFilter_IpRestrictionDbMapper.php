<?php
/**
 * Util IpFilter Ip Restriction Database Mapper
 *
 * @package Util.IpFilter
 */
class Util_IpFilter_IpRestrictionDbMapper extends Fl_Mapper_DbMapper {
	
	private static $findByFkClient;

	public function __construct() {
		parent::__construct(Util_Db_DbFactory::get());
		self::$findByFkClient = "SELECT allowedLocations FROM PluginMap PM WHERE name = 'RestrictedAccess' AND fkClient = ?";
	}
		
	public function findByFkClient($clientId) {
		$rs = $this->db->selectRecord(self::$findByFkClient, array($clientId));
		$allowedLocations = '';
		if ($rs) {
			$allowedLocations = $rs->allowedLocations;
		} 
		return new Util_IpFilter_IpRestriction($allowedLocations);
	}

}
