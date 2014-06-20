<?php
Wind::import('EXT:4tschool.service.tag.dm.App_Tag_Dm');
Wind::import('EXT:4tschool.controller.T4BaseNotLoginController');

/**
 */
class ShopadvantageController extends T4BaseNotLoginController {

    private $pageNumber = 10;

	public function beforeAction($handlerAdapter) {
		parent::beforeAction($handlerAdapter);

	}

	public function run()
	{

	}


	public function shopMerchdiseAction()
	{

		$this->getShopMenu();

        //judge if the shop already marked by current user
        $userId = $this->loginUser->uid;
        $this->setOutput($userId, 'userId');
        $shopMeg = $this->getShopMsgByUserId($userId);

        $defaultSelected = null;
        $merchandiseList = $this->_getMerchandiseDs()->getActiveMerchandiseByShopId($shopMeg['id']);
        
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

        $this->setOutput($shop, 'shop');
        $this->setOutput($tagList, 'tagList');
        
        $this->setOutput($merchandiseList, 'merchandiseList');

        $this->setOutput('我家菜单','selectedMenu');
        $this->setOutput('我家菜单','subtitle');

		
	}

	public function orderStatisticsAction()
	{
		$this->getShopMenu();

		$startDate = $this->getInput('startDate');
        $endDate = $this->getInput('endDate');
        $shopid = $this->getInput('shopid');

        $today = date('Y-m-d');
        $todayDateArray = getdate(strtotime($today));
        
        $userId = $this->loginUser->uid;
        $shopMeg = $this->getShopMsgByUserId($userId);

        //check start date and end date, if start date is empty, then it need to be previous month day 1
        //if end date is empty, it need to be previous month day last day
        if(empty($startDate))
        {
            $fromTime = mktime(0, 0, 0, $todayDateArray['mon'] -1, 1, $todayDateArray['year']);
            $startDate = date('Y-m-d', $fromTime);
        }

        if(empty($endDate))
        {
            $fromTime = mktime(-24, 0, 0, $todayDateArray['mon'], 1, $todayDateArray['year']);
            $endDate = date('Y-m-d', $fromTime);
        }

        if(empty($shopid) == false)
        {
            $this->setOutput($shopid,'shopid');
        }
        else
            $shopid = 0;  

        $this->setOutput($startDate,'startDate');
        $this->setOutput($endDate,'endDate');

        $ShopSales = $this->_getShopDailySaleDs()->getSaleByShop($shopMeg['id'],$startDate,$endDate);
        $this->setOutput($ShopSales,'ShopSales');

		$this->setOutput('外卖统计','selectedMenu');
	}

	public function shopOrderAction()
	{
		$this->getShopMenu();

        $startDate = $this->getInput('startDate');
        $endDate = $this->getInput('endDate');
        
        $today = date('Y-m-d');
        $todayDateArray = getdate(strtotime($today));

        if(empty($startDate))
        {
            $fromTime = mktime(0, 0, 0, $todayDateArray['mon'] -1, 1, $todayDateArray['year']);
            $startDate = date('Y-m-d', $fromTime);
        }

        if(empty($endDate))
        {
            $fromTime = mktime(-24, 0, 0, $todayDateArray['mon'], 1, $todayDateArray['year']);
            $endDate = date('Y-m-d', $fromTime);
        }

        $days = 31;

        $userId = $this->loginUser->uid;
        $shopMeg = $this->getShopMsgByUserId($userId);

        // get order status, except cancelled order
        $statusArray = $this->_getMyOrderDS()->getAllStatus();
        unset($statusArray['0']);
        unset($statusArray['1']);
        unset($statusArray['7']);

        $startstrtotime = strtotime($startDate);
        $endstrtotime = strtotime($endDate);

        $page = $this->getInput('page');
        $count = $this->_getMyOrderDS()->getCountShopOrders(
            $shopMeg['id'],0,$statusArray,'',-1,2,0,$startstrtotime,$endstrtotime);
        if (0 < $count) 
        {
            $totalPage = ceil($count/$this->pageNumber);
            $page > $totalPage && $page = $totalPage;
            list($start, $limit) = Pw::page2limit($page, $this->pageNumber);

            if($page <= 0)
                $page =1;
        }

        $orderList = $this->_getMyOrderDS()->getShopOrdersByShopId($shopMeg['id'],0,$statusArray,'',-1,2,0,$startstrtotime,$endstrtotime,$limit,$start);

        $orderTotalMoney = $this->_getMyOrderDS()->countShopOrderMoney($shopMeg['id'],0,$statusArray,'',-1,2,0,$startstrtotime,$endstrtotime);
        $this->setOutput($orderTotalMoney,"orderTotalMoney");

        //get order ids and get its order items
        $orderIds = " -1 ";
        foreach($orderList as $key => &$eachOrder)
        {
            $orderIds = $orderIds.",".$eachOrder['id'];
        }

        $orderIds = $orderIds." ,-1 ";

        $orderItems = $this->_getMyOrderDS()->getOrderItemByOrderIds($orderIds);
        foreach($orderList as $key=>&$value)
        {
            foreach ($orderItems as $key1 => $value1) {
                if($value1['orderid']== $value['id'])
                {
                    $value['phonenumber'] = $value1['phonenumber'];
                    $value['contactnumber'] = $value1['contactnumber'];
                    break;
                }
            }
        }

        $this->setOutput($startDate,'startDate');
        $this->setOutput($endDate,'endDate');
        $this->setOutput($orderList,'orderList');
        $this->setOutput($orderItems,'orderItems');
		$this->setOutput('订单列表','selectedMenu');

        $this->setOutput($count, 'count');  
        $this->setOutput($page, 'page');
        $this->setOutput($this->pageNumber, 'perPage'); 
        $this->setOutput($args,"args");
	}

