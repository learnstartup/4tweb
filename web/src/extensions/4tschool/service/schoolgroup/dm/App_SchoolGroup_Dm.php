<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_SchoolArea_Dm - 数据模型
 *
 * @author yang <yangyan7777@sina.com> 
 * @copyright http://www.fenxiangyo.com
 */
class App_SchoolGroup_Dm extends PwBaseDm {

	protected $id;
	
	public function setSchool($schoolid) {
		$this->_data['schoolid'] = intval($schoolid);
		return $this;
	}

	public function setName($groupname) {
		$this->_data['name'] = $groupname;
		return $this;
	}

	public function setType($type) {
		$this->_data['type'] = $type;
		return $this;
	}

	public function setAreaId($areaid) {
		$this->_data['areaid'] = $areaid;
		return $this;
	}

	public function setLeaderId($leaderid) {
		$this->_data['leaderid'] = $leaderid;
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