<?php

/**
 * @package FinTech
 */
class FinTech_FooDbMapper extends Fl_Mapper_DbMapper {


	private static $select;
	private static $update;
	private static $insert;

	public function __construct() {
		parent::__construct(Util_Db_DbFactory::get());


		self::$select = "SELECT * FROM Foo WHERE `id` = ?;";
		self::$update = "UPDATE Foo SET val = ? WHERE id = ?";
		self::$insert = "INSERT INTO Foo (val) VALUES (?)";
	}

	/**
	 * Find Audit by id
	 *
	 * @param int $id 
	 * @return Audit_Audit
	 */
	public function find($id) {
		$rs = $this->db->selectRecord(self::$select, array($id));
		if (!$rs) {
			throw new Exception("Foo, $id, not found.");
		}
		return new FinTech_Foo($rs->val, $rs->id);
	}

	public function save(FinTech_Foo $foo) {
		if (!is_null($foo->getId())) {
			$this->db->update(self::$update, array($foo->getVal(), $foo->getId()));
		} else {
			$id = $this->db->insert(self::$insert, array($foo->getVal()));
			$foo->setId($id);
		}
	}

}