<?php
defined('WEKIT_VERSION') or exit(403);

class App_MyMoney_Dao extends PwBaseDao {
	
	/**
	 * table name
	 */
	protected $_table = '4t_order_address';

	/**
	 * primary key
	 */
	protected $_pk = 'id';
	/**
	 * table fields
	 */
	protected $_dataStruct = array('id', 'userid', 'rname','raddress','rphone','createdate');
	
	
	public function getOrderAddress($userid) {
		$sql = $this->_bindSql('SELECT * from %s where userid =  ? ',
						$this->getTable());
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($userid));
	}

	public function getOrderAddressbyId($id) {
		$sql = $this->_bindSql('SELECT * from %s where id =  ? ',
						$this->getTable());
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($id));
	}

	public function update($id,$userid,$rname,$raddress,$rphone)
	{
		$sql = $this->_bindSql('UPDATE %s SET rname =?, raddress=?, rphone=? where id =?',
						$this->getTable());
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->execute(array($rname,$raddress,$rphone,$id));
	}

	public function add($fields) {
		return $this->_add($fields, true);
	}


	public function delete($id) {
		return $this->_delete($id);
	}


}

?>