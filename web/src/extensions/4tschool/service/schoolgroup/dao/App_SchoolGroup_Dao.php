<?php
defined('WEKIT_VERSION') or exit(403);
/**
 * App_SchoolArea_Dao - dao
 *
 * @author yang <yangyan7777@gmail.com>
 * @copyright http://www.fenxiangyo.net
 * @license http://www.fenxiangyo.net
 */
class App_SchoolGroup_Dao extends PwBaseDao {
	
	/**
	 * table name
	 */
	protected $_table = '4t_school_group';

	protected $_SchoolPeopleTable = '4t_school_people';

	protected $_SchoolPeopleInGroupTable = '4t_school_peopleingroup';

	protected $_schoolAreaTable = "4t_school_area";

	protected $_schooltable = 'windid_school';

	protected $_userTable = "user";
	/**
	 * primary key
	 */
	protected $_pk = 'id';
	/**
	 * table fields
	 */
	protected $_dataStruct = array('id', 'schoolid','name','type','areaid','leaderid');
	

	public function getSchoolGroup($schoolid,$type)
	{
		$sql = $this->_bindSql('SELECT u.username,sg.name as groupname,sg.schoolid,sg.type,sg.id,sg.leaderid,sg.areaid,area.areaname FROM %s AS sg INNER JOIN %s AS u on sg.leaderid = u.uid LEFT JOIN %s area on sg.areaid = area.id WHERE sg.schoolid = ? and sg.type = ?',
						$this->getTable(),
						$this->getTable($this->_userTable),
						$this->getTable($this->_schoolAreaTable),
						$this->sqlLimit($limit, $offset));
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($schoolid,$type));
	}

	public function getPeopleNotInGroup($schoolid,$type)
	{
		$sql = $this->_bindSql("Select sp.userid,u.username from %s sp Inner JOIN %s u on sp.userid = u.uid where sp.schoolid =? and sp.type =? and sp.userid not in (select peopleid from %s)",
						$this->getTable($this->_SchoolPeopleTable),
						$this->getTable($this->_userTable),
						$this->getTable($this->_SchoolPeopleInGroupTable));
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($schoolid,$type));
	}

	public function getPeopleInGroup($schoolid,$type)
	{
		$sql = $this->_bindSql("Select sp.userid,u.username,ping.groupid from %s sp Inner JOIN %s u on sp.userid = u.uid JOIN %s ping on sp.userid = ping.peopleid where sp.schoolid =? and sp.type =?",
						$this->getTable($this->_SchoolPeopleTable),
						$this->getTable($this->_userTable),
						$this->getTable($this->_SchoolPeopleInGroupTable));
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($schoolid,$type));
	}

	public function checkIfExists($schoolid,$groupname,$type,$areaid = 0)
	{
		$sql = $this->_bindSql("SELECT count(*) as total from %s s WHERE s.schoolid = ? and s.type = ? and s.name = ? and %s",
								$this->getTable(),
								($areaid == 0 ?" 1 = 1": " areaid = $areaid "),
								$this->sqlLimit($limit, $offset));
		$smt = $this->getConnection()->createStatement($sql);
		$result = $smt->queryAll(array($schoolid,$type,$groupname));	
		return ($result[0]['total'] > 0 );
	}

	public function add($fields) {
		return $this->_add($fields, true);
	}

	public function delete($id) {
		return $this->_delete($id);
	}

}

?>