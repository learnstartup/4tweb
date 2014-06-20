<?php
defined('WEKIT_VERSION') or exit(403);

class App_MyMoneyHistory_Dao extends PwBaseDao {
	
	/**
	 * table name
	 */
	protected $_table = '4t_my_money_history';

		/**
	 * primary key
	 */
	protected $_pk = 'id';
	/**
	 * table fields
	 */
	protected $_dataStruct = array('id', 'userid', 'orderid', 'moneyoriginal','moneyincome','moneyleft','description','createdate');
	
	
	public function getMyMoneyHistory($userid,$limit,$offset) {
		$sql = $this->_bindSql('SELECT * from %s where userid =  ?  order by id desc %s ',
						$this->getTable(),
						$this->sqlLimit($limit, $offset));
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($userid));
	}

	public function countMyMoneyHistory($userid) {
		$sql = $this->_bindSql('SELECT count(*) as totalCount from %s where userid =  ?   order by id desc ',
						$this->getTable());
		$smt = $this->getConnection()->createStatement($sql);
		$result = $smt->queryAll(array($userid));
		return $result[0]['totalCount'];
	}

	public function getOneByOrderId($orderid)
	{
		$sql = $this->_bindSql("SELECT * FROM %s WHERE orderid = ?", 
								$this->getTable());
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->getOne(array($orderid));
	}
	
	public function add($fields) {
		return $this->_add($fields, true);
	}


	public function delete($id) {
		return $this->_delete($id);
	}


}

?>