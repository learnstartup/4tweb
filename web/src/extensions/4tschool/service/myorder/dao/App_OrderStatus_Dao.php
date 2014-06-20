<?php
defined('WEKIT_VERSION') or exit(403);

class App_OrderStatus_Dao extends PwBaseDao {
	
	/**
	 * table name
	 */
	protected $_table = '4t_order_status_history';

	/*
	 *  user table
	 */
	protected $_userTable = 'user';

	/**
	 * primary key
	 */
	protected $_pk = 'id';
	/**
	 * table fields
	 */
	protected $_dataStruct = array('id', 'orderid', 'changedby','statusfrom','statusto','changedatefrom','changedate');
	
	
	public function getOrderHistory($orderid,$limit, $offset) {
		$sql = $this->_bindSql('SELECT oh.*,u.username from %s oh LEFT JOIN %s u on oh.changedby = u.uid  where orderid =  ? ORDER BY changedate DESC',
			$this->getTable(),
			$this->getTable($this->_userTable),
			$this->getStatusFilterSQL(),
			$this->sqlLimit($limit, $offset));
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($orderid));
	}

	public function add($fields) {
		return $this->_add($fields, true);
	}


}

?>