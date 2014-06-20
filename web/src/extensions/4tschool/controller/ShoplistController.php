<?php
Wind::import('EXT:4tschool.controller.T4BaseNotLoginController');
Wind::import('EXT:4tschool.service.shop.dm.App_Shop_DeliveryTime_Dm');
Wind::import('EXT:4tschool.service.searches.dm.App_Search_Dm');
Wind::import('EXT:4tschool.service.shop.dm.App_Shop_Dm');
Wind::import('EXT:4tschool.service.shoparea.dm.App_Shoparea_Dm');
Wind::import('EXT:4tschool.service.tag.dm.App_Tag_Dm');

class ShopListController extends T4BaseNotLoginController
{

    private $pageNumber = 10;
    private $oriKeyword;
    private $oriType;

    public function run()
    {
        list($aid, $type, $keyword, $page, $hotkey) = $this->getInput(array('aid', 'type', 'keyword', 'page', 'hotkey'), 'request');
        $this->setOutput($keyword, "keyword");
        $schoolId = $this->getCurrentSchoolId();
        $this->getWebStatus($schoolId);

        $schoolareaList = $this->setAreaFilterWidgetData();
        if(empty($aid))
        {
            $schoolName = $schoolareaList[0]['name'];
        }
        else
        {
            foreach ($schoolareaList as $key => $value) 
            {
                if($aid == $value['id'])
                {
                    $schoolName = $value['name'];
                    $schoolAreaName = $value['areaname'];
                    break;
                }
            }
        }

        //推荐商家
        $schoolInfo = $this->_getSchoolDS()->getSchoolExtra($schoolId);
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

        //get search Args
        $searchArgs = $this->getSearchArg();
        $count = $this->_getSearchDs()->countShopsByArgs($schoolId,$searchArgs);
        if (0 < $count) {
            $totalPage = ceil($count / $this->pageNumber);
            $page > $totalPage && $page = $totalPage;
            list($offset, $limit) = Pw::page2limit($page, $this->pageNumber);
            if ($page <= 0)
                $page = 1;
        }

        $shopList = $this->_getSearchDs()->searchShopsByArgs($schoolId,$searchArgs,$limit,$offset);
        foreach ($shopList as $key => $value) {
            $shopList[$key]['imageurl'] = Wekit::C('site', 'info.url') .'/src/extensions/4tschool'. str_replace('\\', '/', $value['imageurl']);
            $shopList[$key]['isopen'] = $this->isOpening($shopList[$key]['orderbegin'], $shopList[$key]['orderend']);
        }

        $this->setOutput($aid,'aid');
        $this->setOutput($shopList, "shopList");

        $this->setOutput($count, 'count');
        $this->setOutput($page, 'page');
        $this->setOutput($this->pageNumber, 'perPage');

        $this->outputFilter($searchArgs);

        if($_POST['shop'] || $hotkey == 'h')
        {
            //save search info
            $this->saveSearchInfomation($keyword,$hotkey);
        }

        $basepricestring = '搜索'.$schoolName.$schoolAreaName.'的外卖价格在';

        if($searchArgs['ifdeliver'] == 'n')
        {
            $ifdeliver = '非';
        }
        elseif ($searchArgs['ifdeliver'] == 'y') 
        {
            $ifdeliver = '送';
        }
        else
        {
            $ifdeliver = '';
        }    

        if($searchArgs['ifdeliverfee'] == 'n')
        {
            $ifdeliverfee = '没有外卖费的';
        }
        elseif ($searchArgs['ifdeliverfee'] == 'y') 
        {
            $ifdeliverfee = '含外卖费的';
        }
        else
        {
            $ifdeliverfee = '';
        }

        if(!empty($keyword))
        {
            $keyword = '做'.$keyword;
        }

        if($searchArgs['baseprice'] == '1-9' && $type == 's')
        {
            $basepricestring = $basepricestring.'10元以下'.$keyword.$ifdeliverfee.$ifdeliver.'外卖的'.$tagInfo['name'].'店铺';
        }
        elseif ($searchArgs['baseprice'] == '10-19' && $type == 's') 
        {
            $basepricestring = $basepricestring.'10-20元'.$keyword.$ifdeliverfee.$ifdeliver.'外卖的'.$tagInfo['name'].'店铺';
            
        }elseif ($searchArgs['baseprice'] == '20-10000' && $type == 's') 
        {
            $basepricestring = $basepricestring.'20元以上'.$keyword.$ifdeliverfee.$ifdelivere.'外卖的'.$tagInfo['name'].'店铺';
        }
        else
        {
            $basepricestring = '搜索'.$schoolName.$schoolAreaName.$keyword.$ifdeliverfee.$ifdeliver.'外卖的'.$tagInfo['name'].'店铺';
        }
        
        $SEOTitle  = $basepricestring;
        $SEOKeyword  = $basepricestring;
        $this->setOutput($SEOTitle,'SEOTitle');
        $this->setOutput($SEOKeyword,'SEOKeyword');
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

    private function outputFilter($searchArgs)
    {
        $this->setOutput($searchArgs,'searchArgs');
    }

    private function getSearchArg()
    {
        //0. shop or m
        $type = $this->getInput("type");
        if($type !='m' && $type != 's')
            $type = 'm';

        //-1. controller
        $baseurl = ($type == 'm'?WindUrlHelper::createUrl('app/4tschool/merchandiselist/run'):WindUrlHelper::createUrl('app/4tschool/shoplist/run'));
        $target = ($type == 'm'?"merchandiselist":"shoplist");

        //1. area
        $aid = $this->getInput("aid");

        //2. delivery or not
        $ifdeliver = $this->getInput("ifdeliver");

        //3. base price
        $baseprice = $this->getInput("baseprice");

        //4. delivery fee or not
        $ifdeliverfee = $this->getInput("ifdeliverfee");

        //5. keyword
        $keyword = $this->getInput("keyword");

        //6. tag id
        $tagid = $this->getInput("systid");

        //7. sort
        $sort = $this->getInput("sort");

        //8. order by
        $orderby = $this->getInput("orderby");

        //9. schoolid
        $schoolid = $this->schoolExtra['schoolid'];

        if (empty($orderby)) {
            $orderby='price';
        }

        //set argument
        $searchArgs['schoolid'] = $schoolid;
        $searchArgs['aid'] = $aid;
        $searchArgs['ifdeliver'] = $ifdeliver;
        $searchArgs['baseprice'] = $baseprice;
        $searchArgs['ifdeliverfee'] = $ifdeliverfee;
        $searchArgs['type'] = $type;
        $searchArgs['keyword'] = $keyword;
        $searchArgs['tagid'] = $tagid;
        $searchArgs['baseurl'] = $baseurl;
        $searchArgs['orderby'] = $orderby;
        $searchArgs['sort'] = $sort;

        $searchArgs['target'] = $target;

        return $searchArgs;
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

    private function saveSearchInfomation($keyword,$type)
    {
        $userId=$this->loginUser->uid;
        $schoolId = $this->getCurrentSchoolId();
        if($type == 'h')
        {
            $shop = $keyword;
            $type = $type;
        }
        else
        {
            $shop = $this->getInput("shop");
            $type = $this->getInput("type");
        }

        
        $dm=new App_Search_Dm();
        $dm->setUid($userId)
            ->setSchoolid($schoolId)
            ->setKeyword($shop)
            ->setSearchType($type);

        $result=$this->_getSearchDs()->add($dm);
    }

    public function shopManageAction()
    {
        //set selected menu
        $this->setOutput('商家列表','shoplistname');
        $this->setOutput('管理商家','selectedMenu');
        $schoolId = $this->getCurrentSchoolId();
        $this->getWebStatus($schoolId);
        $userId = $this->loginUser->uid;
        $this->isSchoolManage($schoolId, $userId);
        $this->getNoCommentSum($schoolId, $userId);

        $myMenus =  $this->_getMyOrderDS()->getMyMenus($schoolId,
                                                       $this->loginUser->uid);

        $choosenShopid = -1;
        $isactive = -1;
        $ispartner = -1;
        $isaudit = -1;
        if ($this->getInput('type', 'post') === 'do') 
        {
            list($choosenShopid) = $this->getInput(array('choosenShopid'), 'post');
        }

        $page = $this->getInput('page');

        $searchCondition = array('schoolid' => $schoolId,
                                 'choosenShopid' => $choosenShopid,
                                 'isactive' => $isactive,
                                 'ispartner' => $ispartner,
                                 'isaudit' => $isaudit);
        $count =  $this->_getShopDs()->countAllShop($searchCondition);
        if (0 < $count) 
        {
          $totalPage = ceil($count/$this->pageNumber);
          $page > $totalPage && $page = $totalPage;
          list($start, $limit) = Pw::page2limit($page, $this->pageNumber);

          if($page <= 0)
            $page =1;
        }

        $allShopList = $this->_getShopDs()->getAllShops(array('schoolid' => $schoolId,
                                                              'choosenShopid'=>'-1', 
                                                              'isactive'=>'-1', 
                                                              'ispartner'=>'-1',
                                                              'isaudit'=>'-1'));
        $shopList = $this->_getShopDs()->getAllShops($searchCondition, $start, $limit);
        foreach ($shopList as $key => $value) {
            if (empty($shopList[$key]['imageurl'])) {
                //set default image
                $shopList[$key]['imageurl'] = Wekit::C('site', 'info.url') .'/src/extensions/4tschool'. "/uploaded_images/default/sdefault.jpg";
                $shopList[$key]['newimage'] = 'no';
            } else {
                $shopList[$key]['imageurl'] = Wekit::C('site', 'info.url') .'/src/extensions/4tschool'.str_replace('\\', '/', $value['imageurl']);
                $shopList[$key]['newimage'] = 'yes';
            }
            $shopList[$key]['isopen'] = $this->isOpening($shopList[$key]['orderbegin'], $shopList[$key]['orderend']);
        }
        $shopList = array_values($shopList);

        $this->setOutput($allShopList, 'allShopList');
        $this->setOutput($shopList, 'shopList');
        $this->setOutput($searchCondition, 'searchCondition');
        $this->setOutput($myMenus,'myMenus');
        $this->setOutput($shopList,'shopList');
        $this->setOutput($count, 'count');  
        $this->setOutput($page, 'page');
        $this->setOutput($this->pageNumber, 'perPage');
        $this->setOutput($schoolId, 'schoolId');
    }

    public function isSchoolManage($schoolId, $userId)
    {
        $ppls = $this->_getSchoolPeopleDS()->getSchoolPeople($schoolId,'master');
        $userids = array();
        foreach ($ppls AS $KEY => $VALUE) 
        {
            array_push($userids, $VALUE['userid']);
        }

        if(!in_array($userId, $userids))
        {
            $this->setTemplate("manage_ifexists");
            return;
        }
        
        $this->setOutput($ppls,"ppls");
    }

    public function shopManagEditAction()
    {
        $schoolId = $this->getCurrentSchoolId();
        $this->getWebStatus($schoolId);
        $masterId = $userId = $this->loginUser->uid;
        $this->isSchoolManage($schoolId, $userId);
        $this->getNoCommentSum($schoolId, $userId);

        $shopId = $this->getInput('id');
        $shopInfo = $this->_getShopDs()->getShopNameByShopId($shopId);
        $isMine = $this->_getShopDs()->isMyShop($shopInfo['areaid'], $schoolId);
        if(!$isMine)
        {
            $this->setTemplate("manage_ifexists");
            return;
        }

        if ($this->getInput('type', 'post') === 'do') {
            list($choosenUserid, 
            $shopName, 
            $description, 
            $address, 
            $packingprice,
            $areaid, 
            $phoneNumber, 
            $contactNumber, 
            $openOrder, 
            $orderBegin, 
            $orderEnd, 
            $isActive, 
            $isPartner, 
            $hasTerminal,
            $hasPrint,
            $openOrderToUser,
            $actualmakeordertime,
            $actualbakeouttime,
            $actualtocentertime,
            $actualdeliverytime,
            $deliveryprice,
            $lat,
            $lng,
            $startingprice) = $this->getInput(array('choosenUserid', 
                                                    'shopname', 
                                                    'description', 
                                                    'address', 
                                                    'packingprice', 
                                                    'area', 
                                                    'phonenumber', 
                                                    'contactnumber', 
                                                    'openorder', 
                                                    'orderbegin', 
                                                    'orderend', 
                                                    'isactive' , 
                                                    'ispartner', 
                                                    'hasterminal',
                                                    'hasprint',
                                                    'openordertouser',
                                                    'actualmakeordertime',
                                                    'actualbakeouttime',
                                                    'actualtocentertime',
                                                    'actualdeliverytime',
                                                    'deliveryprice',
                                                    'lat',
                                                    'lng',
                                                    'startingprice'), 'post');
            if (empty($shopName)) {
                $this->showError('请输入商家名称.');
                return;
            }
            if (empty($address)) {
                $this->showError('请输入地址.');
                return;
            }
            if (empty($phoneNumber)) {
                $this->showError('请输入手机号码');
                return;
            }

            $shopId = $this->getInput('id', 'request');
            $nameDuplicate = $this->_getShopDs()->checkDuplicateInfo('name', $shopName, $shopId);
            if ($nameDuplicate) {
                $this->showError('商家名:' . '"' . $shopName . '"' . '已存在');
                return;
            }

            $dm = new App_Shop_Dm();
            $dm->setUserId($choosenUserid)
                ->setMasterId($masterId)
                ->setShopName($shopName)
                ->setAddress($address)
                ->setPackingPrice($packingprice)
                ->setArea($areaid)
                ->setPhoneNumber($phoneNumber)
                ->setContactNumber($contactNumber)
                ->setOpenOrder($openOrder)
                ->setOrderBegin($orderBegin)
                ->setOrderEnd($orderEnd)
                ->setLastUpdateTime(Pw::getTime())
                ->setDescription($description)
                ->setIsActive($isActive)
                ->setIsPartner($isPartner)
                ->setHasTerminal($hasTerminal)
                ->setHasPrint($hasPrint)
                ->setIsOpenOrderToUser($openOrderToUser)
                ->setActualmakeorder($actualmakeordertime)
                ->setActualbakeout($actualbakeouttime)
                ->setActualtocenter($actualtocentertime)
                ->setActualdelivery($actualdeliverytime)
                ->setDeliveryprice($deliveryprice)
                ->setLatitude($lat)
                ->setLongitude($lng)
                ->setStartingPrice($startingprice);                

            $r = $this->_getShopDs()->update($shopId, $dm);
            if ($r == 1 && $this->shopDeliveryTimeHandle($shopId)) {
                echo "<script>alert('更新成功')</script>";
            } else {
                echo "<script>alert('更新失败,请联系管理员')</script>";
            }
            echo "<script language=JavaScript> location.replace(location.href);</script>";
        }

        $isChange = $this->getInput('isChange');
        $shopId = $this->getInput('id', 'request');
        $shop = $this->_getShopDs()->getByShopId($shopId);
        if (empty($shop)) {
            $this->showError("Invalid data");
        }

        $choosenProvinceid = isset($isChange) ? $this->getInput('choosenProvinceid') : $shop['provinceid'];
        $choosenSchoolid = isset($isChange) ? $this->getInput('choosenSchoolid') : $shop['schoolid'];

        $userList = $this->_getSchoolPeopleDS()->getSchoolPeople($choosenSchoolid, 'shopaccount');

        $allProvince = $this->_getAreaDs()->getAreaByParentid(0);
        $allProvince = array_values($allProvince);

        $allSchool = $this->_get4TSchoolDS()->getOpenedSchools();
        $allSchool = array_values($allSchool);

        Wind::import('EXT:4tschool.service.dm.App_SchoolArea_Dm');
        $areaList = Wekit::load('EXT:4tschool.service.schoolarea.App_SchoolArea')->getBySchoolid(empty($choosenSchoolid) ? $allSchool[0]['schoolid'] : $choosenSchoolid);

        $shopSchoolMsg = $this->_getShopAreaDs()->getShopAreaByShopId($shopId);
        $schoolnameMsg = array();
        foreach ($shopSchoolMsg as $key => $value) 
        {
            array_push($schoolnameMsg, $value['schoolname']);
        }
        $schoolnamestring = implode(', ',$schoolnameMsg);

        $agents = $this->_getShopSchoolPeople()->getPeopleByType('master');

        $this->setOutput($userList, 'userList');
        $this->setOutput($choosenProvinceid, "choosenProvinceid");
        $this->setOutput($choosenSchoolid, "choosenSchoolid");
        $this->setOutput($allProvince, 'allProvince');
        $this->setOutput($allSchool, 'allSchool');
        $this->setOutput($areaList, 'areaList');
        $this->setOutput($shop, 'shop');
        $this->setOutput($agents, 'agents');
        $this->setOutput($schoolnamestring, 'schoolnamestring');

        $shopDeliveryTimeList=$this->_getShopDs()->getShopDeliveryTimeByShopId($shopId);
        $this->setOutput($shopDeliveryTimeList,'shopDeliveryTimeList');

        $schoolId = $this->getCurrentSchoolId();
        $myMenus =  $this->_getMyOrderDS()->getMyMenus($schoolId,$this->loginUser->uid);
        $this->setOutput($myMenus, 'myMenus');
        $this->setOutput($this->loginUser->username, 'mastername');
        $this->setOutput($schoolId, 'schoolId');
    }

    public function shopManageAddAction()
    {
        $schoolId = $this->getCurrentSchoolId();
        $this->getWebStatus($schoolId);
        $masterId = $userId = $this->loginUser->uid;
        $this->isSchoolManage($schoolId, $userId);
        $this->getNoCommentSum($schoolId, $userId);
        
        if ($this->getInput('type', 'post') === 'do') {

            list($choosenUserid, 
                $shopName, 
                $description, 
                $address, 
                $packingPrice, 
                $areaid, 
                $phoneNumber, 
                $contactNumber, 
                $openOrder, 
                $orderBegin, 
                $orderEnd, 
                $isActive, 
                $isPartner, 
                $hasTerminal, 
                $hasPrint,
                $openOrderToUser,
                $actualmakeordertime,
                $actualbakeouttime,
                $actualtocentertime,
                $actualdeliverytime,
                $deliveryprice,
                $lat,
                $lng,
                $startingprice) = $this->getInput(array('choosenUserid',
                                                        'shopname', 
                                                        'description', 
                                                        'address', 
                                                        'packingprice', 
                                                        'area', 
                                                        'phonenumber', 
                                                        'contactnumber', 
                                                        'openorder', 
                                                        'orderbegin', 
                                                        'orderend', 
                                                        'isactive',
                                                        'ispartner',
                                                        'hasterminal',
                                                        'hasprint',
                                                        'openordertouser',
                                                        'actualmakeordertime',
                                                        'actualbakeouttime',
                                                        'actualtocentertime',
                                                        'actualdeliverytime',
                                                        'deliveryprice', 
                                                        'lat', 
                                                        'lng', 
                                                        'startingprice'), 'post');

            if (empty($shopName)) {
                $this->showError('请输入商家名称.');
                return;
            }
            if (empty($address)) {
                $this->showError('请输入地址.');
                return;
            }
            if (empty($phoneNumber)) {
                $this->showError('请输入手机号码');
                return;
            }

            $nameDuplicate = $this->_getShopDs()->checkDuplicateInfo('name', $shopName, 'new');
            if ($nameDuplicate) {
                $this->showError('商家名:' . '"' . $shopName . '"' . '已存在');
                return;
            }

            // $phoneNumberDuplicate = $this->_getShopDs()->checkDuplicateInfo('phonenumber', $phoneNumber, 'new');
            // if ($phoneNumberDuplicate) {
            //     $this->showError('手机号码:' . '"' . $phoneNumber . '"' . '已存在');
            //     return;
            // }

            $dm = new App_Shop_Dm();
            $dm->setUserId($choosenUserid)
                ->setMasterId($masterId)
                ->setShopName($shopName)
                ->setAddress($address)
                ->setPackingPrice($packingPrice)
                ->setArea($areaid)
                ->setPhoneNumber($phoneNumber)
                ->setContactNumber($contactNumber)
                ->setOpenOrder($openOrder)
                ->setOrderBegin($orderBegin)
                ->setOrderEnd($orderEnd)
                ->setCreateDate(Pw::getTime())
                ->setLastUpdateTime(Pw::getTime())
                ->setDescription($description)
                ->setOrderCount(0)
                ->setIsActive($isActive)
                ->setIsPartner($isPartner)
                ->setHasTerminal($hasTerminal)
                ->setHasPrint($hasPrint)
                ->setIsOpenOrderToUser($openOrderToUser)
                ->setActualmakeorder($actualmakeordertime)
                ->setActualbakeout($actualbakeouttime)
                ->setActualtocenter($actualtocentertime)
                ->setActualdelivery($actualdeliverytime)
                ->setDeliveryprice($deliveryprice)
                ->setLatitude($lat)
                ->setLongitude($lng)
                ->setStartingPrice($startingprice);

            $id=$this->_getShopDs()->add($dm);

            if ($id > 0 && $this->shopDeliveryTimeHandle($id) && $this->saveShopSchool($id, $schoolId)) {
                echo "<script>alert('添加成功')</script>";
            } else {
                echo "<script>alert('添加成功,请联系管理员')</script>";
            }
            echo "<script language=JavaScript> location.replace(location.href);</script>";            
        }
        $allProvince = $this->_getAreaDs()->getAreaByParentid(0);
        $allProvince = array_values($allProvince);
        //check if has province id or not, if has, then school list need to based on that
        //get province from url
        $choosenProvinceid = $this->getInput('choosenProvinceid');
        if (!isset($choosenProvinceid) || $choosenProvinceid <= 0) {
            $choosenProvinceid = $allProvince[0]['areaid'];
        }

        $allSchool = $this->_get4TSchoolDS()->getOpenedSchools();
        $allSchool = array_values($allSchool);
        $this->setOutput($allSchool, 'allSchool');

        $choosenSchoolid = $this->getInput('schoolid');
        if (!isset($choosenSchoolid) || $choosenSchoolid <= 0) {
            $choosenSchoolid = $allSchool[0]['schoolid'];
        }

        $userList = $this->_getSchoolPeopleDS()->getSchoolPeople($choosenSchoolid, 'shopaccount');

        Wind::import('EXT:4tschool.service.dm.App_SchoolArea_Dm');

        $areaList = Wekit::load('EXT:4tschool.service.schoolarea.App_SchoolArea')->getBySchoolid($choosenSchoolid);

        $agents = $this->_getShopSchoolPeople()->getPeopleByType('master');

        $this->setOutput($userList, 'userList');
        $this->setOutput($choosenProvinceid, 'choosenProvinceid');
        $this->setOutput($choosenSchoolid, 'choosenSchoolid');
        $this->setOutput($areaList, 'areaList');
        $this->setOutput($agents, 'agents');
        $this->setOutput($allProvince, 'allProvince');
        

        $myMenus =  $this->_getMyOrderDS()->getMyMenus($schoolId,$this->loginUser->uid);
        $this->setOutput($myMenus, 'myMenus');
        $this->setOutput($this->loginUser->username, 'mastername');
        $this->setOutput($schoolId, 'schoolId');
    }

    public function shopManageUploadAction()
    {
        $schoolId = $this->getCurrentSchoolId();
        $userId = $this->loginUser->uid;
        $this->isSchoolManage($schoolId, $userId);
        $this->getNoCommentSum($schoolId, $userId);

        $myMenus =  $this->_getMyOrderDS()->getMyMenus($schoolId,$this->loginUser->uid);
        $this->setOutput($myMenus, 'myMenus');

        $shopId = $this->getInput('sid');
        $shopInfo = $this->_getShopDs()->getShopNameByShopId($shopId);
        $isMine = $this->_getShopDs()->isMyShop($shopInfo['areaid'], $schoolId);
        
        // if(!$isMine)
        // {$this->showError($isMine);
        //     $this->setTemplate("manage_ifexists");
        //     return;
        // }

        $imageUrl = $this->getInput('url');
        $this->setOutput($shopInfo['name'], 'shopName');
        $this->setOutput($shopId, 'shopId');
        $this->setOutput($imageUrl, 'imageUrl');

        if ($this->getInput('type', 'post') === 'do' && is_uploaded_file($_FILES["uploadimg"]["tmp_name"])) 
        {
            list($shopId, $imageUrl) = $this->getInput(array('shopid', 'imageurl'), 'post');

            if (empty($shopId)) {
                $this->showError("未知的错误,请联系管理员");
            }

            $file = $_FILES["uploadimg"];

            if($_FILES['uploadimg']['size']/1024 > 1024)
            {
                $this->showError(图片过大);
            }

            //check the uploaded file whether it is a image.
            $ext = strtolower(substr(strrchr($file['name'], '.'), 1));
            if (!$this->isImage($ext)) {
                $this->showError("文件格式不正确!");
            }

            //build dir
            $image_path = '/uploaded_images/' . $shopId . '/';
            $destination_folder = dirname(dirname(__FILE__)) . $image_path;


            if (!file_exists($destination_folder)) {
                   mkdir($destination_folder);
            }

            $imgName = 'shop_' . $shopId . '.' . $ext;
            $destination = $destination_folder . $imgName;

            //if the image of current merchandise already exists, change the exists one to history.
            if (file_exists($destination)) {

                $imgHistory = $destination_folder . 'shop_' . $shopId . "_" . "hist" . "_" . time() . "." . $ext;
                rename($destination, $imgHistory);
            }

            //save image and stroage url to db.
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                $url = $image_path . $imgName;
                if ($this->saveUrl($shopId, $url)) {
                    $this->showMessage("上传成功！");
                }
            }
        }
        $this->setOutput($schoolId, 'schoolId');

    }

    public function getNoCommentSum($schoolId, $userid)
    {
        $countNoComment = $this->_getShopCommentDS()->getCountOfMyUnComment($schoolId, $userid);
        $this->setOutput($countNoComment,"countNoComment");
    }

    public function shopDeliveryTimeHandle ($shopid){
        list($data,$newData) = $this->getInput(array('data', 'newdata'), 'post');
        $add=true;
        $update=true;
        if ($data) {
            $update=$this->updateShopDeliveryTime($data);
        }
        if ($newData) {
            $add=$this->addShopDeliveryTime($shopid,$newData);
        }
        return ($add && $update);
    }

    public function updateShopDeliveryTime ($data){
        $flag=true;
        foreach ($data as $item) {
            if (empty($item['begintime'])||empty($item['endtime'])) continue;

            $dm=new App_Shop_DeliveryTime_Dm();
            $dm->setBeginTime($item['begintime'])
               ->setEndtime($item['endtime'])
               ->setWeights($item['weights'])
               ->setIsActive($item['isactive']);

            $r=$this->_getShopDs()->updateShopDeliveryTime($item['id'],$dm);

            if (!$r>0) {
                $flag=false;
            }            
        }
        return $flag;
    }

    public function addShopDeliveryTime ($shopid,$data){
        $flag=true;
        foreach ($data as $item) {            
            if (empty($item['begintime'])||empty($item['endtime'])) continue;

            $dm=new App_Shop_DeliveryTime_Dm();

            $dm->setShopId($shopid)
               ->setBeginTime($item['begintime'])
               ->setEndtime($item['endtime'])
               ->setWeights($item['weights'])
               ->setIsActive($item['isactive']);

            $r=$this->_getShopDs()->addShopDeliveryTime($dm);

            if (!$r>0) {
                $flag=false;
            }
        }

        return $flag;
    }

    public function shopManagepreviewAction()
    {
        $id = $this->getInput('id');
        $shopmanagepreview = $this->_getShopDs()->get($id);
        $shopmanagepreview['imageurl'] = 'src/extensions/4tschool'. str_replace('\\', '/', $shopmanagepreview['imageurl']);
        $this->setOutput($shopmanagepreview,'shopmanagepreview');
    }

    public function shopTagManageAction (){
        $schoolId = $this->getCurrentSchoolId();
        $userId = $this->loginUser->uid;
        $myMenus =  $this->_getMyOrderDS()->getMyMenus($schoolId,$this->loginUser->uid);
        $this->setOutput($myMenus, 'myMenus');  

        $shopId=$this->getInput('id');
        $this->setOutput($shopId,'shopId');      
        $tags=$this->_getTagDs()->getTagsByShopId($shopId);
        $this->setOutput($tags,'tags');
    }

    public function doShopTagSettingAction(){
        if ($this->updateShopTag()) {
            $this->showMessage("保存成功");
        }
        $this->showMessage("保存失败");
    }

    private function updateShopTag (){
        $shopId=$this->getInput('shopid','get');
        $tags=$this->getInput('tags', 'post');
        $newTags=$this->getInput('newtags','post');

        if ($tags) {
            foreach ($tags as $key => $item) {
                $dm=new App_Tag_Dm();
                $dm->setShopId($shopId)
                   ->setTagName($item['name'])
                   ->setIsActive($item['isactive'])
                   ->setLastUpdateTime(Pw::getTime());
                $this->_getTagDs()->update($key,$dm);
            }
        }        

        if ($newTags) {
            foreach ($newTags as $key => $item) {
                $tag['shopid']=$shopId;
                $tag['name']=$item['name'];
                $tag['isactive']=$item['isactive'];
                $tag['issystem']=0;
                $tag['createdate']= Pw::getTime();
                $tag['lastupdatetime']= Pw::getTime();
                $dm=new App_Tag_Dm();
                $dm->setTag($tag);
                $this->_getTagDs()->add($dm);
            }
        }
        
        return true;
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

    public function isImage($ext)
    {
        return in_array($ext, array('gif', 'jpg', 'jpeg', 'png', 'bmp', 'swf'));
    }

    public function saveUrl($shopId, $url)
    {
        $dm = new App_Shop_Dm();
        $dm->setImageUrl($url)
            ->setLastUpdateTime(Pw::getTime());
        $result = $this->_getShopDs()->update($shopId, $dm);

        return $result;
    }

    public function saveShopSchool($shopId, $schoolId)
    {
        $dm = new App_Shoparea_Dm();
        $dm->setShopId($shopId)
           ->setSchoolId($schoolId);
        $id = $this->_getShopAreaDs()->add($dm);

       return $id;
    }

    /**
     * 获得windid的地区DS
     *
     * @return WindidArea
     */
    private function _getAreaDs()
    {
        return Wekit::load('WINDID:service.area.WindidArea');
    }

    /**
     * @return App_Search
     */
    private function _getSearchDs()
    {
        return Wekit::load('EXT:4tschool.service.searches.App_Search');
    }

    private function _getSchoolAreaDs()
    {
        return Wekit::load('EXT:4tschool.service.schoolarea.App_SchoolArea');
    }

    /**
     * @return App_School
     */
    private function _getSchoolDs()
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
     * @return App_MyOrder
     */
    private function _getMyOrderDS()
    {
        return Wekit::load('EXT:4tschool.service.myorder.App_MyOrder');
    }

    private function _getShopDs() {
        return Wekit::load('EXT:4tschool.service.shop.App_Shop');
    }

    /**
     * @return App_SchoolPeople
     */
    private function _getSchoolPeopleDS()
    {
        return Wekit::load('EXT:4tschool.service.schoolpeople.App_SchoolPeople');
    }

    private function _get4TSchoolDS()
    {
        return Wekit::load('EXT:4tschool.service.school.App_School');
    }

    /**
     * @return App_Cate_Week_Report
     */
    private function _getCateWeekReportDs()
    {
        return Wekit::load('EXT:4tschool.service.cateweekreport.App_CateWeekReport');
    }

    private function _getShopCommentDS()
    {
        return Wekit::LOAD('EXT:4tschool.service.mercomment.App_MerComment');
    }

    /**
     * @return App_Shop
     */
    private function _getShopAreaDs()
    {
        return Wekit::load('EXT:4tschool.service.shoparea.App_Shoparea');
    }

    private function _getTagDs() {
        return Wekit::load('EXT:4tschool.service.tag.App_Tag');
    } 

    /**
     * @return App_SchoolPeople
     */
    private function _getShopSchoolPeople()
    {
        return Wekit::load('EXT:4tschool.service.schoolpeople.App_SchoolPeople');
    }   

}