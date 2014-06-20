<?php

//Wind::import('EXT:4tschool.admin.T4AdminBaseController');
Wind::import('EXT:4tschool.controller.T4BaseNotLoginController');


class AgentshoporderController extends T4BaseNotLoginController
{
    private $pageNumber = 10;

    public function run()
    {
        $this->setOutput('外卖商家统计','selectedMenu');
        $schoolId = $this->getCurrentSchoolId();
        $startDate = $this->getInput('startDate');
        $endDate = $this->getInput('endDate');
        $shopid = $this->getInput('shopid');
        $agentId = $this->loginUser->uid;

        $today = date('Y-m-d');
        $todayDateArray = getdate(strtotime($today));

        $this->getNoCommentSum($schoolId, $agentId);

        //check start date and end date, if start date is empty, then it need to be previous month day 1
        //if end date is empty, it need to be previous month day last day
        if(empty($startDate))
        {
            $fromTime = mktime(0, 0, 0, $todayDateArray['mon'] -1, 1, $todayDateArray['year']);
            $startDate = date('Y-m-d', $fromTime);
        }

        if(empty($endDate))
        {
            $fromTime = mktime(-24, 0, 0, $todayDateArray['mon'], 1, $todayDateArray['year']);
            $endDate = date('Y-m-d', $fromTime);
        }

        if(empty($shopid) == false)
        {
            $this->setOutput($shopid,'shopid');
        }
        else
            $shopid = 0;  

        $this->setOutput($startDate,'startDate');
        $this->setOutput($endDate,'endDate');

        $ShopSales = $this->_getShopDailySaleDs()->getShopSalesByAgent($agentId,$startDate,$endDate);
        foreach ($ShopSales as $key => &$eachSale) {
            $agentMoney = $this->_getShopDailySaleDs()->getAgentProfit($eachSale['validshopreturn']);
            $eachSale['agentMoney'] = $agentMoney;
        }
        $this->setOutput($ShopSales,'ShopSales');

        $OverallSales = $this->_getShopDailySaleDs()->getOverallSalesByAgent($agentId,$startDate,$endDate);
        foreach ($OverallSales as $key => &$eachSale) {
            $agentMoney = $this->_getShopDailySaleDs()->getAgentProfit($eachSale['validshopreturn']);
            $eachSale['agentMoney'] = $agentMoney;
        }
        $this->setOutput($OverallSales,'OverallSales');

        $myMenus =  $this->_getMyOrderDS()->getMyMenus($schoolId,$this->loginUser->uid);
        $this->setOutput($myMenus, 'myMenus');
        $this->setOutput($schoolId, "schoolId");

    }

    public function agentAction()
    {

        $startDate = $this->getInput('startDate');
        $endDate = $this->getInput('endDate');
        $agentid = $this->getInput('agentid');

        $today = date('Y-m-d');
        $todayDateArray = getdate(strtotime($today));
        

        //check start date and end date, if start date is empty, then it need to be previous month day 1
        //if end date is empty, it need to be previous month day last day
        if(empty($startDate))
        {
            $fromTime = mktime(0, 0, 0, $todayDateArray['mon'] -1, 1, $todayDateArray['year']);
            $startDate = date('Y-m-d', $fromTime);
        }

        if(empty($endDate))
        {
            $fromTime = mktime(-24, 0, 0, $todayDateArray['mon'], 1, $todayDateArray['year']);
            $endDate = date('Y-m-d', $fromTime);
        }

        if(empty($shopid) == false)
        {
            $this->setOutput($shopid,'shopid');
        }
        else
            $shopid = 0;

        $this->setOutput($agentid,'agentid');
        $this->setOutput($startDate,'startDate');
        $this->setOutput($endDate,'endDate');

        $agents = $this->_getShopSchoolPeople()->getPeopleByType('master');
        $this->setOutput($agents,'agents');

        $agentSales = $this->_getShopDailySaleDs()->getOverallSalesByAgent($agentid,$startDate,$endDate);
        foreach ($agentSales as $key => &$eachSale) {
            $agentMoney = $this->_getShopDailySaleDs()->getAgentProfit($eachSale['rebatefromshop']);
            $eachSale['agentMoney'] = $agentMoney;
        }
        $this->setOutput($agentSales,'agentSales');

    }

