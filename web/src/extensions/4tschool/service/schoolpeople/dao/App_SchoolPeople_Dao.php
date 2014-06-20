<?php
defined('WEKIT_VERSION') or exit(403);
/**
 * App_SchoolArea_Dao - dao
 *
 * @author yang <yangyan7777@gmail.com>
 * @copyright http://www.fenxiangyo.net
 * @license http://www.fenxiangyo.net
 */
class App_SchoolPeople_Dao extends PwBaseDao {
	
	/**
	 * table name
	 */
	protected $_table = '4t_school_people';

	protected $_schoolPeopleOpenedTable = "4t_school_opened";

	protected $_schoolAreaTable = "4t_school_area";

	protected $_schooltable = 'windid_school';

	protected $_windidUser = 'windid_user';
	protected $_userTable = "user";
	/**
	 * primary key
	 */
	protected $_pk = 'id';
	/**
	 * table fields
	 */
	protected $_dataStruct = array('id', 'schoolid','userid','type','areaid');
	
	
	public function getByOpenSchool() {
		$sql = $this->_bindSql('SELECT s.name,s.schoolid FROM %s AS sa INNER JOIN %s AS s on s.schoolid = sa.schoolid WHERE sa.opened=1 ',
						$this->getTable($this->_schoolPeopleOpenedTable),
						$this->getTable($this->_schooltable),
						$this->sqlLimit($limit, $offset));
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array());
	}

	public function getSchoolPeople($schoolid,$type)
	{
		$sql = $this->_bindSql('SELECT u.username,sp.schoolid,sp.type,sp.id,sp.userid,sp.areaid,area.areaname FROM %s AS sp INNER JOIN %s AS u on sp.userid = u.uid LEFT JOIN %s area on sp.areaid = area.id WHERE sp.schoolid = ? and sp.type = ?',
						$this->getTable("4t_school_people"),
						$this->getTable("user"),
						$this->getTable($this->_schoolAreaTable),
						$this->sqlLimit($limit, $offset));
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($schoolid,$type));
	}

	public function getPeopleByType($type)
	{
		$sql = $this->_bindSql('SELECT distinct DISTINCT sp.userid, u.username, sp.userid FROM %s AS sp INNER JOIN %s AS u on sp.userid = u.uid LEFT JOIN %s area on sp.areaid = area.id WHERE sp.type = ?',
						$this->getTable("4t_school_people"),
						$this->getTable("user"),
						$this->getTable($this->_schoolAreaTable),
						$this->sqlLimit($limit, $offset));
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($type));
	}

	public function getMyRolesInSchool($schoolid,$userid)
	{
		$sql = $this->_bindSql('SELECT distinct type FROM %s WHERE schoolid=? and userid= ? ',
						$this->getTable());
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($schoolid,$userid));
	}

	public function checkIfExists($schoolid,$userid,$type,$areaid = 0)
	{ 
		$sql = $this->_bindSql('SELECT count(*) as total from %s s WHERE s.schoolid = ? and s.type = ? and s.userid =? and %s',
						$this->getTable(),
						($areaid == 0 ?" 1=1": " areaid = $areaid "),
						$this->sqlLimit($limit, $offset));

		$smt = $this->getConnection()->createStatement($sql);
		$result = $smt->queryAll(array($schoolid,$type,$userid));	
		return ($result[0]['total'] > 0 );
	}

	public function checkIfAccount($userid,$type,$areaid = 0)
	{ 
		$sql = $this->_bindSql('SELECT count(*) as total from %s s 
								WHERE s.type = ? and s.userid = ? and %s',
						$this->getTable(),
						($areaid == 0 ?" 1=1": " areaid = $areaid "),
						$this->sqlLimit($limit, $offset));

		$smt = $this->getConnection()->createStatement($sql);
		$result = $smt->queryAll(array($type,$userid));	
		return ($result[0]['total'] > 0 );
	}

	public function checkIfAreaExistPPL($schoolid,$userid,$type,$areaid = 0)
	{ 
		$sql = $this->_bindSql('SELECT count(*) as total from %s s WHERE s.schoolid = ? and s.type = ? and s.areaid = ?',
						$this->getTable(),
						$this->sqlLimit($limit, $offset));
		$smt = $this->getConnection()->createStatement($sql);
		$result = $smt->queryAll(array($schoolid,$type,$areaid));	
		return ($result[0]['total'] > 0 );
	}

	public function getMasterId($schoolid, $type)
	{
		$sql = $this->_bindSql('SELECT sp.userid, wu.username FROM %s as sp
								LEFT JOIN %s AS wu ON sp.userid = wu.uid  
								WHERE sp.schoolid = ? AND sp.TYPE = ?', 
								$this->getTable(),
								$this->getTable($this->_windidUser));
		$smt = $this->getConnection()->createStatement($sql);
		$result = $smt->queryAll(array($schoolid, $type));

		return $result;
	}
	public function add($fields) {
		return $this->_add($fields, true);
	}

	public function delete($id) {
		return $this->_delete($id);
	}

}

?>