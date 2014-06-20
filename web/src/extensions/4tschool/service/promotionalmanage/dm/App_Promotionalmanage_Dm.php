<?php
defined('WEKIT_VERSION') or exit(403);

/**
* 
*/
class App_Promotionalmanage_Dm extends PwBaseDm
{

	protected $id;

	public function setChoosenSchoolId ($choosenSchoolId){
		$this->_data['schoolid'] = $choosenSchoolId;
		return $this;
	}

	public function setShopId ($choosenShopId){
		$this->_data['shopid'] = $choosenShopId;
		return $this;
	}

	public function setPromotionalStatus ($promotionalStatus){
		$this->_data['promotionalstatus'] = $promotionalStatus;
		return $this;
	}

	public function setPromotionalStarTime ($promotionalStarTime){
		$this->_data['promotionalstartime'] = $promotionalStarTime;
		return $this;
	}

	public function setPromotionalEndTime ($promotionalEndTime){
		$this->_data['promotionalendtime'] = $promotionalEndTime;
		return $this;
	}

	public function setPromotionalCreateDate ($promotionalCreatedate){
		$this->_data['promotionalcreatedate'] = $promotionalCreatedate;
		return $this;
	}

	public function setPromotionalUpdate ($promotionalUpdate){
		$this->_data['promotionalupdate'] = $promotionalUpdate;
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