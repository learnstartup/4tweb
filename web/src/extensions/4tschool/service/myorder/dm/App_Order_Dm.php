<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_SchoolArea_Dm - 数据模型
 *
 * @author yang <yangyan7777@sina.com> 
 * @copyright http://www.fenxiangyo.com
 */
class App_Order_Dm extends PwBaseDm {

	protected $id;

	
	public function setUserId($userid) {
		$this->_data['userid'] = intval($userid);
		return $this;
	}

	public function setSchoolId($schoolid) {
		$this->_data['schoolid'] = intval($schoolid);
		return $this;
	}

	public function setShopId($shopid) {
		$this->_data['shopid'] = intval($shopid);
		return $this;
	}

	public function setOrderNumber($ordernumber) {
		$this->_data['ordernumber'] = $ordernumber;
		return $this;
	}


	public function setStatus($status) {
		$this->_data['status'] = intval($status);
		return $this;
	}

	public function setPaymethod($paymethod) {
		$this->_data['paymethod'] = intval($paymethod);
		return $this;
	}

	public function setDelivermethod($delivermethod) {
		$this->_data['delivermethod'] = intval($delivermethod);
		return $this;
	}

	public function setTo($to) {
		$this->_data['to'] = $to;
		return $this;
	}

	public function setToWho($towho) {
		$this->_data['towho'] = $towho;
		return $this;
	}

	public function setToMobile($toMobile) {
		$this->_data['tomobile'] = $toMobile;
		return $this;
	}

	public function setPreOrder($preOrder) {
		$this->_data['preorder'] = $preOrder;
		return $this;
	}

	public function setPreOrderAt($preOrderAt) {
		$this->_data['preOrderAt'] = $preOrderAt;
		return $this;
	}

	public function setDelivercontact($delivercontact) {
		$this->_data['delivercontact'] = $delivercontact;
		return $this;
	}


	public function setSavingtotal($savingtotal) {
		$this->_data['savingtotal'] = $savingtotal;
		return $this;
	}


	public function setOrdermoney($ordermoney) {
		$this->_data['ordermoney'] = $ordermoney;
		return $this;
	}

	public function setRebatefromshop($rebatefromshop) {
		$this->_data['rebatefromshop'] = $rebatefromshop;
		return $this;
	}

	public function setShopreturn($shopreturn) {
		$this->_data['shopreturn'] = $shopreturn;
		return $this;
	}

	public function setFirstOrder($firstOrder) {
		$this->_data['firstorder'] = $firstOrder;
		return $this;
	}

	public function setFirstOrderSince0331($firstOrder0331) {
		$this->_data['firstordersince0331'] = $firstOrder0331;
		return $this;
	}

	public function setNote($note) {
		$this->_data['note'] = $note;
		return $this;
	}

	public function setEstimatedeliveryat($estimatedeliveryat) {
		$this->_data['estimatedeliveryat'] = $estimatedeliveryat;
		return $this;
	}

	public function setEstimatetime($estimatetime) {
		$this->_data['estimatetime'] = $estimatetime;
		return $this;
	}

	public function setSource($source) {
		$this->_data['source'] = $source;
		return $this;
	}

	public function setOrderToUser($yes) {
		$this->_data['isordertouser'] = $yes;
		return $this;
	}

	public function setDeservedPointcoin($deservedpointcoin) {
		$this->_data['deservedpointcoin'] = $deservedpointcoin;
		return $this;
	}

	public function setIfUserSignInOrder($ifusersigninorder) {
		$this->_data['ifusersigninorder'] = $ifusersigninorder;
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