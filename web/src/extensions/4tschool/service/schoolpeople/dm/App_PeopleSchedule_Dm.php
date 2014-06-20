<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_PeopleSchedule_Dm - 数据模型
 *
 * @author yang <yangyan7777@sina.com> 
 * @copyright http://www.fenxiangyo.com
 */
class App_PeopleSchedule_Dm extends PwBaseDm {

	protected $id;
	
	public function setSchool($schoolid) {
		$this->_data['schoolid'] = intval($schoolid);
		return $this;
	}

	public function setUserid($userid) {
		$this->_data['userid'] = intval($userid);
		return $this;
	}

	public function setType($type) {
		$this->_data['type'] = $type;
		return $this;
	}

	public function setDateTimeBegin($datetimeBegin) {
		$this->_data['datetimeBegin'] = $datetimeBegin;
		return $this;
	}

	public function setDateTimeEnd($datetimeEnd) {
		$this->_data['datetimeEnd'] = $datetimeEnd;
		return $this;
	}

	public function setActionBy($actionBy) {
		$this->_data['actionby'] = $actionBy;
		return $this;
	}

	public function setShopId($shopId) {
		$this->_data['shopid'] = $shopId;
		return $this;
	}

	public function setDescription($description) {
		$this->_data['description'] = $description;
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