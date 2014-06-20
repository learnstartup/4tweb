<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_SchoolArea_Dm - 数据模型
 *
 * @author yang <yangyan7777@sina.com> 
 * @copyright http://www.fenxiangyo.com
 */
class App_OrderItem_Dm extends PwBaseDm {

	protected $id;
	
	public function setOrderId($orderid) {
		$this->_data['orderid'] = intval($orderid);
		return $this;
	}

	public function setMerchandiseId($merchandiseid) {
		$this->_data['merchandiseid'] = intval($merchandiseid);
		return $this;
	}

	public function setValid($valid) {
		$this->_data['valid'] = intval($valid);
		return $this;
	}

	public function setSchoolAreaId($schoolareaid) {
		$this->_data['schoolareaid'] = intval($schoolareaid);
		return $this;
	}

	public function setQuatity($quatity) {
		$this->_data['quatity'] = $quatity;
		return $this;
	}


	public function setPriceOriginal($priceoriginal) {
		$this->_data['priceoriginal'] = $priceoriginal;
		return $this;
	}

	public function setPriceOfferDescription($priceofferdescription) {
		$this->_data['priceofferdescription'] = $priceofferdescription;
		return $this;
	}

	public function setPrice($price) {
		$this->_data['price'] = $price;
		return $this;
	}

	public function setSaving($saving) {
		$this->_data['saving'] = $saving;
		return $this;
	}

	public function setIntegral($integral) {
		$this->_data['integral'] = intval($integral);
		return $this;
	}

	public function setSequence($sequence) {
		$this->_data['sequence'] = $sequence;
		return $this;
	}

	public function setPackingprice($packingprice) {
		$this->_data['packingprice'] = $packingprice;
		return $this;
	}

	public function setChangeFromItemId($changeFromItemId) {
		$this->_data['changeFromItemId'] = intval($changeFromItemId);
		return $this;
	}

	public function setStatus($status)
	{
		$this->_data['status'] = intval($status);
		return $this;
	}

	public function setTotalMoney($totalMoney)
	{
		$this->_data['totalMoney'] = $totalMoney;
		return $this;

	}

	public function setPromoUsed($promoUsed)
	{
		$this->_data['promoUsed'] = $promoUsed;
		return $this;
		
	}

	public function setCommented($commented)
	{
		$this->_data['commented'] = $commented;
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