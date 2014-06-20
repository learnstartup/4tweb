<?php

Wind::import('EXT:4tschool.controller.T4BaseNotLoginController');

/**
 */
class IndexController extends T4BaseNotLoginController
{

    public function beforeAction($handlerAdapter)
    {
        parent::beforeAction($handlerAdapter);
    }


    public function run()
    {
        $schoolId = $this->getCurrentSchoolId();

        $this->getWebStatus($schoolId);

        $newOrders = $this->_getMyOrderDS()->getLatestOrderTxt(5);
        $this->setOutput($newOrders, "newOrders");

        //set navigation tree
        $this->setNavigationTree();

        //set combo
        $this->setComboTree();

        //set boutique
        $this->setBoutique();

        //set combo
        $this->setCombo();

        //set hot merchandises
        $this->setHotMerchandises($schoolId);

        //set my favorite shops
        $userid = $this->loginUser->uid;
        $this->setMyFavoriteShops($schoolId, $userid);

        //set promo merchandises
        $this->setPromoMerchandises($schoolId);


        $userInfo = $this->loginUser;
        if(!empty($userInfo->username))
        {
            $username = $userInfo->username;
        }
        else
        {
            $username = '';
        }

        $this->setOutput($username, "username");
        $this->setOutput($userInfo, "loginUser");
        $this->setOutput($userid, "userid");

        //get school extras
        $extras = $this->_getSchoolDS()->getSchoolExtra($schoolId);
        $this->setOutput($extras[0],"schoolextra");

        //set shops
        $shopList = $this->_getShopDs()->getBySchoolId($schoolId);

        $promotionalShopList = $this->_getPromotionalmanageDs()->getPromotionalShops($schoolId);

        $promotionalShopIdList = array();
        $newPromotionalList = array();
        $unNewPromotionalList = array();
        foreach ($promotionalShopList as $key => $value) 
        {
            array_push($promotionalShopIdList, $value['shopid']);
        }

        foreach ($shopList as $key => $value) 
        {
            if (empty($shopList[$key]['imageurl'])) 
            {
                $shopList[$key]['imageurl'] = Wekit::C('site', 'info.url') .'/src/extensions/4tschool'. "/uploaded_images/default/sdefault.jpg";
            } 
            else 
            {
                $shopList[$key]['imageurl'] = Wekit::C('site', 'info.url') .'/src/extensions/4tschool'. str_replace('\\', '/', $value['imageurl']);
            }

            $shopList[$key]['isopen'] = $this->isOpening($shopList[$key]['orderbegin'], $shopList[$key]['orderend']);
            

            if(in_array($value['id'], $promotionalShopIdList))
            {
                array_push($newPromotionalList, $shopList[$key]);
            }
            else
            {
                array_push($unNewPromotionalList, $shopList[$key]);
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

        $this->setOutput($result, 'shopList');

        //set merchandises, limit should be get form config
        $merchandiseList = $this->_getMerchandiseDs()->getHotMerchandises($schoolId, 15, 0);
        foreach ($merchandiseList as $key => $value) {
            if (empty($merchandiseList[$key]['imageurl'])) {
                $merchandiseList[$key]['imageurl'] = Wekit::C('site', 'info.url') .'/src/extensions/4tschool'. "/uploaded_images/default/sdefault.jpg";
            } else {
                $merchandiseList[$key]['imageurl'] = Wekit::C('site', 'info.url') .'/src/extensions/4tschool'. str_replace('\\', '/', $value['imageurl']);
            }
        }
        $this->setOutput($merchandiseList, 'merchandiseList');

        $myCredit = $this->_getMyMoneyDS()->getMyMoney($userid);
        $this->setOutput($myCredit,"myCredit");

        $countNoComment = $this->_getShopCommentDS()->getCountOfMyUnComment($schoolId, $userid);
        $this->setOutput($countNoComment,"countNoComment");

        $countComment = $this->_getShopCommentDS()->getCountOfMyComment($schoolId,$userid);
        $this->setOutput($countComment,"countComment");

        $countMoney = $this->_getMyOrderDS()->countMoney($schoolId, $userid);
        $this->setOutput($countMoney,"countMoney");

        //set announce list info
        $eachContentInfo = $this->_getPwAnnounceDs()->getAnnounceOrderByVieworder($schoolId, 5, 0);

        $this->setOutput($eachContentInfo,'eachContentInfo');
        
        //$this->setOutput($mostOrderedPPl,'mostOrderedPPl');
        $this->setOutput($schoolId,'schoolId');

        $this->setOutput($addheaderlong,'addheaderlong');

    }

    private function abslength($str)
    {
        if(empty($str)){
            return 0;
        }
        if(function_exists('mb_strlen')){
            return mb_strlen($str,'utf-8');
        }
        else {
            preg_match_all("/./u", $str, $ar);
            return count($ar[0]);
        }
    }

    private function setNavigationTree(){
        $sysTagTree=$this->_getSysTagTreeDs()->getSysTagTreeByType('HOME');
        $sysTagTree=$sysTagTree[0]['json'];
        $this->setOutput(json_decode($sysTagTree),"nav");
        // echo "<pre>";
        // print_r($sysTagTree);
        // echo "</pre>";
    }

    private function setComboTree(){
        $comboTree=$this->_getSysTagTreeDs()->getSysTagTreeByType('COMBO');
        $comboTree=json_decode($comboTree[0]['json']);

        foreach ($comboTree as $ckey => $combo) {
            $children=array();

            $tid = $combo->a_attr->id;
            $merchandiseList=$this->_getMerchandiseDs()->getMerchandiseBySysTagIds($tid,$this->getCurrentSchoolId());
            foreach ($merchandiseList as $mkey => $mer) {
                    $mer['imageurl']= Wekit::C('site', 'info.url') .'/src/extensions/4tschool'. str_replace('\\', '/', $mer['imageurl']);
                    $children[]=$mer;
                }
            $comboTree[$ckey]->children=$children;
        }
        $this->setOutput($comboTree,"combo");

         // echo "<pre>";
         // print_r($comboTree);
         // echo "</pre>";
    }    

    private function setBoutique (){    
        $schoolId = $this->getCurrentSchoolId();
        $boutiqueList=$this->_getBoutiqueDs()->getCurrentSchoolBoutiquesByType($schoolId,'B');
        foreach ($boutiqueList as $key => $value) {
                $boutiqueList[$key]['imgurl'] = Wekit::C('site', 'info.url') .'/src/extensions/4tschool'. str_replace('\\', '/', $value['imgurl']);
        }        
        $this->setOutput($boutiqueList,"boutiqueList");        
        // var_export($boutiqueList);
        
    }

    private function setHotMerchandises($schoolId)
    {
        $hotMerchandiseList = $this->_getMerchandiseDs()->getHotMerchandises($schoolId, 15, 0);
        $this->setOutput($hotMerchandiseList, "hotMerchandiseList");
    }

    //Ajax function
    public function getCurrentSchoolShopsAction (){
        // $isPartner=$this->getInput('ispartner','post');
        $schoolId = $this->getCurrentSchoolId();
        // if ($isPartner) {
        $ismerchandise = 'ismerchandise';
        $shopList = $this->_getShopDs()->getBySchoolId($schoolId, '', '', '', $ismerchandise);
        // }else{
            // $shopList = $this->_getShopDs()->getUnPartnerShopsBySchoolId($schoolId);
        // }

        $shopDeliveryTime = $this->_getShopDs()->getShopDeliveryTimeByShopIds($shopList, $schoolId);
        
        foreach ($shopList as $keyval => &$eachshop) {

            $eachshop['deliverytime'] = array();

            foreach ($shopDeliveryTime as $key => $v) {
                if($v['shopid'] == $eachshop['id'])
                {
                    array_push($eachshop['deliverytime'], $v);
                }
            }
        }
        
        foreach ($shopList as $key => $value) {
            if (empty($shopList[$key]['imageurl'])) {
                //set default image
                $shopList[$key]['imageurl'] = Wekit::C('site', 'info.url') .'/src/extensions/4tschool'. "/uploaded_images/default/sdefault.jpg";
            } else {
                $shopList[$key]['imageurl'] = Wekit::C('site', 'info.url') .'/src/extensions/4tschool'. str_replace('\\', '/', $value['imageurl']);
            }
            $shopList[$key]['isopen'] = $this->isOpening($shopList[$key]['orderbegin'], $shopList[$key]['orderend']);
        }    

        print_r(json_encode($shopList));

        die;
    }

    private function setMyFavoriteShops($schoolId, $userid)
    {
        $favoriteList = $this->_getMyFavoriteDS()->getMyFavoriteShops($schoolId, $userid);

        //get top 5
        $favoriteList = array_slice($favoriteList, 0, 5);

        foreach ($favoriteList as $key => &$item) {
            if (empty($item['imageurl'])) {
                //set default image
                $item['imageurl'] = Wekit::C('site', 'info.url') .'/src/extensions/4tschool'. "/uploaded_images/default/sdefault.jpg";
            } else {
                $item['imageurl'] = Wekit::C('site', 'info.url') .'/src/extensions/4tschool'. str_replace('\\', '/', $item['imageurl']);
            }
        }
        $favCount = count($favoriteList);
        $this->setOutput($favCount, "favCount");

        if ($favCount < 5) {
            $diff = 5 - $favCount;
            for ($i = 0; $i < $diff; $i++) {
                $favoriteList[$favCount + $i] = "";
            }
        }
        $this->setOutput($favoriteList, "favoriteList");
    }

    private function setPromoMerchandises($schoolId)
    {
        $promoMerchandiseList=$this->_getMerchandiseDs()->getPromoMerchandisesBySchoolId($schoolId,'discount');
        $this->setOutput($promoMerchandiseList,'promoMerchandiseList');
    }

    private function isOpening($startTime, $endTime)
    {
        date_default_timezone_set("PRC");
        $cur = date('H:i:s');
        if (strtotime($startTime) <= strtotime($cur) && strtotime($cur) <= strtotime($endTime)) {
            return true;
        }
        return false;
    }
    
    private function getWebStatus($schoolId)
    {
        $webstatus = $this->_getSchoolDS()->getWebSiteStatus($schoolId);
            
        if(!$webstatus)
        {   
            $this->setOutput($webstatus, 'webstatus');
            $this->setTemplate("ifopenwebsite");
        }
    }

    /**
     * @return App_SysTag_Tree
     */
    private function _getSysTagTreeDs() {
        return Wekit::load('EXT:4tschool.service.tag.App_SysTag_Tree');
    }       

    /**
     * @return App_SchoolArea
     */
    private function _getSchoolAreaDS()
    {
        return Wekit::load('EXT:4tschool.service.schoolarea.App_SchoolArea');
    }

    /**
     * @return App_School
     */
    private function _getSchoolDS()
    {
        return Wekit::load('EXT:4tschool.service.school.App_School');
    }

    /**
     * @return App_MyOrder
     */
    private function _getMyOrderDS()
    {
        return Wekit::load('EXT:4tschool.service.myorder.App_MyOrder');
    }

    /**
     * @return App_Shop
     */
    private function _getShopDs()
    {
        return Wekit::load('EXT:4tschool.service.shop.App_Shop');
    }

    /**
     * @return App_Merchandise
     */
    private function _getMerchandiseDs()
    {
        return Wekit::load('EXT:4tschool.service.merchandise.App_Merchandise');
    }

    /**
     * @return  App_MyFavorite
     */
    private function _getMyFavoriteDS()
    {
        return Wekit::load('EXT:4tschool.service.myfavorite.App_MyFavorite');
    }

    /**
     * @return App_Boutique
     */
    private function _getBoutiqueDs()
    {
        return Wekit::load('EXT:4tschool.service.boutique.App_Boutique');
    } 

    /**
     * 加载PwAnnounce Ds 服务
     *
     * @return PwAnnounce
     */
    private function _getPwAnnounceDs() {
        return Wekit::load('announce.PwAnnounce');
    }

    /**
     * @return App_Promotionalmanage
     */
    private function _getPromotionalmanageDs()
    {
        return Wekit::load('EXT:4tschool.service.promotionalmanage.App_Promotionalmanage');
    }

    /**
     * @return App_MyMoney
     */
    private function _getMyMoneyDS()
    {
        return Wekit::load('EXT:4tschool.service.mymoney.App_MyMoney');
    }

    private function _getShopCommentDS()
    {
        return Wekit::load('EXT:4tschool.service.mercomment.App_MerComment');
    }

}