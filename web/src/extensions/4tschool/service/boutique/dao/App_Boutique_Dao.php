<?php

defined('WEKIT_VERSION') or exit(403);

class App_Boutique_Dao extends PwBaseDao {

	/**
	 * table name
	 */
	protected $_table = '4t_boutique';

	/**
	 * primary key
	 */
	protected $_pk = 'id';

	/**
	 * table fields
	 */
	protected $_dataStruct = array('id', 'schoolid','type', 'imgurl', 'link', 'description', 'isrelease', 'startdate', 'enddate','createdate','lastupdatetime');

	public function get($id) {
		return $this->_get($id);
	}

	public function getBoutiques($isActive) {
		$sql = $this->_bindSql('SELECT * FROM %s WHERE %s', 
			$this->getTable(),
			empty($isActive) ? "(1 = 1)" : "CURDATE() BETWEEN startdate AND enddate");
		$smt = $this->getConnection()->createStatement($sql);
		
		return $smt->queryAll();
	}

	public function getBoutiquesBySchoolId($schoolid,$isActive) {
		$sql = $this->_bindSql('SELECT * FROM %s WHERE %s AND schoolid=?', 
			$this->getTable(),
			empty($isActive) ? "(1 = 1)" : "CURDATE() BETWEEN startdate AND enddate");
		$smt = $this->getConnection()->createStatement($sql);

		return $smt->queryAll(array($schoolid));
	}

	public function getCurrentSchoolBoutiquesByType ($schoolid,$type){
		$sql=$this->_bindSql('SELECT * FROM %s WHERE schoolid = ? AND type = ? AND isrelease=1',$this->getTable());
		$smt=$this->getConnection()->createStatement($sql);

		return $smt->queryAll(array($schoolid,$type));
	}

	public function add($boutique) {
		return $this->_add($boutique, true);
	}

	public function update($id, $boutique) {
		return $this->_update($id, $boutique);
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

}

?>