<?php

Wind::import('EXT:4tschool.admin.T4AdminBaseController');
Wind::import('EXT:4tschool.service.shop.dm.App_Shop_Dm');
Wind::import('EXT:4tschool.service.shop.dm.App_Shop_DeliveryTime_Dm');
Wind::import('EXT:4tschool.service.shoparea.dm.App_Shoparea_Dm');

class ShopController extends T4AdminBaseController
{
    private $pageNumber = 10;

    public function run()
    {
        $this->_setNavType('shop');

        $choosenschoolid = -1;
        $isactive = -1;
        $ispartner = -1;
        $isaudit = -1;
        $shopname = '';
        $shopid = '';
        $ifrebate = -1;
        $openordertouser = -1;
        if ($this->getInput('type', 'post') === 'do') 
        {
            list($choosenschoolid, 
                 $isactive, 
                 $ispartner,
                 $isaudit,
                 $shopname,
                 $shopid,
                 $ifrebate,
                 $openordertouser) = $this->getInput(array('choosenschoolid', 
                                                   'isactive', 
                                                   'ispartner',
                                                   'isaudit',
                                                   'shopname',
                                                   'shopid',
                                                   'ifrebate',
                                                   'openordertouser'), 'post'); 
        }

        $status = $this->getInput("status", "GET");
        $yes = $this->getInput("yes", "GET");
        if(!empty($yes))
        {
            $this->_getShopDs()->updateIsDaiKe($status);
            $message = $status?"开启成功！":"关闭成功！";
            $this->setOutput($message, "message");
        }

        $choosenschoolid = $this->getInput("choosenschoolid");
        $this->setOutput($choosenschoolid,"choosenschoolid");

        $isactive = $this->getInput("isactive");
        $this->setOutput($isactive,"isactive");

        $ispartner = $this->getInput("ispartner");
        $this->setOutput($ispartner,"ispartner");

        $isaudit = $this->getInput("isaudit");
        $this->setOutput($isaudit,"isaudit");

        $shopname = $this->getInput("shopname");
        $this->setOutput($shopname,"shopname");

        $shopid = $this->getInput("shopid");
        $this->setOutput($shopid,"shopid");

        $ifrebate = $this->getInput("ifrebate");
        $this->setOutput($shopid,"ifrebate");

        $openordertouser = $this->getInput("openordertouser");
        $this->setOutput($openordertouser,"openordertouser");

        $page = $this->getInput('page');

        $searchCondition = array('schoolid' => $choosenschoolid, 
                                 'isactive' => $isactive,
                                 'ispartner' => $ispartner,
                                 'isaudit' => $isaudit,
                                 'shopname' => $shopname,
                                 'shopid' => $shopid,
                                 'ifrebate' => $ifrebate,
                                 'openordertouser' => $openordertouser);
        $count =  $this->_getShopDs()->countAllShop($searchCondition);

        if (0 < $count) 
        {
          $totalPage = ceil($count/$this->pageNumber);
          $page > $totalPage && $page = $totalPage;
          list($start, $limit) = Pw::page2limit($page, $this->pageNumber);

          if($page <= 0)
            $page =1;
        }
        $shopList = $this->_getShopDs()->getAllShops($searchCondition, $start, $limit);
        $shopList = array_values($shopList);

        $allSchool = $this->_get4TSchoolDS()->getOpenedSchools();
        $allSchool = array_values($allSchool); 

        $args['choosenschoolid'] = $choosenschoolid;
        $args['isactive'] = $isactive;
        $args['ispartner'] = $ispartner;
        $args['isaudit'] = $isaudit;
        $args['shopname'] = $shopname;
        $args['shopid'] = $shopid;
        $args['ifrebate'] = $ifrebate;
        $args['openordertouser'] = $openordertouser;
        
        $this->setOutput($args,"args");
        $this->setOutput($shopList, 'shopList');
        $this->setOutput($allSchool, 'allSchool');
        $this->setOutput($searchCondition, 'searchCondition');
        $this->setOutput($count, 'count');  
        $this->setOutput($page, 'page');
        $this->setOutput($this->pageNumber, 'perPage');
    }

