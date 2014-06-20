<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_SchoolArea_Dm - 数据模型
 *
 * @author yang <yangyan7777@sina.com> 
 * @copyright http://www.fenxiangyo.com
 */
class App_OrderStatus_Dm extends PwBaseDm {

	protected $id;
	
	public function setOrderId($orderid) {
		$this->_data['orderid'] = intval($orderid);
		return $this;
	}

	public function setby($username) {
		$this->_data['changedby'] = $username;
		return $this;
	}

	public function setStatusTo($status) {
		$this->_data['statusto'] = $status;
		return $this;
	}

	public function setStatusFrom($status) {
		$this->_data['statusfrom'] = $status;
		return $this;
	}

	public function setChangeDateFrom($changedatefrom) {
		$this->_data['changedatefrom'] = $changedatefrom;
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