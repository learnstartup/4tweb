<?php
Wind::import('EXT:4tschool.controller.T4BaseNotLoginController');
Wind::import('EXT:4tschool.service.shop.dm.App_ShopPhone_Dm');
class ShopDetailsController extends T4BaseNotLoginController
{
    private $pageNumber = 10;
    private $_user_rate=0.4;
    private $_tax_rate=0.07;
    private $_cur_shop;    

    public function run()
    {
        $schoolId = $this->getCurrentSchoolId();
        
        $this->getWebStatus($schoolId);
        
        list($shopid, $mid) = $this->getInput(array('shopid', 'mid'), 'request');

        //judge if the shop already marked by current user
        $userId = $this->loginUser->uid;
        $this->setOutput($userId, 'userId');
        $isFavorite = $this->_getMyFavoriteDS()->checkIfExists($userId, $shopid, 0);
        $this->setOutput($isFavorite, 'isFavorite');

        //推荐商家
        $schoolInfo = $this->_getSchoolDS()->getSchoolExtra($schoolId);
        $this->setOutput($schoolInfo[0],'schoolInfo');

        $promotionalShopList = $this->_getPromotionalmanageDs()->getPromotionalShops($schoolId);
        foreach ($promotionalShopList as $key => $value) {
            if (empty($promotionalShopList[$key]['imageurl'])) {
                //set default image
                $promotionalShopList[$key]['imageurl'] = Wekit::C('site', 'info.url') .'/src/extensions/4tschool'. "/uploaded_images/default/sdefault.jpg";
            } else {
                $promotionalShopList[$key]['imageurl'] = Wekit::C('site', 'info.url') .'/src/extensions/4tschool'.str_replace('\\', '/', $value['imageurl']);
            }
            $promotionalShopList[$key]['isopen'] = $this->isOpening($promotionalShopList[$key]['orderbegin'], $promotionalShopList[$key]['orderend']);
        }
        $this->setOutput($promotionalShopList, 'promotionalShopList');

        $shop = $this->_getShopDs()->getByShopId($shopid);

        $this->_cur_shop=$shop;

        $schoolareaList = $this->setAreaFilterWidgetData();
        
        foreach ($schoolareaList as $key => $value) 
        {
            if($shop['areaid'] == $value['id'])
            {
                $schoolName = $value['name'];
                $schoolAreaName = $value['areaname'];
                break;
            }
        }

        //check if shop is active or not
        if(empty($shop)
            || ($shop['isactive'] == 0))
            {
                $this->setTemplate("shopdetails_notexist");
                return;
            }

        $this->displayShoppingCart($shopid,$shop['packingprice'] + $shop['deliveryprice']);

        $defaultSelected = null;
        $merchandiseList = $this->_getMerchandiseDs()->getActiveMerchandiseByShopId($shopid);
        
        foreach ($merchandiseList as $key => $value) {
            if (empty($merchandiseList[$key]['imageurl'])) {
                $merchandiseList[$key]['imageurl'] = $this->getDomain() . "/uploaded_images/default/sdefault.jpg";
            } else {
                $merchandiseList[$key]['imageurl'] = $this->getDomain() . str_replace('\\', '/', $value['imageurl']);
            }
            $merchandiseList[$key]['isopen'] = $this->isOpening($merchandiseList[$key]['orderbegin'], $merchandiseList[$key]['orderend']);
            $tagList[$value['tagid']] = $value['tagname'];

            if ($mid && $mid == $value['id']) {
                $defaultSelected = $value['tagname'];
            }

            $merchandiseList[$key]['dmoney']=0;
            if ($shop['ifrebate']) {
                $merchandiseList[$key]['dmoney']=$this->calculateMerchandiseDMoneyByPrice($value['price']);
            }
        }

        $tagList = array_unique($tagList);
        krsort($tagList);

        if ($defaultSelected == null) {
            $defaultSelected = reset($tagList);
        }
        
        //output this var to judge which tag tab should be shown
        $this->setOutput($defaultSelected, 'defaultSelected');

        $this->setAnchor($mid);

        //set hot merchandises
        $hotMerchandiseList=$this->_getMerchandiseDs()->getHotMerchandisesByShopId($shopid);
        
        foreach($hotMerchandiseList as $key => &$item)
        {
            if(empty($item['imageurl']))
            {
                //set default image
                $item['imageurl'] =  Wekit::C('site', 'info.url')."/src/extensions/4tschool/uploaded_images/default/mdefault.jpg";
            }
            else
                $item['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool'.str_replace('\\', '/', $item['imageurl']);

            $item['isopen'] = $this->isOpening($mInfo['orderbegin'], $item['orderend']);
            $item['substrname'] = mb_substr($item['name'], 0, 10, 'utf-8');

            $hotMerchandiseList[$key]['dmoney']=0;
            if ($shop['ifrebate']) {
                $hotMerchandiseList[$key]['dmoney']=$this->calculateMerchandiseDMoneyByPrice($item['price']);
            }            
        }
        $this->setOutput($hotMerchandiseList,'hotMerchandiseList');

        //set incidentally merchandise
        $incidentallyMerchandiseList = $this->_getMerchandiseDs()->getIncidentallyMerchandises($this->getIncidentallyShopId());
        $this->setOutput($this->getIncidentallyShopId(), 'IncidentallyShopId');
        $this->setOutput($incidentallyMerchandiseList, 'incidentallyMerchandiseList');

        //set incidentally tag
        $incidentallyTagList = $this->_getTagDs()->getIncidentallyTags($this->getIncidentallyTagId());
        $this->setOutput($incidentallyTagList, 'incidentallyTagList');
        $this->setOutput($mid, 'mid');
        $cartMid = $mid;
        if ($this->addToCart($cartMid)) {
            $this->setOutput($cartMid,'cartMid');
        }
        $this->setOutput($this->getDomain() . $this->getCartRelayPath(), 'BASE_URL');
        $this->setOutput($shop, 'shop');
        $this->setOutput($tagList, 'tagList');
        
        $this->setOutput($merchandiseList, 'merchandiseList');

        //设置是否学校当前状态为可以订餐，如果可以，才能去结算
        $schoolid = $this->getCurrentSchoolId();
        $opening = $this->_getSchoolDS()->isSchoolOpenNow($schoolid);
        $this->setOutput($opening,"opening");

        //get shop's delivery time
        $timeList = $this->_getShopDs()->getShopDeliveryTimeByShopId($shopid);
        $this->setOutput($timeList,'timeList');

        $SEOTitleKeyword = '点餐哟外卖平台 - '.$shop['name'].'点餐, '.$shop['name'].'外卖, '.$shop['name'].'外卖菜单,'.$shop['name'].'网络订餐';

        $this->setOutput($SEOTitleKeyword,'SEOTitle');
        $this->setOutput($SEOTitleKeyword,'SEOKeyword');
        $this->setOutput(1,'addheaderlong');


    }

    //学校订餐开放时间
    public function whenOpenAction()
    {
        $schoolid = $this->getCurrentSchoolId();
        $info = $this->_getSchoolDS()->getSchoolOpenTime($schoolid);
        $this->setOutput($info,'info');

        $opening = $this->_getSchoolDS()->isSchoolOpenNow($schoolid);
        $this->setOutput($opening,"opening");

    }

    private function setAreaFilterWidgetData()
    {
        $schoolId = $this->getCurrentSchoolId();

        $areaList = $this->_getSchoolAreaDs()->getBySchoolid($schoolId);

        $schoolName = $areaList[0]['name'];

        $this->setOutput($schoolName, "schoolName");
        $this->setOutput($areaList, "areaList");

        return $areaList;
    }

    public function myFavoriteAction()
    {
        $shopId = $this->getInput('shopId');
        $mId = $this->getInput('mId');

        $mId = empty($mId)?0:$mId;
        $userId = $this->loginUser->uid;
        $insert_id = $this->_getMyFavoriteDS()->addMyFavorite($userId, $shopId, $mId);
        $result = $insert_id > 0;
        $this->_getMerchandiseDs()->updateCollectCountByMerchandiseId($mId);
        print_r($result);
        die;
    }

    public function appsAction()
    {
        
    }

    public function mdetailAction()
    {
        $shopid = $this->getInput("shopid");
        $mid = $this->getInput("mid");
        $schoolId = $this->getCurrentSchoolId();

        $userId = $this->loginUser->uid;
        $this->setOutput($userId,'userId');

        $isFavorite = $this->_getMyFavoriteDS()->checkIfExists($userId, $shopid, $mid);
        $this->setOutput($isFavorite, 'isFavorite');

        $schoolareaList = $this->setAreaFilterWidgetData();
        $schoolInfo = $this->_getSchoolDS()->getSchoolExtra($schoolId);
        foreach ($schoolareaList as $key => $value) 
        {
            if($shop['areaid'] == $value['id'])
            {
                $schoolName = $value['name'];
                $schoolAreaName = $value['areaname'];
                break;
            }
        }

        //get detail
        $mInfo = $this->_getMerchandiseDs()->getMerchandiseById($mid);
        
        if(empty($mInfo['imageurl']))
        {
            //set default image
            $mInfo['imageurl'] =  Wekit::C('site', 'info.url')."/src/extensions/4tschool/uploaded_images/default/mdefault.jpg";
        }
        else
            $mInfo['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool'.str_replace('\\', '/', $mInfo['imageurl']);
        $mInfo['isopen'] = $this->isOpening($mInfo['orderbegin'], $mInfo['orderend']);
        
        $this->setOutput($mInfo,"mInfo");

        $shop = $this->_getShopDs()->getByShopId($shopid);

        //check if shop is active or not
        if(empty($shop))
        {
                $this->setTemplate("shopdetails_notexist");
                return;
        }

        $this->setOutput($this->getDomain() . $this->getCartRelayPath(), 'BASE_URL');
        $this->setOutput($shop, 'shop');
        $this->setOutput($schoolInfo[0], 'schoolInfo');
        $this->displayShoppingCart($shopid,$shop['packingprice'] + $shop['deliveryprice']);
        $selectedcomment = $this->getInput("selectedcomment", "get");

        if(isset($_POST['submitbox']))
        {
            $comment = $this->getInput("comment","post");
            $tastescore = $this->getInput("tastescoreshow","post");
            $servicescore = $this->getInput("servicescoreshow","post");
            $mid = $this->getInput("mid","get");

            $id = $this->_getShopCommentDS()->addMyComment($this->loginUser->uid, 
                                                           $mid, 
                                                           $orderid, 
                                                           $comment, 
                                                           0, 
                                                           $servicescore, 
                                                           $tastescore);
            $this->_getMyMoneyDS()->updateMyCredit($userId, 1 ,"对菜品评论后转入积分");
            $url = 'http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
            header("Location:".$url);
        }

        $this->setOutput($selectedcomment, 'selectedcomment');
        $schoolId = $this->getCurrentSchoolId();

        $page = $this->getInput('page');
        $count = $this->_getMerCommentDS()->getCountOfMcomment($mid);

        if (0 < $count) 
        {
            $totalPage = ceil($count/$this->pageNumber);
            $page > $totalPage && $page = $totalPage;
            list($offset, $limit) = Pw::page2limit($page, $this->pageNumber);

            if($page <= 0)
                $page =1;
        }

        $messageList = $this->_getMerCommentDS()->getMcomment($mid,$limit,$offset);
        foreach ($messageList as $key => $value) 
        {
            $messageList[$key]['username'] = $this->formatUserName($value['username']);
        }

        //overall comment
        $mOverAll = $this->_getMerCommentDS()->getMOverall($mid);
        
        $this->setOutput($mOverAll,'mOverAll');

        //get shop's delivery time
        $timeList = $this->_getShopDs()->getShopDeliveryTimeByShopId($shopid);
        $this->setOutput($timeList,'timeList');

        $exists = $this->_getShopCommentDS()->checkIfExists($this->loginUser->uid,$orderid = 0,$mid);
        if($exists || empty($userId))
        {
            $docomment = '';
            $this->setOutput($docomment, 'docomment');
        }
        else
        {
            $docomment = 'yes';
            $this->setOutput($docomment, 'docomment');
        }

        $args['shopid'] = $shopid;
        $args['mid'] = $mid;
        $args['schoolid'] = $schoolId;

        $this->setOutput($messageList,'messageList');
        $this->setOutput($count, 'count'); 
        $this->setOutput($page, 'page');
        $this->setOutput($this->pageNumber, 'perPage');
        $this->setOutput($args,'args');
        $this->setOutput($userId,'userId');
        
        //SEO Information
        $SEOTitleKeyword = '点餐哟外卖平台 - '.$shop['name'].$mInfo['name'].'点餐,'.
                           $shop['name'].$mInfo['name'].'外卖,'.
                           $shop['name'].$mInfo['name'].'网络订餐';

        $this->setOutput($SEOTitleKeyword,'SEOTitle');
        $this->setOutput($SEOTitleKeyword,'SEOKeyword');
        $this->setOutput(Wekit::C('site', 'info.url'),'rooturl');
        $this->setOutput(1,'addheaderlong');
    }

    public function formatUserName($username)
    {
        $newname = '';
        $count = floor(strlen($username)/2);
        for ($i=0; $i < strlen($username); $i++) {
            if($i < $count + 2 && $i >= $count)
            {
                $newname .= '*';
            }
            else
            {
                $newname .= $username[$i];
            } 
        }

        return $newname;
    }

    public function showPhoneAction()
    {
        $shopid = $this->getInput("shopid");
        if(empty($shopid))
        {
            $this->setTemplate("shopdetails_notexist");
            return;
        }

        //show phone number
        $shop = $this->_getShopDs()->getByShopId($shopid);
        $schoolareaList = $this->setAreaFilterWidgetData();
        
        foreach ($schoolareaList as $key => $value) 
        {
            if($shop['areaid'] == $value['id'])
            {
                $schoolName = $value['name'];
                $schoolAreaName = $value['areaname'];
                break;
            }
        }

        //check if shop is active or not
        if(empty($shop))
        {
            $this->setTemplate("shopdetails_notexist");
            return;
        }

        $ip=$_SERVER["REMOTE_ADDR"];

        $dm=new App_ShopPhone_Dm();
        $dm->setShopId($shopid)
            ->setUID($this->loginUser->uid)
            ->setClientIP($ip);

        $this->_getShopDs()->addShopPhoneChecked($dm);

        $this->setOutput($shop,'shop');

        //SEO Information
        $SEOTitleKeyword = $shop['name'].'外卖电话 - '.$schoolName.'外卖电话查询';
        $this->setOutput($SEOTitleKeyword,'SEOTitle');
        $this->setOutput($SEOTitleKeyword,'SEOKeyword');


    }

    private function displayShoppingCart($shopId,$packingPrice)
    {
        $perShopSubtotal=$this->jcart->get_shop_subtotal();
        $curShopSubtotal=$perShopSubtotal[$shopId]==null?0:$perShopSubtotal[$shopId];
        $this->setOutput($curShopSubtotal,'curShopSubtotal');


        //extends from T4BaseController
        $this->jcart->set_redirect_url();
        $this->jcart->set_packing_price($shopId,$packingPrice);
        $this->setOutput($this->jcart, 'jcart');
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

    private function setAnchor($mid)
    {
        $anchor = "";
        if ($mid) {
            $anchor = 'm' . $mid;
        }
        //help to determine the position of the anchor
        $this->setOutput($anchor, 'anchor');
    }

    private function addToCart($cartMid)
    {
        if (!isset($_SESSION)) {
            @session_start();
        }

        if (!isset($_SESSION['addToCart'])) {
            $_SESSION['addToCart']=$cartMid;
            return true;
        }
        $tmp=$_SESSION['addToCart'];
        $_SESSION['addToCart']=$cartMid;
        return $tmp!=$cartMid;
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

    public function doaddcommentAction()
    {
        $returnData = array("success" => true,
                            "data" => "评价成功, 感谢您的配合");
        $comment = $this->getInput("comment","post");
        $tastescore = $this->getInput("tastescoreshow","post");
        $servicescore = $this->getInput("servicescoreshow","post");
        $mid = $this->getInput("mid","get");

        if(empty($comment))
        {
            // $returnData['success'] = false;
            // $returnData['data'] = "评论不能为空";
            // print_r(json_encode($returnData));
            // die;
        }

        $id = $this->_getShopCommentDS()->addMyComment($this->loginUser->uid, 
                                                       $mid, 
                                                       $orderid, 
                                                       $comment, 
                                                       0, 
                                                       $servicescore, 
                                                       $tastescore);
        if($id > 0)
        {
            //$this->showMessage($returnData['data']);
        }
        else
        {
            $returnData['success'] = false;
            $returnData['data'] = "评论失败,请联系系统管理员";
            print_r(json_encode($returnData));
            die;
        }
    }

    private function calculateMerchandiseDMoneyByPrice ($price)
    {
        $rate = $this->_cur_shop['rebatefromshop'];
        $rmbShopReturn = $price * $rate;
        $rmbforUser = $this->_getShopDailySaleDs()->getUserProfit($rmbShopReturn);
        $DMoney = $rmbforUser * 10;
        return $DMoney;
    }    

    private function _getShopCommentDS()
    {
        return Wekit::load('EXT:4tschool.service.mercomment.App_MerComment');
    }

    private function _getMyOrderDS()
    {
        return Wekit::load('EXT:4tschool.service.myorder.App_MyOrder');
    }

    /**
     * @return  App_MessageBoard
     */
    private function _getMessageBoardDS()
    {
        return Wekit::load('EXT:4tschool.service.messageboard.App_MessageBoard');
    }

    /**
     * @return App_Shop
     */
    private function _getShopDs()
    {
        return Wekit::load('EXT:4tschool.service.shop.App_Shop');
    }

    /**
     * @return App_Tag
     */
    private function _getTagDs()
    {
        return Wekit::load('EXT:4tschool.service.tag.App_Tag');
    }

    /**
     * @return App_Merchandise
     */
    private function _getMerchandiseDs()
    {
        return Wekit::load('EXT:4tschool.service.merchandise.App_Merchandise');
    }

    private function _getSchoolAreaDs()
    {
        return Wekit::load('EXT:4tschool.service.schoolarea.App_SchoolArea');
    }

    /**
     * @return App_MyFavorite
     */
    private function _getMyFavoriteDS()
    {
        return Wekit::load('EXT:4tschool.service.myfavorite.App_MyFavorite');
    }

    /**
     * @return App_School
     */
    private function _getSchoolDS()
    {
        return Wekit::load('EXT:4tschool.service.school.App_School');
    }

    /**
     * @return App_MerComment
     */
    private function _getMerCommentDS()
    {
        return Wekit::load('EXT:4tschool.service.mercomment.App_MerComment');
    }

    /**
     * @return App_Promotionalmanage
     */
    private function _getPromotionalmanageDs()
    {
        return Wekit::load('EXT:4tschool.service.promotionalmanage.App_Promotionalmanage');
    }

    private function _getMyMoneyDS()
    {
        return Wekit::load('EXT:4tschool.service.mymoney.App_MyMoney');
    }

    /**
     * @return App_ShopDailySale
     */
    private function _getShopDailySaleDs()
    {
        return Wekit::load('EXT:4tschool.service.shopdailysale.App_ShopDailySale');
    }       
}