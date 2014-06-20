<?php
defined('WEKIT_VERSION') or exit(403);

class App_Security_Dao extends PwBaseDao {
	
	/**
	 * table name
	 */
	protected $_table = 'user_active_code';

	protected $_mobileActive_Table ='user_mobile';

	/**
	 * primary key
	 */
	protected $_pk = 'id';

	
	public function checkIfEmailVerified($userid,$email) {
		$sql = $this->_bindSql('SELECT count(*) as totalCount from %s  where uid = ? and email =? and active_time > 0',
			$this->getTable());
		$smt = $this->getConnection()->createStatement($sql);
		$result = $smt->queryAll(array($userid,$email));

		return ($result[0]['totalCount'] > 0);
	}

	public function checkIfMobileVerified($userid,$mobile)
	{
		$sql = $this->_bindSql('SELECT count(*) as totalCount from %s  where uid = ? and  mobile =? ',
			$this->getTable($this->_mobileActive_Table));
		$smt = $this->getConnection()->createStatement($sql);
		$result = $smt->queryAll(array($userid,$mobile));
	}

}

?>