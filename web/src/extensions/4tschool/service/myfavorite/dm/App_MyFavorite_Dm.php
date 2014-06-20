<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_SchoolArea_Dm - 数据模型
 *
 * @author yang <yangyan7777@sina.com> 
 * @copyright http://www.fenxiangyo.com
 */
class App_MyFavorite_Dm extends PwBaseDm {

	protected $id;
	
	public function setShop($shopid) {
		$this->_data['shopid'] = intval($shopid);
		return $this;
	}

	public function setUser($userid) {
		$this->_data['userid'] = intval($userid);
		return $this;
	}

	public function setMerchandiseid($merchandiseid) {
		$this->_data['merchandiseid'] = $merchandiseid;
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