<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_MerComment_Dm - 数据模型
 *
 * @author yang <yangyan7777@sina.com> 
 * @copyright http://www.fenxiangyo.com
 */
class App_MerComment_Dm extends PwBaseDm {

	protected $id;
	
	public function setUserId($userid) {
		$this->_data['userid'] = intval($userid);
		return $this;
	}

	public function setMID($mid) {
		$this->_data['mid'] = intval($mid);
		return $this;
	}

	public function setOrderId($orderid) {
		$this->_data['orderid'] = $orderid;
		return $this;
	}

	public function setComment($comment) {
		$this->_data['comment'] = $comment;
		return $this;
	}

	public function setEnvironmentscore($environmentscore) {
		$this->_data['environmentscore'] = $environmentscore;
		return $this;
	}

	public function setServicescore($servicescore) {
		$this->_data['servicescore'] = $servicescore;
		return $this;
	}

	public function setTastescore($tastescore) {
		$this->_data['tastescore'] = $tastescore;
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