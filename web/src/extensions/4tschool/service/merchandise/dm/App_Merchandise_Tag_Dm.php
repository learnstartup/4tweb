<?php

defined('WEKIT_VERSION') or exit(403);

class App_Merchandise_Tag_Dm extends PwBaseDm {

	protected $id;

	public function setMerchandise($merchandise) {
		
	}

	public function setMid($mid) {
		$this->_data['mid'] = $mid;
		return $this;
	}

	public function setTid($tid) {
		$this->_data['tid'] = $tid;
		return $this;
	}	

	public function setCreateDate($createDate) {
		$this->_data['createdate'] = $createDate;
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

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
