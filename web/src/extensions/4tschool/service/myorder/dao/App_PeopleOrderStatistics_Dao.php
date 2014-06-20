<?php
defined('WEKIT_VERSION') or exit(403);

class App_PeopleOrderStatistics_Dao extends PwBaseDao {
	
	/**
	 * table name
	 */
	protected $_table = '4t_people_order_statistic';

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
	protected $_dataStruct = array('id', 'uid', 'schoolid','counttotal','typefor');
	
	
	public function getSchoolPeopleStatistics($schoolid,$limit, $offset) {
		$sql = $this->_bindSql('SELECT pos.*,u.username from %s pos INNER JOIN %s u on pos.uid = u.uid  where schoolid =  ? ORDER BY counttotal DESC %s',
			$this->getTable(),
			$this->getTable($this->_userTable),
			$this->sqlLimit($limit, $offset));
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($schoolid));
	}

	public function countMoney($schoolId, $userid)
	{
		$sql = $this->_bindSql('SELECT counttotal FROM %s AS pos 
								WHERE pos.schoolid = ? AND pos.uid = ?', 
								$this->getTable());
		$smt = $this->getConnection()->createStatement($sql);
		$data = $smt->queryAll(array($schoolId, $userid));

		return $data[0]['counttotal'];

	}

}

?>