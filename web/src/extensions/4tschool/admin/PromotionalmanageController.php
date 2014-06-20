<?php

Wind::import('EXT:4tschool.admin.T4AdminBaseController');
Wind::import('EXT:4tschool.service.promotionalmanage.dm.App_Promotionalmanage_Dm');

class PromotionalmanageController extends T4AdminBaseController
{
    private $pageNumber = 10;

    public function run()
    {
        $this->_setNavType('promotionalmanage');

        $choosenSchoolId = -1;
        $promotionalstatus = -1;
        if ($this->getInput('type', 'post') === 'do') 
        {
          list($choosenSchoolId, 
               $promotionalstatus) = $this->getInput(array('choosenSchoolId',
                                                           'promotionalstatus'), 'post');
        }

        $page = $this->getInput('page');

        $searchCondition = array('choosenSchoolId' => $choosenSchoolId, 
                                 'promotionalstatus' => $promotionalstatus);
        $count =  $this->_getPromotionalmanageDs()->countPromotional($searchCondition);

        if (0 < $count) 
        {
          $totalPage = ceil($count/$this->pageNumber);
          $page > $totalPage && $page = $totalPage;
          list($start, $limit) = Pw::page2limit($page, $this->pageNumber);

          if($page <= 0)
            $page =1;
        }
        $shopPromotionalList = $this->_getPromotionalmanageDs()->getAllShopsPromotional($searchCondition, $start, $limit);
        $shopPromotionalList = array_values($shopPromotionalList);

        $this->getSchoolList();

        $this->setOutput($shopPromotionalList, 'shopPromotionalList');
        $this->setOutput($searchCondition, 'searchCondition');
        $this->setOutput($count, 'count');  
        $this->setOutput($page, 'page');
        $this->setOutput($this->pageNumber, 'perPage'); 
    }

    public function addAction()
    {
        $shopList = $this->_getShopDs()->getAllShops(array('choosenShopid'=>'-1', 
                                                           'isactive'=>'-1', 
                                                           'ispartner'=>'-1',
                                                           'isaudit'=>'-1'));

        if ($this->getInput('type', 'post') === 'do') {

            list($choosenSchoolId,
                 $choosenShopId,
                 $promotionalStatus,
                 $promotionalStarTime, 
                 $promotionalEndTime) = $this->getInput(array('choosenSchoolId',
                                                              'choosenShopid',
                                                              'promotionalStatus', 
                                                              'promotionalStarTime', 
                                                              'promotionalEndTime'), 'post');
            if (empty($choosenSchoolId)) 
            {
                $this->showError('请选择学校.');
                return;
            }
                 
            if (empty($choosenShopId)) 
            {
                $this->showError('请选择商家.');
                return;
            }
            
            date_default_timezone_set('PRC');
            $promotionalUpdate = date('Y-m-d H:i:s');

            if (!($promotionalUpdate > $promotionalStarTime && $promotionalUpdate < $promotionalEndTime))
            {
                $this->showError('请选择有效时间.');
            }

            $promotionalUpdate = date('Y-m-d H:i:s');

            $dm = new App_Promotionalmanage_Dm(); 
            $dm->setChoosenSchoolId($choosenSchoolId)
               ->setShopId($choosenShopId)
               ->setPromotionalStatus($promotionalStatus)
               ->setPromotionalStarTime($promotionalStarTime)
               ->setPromotionalEndTime($promotionalEndTime)
               ->setPromotionalCreateDate($promotionalUpdate)
               ->setPromotionalUpdate($promotionalUpdate);

            $id = $this->_getPromotionalmanageDs()->add($dm);
            if ($id > 0) {
                $this->showMessage('添加成功');
            } else {
                $this->showError('更新失败,请联系管理员');
            }  
        } else {

            $this->getSchoolList();
        }
        $this->setOutput($shopList, 'shopList');
    }

    public function editAction()
    {
        if ($this->getInput('type', 'post') === 'do') {

        $id = $this->getInput('id');

        list($choosenSchoolId,
             $promotionalStatus,
             $promotionalStarTime, 
             $promotionalEndTime) = $this->getInput(array('choosenSchoolId',
                                                          'promotionalStatus', 
                                                          'promotionalStarTime', 
                                                          'promotionalEndTime'), 'post');
            if (empty($choosenSchoolId)) 
            {
                $this->showError('请选择学校.');
                return;
            }

            date_default_timezone_set('PRC');
            $promotionalUpdate = date('Y-m-d H:i:s');
            
            if (!($promotionalUpdate > $promotionalStarTime && $promotionalUpdate < $promotionalEndTime))
            {
                $this->showError('请选择有效时间.');
            }

            $dm = new App_Promotionalmanage_Dm();
            $dm->setChoosenSchoolId($choosenSchoolId)
               ->setPromotionalStatus($promotionalStatus)
               ->setPromotionalStarTime($promotionalStarTime) 
               ->setPromotionalEndTime($promotionalEndTime) 
               ->setPromotionalUpdate($promotionalUpdate);                

            $r = $this->_getPromotionalmanageDs()->update($id, $dm);
            if ($r == 1) {
                $this->showMessage('更新成功');
            } else {
                $this->showError('更新失败,请联系管理员');
            }

        } else {
            $id = $this->getInput('id');
            $oneShopPromotionalList = $this->_getPromotionalmanageDs()->getOneShopsPromotional($id);
            $this->getSchoolList();
            $this->setOutput($oneShopPromotionalList, 'oneShopPromotionalList');
        }
    }

    public function getSchoolList()
    {
        $allSchool = $this->_get4TSchoolDS()->getOpenedSchools();
        $allSchool = array_values($allSchool);
        
        $this->setOutput($allSchool, 'allSchool');
    }

    /**
     * @return App_Promotionalmanage
     */
    private function _getPromotionalmanageDs()
    {
        return Wekit::load('EXT:4tschool.service.promotionalmanage.App_Promotionalmanage');
    }

    /**
     * @return App_SchoolPeople
     */
    private function _get4TSchoolDS()
    {
        return Wekit::load('EXT:4tschool.service.school.App_School');
    }

    private function _getShopDs() {
        return Wekit::load('EXT:4tschool.service.shop.App_Shop');
    }

}