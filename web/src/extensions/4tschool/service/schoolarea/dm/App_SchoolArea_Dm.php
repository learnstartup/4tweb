<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_SchoolArea_Dm - 数据模型
 *
 * @author yang <yangyan7777@sina.com> 
 * @copyright http://www.fenxiangyo.com
 */
class App_SchoolArea_Dm extends PwBaseDm {

	protected $id;
	
	public function setSchool($schoolid) {
		$this->_data['schoolid'] = intval($schoolid);
		return $this;
	}

	public function setArea($areaname) {
		$this->_data['areaname'] = $areaname;
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