   public function agentdetailAction()
   {
        $startDate = $this->getInput('startDate');
        $endDate = $this->getInput('endDate');
        $agentid = $this->getInput('agentid');

        $ShopSales = $this->_getShopDailySaleDs()->getShopSalesByAgent($agentid,$startDate,$endDate);
        $this->setOutput($ShopSales,'ShopSales');

        $this->setOutput($agentid,'agentid');
        $this->setOutput($startDate,'startDate');
        $this->setOutput($endDate,'endDate');

   }

   public function orderdetailAction()
   {    
        $startDate = $this->getInput('from');
        $endDate = $this->getInput('to');
        $shopId = $this->getInput('shopId');
        $this->useShareData($shopId, $startDate, $endDate);

        $this->setOutput($startDate,'startDate');
        $this->setOutput($endDate,'endDate');

   }

   private function useShareData($shopId, $startDate, $endDate)
    {
        $this->setOutput('外卖商家统计','selectedMenu');   
        $schoolId = $this->getCurrentSchoolId();
        $userid = $this->loginUser->uid;

        $myMenus =  $this->_getMyOrderDS()->getMyMenus($schoolId,$userid);
        $this->setOutput($myMenus,'myMenus');

        $page = $this->getInput('page');

        //note that it need to retrive out all orders instead of only userself.
        $count = $this->_getMyOrderDS()->countAgentOrders($schoolId, $shopId, $startDate, $endDate);
        $orderTotalMoney = $this->_getMyOrderDS()->countAgentOrderMoney($schoolId, $shopId, $startDate, $endDate); 
        
        $this->setOutput($orderTotalMoney,"orderTotalMoney");

        $this->getNoCommentSum($schoolId, $userid);

        if (0 < $count) 
        {
            $totalPage = ceil($count/$this->pageNumber);
            $page > $totalPage && $page = $totalPage;
            list($start, $limit) = Pw::page2limit($page, $this->pageNumber);

            if($page <= 0)
                $page =1;
        }

        //filter by date range and status
        //note that it need to retrive out all orders instead of only userself.
        $orderList = $this->_getMyOrderDS()->getAgentOrders($schoolId, $shopId, $startDate, $endDate, $limit, $start);

        //get order ids and get its order items
        $orderIds = " -1 ";
        foreach($orderList as $key => $eachOrder)
        {
            $orderIds = $orderIds.",".$eachOrder['id'];
        }

        $orderIds = $orderIds." ,-1 ";

        $orderItems = $this->_getMyOrderDS()->getOrderItemByOrderIds($orderIds);
        $this->setOutput($orderItems,"orderItems");

        $this->setOutput($orderList,'orderList');
        $this->setOutput($count, 'count');  
        $this->setOutput($page, 'page');
        $this->setOutput($this->pageNumber, 'perPage');

        $args['from'] = $startDate;
        $args['to'] = $endDate;
        $args['shopId'] = $shopId;
        $this->setOutput($args,"args");
    }

    public function getNoCommentSum($schoolId, $userid)
    {
        $countNoComment = $this->_getShopCommentDS()->getCountOfMyUnComment($schoolId, $userid);
        $this->setOutput($countNoComment,"countNoComment");
    }

    private function _getShopCommentDS()
    {
        return Wekit::load('EXT:4tschool.service.mercomment.App_MerComment');
    }


    /**
     * @return App_ShopDailySale
     */
    private function _getShopDailySaleDs()
    {
        return Wekit::load('EXT:4tschool.service.shopdailysale.App_ShopDailySale');
    }

    private function _getSchoolAreaDS()
    {
        return Wekit::load('EXT:4tschool.service.schoolarea.App_SchoolArea');
    }

    /**
     * @return App_SchoolPeople
     */
    private function _getShopSchoolPeople()
    {
        return Wekit::load('EXT:4tschool.service.schoolpeople.App_SchoolPeople');
    }

    /**
     * @return App_MyOrder
     */
    private function _getMyOrderDS()
    {
        return Wekit::load('EXT:4tschool.service.myorder.App_MyOrder');
    }

    private function _getSchoolPeopleDS()
    {
        return Wekit::load('EXT:4tschool.service.schoolpeople.App_SchoolPeople');
    }
}