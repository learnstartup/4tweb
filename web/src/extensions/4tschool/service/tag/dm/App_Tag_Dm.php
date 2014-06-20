<?php
defined('WEKIT_VERSION') or exit(403);
class App_Tag_Dm extends PwBaseDm {

	protected $id;


	public function setTag($tag) {
		$this->_data['name'] = $tag['name'];
		$this->_data['shopid']= $tag['shopid'];
		$this->_data['issystem'] = $tag['issystem'];
		$this->_data['isactive']= $tag['isactive'];
		$this->_data['createdate'] = $tag['createdate'];
		$this->_data['lastupdatetime']=$tag['lastupdatetime'];
		return $this;
	}

	public function setShopId ($shopId){
		$this->_data['shopid']=$shopId;
		return $this;
	}

	public function setTagName($tagName) {
		$this->_data['name'] = $tagName;
		return $this;
	}
	
	public function setLastUpdateTime($updateTime) {
		$this->_data['lastupdatetime']=$updateTime;
		return $this;
	}

	public function setIsActive ($isActive){
		$this->_data['isactive']=$isActive;
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
