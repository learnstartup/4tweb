<?php
defined('WEKIT_VERSION') or exit(403);
class App_Boutique_Dm extends PwBaseDm {

	protected $id;


	public function setBoutique($boutique) {
	}

	public function setSchoolId ($schoolid){
		$this->_data['schoolid']=$schoolid;
		return $this;
	}

	public function setType($type) {
		$this->_data['type'] = $type;
		return $this;
	}	

	public function setImgUrl($imgurl) {
		$this->_data['imgurl'] = $imgurl;
		return $this;
	}

	public function setLink($link) {
		$this->_data['link'] = $link;
		return $this;
	}	

	public function setDescription($description) {
		$this->_data['description'] = $description;
		return $this;
	}

	public function setIsRelease ($release){
		$this->_data['isrelease']=$release;
		return $this;
	}

	public function setStartDate ($startdate){
		$this->_data['startdate']=$startdate;
		return $this;
	}

	public function setEndDate ($enddate){
		$this->_data['enddate']=$enddate;
		return $this;
	}
	
	public function setCreateDate($createDate) {
		$this->_data['createdate']=$createDate;
		return $this;
	}

	public function setLastUpdateTime ($lastUpdateTime){
		$this->_data['lastupdatetime']=$lastUpdateTime;
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
