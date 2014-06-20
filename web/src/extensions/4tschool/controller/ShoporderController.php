<?php

Wind::import('EXT:4tschool.admin.T4AdminBaseController');


class ShoporderController extends T4AdminBaseController
{
    public function run()
    {
        $startDate = $this->getInput('startDate');
        $endDate = $this->getInput('endDate');
        $shopid = $this->getInput('shopid');

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

        $this->setOutput($startDate,'startDate');
        $this->setOutput($endDate,'endDate');

        $ShopSales = $this->_getShopDailySaleDs()->getSaleByShop($shopid,$startDate,$endDate);
        $this->setOutput($ShopSales,'ShopSales');

        $OverallSales = $this->_getShopDailySaleDs()->getOverAllSales($startDate,$endDate);
        $this->setOutput($OverallSales,'OverallSales');



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


    /**
     * @return App_ShopDailySale
     */
    private function _getShopDailySaleDs()
    {
        return Wekit::load('EXT:4tschool.service.shopdailysale.App_ShopDailySale');
    }

    /**
     * @return App_SchoolPeople
     */
    private function _getShopSchoolPeople()
    {
        return Wekit::load('EXT:4tschool.service.schoolpeople.App_SchoolPeople');
    }
}