    public function shopcommentAction()
    {
        $myMenus =  $this->_getShopMerchdiseDS()->getMyMenus();

        $userId = $this->loginUser->uid;

        $shopMeg = $this->getShopMsgByUserId($userId);

        $count = $this->_getShopDs()->countGetShopComment($shopMeg['id']);

        $page = $this->getInput('page');

        if (0 < $count) 
        {
            $totalPage = ceil($count/$this->pageNumber);
            $page > $totalPage && $page = $totalPage;
            list($start, $limit) = Pw::page2limit($page, $this->pageNumber);

            if($page <= 0)
                $page =1;
        }

        $shopComment = $this->_getShopDs()->getShopComment($shopMeg['id'], $limit, $start);

        foreach ($shopComment as $key => $value) {
            $newusername = $this->half_replace($value['username']);
            $shopComment[$key]['username'] = $newusername;
            if($value['speed'] <= 15){
                $shopComment[$key]['speed'] = '火箭';
            }elseif ($value['speed'] <= 30 && $value['speed'] > 15) {
                $shopComment[$key]['speed'] = '飞机';
            }elseif ($value['speed'] <= 45 && $value['speed'] > 30) {
                $shopComment[$key]['speed'] = '汽车';
            }elseif ($value['speed'] <= 60 && $value['speed'] > 45) {
                $shopComment[$key]['speed'] = '步行';
            }else{
                $shopComment[$key]['speed'] = '爬行';
            }
        }

        $this->setOutput($userId, 'userId');
        $this->setOutput('用户评论','selectedMenu');
        $this->setOutput($myMenus,'myMenus');
        $this->setOutput($shopComment,'shopComment');
        $this->setOutput($count, 'count');  
        $this->setOutput($page, 'page');
        $this->setOutput($this->pageNumber, 'perPage');
    }

	public function getShopMenu()
	{
		$myMenus =  $this->_getShopMerchdiseDS()->getMyMenus($userid);
		
		$this->setOutput($myMenus,'myMenus');
	}

	private function calculateMerchandiseDMoneyByPrice ($price)
    {
        $rate = $this->_cur_shop['rebatefromshop'];
        $rmbShopReturn = $price * $rate;
        $rmbforUser = $this->_getShopDailySaleDs()->getUserProfit($rmbShopReturn);
        $DMoney = $rmbforUser * 10;
        return $DMoney;
    }

    public function getShopMsgByUserId($userId){
        if($userId<=0){
            $this->forwardRedirect(WindUrlHelper::createUrl('u/login/run'));
        }

        $shopMeg = $this->_getShopDs()->getShopPrintHasterminal($userId);
        if(empty($shopMeg)){
            $this->setTemplate("shopnotexist");
        }
        return $shopMeg;   
    }

    function half_replace($str){
        $len = strlen($str)/2;
        return substr_replace($str,str_repeat('*',$len),ceil(($len)/2),$len);
    }




    public function shopTagManageAction (){
        //$schoolId = $this->getCurrentSchoolId();
        $userId = $this->loginUser->uid;
        //$myMenus =  $this->_getMyOrderDS()->getMyMenus($schoolId,$this->loginUser->uid);
        //$this->setOutput($myMenus, 'myMenus');  

        $shopMeg = $this->getShopMsgByUserId($userId);

        $this->getShopMenu();

        $this->setOutput($shopMeg['id'],'shopId');      
        $tags=$this->_getTagDs()->getTagsByShopId($shopMeg['id']);
        $this->setOutput($tags,'tags');
        $this->setOutput('我家菜单','selectedMenu');
        $this->setOutput('我家菜单','subtitle');
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





	private function _getShopMerchdiseDS()
	{
		return Wekit::load('EXT:4tshop.service.shopmerchdise.App_MyShop');
	}

	/**
     * @return App_Merchandise
     */
    private function _getMerchandiseDs()
    {
        return Wekit::load('EXT:4tschool.service.merchandise.App_Merchandise');
    }

    /**
     * @return App_ShopDailySale
     */
    private function _getShopDailySaleDs()
    {
        return Wekit::load('EXT:4tschool.service.shopdailysale.App_ShopDailySale');
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
     * @return App_Tag
     */
    private function _getTagDs() {
        return Wekit::load('EXT:4tschool.service.tag.App_Tag');
    } 

}