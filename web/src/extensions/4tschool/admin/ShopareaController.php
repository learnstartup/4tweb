<?php

Wind::import('EXT:4tschool.admin.T4AdminBaseController');
Wind::import('EXT:4tschool.service.shoparea.dm.App_Shoparea_Dm');

class ShopareaController extends T4AdminBaseController
{
    public function run()
    {
        $this->_setNavType('shoparea'); 

        $allSchool = $this->_get4TSchoolDS()->getOpenedSchools();
        $allSchool = array_values($allSchool);
        $countschool = count($allSchool);

        if ($this->getInput('search', 'post') === 'search') 
        {
            list($shopId) = $this->getInput(array('shopId'), 'post');
        }
        elseif($this->getInput('save', 'post') === 'save')
        {
            list($shopId) = $this->getInput(array('hiddenshopid'), 'post');

            list($shop) = $this->getInput(array('shop'), 'post');
            list($shopareaid) = $this->getInput(array('shopareaid'), 'post');
            list($schoolid) = $this->getInput(array('schoolid'), 'post');

            for ($i=0; $i < $countschool; $i++) 
            { 
                $dm = new App_Shoparea_Dm();
                $dm->setShopId($shopId)
                   ->setSchoolId($schoolid[$i]);
                if($shopareaid[$i] > 0)
                {
                    if(!$shop[$i])
                    {
                        $delstatus = $this->_getShopAreaDs()->deleteShopAreaById($shopareaid[$i]);
                    }
                }
                else
                {
                    if($shop[$i])
                    {
                        $addstatus = $this->_getShopAreaDs()->add($dm);
                    }
                }
            }

            if($delstatus || $addstatus)
            {
                $this->showMessage("更新成功");
            }

        }
        else
        {
            list($shopId) = $this->getInput(array('shopId'), 'get');
        }

        $shopMsg = $this->_getShopDs()->getByShopId($shopId);

        foreach ($allSchool as $key => $value)
        {
            $shoparea = $this->_getShopAreaDs()->checkShopIfExist($value['schoolid'], $shopId);

            $allSchool[$key]['shopareaid'] = $shoparea[0]['id'];
            $allSchool[$key]['status'] = count($shoparea)>0?"1":"0";
            $allSchool[$key]['shopname'] = $shopMsg['name'];

        } 

        $this->setOutput($shopId, 'shopId');
        $this->setOutput($shopMsg, 'shopMsg');
        $this->setOutput($allSchool, 'allSchool');

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

    /**
     * @return App_Shop
     */
    private function _getShopAreaDs()
    {
        return Wekit::load('EXT:4tschool.service.shoparea.App_Shoparea');
    }
}