    public function addAction()
    {
        if ($this->getInput('type', 'post') === 'do') {

            list($userid,
                $mastername,
                $choosenSchoolId, 
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
                $isAudit,
                $isPartner, 
                $hasTerminal, 
                $hasPrint,
                $isShopOpen,
                $ifRebate,
                $rebateFromShop,
                $openOrderToUser,
                $actualmakeordertime,
                $actualbakeouttime,
                $actualtocentertime,
                $actualdeliverytime,
                $deliveryprice,
                $lat,
                $lng,
                $startingprice) = $this->getInput(array('choosenUserid',
                                                        'mastername',
                                                        'choosenSchoolid',
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
                                                        'isaudit',
                                                        'ispartner',
                                                        'hasterminal',
                                                        'hasprint',
                                                        'isshopopen',
                                                        'ifrebate',
                                                        'rebatefromshop',
                                                        'openordertouser',
                                                        'actualmakeordertime',
                                                        'actualbakeouttime',
                                                        'actualtocentertime',
                                                        'actualdeliverytime',
                                                        'deliveryprice', 
                                                        'lat', 
                                                        'lng', 
                                                        'startingprice'), 'post');

            $rebateFromShop = (!$ifRebate)?0:$rebateFromShop;

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

            if ($rebateFromShop >= 1) {
                $this->showError('商家返利不能大于1');
                return;
            }

            $nameDuplicate = $this->_getShopDs()->checkDuplicateInfo('name', $shopName, 'new');
            if ($nameDuplicate) {
                $this->showError('商家名:' . '"' . $shopName . '"' . '已存在');
                return;
            }

            $dm = new App_Shop_Dm();
            $dm->setUserId($userid)
                ->setMasterId($mastername)
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
                ->setIsAudit($isAudit)
                ->setIsPartner($isPartner)
                ->setHasTerminal($hasTerminal)
                ->setHasPrint($hasPrint)
                ->setIsShopOpen($isShopOpen)
                ->setIfRebate($ifRebate)
                ->setRebateFromShop($rebateFromShop)
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

            if ($id > 0 && $this->shopDeliveryTimeHandle($id) && $this->saveShopSchool($id, $choosenSchoolId)) {
                $this->showMessage('添加成功');
            } else {
                $this->showError('更新失败,请联系管理员');
            }            
        } else {
            $allProvince = $this->_getAreaDs()->getAreaByParentid(0);
            $allProvince = array_values($allProvince);
            //check if has province id or not, if has, then school list need to based on that
            //get province from url
            $choosenProvinceid = $this->getInput('choosenProvinceid');
            if (!isset($choosenProvinceid) || $choosenProvinceid <= 0) {
                $choosenProvinceid = $allProvince[0]['areaid'];
            }

            $agents = $this->_getShopSchoolPeople()->getPeopleByType('master');

            $allSchool = $this->_get4TSchoolDS()->getOpenedSchools();
            $allSchool = array_values($allSchool);
            $this->setOutput($allSchool, 'allSchool');

            $choosenSchoolid = $this->getInput('choosenSchoolid');
            if (!isset($choosenSchoolid) || $choosenSchoolid <= 0) {
                $choosenSchoolid = $allSchool[0]['schoolid'];
            }

            $userList = $this->_getSchoolPeopleDS()->getSchoolPeople($choosenSchoolid, 'shopaccount');
            $master = $this->_getSchoolPeopleDS()->getMasterId($choosenSchoolid, 'master');

            Wind::import('EXT:4tschool.service.dm.App_SchoolArea_Dm');
            $areaList = Wekit::load('EXT:4tschool.service.schoolarea.App_SchoolArea')->getBySchoolid($choosenSchoolid);

            $this->setOutput($userList, 'userList');
            $this->setOutput($choosenProvinceid, 'choosenProvinceid');
            $this->setOutput($choosenSchoolid, 'choosenSchoolid');
            $this->setOutput($areaList, 'areaList');
            $this->setOutput($agents, 'agents');
            $this->setOutput($allProvince, 'allProvince');
        }
    }

