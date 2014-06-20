<?php
Wind::import('APPS:windid.api.OpenBaseController');
/**
 * the last known user to change this file in the repository  <$LastChangedBy: Peter.yan $>
 * @author $Author: Peter.yan $ 215169718@qq.com
 * @copyright ?2003-2103 fenxiangyo.com
 * @license http://www.fenxiangyo.com
 * @package
 */
class OpenMerchandiseController extends OpenBaseController
{

    public function getByIdAction()
    {
        $merchandiseId = $this->getInput('merchandiseId', 'get');
        $result = $this->_getMerchandiseDs()->getMerchandiseById($merchandiseId);

        if(empty($result['imageurl']))
                $result['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool/uploaded_images/default/mdefault.jpg';
            else
                $result['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool'.str_replace('\\', '/', $result['imageurl']);

        $this->output($result);
    }

    public function getByShopIdAction()
    {
        $shopId = $this->getInput('shopId', 'get');
        $result = $this->_getMerchandiseDs()->getActiveMerchandiseByShopId($shopId);

        foreach ($result as $key => &$item) {
            if(empty($item['imageurl']))
                $item['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool/uploaded_images/default/mdefault.jpg';
            else
                $item['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool'.str_replace('\\', '/', $item['imageurl']);
        }

        $this->output($result);
    }

    public function getMostHotAction()
    {
        list($schoolId, $limit, $offset) = $this->getInput(array('schoolId', 'limit', 'offset'), 'get');
        $result = $this->_getMerchandiseDs()->getHotMerchandises($schoolId, $limit, $offset);
        foreach ($result as $key => &$item) {
            if(empty($item['imageurl']))
                $item['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool/uploaded_images/default/mdefault.jpg';
            else
                $item['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool'.str_replace('\\', '/', $item['imageurl']);
        }

        $this->output($result);
    }

    public function getPromoMerchandiseBySchoolIdAction()
    {
        list($schoolId, $promoName, $orderBy,$sort, $LIMIT, $OFFSET)=$this->getInput(array('schoolId','promoName', 'orderby','sort', 'limit', 'offset'),'get');
        $result=$this->_getMerchandiseDs()->getPromoMerchandisesBySchoolId($schoolId,$promoName,$orderBy,$sort, $LIMIT, $OFFSET);
        foreach ($result as $key => &$item) {
            if(empty($item['imageurl']))
                $item['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool/uploaded_images/default/mdefault.jpg';
            else
                $item['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool'.str_replace('\\', '/', $item['imageurl']);
        }

        $this->output($result);
    }

    public function searchByShopIdAction()
    {
        list($keyword, $shopId, $orderBy, $sort,$limit, $offset) = $this->getInput(array('keyword', 'shopId', 'orderBy', 'sort', 'limit', 'offset'), 'get');
        $result = $this->_getSearchDs()->searchMerchandiseByShopId($keyword, $shopId, $orderBy, $sort, $limit, $offset);

        foreach ($result as $key => &$item) {
            if(empty($item['imageurl']))
                $item['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool/uploaded_images/default/mdefault.jpg';
            else
                $item['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool'.str_replace('\\', '/', $item['imageurl']);
        }

        $this->output($result);
    }

    public function weixinMerchandiseByShopIdAction()
    {
        list($shopId) = $this->getInput(array('shopId'), 'get');
        $result = $this->_getSearchDs()->weixinMerchandiseByShopId($shopId);

        foreach ($result as $key => &$item) {
            if(empty($item['imageurl']))
                $item['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool/uploaded_images/default/mdefault.jpg';
            else
                $item['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool'.str_replace('\\', '/', $item['imageurl']);
        }

        $this->output($result);
    }

    public function getStarMerchandiseBySchoolIdAction (){
        list($schoolId, $promoName)=$this->getInput('schoolId','get');
        $result=$this->_getMerchandiseDs()->getStarMerchandiseBySchoolId($schoolId);
        foreach ($result as $key => &$item) {
            if(empty($item['imageurl']))
                $item['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool/uploaded_images/default/mdefault.jpg';
            else
                $item['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool'.str_replace('\\', '/', $item['imageurl']);
        }

        $this->output($result);
    }

    public function searchBySchoolIdAction()
    {
        list($keyword, 
             $aid, 
             $baseprice, 
             $ifdeliverfee, 
             $type, 
             $tagid, 
             $shopid, 
             $schoolid, 
             $orderby, 
             $sort, 
             $limit, 
             $offset) = $this->getInput(array('keyword', 
                                              'aid', 
                                              'baseprice', 
                                              'ifdeliverfee', 
                                              'type', 
                                              'tagid', 
                                              'shopid', 
                                              'schoolid', 
                                              'orderby',
                                              'sort', 
                                              'limit', 
                                              'offset'), 'get');
        
        $promotionalShopList = $this->_getPromotionalmanageDs()->getPromotionalShops($schoolid);
        $copyPromotionalShopList = $promotionalShopList;

        $ifdeliver = 'y';
        $searchArgs = array('keyword' => $keyword, 
                            'ifdeliver' => $ifdeliver, 
                            'baseprice' => $baseprice, 
                            'ifdeliverfee' => $ifdeliverfee, 
                            'type' => $type, 
                            'tagid' => $tagid, 
                            'shopid' => $shopid, 
                            'orderby' => $orderby, 
                            'sort' => $sort);
        $result = $this->_getSearchDs()->searchMerchandisesByArgs($schoolid,$searchArgs,$limit,$offset);
        $schoolExtra = $this->_get4TSchoolDS()->getSchoolExtra($schoolid);


        $promotionalShopIdList = array();
        $newPromotionalList = array();
        $unNewPromotionalList = array();
        foreach ($copyPromotionalShopList as $key => $value) 
        {
            array_push($promotionalShopIdList, $value['shopid']);
        }

        foreach ($result as $key => &$item) {
            if(empty($item['imageurl']))
                $item['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool/uploaded_images/default/mdefault.jpg';
            else
                $item['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool'.str_replace('\\', '/', $item['imageurl']);
            $isopen = $this->isOpening($item['orderbegin'], $item['orderend']);
            if($isopen){
                $item['isopen'] = '1';
            }else{
                $item['isopen'] = '0';
            }
            $item['schoolopenorder'] = $schoolExtra[0]['openorder'];

            if(in_array($item['id'], $promotionalShopIdList))
            {
                array_push($newPromotionalList, $result[$key]);
            }
            else
            {
                array_push($unNewPromotionalList, $result[$key]);
            }
        }

        $result = array_merge($newPromotionalList, $unNewPromotionalList);
        
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

    private function isOpening($startTime, $endTime)
    {
        date_default_timezone_set(PRC);
        $cur = date('H:i:s');
        if (strtotime($startTime) <= strtotime($cur) && strtotime($cur) <= strtotime($endTime)) {
            return true;
        }
        return false;
    }

    public function searchByAreaIdAction()
    {
        list($keyword, $aid, $orderBy, $limit, $offset) = $this->getInput(array('keyword', 'aid', 'orderBy', 'limit', 'offset'), 'get');
        $result = $this->_getSearchDs()->searchMerchandiseByAreaId($keyword, $aid, $orderBy, $limit, $offset);
        foreach ($result as $key => &$item) {
            if(empty($item['imageurl']))
                $item['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool/uploaded_images/default/mdefault.jpg';
            else
                $item['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool'.str_replace('\\', '/', $item['imageurl']);
        }
        
        $this->output($result);
    }

    //get Ë³´øÉÌÆ·
    public function getshundaiMerchandiseAction()
    {
        $incidentallyMerchandiseList = $this->_getMerchandiseDs()->getIncidentallyMerchandises($this->getIncidentallyShopId());
        foreach($incidentallyMerchandiseList as $key => &$item)
        {
            if(empty($item['imageurl']))
            {
                //set default image
                $item['imageurl'] =  Wekit::C('site', 'info.url')."/src/extensions/4tschool/uploaded_images/default/mdefault.jpg";
            }
            else
                $item['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool'.str_replace('\\', '/', $item['imageurl']);
        }

        $this->output($incidentallyMerchandiseList);
    }

    public function getBoutiquesBySchoolIdAction(){
        list($schoolId, $isActive) = $this->getInput(array('schoolid','isactive'), 'get');

        $result=$this->_getBoutiqueDs()->getBoutiquesBySchoolId($schoolId,$isActive);

        $this->output($result);
    }   

    public function getMerchandiseBySysTagIdsAction (){
        LIST($ids, $schoolId, $orderBy,$sort, $LIMIT, $OFFSET) = $this->getInput(array('ids', 'schoolId', 'orderBy','sort', 'limit', 'offset'), 'get');
        $result = $this->_getMerchandiseDs()->getMerchandiseBySysTagIds($ids, $schoolId, $orderBy,$sort, $LIMIT, $OFFSET);
        $schoolExtra = $this->_get4TSchoolDS()->getSchoolExtra($schoolId);

        $promotionalShopList = $this->_getPromotionalmanageDs()->getPromotionalShops($schoolId);
        $copyPromotionalShopList = $promotionalShopList;

        $promotionalShopIdList = array();
        $newPromotionalList = array();
        $unNewPromotionalList = array();
        foreach ($copyPromotionalShopList as $key => $value) 
        {
            array_push($promotionalShopIdList, $value['shopid']);
        }

        foreach ($result as $key => &$item) {
            if(empty($item['imageurl']))
                $item['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool/uploaded_images/default/mdefault.jpg';
            else
                $item['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool'.str_replace('\\', '/', $item['imageurl']);
            $isopen = $this->isOpening($item['orderbegin'], $item['orderend']);
            if($isopen){
                $item['isopen'] = '1';
            }else{
                $item['isopen'] = '0';
            }
            $item['schoolopenorder'] = $schoolExtra[0]['openorder'];

            if(in_array($item['id'], $promotionalShopIdList))
            {
                array_push($newPromotionalList, $result[$key]);
            }
            else
            {
                array_push($unNewPromotionalList, $result[$key]);
            }
        }

        $result = array_merge($newPromotionalList, $unNewPromotionalList);
        
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

    public function batchUpdateMerchandiseStockoutStatusAction(){
        $itemStatus = $this->getInput("itemStatus");

        $itemStatus = urldecode($itemStatus);
        $itemStatusArray = (array)json_decode($itemStatus);

        $itemStatusArray = (array)$itemStatusArray[0];

        $oos=0; $aog=0;
        //0 means OOS(out of stock)
        if (!empty($itemStatusArray['oos'])) {
            $oos=$this->_getMerchandiseDs()->batchUpdateMerchandiseStockoutStatus($itemStatusArray['oos'],0);
        }  

        //1 means AOG(arrival of goods)
        if (!empty($itemStatusArray['aog'])) {
            $aog=$this->_getMerchandiseDs()->batchUpdateMerchandiseStockoutStatus($itemStatusArray['aog'],1);
        }        

        $result = ($oos >= 0 && $aog >= 0);
        if($result){
            $this->output(1);    
        }else{
            $this->output(0);
        }
        
    }

    public function updateCollectCountByMerchandiseIdAction()
    {
        $mid = $this->getInput('mid','get');
        $status = $this->_getMerchandiseDs()->updateCollectCountByMerchandiseId($mid);
        return $this->output($status);
    }

    public function searchMerchandiseCountByStringAction(){
        list($keyword, 
             $aid, 
             $baseprice, 
             $ifdeliverfee, 
             $type, 
             $tagid, 
             $shopid, 
             $schoolid, 
             $limit, 
             $offset) = $this->getInput(array('keyword', 
                                                      'aid', 
                                                      'baseprice', 
                                                      'ifdeliverfee', 
                                                      'type', 
                                                      'tagid', 
                                                      'shopid', 
                                                      'schoolid', 
                                                      'limit', 
                                                      'offset'), 'get');
        $ifdeliver = 'y';
        $searchArgs = array('keyword' => $keyword, 
                            'ifdeliver' => $ifdeliver, 
                            'baseprice' => $baseprice, 
                            'ifdeliverfee' => $ifdeliverfee, 
                            'type' => $type, 
                            'tagid' => $tagid, 
                            'shopid' => $shopid);
        $count = $this->_getSearchDs()->countMerchandisesByArgs($schoolid,$searchArgs,$limit,$offset);
        $this->output($count);
    }

    public function addMyFavoriteMAction()
    {
        $shopId = $this->getInput('shopId');
        $mId = $this->getInput('mId');

        $mId = empty($mId)?0:$mId;
        $userId = $this->getInput("userid");
        $insert_id = $this->_getMyFavoriteDS()->addMyFavorite($userId, $shopId, $mId);
        $result = $insert_id > 0;
        print_r($result);
        die;
    }

    public function deleteMyFavoriteMAction()
    {
        //choosen item
        $mid = $this->getInput("mid");
        $userid = $this->getInput("userid");

        $returnData = array(
            "success"   => true,
            "data"  => "删除成功，页面将自动刷新"
            );

        $this->_getMyFavoriteDS()->deleteFavoriteM($userid,$mid);
        print_r(json_encode($returnData));
        die;
    }

    public function getFavoriteMByShopIdAction() 
    {
        list($userid, 
             $schoolid, 
             $limit, 
             $offset) = $this->getInput(array('userid', 
                                              'schoolid',
                                              'limit', 
                                              'offset'), 'get');
        $schoolExtra = $this->_get4TSchoolDS()->getSchoolExtra($schoolid);     
        
        $shopItems = $this->_getMyFavoriteDS()->getOpenMyFavoriteItemByShop($userid, 
                                                                            $limit, 
                                                                            $offset);
        foreach ($shopItems as $key => $item) 
        {
            if(empty($shopItems[$key]['imageurl']))
            {
                $shopItems[$key]['imageurl'] =  Wekit::C('site', 'info.url')."/src/extensions/4tschool/uploaded_images/default/mdefault.jpg";
            }
            else
            {
                $shopItems[$key]['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool'.str_replace('\\', '/', $item['imageurl']);
            }
            $isopen = $this->isOpening($item[$key]['orderbegin'], $item[$key]['orderend']);
            if($isopen){
                $shopItems[$key]['isopen'] = '1';
            }else{
                $shopItems[$key]['isopen'] = '0';
            }
            $shopItems[$key]['schoolopenorder'] = $schoolExtra[0]['openorder'];
                
        }

        $this->output($shopItems);

    }

    public function getUserFavoriteMIdAction()
    {
        $userid = $this->getInput('userid');

        $mIdList = $this->_getMyFavoriteDS()->getMyFavoriteMIdByShop($userid);

        $this->output($mIdList);
    }

    public function getOneMerMessageAction()
    {
        $mid = $this->getInput('mid');
        $schoolid = $this->getInput('schoolid');
        $mInfo = $this->_getMerchandiseDs()->getMerchandiseById($mid);
        $schoolExtra = $this->_get4TSchoolDS()->getSchoolExtra($schoolid); 

        if(empty($mInfo['imageurl']))
        {
            //set default image
            $mInfo['imageurl'] =  Wekit::C('site', 'info.url')."/src/extensions/4tschool/uploaded_images/default/mdefault.jpg";
        }
        else
            $mInfo['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool'.str_replace('\\', '/', $mInfo['imageurl']);
        $isopen = $this->isOpening($mInfo['orderbegin'], $mInfo['orderend']);
        if($isopen){
            $mInfo['isopen'] = '1';
        }else{
            $mInfo['isopen'] = '0';
        }
        $mInfo['schoolopenorder'] = $schoolExtra[0]['openorder'];

        $this->output($mInfo,"mInfo");
    }

    /**
     * @return App_MyFavorite
     */
    private function _getMyFavoriteDS()
    {
        return Wekit::load('EXT:4tschool.service.myfavorite.App_MyFavorite');
    }

    /**
     * @return App_Merchandise
     */
    private function _getMerchandiseDs()
    {
        return Wekit::load('EXT:4tschool.service.merchandise.App_Merchandise');
    }

    /**
     * @return App_Search
     */
    private function _getSearchDs()
    {
        return Wekit::load('EXT:4tschool.service.searches.App_Search');
    }

    /**
     * @return App_Boutique
     */
    private function _getBoutiqueDs()
    {
        return Wekit::load('EXT:4tschool.service.boutique.App_Boutique');
    } 

    /**
     * @return App_Shop
     */
    private function _getShopDS()
    {
        return Wekit::load('EXT:4tschool.service.shop.App_Shop');
    }

    private function _get4TSchoolDS()
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

}

?>