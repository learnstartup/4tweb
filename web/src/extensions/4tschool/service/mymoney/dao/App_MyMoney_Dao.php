<?php
defined('WEKIT_VERSION') or exit(403);

class App_MyMoney_Dao extends PwBaseDao {
	
	/**
	 * table name
	 */
	protected $_table = '4t_my_money';

		/**
	 * primary key
	 */
	protected $_pk = 'id';
	/**
	 * table fields
	 */
	protected $_dataStruct = array('id', 'userid', 'money','credit');
	
	
	public function getMyMoney($userid) {
		$sql = $this->_bindSql('SELECT * from %s where userid =  ?  order by id desc',
						$this->getTable());
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($userid));
	}

	public function updateMyMoney($userid,$money) {
		$sql = $this->_bindSql('Update %s set money = ? where userid  =  ? ',
						$this->getTable());
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->execute(array($money,$userid));
	}

	public function getCurrentMoney($userid)
	{
		$sql = $this->_bindSql('select * from %s where userid =  ? ',
						$this->getTable());
		$smt = $this->getConnection()->createStatement($sql);
		$result =  $smt->queryAll(array($userid));

		if(count($result) == 0)
		{
			//no data in database
			$data['userid'] = $userid;
			$data['money'] = 0;
			$data['credit'] = 0;
			$this->add($data);
			return 0;
		}
		else
		{
			return $result[0]['money'];
		}
	}

	public function getCurrentCredit($userid)
	{
		$sql = $this->_bindSql('select * from %s where userid =  ? ',
						$this->getTable());
		$smt = $this->getConnection()->createStatement($sql);
		$result =  $smt->queryAll(array($userid));

		if(count($result) == 0)
		{
			//no data in database
			$data['userid'] = $userid;
			$data['money'] = 0;
			$data['credit'] = 0;
			$this->add($data);
			return 0;
		}
		else
		{
			return $result[0]['credit'];
		}
	}


	public function updateMyCredit($userid,$credit) {
		$sql = $this->_bindSql('Update %s set credit = ? where userid  =  ? ',
						$this->getTable());
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->execute(array($credit,$userid));
	}


	public function existRecord($userid)
	{
		$sql = $this->_bindSql('select count(*) as totalCount from %s set credit = ? where  =  ? ',
						$this->getTable());

		$smt = $this->getConnection()->createStatement($sql);

		$result  = $smt->queryAll(array($$userid));
		return ($result[0]['totalCount'] > 0);

	}

	
	public function add($fields) {
		return $this->_add($fields, true);
	}


	public function delete($id) {
		return $this->_delete($id);
	}


}

?>