    public function editAction()
    {
        list($userid, 
            $mastername,
            $choosenSchoolId,
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
            $isAudit,
            $isPartner, 
            $hasTerminal,
            $hasPrint,
            $isShopOpen,
            $ifRebate,
            $rebateFromShop,
            $openOrderToUser,
            $actualmakeordertime,
            $actualbakeouttime,
            $actualtocentertime,
            $actualdeliverytime,
            $deliveryprice,
            $lat,
            $lng,
            $startingprice) = $this->getInput(array('choosenUserid',
                                                    'mastername',
                                                    'choosenSchoolId', 
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
                                                    'isaudit',
                                                    'ispartner', 
                                                    'hasterminal',
                                                    'hasprint',
                                                    'isshopopen',
                                                    'ifrebate',
                                                    'rebatefromshop',
                                                    'openordertouser',
                                                    'actualmakeordertime',
                                                    'actualbakeouttime',
                                                    'actualtocentertime',
                                                    'actualdeliverytime',
                                                    'deliveryprice',
                                                    'lat',
                                                    'lng',
                                                    'startingprice'), 'post');
        if ($this->getInput('type', 'post') === 'do') {

            $rebateFromShop = (!$ifRebate)?0:$rebateFromShop;
            
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

            if ($rebateFromShop >= 1) {
                $this->showError('商家返利不能大于1');
                return;
            }

            $shopId = $this->getInput('id', 'request');
            $nameDuplicate = $this->_getShopDs()->checkDuplicateInfo('name', $shopName, $shopId);
            if ($nameDuplicate) {
                $this->showError('商家名:' . '"' . $shopName . '"' . '已存在');
                return;
            }

            $dm = new App_Shop_Dm();
            $dm->setUserId($userid)
                ->setMasterId($mastername)
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
                ->setIsAudit($isAudit)
                ->setIsPartner($isPartner)
                ->setHasTerminal($hasTerminal)
                ->setHasPrint($hasPrint)
                ->setIsShopOpen($isShopOpen)
                ->setIfRebate($ifRebate)
                ->setRebateFromShop($rebateFromShop)
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
                $this->showMessage('更新成功');
            } else {
                $this->showError('更新失败,请联系管理员');
            }
        } else {
            $isChange = $this->getInput('isChange');
            $shopId = $this->getInput('id', 'request');
            $shop = $this->_getShopDs()->getByShopId($shopId);
            if (empty($shop)) {
                $this->showError("Invalid data");
            }

            $choosenProvinceid = isset($isChange) ? $this->getInput('choosenProvinceid') : $shop['provinceid'];
            $choosenSchoolid = isset($isChange) ? $this->getInput('choosenSchoolid') : $shop['schoolid'];
            $agents = $this->_getShopSchoolPeople()->getPeopleByType('master');

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
        }
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

    public function imguploadAction()
    {
        $shopId = $this->getInput('sid');
        $imageUrl = $this->getInput('url');
        $this->setOutput($shopId, 'shopId');
        $this->setOutput($imageUrl, 'imageUrl');

        if ($this->getInput('type', 'post') === 'do' && is_uploaded_file($_FILES["uploadimg"]["tmp_name"])) {
            list($shopId, $imageUrl) = $this->getInput(array('shopid', 'imageurl'), 'post');

            if (empty($shopId)) {
                $this->showError("未知的错误,请联系管理员");
            }

            $file = $_FILES["uploadimg"];

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

    private function _getSchoolDs()
    {
        return Wekit::load('WINDID:service.school.WindidSchool');
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
     * @return App_SchoolPeople
     */
    private function _getSchoolPeopleDS()
    {
        return Wekit::load('EXT:4tschool.service.schoolpeople.App_SchoolPeople');
    }

    /**
     * @return App_Shop
     */
    private function _getShopAreaDs()
    {
        return Wekit::load('EXT:4tschool.service.shoparea.App_Shoparea');
    }

    /**
     * @return App_SchoolPeople
     */
    private function _getShopSchoolPeople()
    {
        return Wekit::load('EXT:4tschool.service.schoolpeople.App_SchoolPeople');
    }
}