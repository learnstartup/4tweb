<?php
defined('WEKIT_VERSION') or exit(403);
/**
 * App_Dongta_Dao - dao
 *
 * @author chenjm <sky_hold@163.com>
 * @copyright http://www.phpwind.net
 * @license http://www.phpwind.net
 */
class App_Dongta_Dao extends PwBaseDao {
	
	/**
	 * table name
	 */
	protected $_table = 'app_dongta';
	/**
	 * primary key
	 */
	protected $_pk = 'id';
	/**
	 * table fields
	 */
	protected $_dataStruct = array('id', 'act', 'touid', 'created_userid', 'creaed_username', 'created_time');
	
	public function get($id) {
		return $this->_get($id);
	}
	
	public function getByUid($uid, $limit, $offset) {
		$sql = $this->_bindSql('SELECT * FROM %s WHERE touid=? ORDER BY created_time DESC %s', $this->getTable(), $this->sqlLimit($limit, $offset));
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($uid));
	}
	
	public function countByUid($uid) {
		$sql = $this->_bindTable('SELECT COUNT(*) AS sum FROM %s WHERE touid=?');
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->getValue(array($uid));
	}

	public function add($fields) {
		return $this->_add($fields, true);
	}
	
	public function update($id, $fields) {
		return $this->_update($id, $fields);
	}
	
	public function delete($id) {
		return $this->_delete($id);
	}
}

?>