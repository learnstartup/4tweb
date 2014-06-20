<?php
defined('WEKIT_VERSION') or exit(403);
/**
 * App_SchoolArea_Dao - dao
 *
 * @author yang <yangyan7777@gmail.com>
 * @copyright http://www.fenxiangyo.net
 * @license http://www.fenxiangyo.net
 */
class App_SchoolUserInGroup_Dao extends PwBaseDao {
	
	/**
	 * table name
	 */
	protected $_table = '4t_school_peopleingroup';

	/**
	 * primary key
	 */
	protected $_pk = 'id';
	/**
	 * table fields
	 */
	protected $_dataStruct = array('groupid', 'peopleid');
	
	public function add($groupid,$peopleid) {

		$fields['groupid'] = $groupid;
		$fields['peopleid'] = $peopleid;
		return $this->_add($fields, false);
	}

	public function delete($groupid,$peopleid) {
		$sql = $this->_bindSql('delete from %s where groupid = ? and peopleid = ?',
						$this->getTable());

		$smt = $this->getConnection()->createStatement($sql);
		$result = $smt->execute(array($groupid,$peopleid));	
		return ($result);
	}

}

?>