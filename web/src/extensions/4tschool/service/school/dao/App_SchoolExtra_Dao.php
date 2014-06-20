<?php
defined('WEKIT_VERSION') or exit(403);

class App_SchoolExtra_Dao extends PwBaseDao {
	
	/**
	 * table name
	 */
	protected $_table = '4t_school_opened';

	protected $_wind_school_table='windid_school';

	/**
	 * primary key
	 */
	protected $_pk = 'schoolid';
	/**
	 * table fields
	 */
	protected $_dataStruct = array('schoolid', 
								   'opened',
								   'openmap',
								   'complaintsline',
								   'shundaiid',
								   'openwallet',
								   'openorder',
								   'openshundai',
								   'openliuyanban', 
								   'openwebsite', 
								   'opencombo',
								   'openclassannounce', 
								   'schlatitude', 
								   'schlongitude',
								   'abbreviation');
	
	public function getSchoolExtra($schoolid)
	{
		$sql = $this->_bindSql('SELECT sc.`name`, so.*  from %s so LEFT JOIN %s sc on so.schoolid=sc.schoolid where so.schoolid=? ',
						$this->getTable(),
						$this->getTable($this->_wind_school_table));
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($schoolid));	
	}

	public function getOpenedSchools (){
		$sql=$this->_bindSql('SELECT sc.`name`, so.* FROM %s so LEFT JOIN %s sc on so.schoolid=sc.schoolid where so.type="P"',
			$this->getTable(),
			$this->getTable($this->_wind_school_table));
		$smt=$this->getConnection()->createStatement($sql);
		return $smt->queryAll();
	}

	public function getWebSiteStatus($schoolid)
	{
		$sql = $this->_bindSql('SELECT `openwebsite` FROM %s WHERE `schoolid` = ?',
							   $this->getTable());
		$smt = $this->getConnection()->createStatement($sql);
		$result = $smt->getOne(array($schoolid));
		return $result['openwebsite'];
		
	}

	public function update($schoolid,$fields)
	{
		return $this->_update($schoolid, $fields);
	}

}

?>