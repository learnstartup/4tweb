<?php
Wind::import('EXT:4tschool.controller.T4BaseNotLoginController');
Wind::import('EXT:4tschool.controller.T4BaseController');
Wind::import('EXT:4tschool.service.searches.dm.App_Search_Dm');
Wind::import('EXT:4tschool.service.merchandise.dm.App_Merchandise_Dm');
Wind::import('EXT:4tschool.service.merchandise.dm.App_Merchandise_Tag_Dm');
class MerchandiseListController extends T4BaseNotLoginController
{

    private $pageNumber = 10;
    private $oriKeyword;
    private $oriType;

    public function run()
    {
        list($aid, $systid, $type, $keyword, $page, $orderBy, $sort, $hotkey) = $this->getInput(array('aid', 'systid','type', 'keyword', 'page', 'orderby', 'sort', 'hotkey'), 'request');

        $this->setOutput($keyword, "keyword");

        $schoolId = $this->getCurrentSchoolId();
        
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
        $copyPromotionalShopList = $promotionalShopList;
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

        $count = $this->_getSearchDs()->countMerchandisesByArgs($schoolId,$searchArgs);
        if (0 < $count) {
            $totalPage = ceil($count / $this->pageNumber);
            $page > $totalPage && $page = $totalPage;
            list($start, $limit) = Pw::page2limit($page, $this->pageNumber);
            if ($page <= 0)
                $page = 1;
        }
        
        $merchandiseList = $this->_getSearchDs()->searchMerchandisesByArgs($schoolId,$searchArgs,$limit,$start);

        $promotionalShopIdList = array();
        $newPromotionalList = array();
        $unNewPromotionalList = array();
        foreach ($copyPromotionalShopList as $key => $value) 
        {
            array_push($promotionalShopIdList, $value['shopid']);
        }

        foreach ($merchandiseList as $key => $value) {
            $merchandiseList[$key]['imageurl'] = $this->getDomain() . str_replace('\\', '/', $value['imageurl']);
            $merchandiseList[$key]['hasdiscount'] = $merchandiseList[$key]['price'] != $merchandiseList[$key]['currentprice'] ? '1' : '0';
            $merchandiseList[$key]['isopen'] = $this->isOpening($merchandiseList[$key]['orderbegin'], $merchandiseList[$key]['orderend']);

            if(in_array($value['id'], $promotionalShopIdList))
            {
                array_push($newPromotionalList, $merchandiseList[$key]);
            }
            else
            {
                array_push($unNewPromotionalList, $merchandiseList[$key]);
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
        
        $this->setOutput($result, "merchandiseList");
        $this->setOutput($schoolInfo[0], "schoolInfo");

        $this->setOutput($count, 'count');
        $this->setOutput($page, 'page');
        $this->setOutput($this->pageNumber, 'perPage');

        $this->outputFilter($searchArgs);

        if ($sort == 'desc') {
            $sort = 'asc';
            $sortStyle = 'icon';
        } else {
            $sort = 'desc';
            $sortStyle = 'icon';
        }

        $this->setOutput($sort,'sort');
        $this->setOutput($sortStyle,'sortStyle');

        //get tag info by tag id
        if($systid > 0)
            $tagInfo  = $this->_getTagDs()->getTag($systid);
        else
            $tagInfo = array();
        $this->setOutput($tagInfo,'tagInfo');
        
        if($_POST['merchandise'] || $hotkey == 'h')
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

        if($searchArgs['baseprice'] == '1-9')
        {
            $basepricestring = $basepricestring.'10元以下'.$keyword.$ifdeliverfee.$ifdeliver.'外卖的'.$tagInfo['name'].'店铺';
        }
        elseif ($searchArgs['baseprice'] == '10-19') 
        {
            $basepricestring = $basepricestring.'10-20元'.$keyword.$ifdeliverfee.$ifdeliver.'外卖的'.$tagInfo['name'].'店铺';
            
        }elseif ($searchArgs['baseprice'] == '20-10000') 
        {
            $basepricestring = $basepricestring.'20元以上'.$keyword.$ifdeliverfee.$ifdeliver.'外卖的'.$tagInfo['name'].'店铺';
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

    public function merchandiseManageAction()
    {
        $this->_setNavType('merchandise');
        $schoolId = $this->getCurrentSchoolId();
        $this->getWebStatus($schoolId);

        $userId = $this->loginUser->uid;
        $this->isSchoolManage($schoolId, $userId);
        $this->getNoCommentSum($schoolId, $userId);
        
        $myMenus =  $this->_getMyOrderDS()->getMyMenus($schoolId,$this->loginUser->uid);

        $shopList = $this->_getShopDs()->getAllShops(array('schoolid'=>$schoolId,
                                                           'choosenShopid'=>'-1', 
                                                           'isactive'=>'-1', 
                                                           'ispartner'=>'-1',
                                                           'isaudit'=>'-1'));
        $shopList = array_values($shopList);
        $this->setOutput($shopList, 'shopList');

        $choosenShopid = $this->getInput('choosenShopid');
        if(empty($choosenShopid))
        {
            $choosenShopid = $this->getInput('id');
        }

        if (!isset($choosenShopid) || $choosenShopid <= 0) {
            $choosenShopid = $shopList[0]['id'];
        }

        //check if the shop id come from search,
        if ($this->getInput('type', 'post') === 'search') { 
            $choosenShopid = $this->getInput('searchShopid', 'post');
        }

        //分页
        $page = $this->getInput('page');
        $selectedFilter = $this->getInput('selectedFilter');

        $count =  $this->_getMerchandiseDs()->countGetMerchandiseByShopId($choosenShopid, $schoolId);
        if (!empty($selectedFilter))
        {
            $para = explode('_',$selectedFilter);
            $count = $this->_getMerchandiseDs()->CountGetMerchandiseBySpecialFilter($para[0],$para[1], $schoolId);
        }

        if (0 < $count) 
        {
          $totalPage = ceil($count/$this->pageNumber);
          $page > $totalPage && $page = $totalPage;
          list($start, $limit) = Pw::page2limit($page, $this->pageNumber);

          if($page <= 0)
            $page = 1;
        }

        $merchandiseList = $this->_getMerchandiseDs()->getMerchandiseByShopId($choosenShopid, $schoolId, $start, $limit);
        if (!empty($selectedFilter)) {
            $para = explode('_', $selectedFilter);
            $merchandiseList = $this->_getMerchandiseDs()->getMerchandiseBySpecialFilter($para[0],$para[1], $schoolId, $start, $limit);
            $this->setOutput($para[0],"selectedFilter");
        }
        foreach ($merchandiseList as $key => $value) 
        {
            if (empty($merchandiseList[$key]['imageurl'])) {
                //set default image
                $merchandiseList[$key]['imageurl'] = Wekit::C('site', 'info.url') .'/src/extensions/4tschool'. "/uploaded_images/default/sdefault.jpg";
                $merchandiseList[$key]['newimage'] = 'no';
            } else {
                $merchandiseList[$key]['imageurl'] = Wekit::C('site', 'info.url') .'/src/extensions/4tschool'.str_replace('\\', '/', $value['imageurl']);
                $merchandiseList[$key]['newimage'] = 'yes';
            }
        }
        $args['choosenShopid'] = $choosenShopid;
        $args['selectedFilter'] = $selectedFilter;
        $args['isall'] = 'all';
        
        $this->setOutput($choosenShopid, "choosenShopid");
        $this->setOutput($merchandiseList, 'merchandiseList');
        $this->setOutput($count, 'count');  
        $this->setOutput($page, 'page');
        $this->setOutput($args, 'args');
        $this->setOutput($this->pageNumber, 'perPage');
        $this->setOutput($myMenus, 'myMenus');
        $this->setOutput($schoolId, 'schoolId');

        $isall = $this->getInput("isall");
        $this->renderSpecialList($isall);
    }

    public function getNoCommentSum($schoolId, $userid)
    {
        $countNoComment = $this->_getShopCommentDS()->getCountOfMyUnComment($schoolId, $userid);
        $this->setOutput($countNoComment,"countNoComment");
    }

    public function merchandisePreviewAction()
    {
        $id = $this->getInput('id');
        $merchandisepreview = $this->_getMerchandiseDs()->get($id);
        $merchandisepreview['imageurl'] = 'src/extensions/4tschool'. str_replace('\\', '/', $merchandisepreview['imageurl']);
        $this->setOutput($merchandisepreview,'merchandisepreview');
    }

    public function renderSpecialList ($isall){
        if(empty($isall))
        {
            $specialList=array(
            "active"=>array("name"=>"所有未上架的菜","value"=>"0"),
            "recommend"=>array("name"=>"所有推荐菜","value"=>"1")
            );
        }else{
            $specialList=array(
            "active"=>array("name"=>"所有上架的菜","value"=>"0"),
            "recommend"=>array("name"=>"所有推荐菜","value"=>"1")
            );
        }
        $this->setOutput($specialList,"specialList");
    }

    public function merchandiseManagerAddAction()
    {
        //Get all shop, then choose one and add merchandise
        $shopList = $this->_getShopDs()->getAllShops(array('choosenShopid'=>'-1', 
                                                           'isactive'=>'-1', 
                                                           'ispartner'=>'-1',
                                                           'isaudit'=>'-1'));
        $shopList = array_values($shopList);
        $this->setOutput($shopList, 'shopList');
        $choosenShopid = $this->getInput('choosenShopid', 'get');

        //Submit form, get and save new merchandise
        if ($this->getInput('type', 'post') === 'do') {
            $shopid = $this->getInput('choosenShopid', 'post');
            list($foodNameList, 
                 $priceList, 
                 $unitList, 
                 $remainderList, 
                 $descriptionList, 
                 $descriptionUrList, 
                 $tagList,
                 $needPackingPrice,
                 $willRecommend,
                 $isActive) = $this->getInput(array('foodname', 
                                                    'price', 
                                                    'unit', 
                                                    'remainder', 
                                                    'description', 
                                                    'descriptionurl', 
                                                    'tag',
                                                    'needPackingPrice',
                                                    'willRecommend',
                                                    'isActive'), 'post');
            
            //verify data
            if(false == $this->verfiyNotEmpty($foodNameList))
            {
                $this->showError("更新失败,菜品名字不能为空 ");
            }

            if(false == $this->verfiyNotEmpty($priceList))
            {
                $this->showError("更新失败,菜品价格不能为空 ");
            }

            if(false == $this->verfiyNotEmpty($unitList))
            {
                $this->showError("更新失败,菜品单位不能为空 ");
            }

            if(false == $this->verfiyNotEmpty($remainderList))
            {
                $this->showError("更新失败,菜品数量不能为空 ");
            }


            //Merchandise support batch added
            for ($i = 0; $i <= count($foodNameList)-1; $i++) {
                $dm = new App_Merchandise_Dm();
                $dm->setMerchandiseName($foodNameList[$i])
                    ->setShopId($shopid)
                    ->setNeedPackingPrice($needPackingPrice[$i])
                    ->setPrice($priceList[$i])
                    ->setCurrentPrice($priceList[$i])
                    ->setUnit($unitList[$i])
                    ->setRemainder($remainderList[$i])
                    ->setRecommend($willRecommend[$i])
                    ->setActive($isActive[$i])
                    ->setDescription($descriptionList[$i])
                    ->setDescriptionUrl($descriptionUrList[$i])
                    ->setTagId($tagList[$i])
                    ->setCreateDate(Pw::getTime())
                    ->setLastUpdateTime(Pw::getTime());
                $this->_getMerchandiseDs()->add($dm);
            }
            $this->showMessage("添加成功");
            return;
        }
        
        $tagList = $this->_getTagDs()->getTagsByShopId($choosenShopid,true);
        $this->setOutput($tagList, 'tagList');
        $this->setOutput($choosenShopid, 'choosenShopid');
    }

    public function merchandiseManagerImguploadAction()
    {
        $shopId = $this->getInput('sid');
        $merchandiseId = $this->getInput('mid');
        $imageUrl = $this->getInput('url');
        $this->setOutput($shopId, 'shopId');
        $this->setOutput($merchandiseId, 'merchandiseId');
        $this->setOutput($imageUrl, 'imageUrl');

        if ($this->getInput('type', 'post') === 'do' && is_uploaded_file($_FILES["uploadimg"]["tmp_name"])) {
            list($shopId, $merchandiseId, $imageUrl) = $this->getInput(array('shopid', 'merchandiseid', 'imageurl'), 'post');

            if (empty($merchandiseId) || empty($shopId)) {
                $this->showError("未知的错误,请联系管理员");
            }

            $file = $_FILES["uploadimg"];

            if($_FILES['uploadimg']['size']/1024 > 1024)
            {
                $this->showError("图片过大");
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

            $imgName = $merchandiseId . "." . $ext;
            $destination = $destination_folder . $imgName;

            //if the image of current merchandise already exists, change the exists one to history.
            if (file_exists($destination)) {

                $imgHistory = $destination_folder . $merchandiseId . "_" . "hist" . "_" . time() . "." . $ext;
                rename($destination, $imgHistory);
            }

            //save image and stroage url to db.
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                $url = $image_path . $imgName;

                $this->saveUrl($merchandiseId, $url);
                // if (empty($imageUrl)) {
                //  $this->saveUrl($merchandiseId, $url);
                // }
                $this->showMessage("上传成功！");
            }
        }

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

    private function setAreaFilterWidgetData()
    {
        $schoolId = $this->getCurrentSchoolId();

        $areaList = $this->_getSchoolAreaDs()->getBySchoolid($schoolId);

        $schoolName = $areaList[0]['name'];

        $this->setOutput($schoolName, "schoolName");
        $this->setOutput($areaList, "areaList");

        return $areaList;
    }

    private function saveSearchInfomation($keyword,$type)
    {
        $userId=$this->loginUser->uid;
        $schoolId = $this->getCurrentSchoolId();
        if($type == 'h')
        {
            $merchandise = $keyword;
            $type = $type;
        }
        else
        {
            $merchandise = $this->getInput("merchandise");
            $type = $this->getInput("type");
        }
        
        $dm=new App_Search_Dm();
        $dm->setUid($userId)
            ->setSchoolid($schoolId)
            ->setKeyword($merchandise)
            ->setSearchType($type);

        $result=$this->_getSearchDs()->add($dm);
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
        $searchArgs['systid'] = $tagid;
        $searchArgs['baseurl'] = $baseurl;
        $searchArgs['orderby'] = $orderby;
        $searchArgs['sort'] = $sort;

        $searchArgs['target'] = $target;

        return $searchArgs;
    }

    public function merchandiseManagEditAction() 
    {
        $schoolId = $this->getCurrentSchoolId();
        $this->getWebStatus($schoolId);
        
        $userId = $this->loginUser->uid;
        $this->getNoCommentSum($schoolId, $userId);

        $this->isSchoolManage($schoolId, $userId);

        $mid = $this->getInput('id');
        $shopId = $this->getInput('shopid');

        if ($this->getInput('type', 'post') === 'do') {
            $merchandiseId = $this->getInput('id', 'request');
            list($foodName, 
                 $price, 
                 $currentprice, 
                 $unit, 
                 $remainder, 
                 $description,
                 $merchandisedescription, 
                 $descriptionurl, 
                 $tag, 
                 $needPackingPrice, 
                 $willRecommend, 
                 $isActive, 
                 $isStar, 
                 $sysTags) = $this->getInput(array('foodname', 
                                                   'price', 
                                                   'currentprice',
                                                   'unit', 
                                                   'remainder', 
                                                   'description', 
                                                   'merchandisedescription',
                                                   'descriptionurl',
                                                   'choosenTagid',
                                                   'needPackingPrice',
                                                   'willRecommend',
                                                   'isActive', 
                                                   'isStar',
                                                   'systags'), 'post');
                 
            $sysTagList = explode('||', $sysTags);
            $r = $this->_getMerchandiseDs()->deleteMerchandiseTag($merchandiseId);
            if(!empty($sysTagList[0])){
                foreach ($sysTagList as $key => $value) {
                  if (!empty($value)) {
                      $dm = new App_Merchandise_Tag_Dm();
                      $dm->setMid($merchandiseId)
                         ->setTid($value);
                      $this->_getMerchandiseDs()->addMerchandiseTag($dm);
                  }
               }                
            };

            $dm = new App_Merchandise_Dm();
            $dm->setMerchandiseName($foodName)
                ->setPrice($price)
                ->setCurrentPrice($currentprice)
                ->setNeedPackingPrice($needPackingPrice)
                ->setUnit($unit)
                ->setRemainder($remainder)
                ->setActive($isActive)
                ->setIsStar($isStar)
                ->setRecommend($willRecommend)
                ->setDescription($description)
                ->setMerchandiseDescription($merchandisedescription)
                ->setDescriptionUrl($descriptionurl)
                ->setTagId($tag)
                ->setLastUpdateTime(Pw::getTime());

            $result = $this->_getMerchandiseDs()->update($merchandiseId, $dm);
            if ($result == 1) {
                $this->showMessage("更新成功");
            } else {
                $this->showError("更新失败,请联系管理员");
            }
            return;
        }

        $myMenus =  $this->_getMyOrderDS()->getMyMenus($schoolId,$this->loginUser->uid);
        $merchandiseId = $this->getInput('id', 'request');
        $merchandise = $this->_getMerchandiseDs()->getMerchandiseById($merchandiseId);
        $this->setOutput($merchandise, 'merchandise');

        
        $tagList = $this->_getTagDs()->getTagsByShopId($shopId,true);
        $this->setOutput($tagList, 'tagList');

        //set seleted system tag for merchandise
        $selectedSysTagList=$this->_getMerchandiseDs()->getMerchandiseTagsByMid($merchandiseId);
        $sysTagList=$this->_getTagDs()->getSysTags();
        $sysTagList=array_values($sysTagList);
        foreach ($sysTagList as $key => $sysTag) {
            $sysTagList[$key]['selected']="";
            foreach ($selectedSysTagList as $selectedTag) {
                if ($sysTag['id']==$selectedTag['tid']) {
                    $sysTagList[$key]['selected']="selected";
                }
            }
        }
        $this->setOutput($sysTagList, 'sysTagList');     
        $this->setOutput($myMenus, 'myMenus'); 
        $this->setOutput($schoolId, 'schoolId');     
    }

    public function isSchoolManage($schoolId, $userId)
    {
        $ppls = $this->_getSchoolPeopleDS()->getSchoolPeople($schoolId,'master');
        $userids = array();
        foreach ($ppls as $key => $value) 
        {
            array_push($userids, $value['userid']);
        }

        if(!in_array($userId, $userids))
        {
            $this->setTemplate("manage_ifexists");
            return;
        }
        
        $this->setOutput($ppls,"ppls");
    }

    public function isImage($ext) {
        return in_array($ext, array('gif', 'jpg', 'jpeg', 'png', 'bmp', 'swf'));
    }

    public function saveUrl($merchandiseId, $url) {
        $dm = new App_Merchandise_Dm();
        $dm->setImageUrl($url)
            ->setLastUpdateTime(Pw::getTime());
        $result = $this->_getMerchandiseDs()->update($merchandiseId, $dm);
        return $result;
    }

    private function verfiyNotEmpty($dataArray)
    {
        foreach ($dataArray as $key => $value) {
            
            if(empty($value))
                return false;
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

    /**
     * @return App_Search
     */
    private function _getSearchDs()
    {
        return Wekit::load('EXT:4tschool.service.searches.App_Search');
    }

    /**
     * @return App_Tag
     */
    private function _getTagDs()
    {
        return Wekit::load('EXT:4tschool.service.tag.App_Tag');
    }

    private function _getSchoolAreaDs()
    {
        return Wekit::load('EXT:4tschool.service.schoolarea.App_SchoolArea');
    }

    /**
     * @return App_Shop
     */
    private function _getShopDs()
    {
        return Wekit::load('EXT:4tschool.service.shop.App_Shop');
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

    private function _getMerchandiseDs() {
        return Wekit::load('EXT:4tschool.service.merchandise.App_Merchandise');
    }
    private function _getSchoolPeopleDS()
    {
        return Wekit::load('EXT:4tschool.service.schoolpeople.App_SchoolPeople');
    }

    private function _getShopCommentDS()
    {
        return Wekit::load('EXT:4tschool.service.mercomment.App_MerComment');
    }

}