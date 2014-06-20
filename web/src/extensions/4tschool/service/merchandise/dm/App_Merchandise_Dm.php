<?php

defined('WEKIT_VERSION') or exit(403);

class App_Merchandise_Dm extends PwBaseDm {

	protected $id;

	public function setMerchandise($merchandise) {
		
	}

	public function setShopId($shopid) {
		$this->_data['shopid'] = $shopid;
		return $this;
	}

	public function setTagId($tagid) {
		$this->_data['tagid'] = $tagid;
		return $this;
	}

	public function setMerchandiseName($merchandisename) {
		$this->_data['name'] = $merchandisename;
		return $this;
	}

	public function setNeedPackingPrice($needPackingPrice)
	{
		$this->_data['needPackingPrice'] = $needPackingPrice;
		return $this;
	}

	public function setPrice($price) {
		$this->_data['price'] = $price;
		return $this;
	}

    public function setCurrentPrice($currentPrice) {
        $this->_data['currentprice'] = $currentPrice;
        return $this;
    }

	public function setUnit($unit) {
		$this->_data['unit'] = $unit;
		return $this;
	}

	public function setRemainder($remainder) {
		$this->_data['remainder'] = $remainder;
		return $this;
	}

	public function setRecommend($recommend) {
		$this->_data['recommend'] = $recommend;
		return $this;
	}

	public function setActive($active) {
		$this->_data['active'] = $active;
		return $this;
	}

	public function setIsStar ($isStar){
		$this->_data['isstar']=$isStar;
		return $this;
	}

	public function setDescription($description) {
		$this->_data['description'] = $description;
		return $this;
	}

	public function setMerchandiseDescription($merchandisedescription) {
		$this->_data['merchandisedescription'] = $merchandisedescription;
		return $this;
	}

	public function setDescriptionUrl($descriptionurl) {
		$this->_data['descriptionurl'] = $descriptionurl;
		return $this;
	}

	public function setImageUrl($url) {
		$this->_data['imageurl'] = $url;
		return $this;
	}

	public function setCreateDate($createDate) {
		$this->_data['createdate'] = $createDate;
		return $this;
	}

	public function setLastUpdateTime($lastupdateTime) {
		$this->_data['lastupdatetime'] = $lastupdateTime;
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
