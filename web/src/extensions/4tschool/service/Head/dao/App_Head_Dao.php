<?php
defined('WEKIT_VERSION') or exit(403);

class App_Head_Dao extends PwBaseDao{
	
	protected $_table='';

	protected $_shoptable='4t_shop';

	protected $_merchandisetable='4t_merchandise';
	
	protected $_pk='id';
	
	protected $_datasStruck=array();
	
	public function searchShop($keyword){
		$keyword='%'.$keyword.'%';
		$sql = $this->_bindSql('SELECT * FROM %s where `name` like ?', $this->getTable($this->_shoptable));
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($keyword));
	}
	
	public function searchMerchandise($keyword){
		$keyword='%'.$keyword.'%';
		$sql = $this->_bindSql('SELECT * FROM %s where `name` like ?', $this->getTable($this->_merchandisetable));
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($keyword));
	}	
	
}
?>
