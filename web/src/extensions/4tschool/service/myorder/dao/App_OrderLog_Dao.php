<?php
defined('WEKIT_VERSION') or exit(403);

class App_OrderLog_Dao extends PwBaseDao {
	
	/**
	 * table name
	 */
	protected $_table = '4t_order_action_log';

	/**
	 * primary key
	 */
	protected $_pk = 'id';
	/**
	 * table fields
	 */
	protected $_dataStruct = array('id', 'orderid', 'by','action','actiondate');
	
	
	public function getOrderLog($orderid,$by,$limit, $offset) {
		$sql = $this->_bindSql('SELECT * from %s  where ? and ? ORDER BY changedate DESC',
			$this->getTable(),
			$this->sqlLimit($limit, $offset));
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array("orderid = $orderid",$by==""?" 1 = 1":" by = $by"));
	}

	public function add($fields) {
		return $this->_add($fields, true);
	}

}

?>