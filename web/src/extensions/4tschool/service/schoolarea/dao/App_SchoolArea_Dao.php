<?php
defined('WEKIT_VERSION') or exit(403);
/**
 * App_SchoolArea_Dao - dao
 *
 * @author yang <yangyan7777@gmail.com>
 * @copyright http://www.fenxiangyo.net
 * @license http://www.fenxiangyo.net
 */
class App_SchoolArea_Dao extends PwBaseDao {
	
	/**
	 * table name
	 */
	protected $_table = '4t_school_area';

	protected $_schooltable = 'windid_school';
	/**
	 * primary key
	 */
	protected $_pk = 'id';
	/**
	 * table fields
	 */
	protected $_dataStruct = array('id', 'schoolid', 'areaname','createdate');
	
	
	public function getBySchoolid($schoolid, $limit, $offset) {
		$sql = $this->_bindSql('SELECT s.name,
									   s.schoolid,
									   sa.id, 
									   sa.areaname FROM %s AS sa 
								INNER JOIN %s AS s on s.schoolid = sa.schoolid 
								WHERE sa.schoolid=? ORDER BY createdate DESC %s',
						$this->getTable(),
						$this->getTable($this->_schooltable),
						$this->sqlLimit($limit, $offset));
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($schoolid));
	}

	public function getByid($areaid,$limit, $offset) 
	{
		$sql = $this->_bindSql('SELECT sa.id, sa.areaname,sa.schoolid FROM %s AS sa where sa.id=? ORDER BY createdate DESC %s',
						$this->getTable(),
						$this->sqlLimit($limit, $offset));
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($areaid));	
	}

	/*
	 * 同一个学校下不能有两个同样的区域
	 */
	public function checkDuplicateName($id,$schoolid,$areaname)
	{
		$sql = $this->_bindSql('SELECT count(*) as total FROM %s AS sa where sa.id !=? and sa.schoolid = ? and sa.areaname = ? ORDER BY createdate DESC',
		$this->getTable());
		
		$smt = $this->getConnection()->createStatement($sql);			
		$result = $smt->queryAll(array($id,$schoolid,$areaname));
		return $result[0]['total'] > 0;
	}
	
	public function add($fields) {
		return $this->_add($fields, true);
	}
	
	public function update($id, $fields) {
		return $this->_update($id, $fields);
	}
	
	public function delete($id) {
		return $this->_delete($id);
	}
}

?>