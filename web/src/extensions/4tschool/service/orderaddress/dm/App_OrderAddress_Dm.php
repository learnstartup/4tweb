<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_SchoolArea_Dm - 数据模型
 *
 * @author yang <yangyan7777@sina.com> 
 * @copyright http://www.fenxiangyo.com
 */
class App_OrderAddress_Dm extends PwBaseDm {

	protected $id;
	
	public function setUserid($userid) {
		$this->_data['userid'] = intval($userid);
		return $this;
	}

	public function setName($username) {
		$this->_data['rname'] = $username;
		return $this;
	}


	public function setAddress($address) {
		$this->_data['raddress'] = $address;
		return $this;
	}

	public function setPhone($phone) {
		$this->_data['rphone'] = $phone;
		return $this;
	}

	public function setIsDefault($value) {
		$this->_data['isdefault'] = $value;
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