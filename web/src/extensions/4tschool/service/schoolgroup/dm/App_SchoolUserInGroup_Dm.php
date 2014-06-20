<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_SchoolArea_Dm - 数据模型
 *
 * @author yang <yangyan7777@sina.com> 
 * @copyright http://www.fenxiangyo.com
 */
class App_SchoolUserInGroup_Dm extends PwBaseDm {

	
	public function setGroupId($groupid) {
		$this->_data['groupid'] = intval($groupid);
		return $this;
	}

	public function setPeopleId($peopleid) {
		$this->_data['peopleid'] = intval($peopleid);
		return $this;
	}


	/* (non-PHPdoc)
	 * @see PwBaseDm::_beforeAdd()
	 */
	protected function _beforeAdd() {
		// TODO Auto-generated method stub
		//check the fields value before add
		return true;
	}

	/* (non-PHPdoc)
	 * @see PwBaseDm::_beforeUpdate()
	 */
	 protected function _beforeUpdate() {
		// TODO Auto-generated method stub
	 	//check the fields value before update
		return true;
	}
}

?>