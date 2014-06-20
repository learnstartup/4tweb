<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_SchoolArea_Dm - 数据模型
 *
 * @author yang <yangyan7777@sina.com> 
 * @copyright http://www.fenxiangyo.com
 */
class App_OrderLog_Dm extends PwBaseDm {

	protected $id;
	
	public function setOrderId($orderid) {
		$this->_data['orderid'] = intval($orderid);
		return $this;
	}

	public function setby($username) {
		$this->_data['by'] = $username;
		return $this;
	}

	public function setAction($action) {
		$this->_data['action'] = $action;
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