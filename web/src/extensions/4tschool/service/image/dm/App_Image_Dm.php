<?php
defined('WEKIT_VERSION') or exit(403);
class App_Image_Dm extends PwBaseDm {

	protected $id;

	public function setFid($fid){
		$this->_data['fid']=$fid;
		return $this;
	}

	public function setImgUrl($url){
		$this->_data['imgurl']=$url;
		return $this;
	}

	public function setType($type){
		$this->_data['type']=$type;
		return $this;
	}

	public function setStandard($standard){
		$this->_data['standard']=$standard;
		return $this;
	}

	public function setCreateDate($createDate){
		$this->_data['createdate']=$createDate;
		return $this;
	}

	public function setLastUpdateTime($lastupdateTime) {
		$this->_data['lastupdatetime'] = $lastupdateTime;
		return $this;
	}
	
	public function setIsActive($isActive){
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
