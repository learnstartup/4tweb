<?php
Wind::import('EXT:4tschool.controller.T4BaseNotLoginController');
Wind::import('EXT:4tschool.service.searches.dm.App_Search_Dm');
class AllshopController extends T4BaseNotLoginController
{

    private $pageNumber = 10;
    private $oriKeyword;
    private $oriType;

    public function run()
    {
        list($aid, $type, $keyword, $page) = $this->getInput(array('aid', 'type', 'keyword', 'page'), 'request');
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
        $promotionalShopList = $this->_getPromotionalmanageDs()->getPromotionalShops($schoolId);
        $shopList = $this->_getSearchDs()->searchShopsByArgs($schoolId,$searchArgs,$limit,$offset);

        $promotionalShopIdList = array();
        $newPromotionalList = array();
        $unNewPromotionalList = array();
        foreach ($promotionalShopList as $key => $value) 
        {
            array_push($promotionalShopIdList, $value['shopid']);
        }

        foreach ($shopList as $key => $value) {
            $shopList[$key]['imageurl'] = Wekit::C('site', 'info.url') .'/src/extensions/4tschool'. str_replace('\\', '/', $value['imageurl']);
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

        $this->setOutput($aid,'aid');
        $this->setOutput($result, "shopList");

        $this->setOutput($count, 'count');
        $this->setOutput($page, 'page');
        $this->setOutput($this->pageNumber, 'perPage');

        $this->outputFilter($searchArgs);

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
            $type = 's';

        //-1. controller
        $baseurl = ($type == 'm'?WindUrlHelper::createUrl('app/4tschool/merchandiselist/run'):WindUrlHelper::createUrl('app/4tschool/allshop/run'));
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

    
}