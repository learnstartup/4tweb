<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_shop - 数据服务接口
 */
class App_ShopDailySale
{
    public function getDiancanyoRate()
    {
        return 0.07;
    }

    public function getAgentRate()
    {
        return 0.6;
    }

    public function getUserRate()
    {
        return 0.4;
    }

    public function getAgentProfit($money)
    {
        $diancanyoRate = $this->getDiancanyoRate();
        $agentRate = $this->getAgentRate();
        $userRate = $this->getUserRate();

        $diancanyoMoney = $money * $diancanyoRate;

        //因为精确到角，所以进位后再退位
        return floor(($money - $diancanyoMoney) * $agentRate * 10) / 10;
    }

    public function getUserProfit($money)
    {
        $diancanyoRate = $this->getDiancanyoRate();
        $agentRate = $this->getAgentRate();
        $userRate = $this->getUserRate();

        $diancanyoMoney = $money * $diancanyoRate;

        return floor(($money - $diancanyoMoney) * $userRate * 10) / 10;
    }

    public function getSaleByShop($shopid,$startdate,$enddate)
    {
        return $this->loadDao()->getSaleByShop($shopid,$startdate,$enddate);
    }

    public function getOverAllSales($startdate,$enddate)
    {
        return $this->loadDao()->getOverAllSales($startdate,$enddate);
    }

    public function getOverallSalesByAgent($agentid,$startdate,$enddate)
    {
        return $this->loadDao()->getOverallSalesByAgent($agentid,$startdate,$enddate);
    }

    public function getShopSalesByAgent($agentid,$startdate,$enddate)
    {
        return $this->loadDao()->getShopSalesByAgent($agentid,$startdate,$enddate);
    }

    /*
    * 计算某一天的销售额, 以店铺为基础单位 
    * 如果指明某一个商家，则只计算某个商家的
    */
    public function calDailySale($datefor,$shopid = 0)
    {
        //get order list by date
        $lowestDate = $this->stringToDateLowerest($datefor);
        $bigestDate = $this->stringToDateBiggest($datefor);

        $statusArray = $this->_getMyOrderDS()->getAllStatus();

        $orders = $this->_getMyOrderDS()->getOrdersByCreateTime(0,$statusArray,$lowestDate,$bigestDate);
        
        $dailyCal = array();

        foreach ($orders as $key => $eachorder) {
            $shopid = $eachorder['shopid'];

            if(array_key_exists($shopid, $dailyCal))
            {
                $dailyCal[$shopid]['totalorders'] = $dailyCal[$shopid]['totalorders'] + 1;
                $dailyCal[$shopid]['totalmoney'] = $dailyCal[$shopid]['totalmoney'] + $eachorder['ordermoney'];
                $dailyCal[$shopid]['totalshopreturn'] = $dailyCal[$shopid]['totalshopreturn'] + $eachorder['shopreturn'];
            }
            else
            {
                //初始化
                $dailyCal[$shopid]['totalorders'] = 1;
                $dailyCal[$shopid]['totalmoney'] = $eachorder['ordermoney'];
                $dailyCal[$shopid]['validorders'] = 0;
                $dailyCal[$shopid]['validmoney'] = 0;
                $dailyCal[$shopid]['datefor'] = $lowestDate;

                $dailyCal[$shopid]['validshopreturn'] = 0;
                $dailyCal[$shopid]['totalshopreturn'] = $eachorder['shopreturn'];
            }

            //check if it is valid order, if yes
            //客户拒签(6)
            //客户取消(7)
            //缺货(-1)
            //等待确认(0)
            
            if($eachorder['status'] != -1
                && $eachorder['status'] != 0
                && $eachorder['status'] != 6
                && $eachorder['status'] != 7)
            {


                $dailyCal[$shopid]['validorders'] = $dailyCal[$shopid]['validorders'] + 1;
                $dailyCal[$shopid]['validmoney'] = $dailyCal[$shopid]['validmoney'] + $eachorder['ordermoney'];
                $dailyCal[$shopid]['validshopreturn'] = $dailyCal[$shopid]['validshopreturn'] + $eachorder['shopreturn'];
                
            }
        }


        return $dailyCal;
    }


    public function saveDailyCal($dailyCal)
    {
        foreach ($dailyCal as $shopid => $value) {
            
            $datefor = $value['datefor'];
        
            //check if exists
            //if exist, delete first, then insert
            $this->loadDao()->deleteBy($shopid,$value['datefor']);
            $value['shopid'] = $shopid;

            $this->loadDao()->add($value);

        }
    }

    protected function stringToDateLowerest($fromTime)
    {
        $fromDateArray = getdate(strtotime($fromTime));
        $fromTime = mktime(0, 0, 0, $fromDateArray['mon'], $fromDateArray['mday'], $fromDateArray['year']);

        return date('Y-m-d', $fromTime);
    }

    protected function stringToDateBiggest($toTime)
    {
        $toDateArray = getdate(strtotime($toTime));
        $toTime = mktime(23, 59, 59, $toDateArray['mon'], $toDateArray['mday'], $toDateArray['year']);

        return date('Y-m-d H:i:s', $toTime);
    }

    
    /**
     * @return App_ShopDailySale_Dao
     */
    private function loadDao()
    {
        return Wekit::loadDao('EXT:4tschool.service.shopdailysale.dao.App_ShopDailySale_Dao');
    }

    private function _getMyOrderDS()
    {
        return Wekit::load('EXT:4tschool.service.myorder.App_MyOrder');
    }

   
}