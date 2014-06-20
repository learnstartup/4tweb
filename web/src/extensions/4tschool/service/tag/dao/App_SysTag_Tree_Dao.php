<?php

defined('WEKIT_VERSION') or exit(403);

class App_SysTag_Tree_Dao extends PwBaseDao {

	/**
	 * table name
	 */
	protected $_table = '4t_systag_tree';

	/**
	 * primary key
	 */
	protected $_pk = 'id';

	/**
	 * table fields
	 */
	protected $_dataStruct = array('id', 'json', 'description', 'type','createdate');

	public function get($id) {
		return $this->_get($id);
	}
	
	public function add($sysTagTree) {
		return $this->_add($sysTagTree, true);
	}

	public function update($id, $sysTagTree) {
		return $this->_update($id, $sysTagTree);
	}

	public function delete($id) {
		return $this->_delete($id);
	}	
	
	public  function checkDuplicateName($name)
	{
		$sql = $this->_bindSql('SELECT count(*) as total FROM %s where name=?', $this->getTable());
		$smt = $this->getConnection()->createStatement($sql);
		$result=$smt->queryAll(array($name));
		return $result[0]['total'] > 0;
	}

	public function getSysTagTrees(){
		$sql= $this->_bindSql('SELECT * FROM %s ORDER BY id DESC',$this->getTable());
		$smt=$this->getConnection()->createStatement($sql);
		return $smt->queryAll();
	}

	public function getSysTagTreeByType ($type){
		$sql=$this->_bindSql('SELECT * FROM %s WHERE type = ? ORDER BY id DESC LIMIT 1',$this->getTable());
		$smt=$this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($type));
	}

}

?>