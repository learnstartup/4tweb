<?php

Wind::import('EXT:4tschool.admin.T4AdminBaseController');

class MyaccountController extends T4AdminBaseController
{

	public function beforeAction($handlerAdapter) {
		parent::beforeAction($handlerAdapter);
		
	}

		
	public function run() 
	{
		if ($this->getInput('type', 'post') === 'do') 
    	{
    		$userid = $this->getInput("userid");
    		$mymoney = $this->getInput("mymoney");
    		$description = $this->getInput("description");

    		$orderid = $this->_getMyOrderDS()->getOrderIdByUserId($userid);
			$description = empty($description)?"首次下单奖励":$description;
			$addbeforemoney = $this->_loadMyMoneyDao()->getCurrentMoney($userid);
			$status = $this->_getMyMoneyHistroyDS()->updateMyMoney($userid, $mymoney, $orderid, $description);
			$addafteremoney = $this->_loadMyMoneyDao()->getCurrentMoney($userid);

			$this->setOutput($status,'status');
			$this->setOutput($userid,'userid');
			$this->setOutput("添加成功！",'show');
			$this->setOutput($addbeforemoney,'addbeforemoney');
			$this->setOutput($addafteremoney,'addafteremoney');
			$this->setOutput($mymoney, 'mymoney');
    	}
	}
		

    private function _getMyMoneyHistroyDS()
	{
		return Wekit::load('EXT:4tschool.service.mymoney.App_MyMoney');
	}

	private function _getMyOrderDS()
	{
		return Wekit::load('EXT:4tschool.service.myorder.App_MyOrder');
	}

	/**
	 * @return App_MyMoney_Dao
	 */
	private function _loadMyMoneyDao() {
		return Wekit::loadDao('EXT:4tschool.service.mymoney.dao.App_MyMoney_Dao');
	}


}