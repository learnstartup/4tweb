<?php
defined('WEKIT_VERSION') or exit(403);
/**
 * App_PeopleSchedule_Dao - dao
 *
 * @author yang <yangyan7777@gmail.com>
 * @copyright http://www.fenxiangyo.net
 * @license http://www.fenxiangyo.net
 */
class App_PeopleSchedule_Dao extends PwBaseDao {
	
	/**
	 * table name
	 */
	protected $_table = '4t_people_schedule';

	protected $_schoolPeopleOpenedTable = "4t_school_opened";

	protected $_schooltable = 'windid_school';

	protected $_userTable = "user";
	/**
	 * primary key
	 */
	protected $_pk = 'id';
	/**
	 * table fields
	 */
	protected $_dataStruct = array('id','shopid', 'schoolid','type','datetimeBegin','datetimeEnd','userid','actionby','createdat','lastupdatedat','description');
	
	
	public function getPeopleSchedule($userid,$schoolid,$shopid,$timeBegin,$timeEnd)
	{
		$sql = $this->_bindSql('SELECT ps.*, orderUser.username FROM %s AS ps JOIN %s orderUser on orderUser.uid = ps.userid  WHERE %s and %s and %s and ps.datetimeBegin >= ? and ps.datetimeEnd <= ? order by datetimeBegin asc',
						$this->getTable(),
						$this->getTable($this->_userTable),
						($userid <= 0? " 1=1 ": " userid = $userid " ),
						($schoolid <= 0? " 1=1 ": " schoolid = $schoolid " ),
						($shopid <= 0? " 1=1 ": " shopid = $shopid " ),
						$this->sqlLimit($limit, $offset));
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($timeBegin,$timeEnd));
	}


	public function getPeopleScheduleById($scheduleId)
	{
		$sql = $this->_bindSql('SELECT ps.*, orderUser.username FROM %s AS ps JOIN %s orderUser on orderUser.uid = ps.userid  WHERE ps.id = ?',
						$this->getTable(),
						$this->getTable($this->_userTable));
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->getOne(array($scheduleId));
	}


	public function deleteByShopIdandDate($shopid,$timeBegin,$timeEnd) {
		$sql = $this->_bindSql('Delete from %s where shopid =? and datetimeBegin =? and datetimeEnd = ?',
						$this->getTable());
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->execute(array($shopid,$timeBegin,$timeEnd));
	}

	public function deleteByScheduleId($scheduleId)
	{
		$sql = $this->_bindSql('Delete from %s where id =?',
						$this->getTable());
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->execute(array($scheduleId));
	}

	public function getPeopleScheduleShop($uid,$datetimeIn)
	{
		$sql = $this->_bindSql('SELECT distinct shopid FROM %s AS ps where ps.userid = ? and  datetimeBegin <=? and datetimeEnd >= ? ',
						$this->getTable());

		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($uid,$datetimeIn,$datetimeIn));

	}


	public function add($fields) {
		return $this->_add($fields, true);
	}

	public function update($id,$fields) {
		return $this->_update($id,$fields);
	}

	public function delete($id) {
		return $this->_delete($id);
	}

}

?>