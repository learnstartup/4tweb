<?php
Wind::import('APPS:windid.api.OpenBaseController');
Wind::import('EXT:4tschool.service.shopstatusrecord.dm.App_Shopstatusrecord_Dm');

/**
 * the last known user to change this file in the repository  <$LastChangedBy: Peter.yan $>
 * @author $Author: Peter.yan $ 215169718@qq.com
 * @copyright ?2003-2103 fenxiangyo.com
 * @license http://www.fenxiangyo.com
 * @package
 */
class OpenShopController extends OpenBaseController
{

    public function getByIdAction()
    {
        $shopId = $this->getInput('shopId', 'get');
        list($schoolid) = $this->getInput(array('schoolid'), 'get');

        $result = $this->_getShopDs()->getByShopId($shopId);
        $schoolExtra = $this->_get4TSchoolDS()->getSchoolExtra($schoolid);
        
        if(empty($result['imageurl']))
        {
            //set default image
            $result['imageurl'] =  Wekit::C('site', 'info.url')."/src/extensions/4tschool/uploaded_images/default/sdefault.jpg";
        }
        else
            $result['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool'.str_replace('\\', '/', $result['imageurl']);

        if($this->isOpening($result['orderbegin'], $result['orderend']))
        {
            $isopen = "1";
        }else
        {
            $isopen = "0";
        }
        $result['isopen'] = $isopen;
        $result['schoolopenorder'] = $schoolExtra[0]['openorder'];

        $this->output($result);
    }

    public function getBySchoolIdAction()
    {   
        
        list($schoolId, $orderby, $sort, $limit, $offset) = $this->getInput(array('schoolId', 'orderby','sort', 'limit', 'offset'), 'get');

        $schoolExtra = $this->_get4TSchoolDS()->getSchoolExtra($schoolId);

        $searchArgs = array('schoolId' => $schoolId, 
                            'shopid' => $shopid, 
                            'orderby' => $orderby, 
                            'sort' => $sort);

        $result = $this->_getShopDs()->getBySchoolId($schoolId, $searchArgs, $limit, $offset);

        foreach($result as $key =>$item)
        {
            if(empty($item['imageurl']))
            {
                //set default image
                $result[$key]['imageurl'] =  Wekit::C('site', 'info.url')."/src/extensions/4tschool/uploaded_images/default/sdefault.jpg";
            }
            else
                $result[$key]['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool'.str_replace('\\', '/', $item['imageurl']);

            if($this->isOpening($result[$key]['orderbegin'], $result[$key]['orderend']))
            {
                $isopen = "1";
            }else
            {
                $isopen = "0";
            }
            $result[$key]['isopen'] = $isopen;
            $result[$key]['schoolopenorder'] = $schoolExtra[0]['openorder'];
        }

        // $openshoplist = array();
        // $noopenshoplist = array();
        // foreach ($result as $key => $value) 
        // {
        //     if($result[$key]['isopen'])
        //     {
        //         array_push($noopenshoplist, $result[$key]);
        //     }
        //     else
        //     {
        //         array_push($openshoplist, $result[$key]);
        //     }
        // }
        // $result = array_merge($noopenshoplist, $openshoplist);
        
        $this->output($result);
    }

    public function countDeliverShopAction()
    {
        $schoolId = $this->getInput('schoolId', 'get');
        $shopList = $this->_getShopDs()->getBySchoolId($schoolId);
        $result['sum'] = count($shopList);
        $this->output($result);
    }

    public function getAllShopBySchoolIdAction()
    {
        list($schoolId, $orderby, $sort, $limit, $offset) = $this->getInput(array('schoolId', 'orderby','sort', 'limit', 'offset'), 'get');

        $schoolExtra = $this->_get4TSchoolDS()->getSchoolExtra($schoolId);

        $searchArgs = array('schoolId' => $schoolId, 
                            'orderby' => $orderby, 
                            'sort' => $sort);

        $result = $this->_getSearchDs()->searchShopsByArgs($schoolId,$searchArgs,$limit,$offset);

        foreach($result as $key =>$item)
        {
            if(empty($item['imageurl']))
            {
                //set default image
                $result[$key]['imageurl'] =  Wekit::C('site', 'info.url')."/src/extensions/4tschool/uploaded_images/default/sdefault.jpg";
            }
            else
                $result[$key]['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool'.str_replace('\\', '/', $item['imageurl']);

            if($this->isOpening($result[$key]['orderbegin'], $result[$key]['orderend']))
            {
                $isopen = "1";
            }else
            {
                $isopen = "0";
            }
            $result[$key]['isopen'] = $isopen;
            $result[$key]['schoolopenorder'] = $schoolExtra[0]['openorder'];
        }

        // $openshoplist = array();
        // $noopenshoplist = array();
        // foreach ($result as $key => $value) 
        // {
        //     if($result[$key]['isopen'])
        //     {
        //         array_push($noopenshoplist, $result[$key]);
        //     }
        //     else
        //     {
        //         array_push($openshoplist, $result[$key]);
        //     }
        // }
        // $result = array_merge($noopenshoplist, $openshoplist);
        
        $this->output($result);

    }

    //菜安标签分类
    public function getTagNameByShopIdAction()
    {
        list($schoolId, $shopId) = $this->getInput(array('schoolId', 'shopId'), 'get');

        $defaultSelected = null;
        $merchandiseList = $this->_getMerchandiseDs()->getActiveMerchandiseByShopId($shopId);
        foreach ($merchandiseList as $key => $value) {
            if (empty($merchandiseList[$key]['imageurl'])) {
                $merchandiseList[$key]['imageurl'] = $this->getDomain() . "/uploaded_images/default/sdefault.jpg";
            } else {
                $merchandiseList[$key]['imageurl'] = $this->getDomain() . str_replace('\\', '/', $value['imageurl']);
            }
            $tagList[$value['tagid']] = $value['tagname'];
            
        }

        $tagList = array_unique($tagList);
        krsort($tagList);
        $newTagList = array();
        foreach ($tagList as $key => $value) {
            array_push($newTagList, array('tagid' => $key, 'tagname' => $value));
        }

        $this->output($newTagList);
    }

    //通过标签取得商品
    public function getMerchandiseByShopIdAndTagIdAction()
    {
        list($schoolId, $shopId, $tagId, $limit, $offset) = $this->getInput(array('schoolId', 'shopId', 'tagId', 'limit', 'offset'), 'get');
        $getFilterArg = array('schoolId' => $schoolId,
                              'shopId' => $shopId,
                              'tagId' => $tagId);
        $schoolInfo = $this->_getSchoolDS()->getSchoolExtra($schoolId);
        $defaultSelected = null;
        $merchandiseList = $this->_getMerchandiseDs()->getMerchandiseByShopIdAndTagId($getFilterArg, $limit, $offset);
        foreach ($merchandiseList as $key => $value) 
        {
            if (empty($merchandiseList[$key]['imageurl'])) 
            {
                $merchandiseList[$key]['imageurl'] = Wekit::C('site', 'info.url') . "/src/extensions/4tschool/uploaded_images/default/sdefault.jpg";
            } else {
                $merchandiseList[$key]['imageurl'] = Wekit::C('site', 'info.url').'/src/extensions/4tschool'. str_replace('\\', '/', $value['imageurl']);
            }
            $tagList[$value['tagid']] = $value['tagname'];
            $merchandiseList[$key]['schoolopenorder'] = $schoolInfo[0]['openorder'];
            if($this->isOpening($merchandiseList[$key]['orderbegin'], $merchandiseList[$key]['orderend']))
            {
                $isopen = "1";
            }else
            {
                $isopen = "0";
            }
            $merchandiseList[$key]['isopen'] = $isopen; 
        }

        $this->output($merchandiseList);

    }

    public function searchBySchoolIdAction()
    {
        list($keyword, $schoolId, $limit, $offset, $isPartner) = $this->getInput(array('keyword', 'schoolId', 'limit', 'offset','ispartner'), 'get');
        $result = $this->_getSearchDs()->searchShopBySchoolId($keyword, $schoolId, $limit, $offset, $isPartner);

        foreach($result as $key =>$item)
        {
            if(empty($item['imageurl']))
            {
                //set default image
                $result[$key]['imageurl'] =  Wekit::C('site', 'info.url')."/src/extensions/4tschool/uploaded_images/default/sdefault.jpg";
            }
            else
                $result[$key]['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool'.str_replace('\\', '/', $item['imageurl']);
        }
        $this->output($result);
    }

    public function searchByAreaIdAction()
    {
        list($keyword, $aid, $limit, $offset) = $this->getInput(array('keyword', 'aid', 'limit', 'offset'), 'get');
        $result = $this->_getSearchDs()->searchShopByAreaId($keyword, $aid, $limit, $offset);
        foreach($result as $key =>$item)
        {
            if(empty($item['imageurl']))
            {
                //set default image
                $result[$key]['imageurl'] =  Wekit::C('site', 'info.url')."/src/extensions/4tschool/uploaded_images/default/sdefault.jpg";
            }
            else
                $result[$key]['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool'.str_replace('\\', '/', $item['imageurl']);
        }
        $this->output($result);
    }

    public function countPhoneNumberViewedAction(){
        list($shopid, $uid) = $this->getInput(array('shopid','uid'), 'get');
        $r=0;
        if (empty($shopid)) {
            $this->output($r);
        }

        $shop = $this->_getShopDs()->getByShopId($shopid);

        if (empty($shop)) {
            $this->output($r);
        }

        $ip=$_SERVER["REMOTE_ADDR"];

        Wind::import('EXT:4tschool.service.shop.dm.App_ShopPhone_Dm');

        $dm=new App_ShopPhone_Dm();
        $dm->setShopId($shopid)
            ->setUID($uid)
            ->setClientIP($ip);

        $r=$this->_getShopDs()->addShopPhoneChecked($dm);
        $this->output($r);
    }

    //商店推荐
    public function getPromotionalShopBySchoolIdAction()
    {
        $schoolId = $this->getInput('schoolId', get);

        //推荐商家
        $schoolInfo = $this->_getSchoolDS()->getSchoolExtra($schoolId);
        $promotionalShopList = $this->_getPromotionalmanageDs()->getPromotionalShops($schoolId);
        $newPromotionalShopList = array();
        foreach ($promotionalShopList as $key => $value) {
            if (empty($promotionalShopList[$key]['imageurl'])) {
                //set default image
                $promotionalShopList[$key]['imageurl'] = Wekit::C('site', 'info.url') .'/src/extensions/4tschool'. "/uploaded_images/default/sdefault.jpg";
            } else {
                $promotionalShopList[$key]['imageurl'] = Wekit::C('site', 'info.url') .'/src/extensions/4tschool'.str_replace('\\', '/', $value['imageurl']);
            }
            if($this->isOpening($promotionalShopList[$key]['orderbegin'], $promotionalShopList[$key]['orderend']))
            {
                $isopen = "1";
            }else
            {
                $isopen = "0";
            }
            $promotionalShopList[$key]['isopen'] = $isopen;
            $promotionalShopList[$key]['schoolopenorder'] = $schoolInfo[0]['openorder']; 
        }
        foreach ($promotionalShopList as $key => $value) 
        {
            if($promotionalShopList[$key]['isopen'])
            {
                array_push($newPromotionalShopList, $value);
            }
        }
        
        $this->output($promotionalShopList);

    }

    public function changeShopStatusAction()
    {   
        date_default_timezone_set('PRC');
        
        list($status, $userid) = $this->getInput(array('status', 
                                                       'userid'), 'get');
        
        $result = $this->_getShopDs()->updateIsOpenField($status, 
                                                         $userid);
        $shopMsgList = $this->_getShopDs()->getShopPrintHasterminal($userid);
        
        if(!empty($result))
        {
            $currentime = date('Y-m-d H:i:s');
            $dm = new App_Shopstatusrecord_Dm();
            $dm->setShopId($shopMsgList['id'])
               ->setUserId($userid)
               ->setActionTime($currentime)
               ->setActionStatus($status);
            $this->_getShopstatusrecordDs()->add($dm);
        }

        $this->output($result);
    }

    public function getShopPrintHasterminalAction()
    {
        $userid = $this->getInput('userid', 'get');
        $result = $this->_getShopDs()->getShopPrintHasterminal($userid);
        $this->output($result);
    }

    public function getShopCurrentStatusAction()
    {
        $idList = $this->getInput('idList', 'get');
        $result = $this->_getShopDs()->getShopsByIdList($idList);
        $this->output($result);
    }

    private function isOpening($startTime, $endTime)
    {
        date_default_timezone_set(PRC);
        $cur = date('H:i:s');
        if (strtotime($startTime) <= strtotime($cur) && strtotime($cur) <= strtotime($endTime)) {
            return true;
        }
        return false;
    }    

    /**
     * @return App_Shop
     */
    private function _getShopDs()
    {
        return Wekit::load('EXT:4tschool.service.shop.App_Shop');
    }

    private function _get4TSchoolDS()
    {
        return Wekit::load('EXT:4tschool.service.school.App_School');
    }

    /**
     * @return App_Search
     */
    private function _getSearchDs()
    {
        return Wekit::load('EXT:4tschool.service.searches.App_Search');
    }

    /**
     * @return App_Merchandise
     */
    private function _getMerchandiseDs()
    {
        return Wekit::load('EXT:4tschool.service.merchandise.App_Merchandise');
    }

    /**
     * @return App_School
     */
    private function _getSchoolDS()
    {
        return Wekit::load('EXT:4tschool.service.school.App_School');
    }

    /**
     * @return App_Promotionalmanage
     */
    private function _getPromotionalmanageDs()
    {
        return Wekit::load('EXT:4tschool.service.promotionalmanage.App_Promotionalmanage');
    }

    /**
     * @return App_Shopstatusrecord
     */
    private function _getShopstatusrecordDs()
    {
        return Wekit::load('EXT:4tschool.service.shopstatusrecord.App_Shopstatusrecord');
    }

}

?>