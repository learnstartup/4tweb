<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_MyMoney - 数据服务接口
 *
 */
class App_MyMoney{


	/*
	*
	*/
    public function getMyMoney($userid)
    {
    	return $this->_loadMyMoneyDao()->getMyMoney($userid);
    }

    public function updateMyMoney($userid,$moneyIncome, $orderid = 0, $description)
    {
    	//get last money
    	$currentMoney = $this->_loadMyMoneyDao()->getCurrentMoney($userid);
    	$moneyLeft = $currentMoney + $moneyIncome;

    	$this->createMyMoneyHistory($userid,$currentMoney,$moneyIncome,$moneyLeft,$orderid,$description);
    	return $this->_loadMyMoneyDao()->updateMyMoney($userid,$moneyLeft);	
    }

    public function getMyMoneyHistorybyId($id)
    {
    	return $this->_loadMyMoneyDao()->getMyMoneyHistorybyId($id);
    }

    public function countMyMoneyHistory($userid)
    {
        return $this->_loadMyMoneyHistoryDao()->countMyMoneyHistory($userid);
    }

    public function getMyMoneyHistory($userid,$limit,$offset)
    {
    	return $this->_loadMyMoneyHistoryDao()->getMyMoneyHistory($userid,$limit,$offset);
    }

    public function getOneByOrderId($orderid)
    {
        return $this->_loadMyMoneyHistoryDao()->getOneByOrderId($orderid);
    }

    public function createMyMoneyHistory($userid,$moneyoriginal,$moneyincome,$moneyleft,$orderid,$description)
    {
    	$data['userid'] = $userid;
    	$data['moneyoriginal'] = $moneyoriginal;
    	$data['moneyincome'] = $moneyincome;
    	$data['moneyleft'] = $moneyleft;
        $data['orderid'] = $orderid;
        $data['description'] = $description;

    	$this->_loadMyMoneyHistoryDao()->add($data);

    }

//======================================================================
//  credit part
//======================================================================

    public function updateMyCredit($userid,$creditIncome,$description="")
    {
    	//get last credit
    	$currentCredit = $this->_loadMyMoneyDao()->getCurrentCredit($userid);
    	$creditLeft = $currentCredit + $creditIncome;

    	$this->createMyCreditHistory($userid,$currentCredit,$creditIncome,$creditLeft,$description);
    	return $this->_loadMyMoneyDao()->updateMyCredit($userid,$creditLeft);
    }

    public function getMyCreditHistorybyId($id)
    {
    	return $this->_loadMyCreditHistoryDao()->getMyCreditHistorybyId($id);
    }

    public function getMyCreditHistory($userid,$limit,$offset)
    {
    	return $this->_loadMyCreditHistoryDao()->getMyCreditHistory($userid,$limit,$offset);
    }


    public function countMyCreditHistory($userid)
    {
        return $this->_loadMyCreditHistoryDao()->countMyCreditHistory($userid);
    }

    public function createMyCreditHistory($userid,$creditoriginal,$creditincome,$creditleft,$description)
    {
    	$data['userid'] = $userid;
    	$data['creditoriginal'] = $creditoriginal;
    	$data['creditincome'] = $creditincome;
    	$data['creditleft'] = $creditleft;
        $data['description'] = $description;

    	$this->_loadMyCreditHistoryDao()->add($data);

    }

	
	/**
	 * @return App_MyMoney_Dao
	 */
	private function _loadMyMoneyDao() {
		return Wekit::loadDao('EXT:4tschool.service.mymoney.dao.App_MyMoney_Dao');
	}

	/**
	 * @return App_MyMoneyHistory_Dao
	 */
	private function _loadMyMoneyHistoryDao() {
		return Wekit::loadDao('EXT:4tschool.service.mymoney.dao.App_MyMoneyHistory_Dao');
	}

	/**
	 * @return App_MyCredit_Dao
	 */
	private function _loadMyCreditDao() {
		return Wekit::loadDao('EXT:4tschool.service.mymoney.dao.App_MyCredit_Dao');
	}

	/**
	 * @return App_MyCreditHistory_Dao
	 */
	private function _loadMyCreditHistoryDao() {
		return Wekit::loadDao('EXT:4tschool.service.mymoney.dao.App_MyCreditHistory_Dao');
	}

	
}

?>