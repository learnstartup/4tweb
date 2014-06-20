<?php

Wind::import('EXT:4tschool.admin.T4AdminBaseController');

class ShopstatusrecordController extends T4AdminBaseController
{
    private $pageNumber = 10;

    public function run()
    {
        $this->_setNavType('shopstatusrecord'); 

        if ($this->getInput('type', 'post') === 'do') 
        {
            list($shopId) = $this->getInput(array('shopId'), 'post');
        }

        $shopId = $this->getInput("shopId");
        $this->setOutput($shopId, 'shopId');

        $page = $this->getInput('page');

        $searchCondition = array('shopId' => $shopId);
        $count = $this->_getShopstatusrecordDs()->countAllShopStatusRecord($searchCondition);

        if (0 < $count) 
        {
          $totalPage = ceil($count/$this->pageNumber);
          $page > $totalPage && $page = $totalPage;
          list($start, $limit) = Pw::page2limit($page, $this->pageNumber);

          if($page <= 0)
            $page =1;
        }

        $shopStatusRecordList = $this->_getShopstatusrecordDs()->getAllShopStatusRecord($searchCondition, $start, $limit);
        $shopStatusRecordList = array_values($shopStatusRecordList);
        $shopId = $this->getInput('shopId');

        $args['shopId'] = $shopId;

        $this->setOutput($shopStatusRecordList, 'shopStatusRecordList');
        $this->setOutput($searchCondition, 'searchCondition');
        $this->setOutput($count, 'count');  
        $this->setOutput($page, 'page');
        $this->setOutput($this->pageNumber, 'perPage');
        $this->setOutput($args, 'args');
    } 

    /**
     * @return App_Mobilelogin
     */
    private function _getMobileloginDs()
    {
        return Wekit::load('EXT:4tmobile.service.mobile.App_Weixin');
    }

    /**
     * @return App_Shopstatusrecord
     */
    private function _getShopstatusrecordDs()
    {
        return Wekit::load('EXT:4tschool.service.shopstatusrecord.App_Shopstatusrecord');
    }

    private function _get4TSchoolDS()
    {
        return Wekit::load('EXT:4tschool.service.school.App_School');
    }

    /**
     * @return App_Shop
     */
    private function _getShopDs()
    {
        return Wekit::load('EXT:4tschool.service.shop.App_Shop');
    }

}

?>