<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_Dongta_Dm - 数据模型
 *
 * @author chenjm <sky_hold@163.com>
 * @copyright http://www.phpwind.net
 * @license http://www.phpwind.net
 */
class App_Dongta_Dm extends PwBaseDm {

	protected $id;
	
	public function setAct($act) {
		$this->_data['act'] = intval($act);
		return $this;
	}

	public function setTouid($uid) {
		$this->_data['touid'] = intval($uid);
		return $this;
	}

	public function setCreatedUser($uid, $username) {
		$this->_data['created_userid'] = $uid;
		$this->_data['creaed_username'] = $username;
		return $this;
	}
	
	public function setCreatedTime($time) {
		$this->_data['created_time'] = $time;
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