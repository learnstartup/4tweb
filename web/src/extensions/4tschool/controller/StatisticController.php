<?php
Wind::import('EXT:4tschool.controller.T4BaseController');
/**
 */
class StatisticController extends T4BaseController {

	
	private $pageNumber = 10;

	public function beforeAction($handlerAdapter) {
		parent::beforeAction($handlerAdapter);

	}

		
	public function run() {

		//need to check user's role
		//this function only be able to used by 

		//set selected menu
		$this->setOutput('商品销量统计','selectedMenu');
		$this->setOutput("商品销量统计","subtitle");

		//we need to do some validation to make it safe
		$schoolId = $this->getCurrentSchoolId();

		//check if can visit or not
		$canVisist = $this->_getMyOrderDS()->canVisitLink($schoolId,'商店商品销量统计',$this->loginUser->uid);
		if($canVisist == false)
		{
			$this->forwardRedirect(WindUrlHelper::createUrl('app/4tschool/index/run'));
		}

		$myMenus =  $this->_getMyOrderDS()->getMyMenus($schoolId,$this->loginUser->uid);
		$this->setOutput($myMenus,'myMenus');

		$todaytime =  strtotime('today');
    	$lastRetriveTime = date("Y-m-d",$todaytime);

		$fromTime = $this->getInput("fromTime");
		if(empty($fromTime))
		{
			$fromTime =  $lastRetriveTime;
		}
		$this->setOutput($fromTime,"fromTime");


		$toTime = $this->getInput("toTime");
		if(empty($toTime))
		{
			$toTime =  $lastRetriveTime;
		}
		$this->setOutput($toTime,"toTime");

		//re-format, say 2013-07-02 to 2013-07-03, shall be 2013-07-02 00:00:00 to 2013-07-03 23:59:59
		//need to use a helper method
		$fromTime = $this->stringToDateLowerest($fromTime);
		$toTime = $this->stringToDateBiggest($toTime);
		
		//交易成功的订单
		$shopMOrders = $this->_getMyOrderDS()->getOrdersGroupbyShop($schoolId,0,$this->_getMyOrderDS()->getStatusArray(2), $fromTime,$toTime);
		$totalShops = count($shopMOrders);
		$this->setOutput($totalShops,'totalShops');
		$totalMoneys = 0;
		foreach ($shopMOrders as $key => $eachShop) {
			$totalMoneys = $totalMoneys + $eachShop['PayTotal'];
		}
		$this->setOutput($totalMoneys,'totalMoneys');
		$this->setOutput($shopMOrders,"shopMOrders");

		$userid = $this->loginUser->uid;
		$this->getNoCommentSum($schoolId, $userid);

		//交易进行中的订单
		$shopMInProgressOrders = $this->_getMyOrderDS()->getOrdersGroupbyShop($schoolId,0,$this->_getMyOrderDS()->getStatusArray(1), $fromTime,$toTime);
		$totalInProgressShops = count($shopMInProgressOrders);
		$this->setOutput($totalInProgressShops,'totalInProgressShops');
		$totalInProgressMoneys = 0;
		foreach ($shopMInProgressOrders as $key => $eachShop) {
			$totalInProgressMoneys = $totalInProgressMoneys + $eachShop['PayTotal'];
		}
		$this->setOutput($totalInProgressMoneys,'totalInProgressMoneys');
		$this->setOutput($shopMInProgressOrders,"shopMInProgressOrders");
		$this->setOutput($schoolId,"schoolId");

	}

	public function getNoCommentSum($schoolId, $userid)
	{
		$countNoComment = $this->_getShopCommentDS()->getCountOfMyUnComment($schoolId, $userid);
        $this->setOutput($countNoComment,"countNoComment");
	}

	//负责配送的人员的统计
	public function deliveryAction()
	{
		//set selected menu
		$this->setOutput('配送人员配送统计','selectedMenu');
		$this->setOutput("配送人员配送统计","subtitle");

		//we need to do some validation to make it safe
		$schoolId = $this->getCurrentSchoolId();

		//check if can visit or not
		$canVisist = $this->_getMyOrderDS()->canVisitLink($schoolId,'配送人员配送统计',$this->loginUser->uid);
		if($canVisist == false)
		{
			$this->forwardRedirect(WindUrlHelper::createUrl('app/4tschool/index/run'));
		}

		$myMenus =  $this->_getMyOrderDS()->getMyMenus($schoolId,$this->loginUser->uid);
		$this->setOutput($myMenus,'myMenus');

		$todaytime =  strtotime('today');
    	$lastRetriveTime = date("Y-m-d",$todaytime);

		$fromTime = $this->getInput("fromTime");
		if(empty($fromTime))
		{
			$fromTime =  $lastRetriveTime;
		}
		$this->setOutput($fromTime,"fromTime");


		$toTime = $this->getInput("toTime");
		if(empty($toTime))
		{
			$toTime =  $lastRetriveTime;
		}
		$this->setOutput($toTime,"toTime");

		//re-format, say 2013-07-02 to 2013-07-03, shall be 2013-07-02 00:00:00 to 2013-07-03 23:59:59
		//need to use a helper method
		$fromTime = $this->stringToDateLowerest($fromTime);
		$toTime = $this->stringToDateBiggest($toTime);

		$statusArray = $this->_getMyOrderDS()->getAllStatus();
		unset($statusArray['7']); //客户取消的单子
		
		//交易完成的订单
		$deliveryMOrders = $this->_getMyOrderDS()->getOrdersGroupbyDelivery($schoolId,0,$statusArray, $fromTime,$toTime);

		$notfinishedOrder = false;
		foreach ($deliveryMOrders as $key => $eachDelivery) {
			$totalMoneys = $totalMoneys + $eachDelivery['totalMoney'];
			$totalOrders = $totalOrders + $eachDelivery['totalOrder'];
			//totalAcceptMoney
			$totalAcceptMoney = $totalAcceptMoney + $eachDelivery['totalAcceptMoney'];
			//totalQuantity
			$totalQuantity = $totalQuantity + $eachDelivery['totalQuantity'];
			//totalBonusQuantity
			$totalBonusQuantity = $totalBonusQuantity + $eachDelivery['totalBonusQuantity'];
			//totalShunDaiQuantity
			$totalShunDaiQuantity = $totalShunDaiQuantity + $eachDelivery['totalShunDaiQuantity'];
			//totalNoBonusQuantity
			$totalNoBonusQuantity = $totalNoBonusQuantity + $eachDelivery['totalNoBonusQuantity'];

			$notfinishedOrder = $notfinishedOrder | $eachDelivery['NotFinishOrder'];
		}

		$total = array("totalMoney" => $totalMoney,
						"totalOrder"	=> $totalOrders,
						"totalAcceptMoney"  => $totalAcceptMoney,
						"totalQuantity"	=> $totalQuantity,
						"totalBonusQuantity"	=> $totalBonusQuantity,
						"totalShunDaiQuantity"	=> $totalShunDaiQuantity,
						"totalNoBonusQuantity"	=> $totalNoBonusQuantity,
						"deliverby"	=> '汇总',
						"NotFinishOrder" => $notfinishedOrder
						);
		$deliveryMOrders[] = $total;

		$this->setOutput($deliveryMOrders,"deliveryMOrders");
		$this->setOutput($schoolId,"schoolId");


	}


	//负责下单的人员的统计
	public function orderforAction()
	{
		//set selected menu
		$this->setOutput('下单人员下单统计','selectedMenu');
		$this->setOutput("下单人员下单统计","subtitle");

		//we need to do some validation to make it safe
		$schoolId = $this->getCurrentSchoolId();

		//check if can visit or not
		$canVisist = $this->_getMyOrderDS()->canVisitLink($schoolId,'下单人员下单统计',$this->loginUser->uid);
		if($canVisist == false)
		{
			$this->forwardRedirect(WindUrlHelper::createUrl('app/4tschool/index/run'));
		}

		$myMenus =  $this->_getMyOrderDS()->getMyMenus($schoolId,$this->loginUser->uid);
		$this->setOutput($myMenus,'myMenus');

		$todaytime =  strtotime('today');
    	$lastRetriveTime = date("Y-m-d",$todaytime);

		$fromTime = $this->getInput("fromTime");
		if(empty($fromTime))
		{
			$fromTime =  $lastRetriveTime;
		}
		$this->setOutput($fromTime,"fromTime");


		$toTime = $this->getInput("toTime");
		if(empty($toTime))
		{
			$toTime =  $lastRetriveTime;
		}
		$this->setOutput($toTime,"toTime");

		//re-format, say 2013-07-02 to 2013-07-03, shall be 2013-07-02 00:00:00 to 2013-07-03 23:59:59
		//need to use a helper method
		$fromTime = $this->stringToDateLowerest($fromTime);
		$toTime = $this->stringToDateBiggest($toTime);

		//template
		$template = array("totalMoney" => 0,
						"totalOrders"	=> 0,
						"totalQuantity"	=> 0,
						"totalBonusQuantity"	=> 0,
						"totalShunDaiQuantity"	=> 0,
						"totalNoBonusQuantity"	=> 0
						);

		$schedules = $this->_getSchoolPeopleDS()->getPeopleSchedule(0,$schoolId,0,$fromTime,$toTime);
		$userSchedule= array();
		$userStatistic = array();
		$users = array();
		//get user schedule
		foreach ($schedules as $day => $shopSchedules) {
			foreach ($shopSchedules as $shopid => $eachShopSchedules) {
				foreach ($eachShopSchedules as $key => &$eachSchedule) {
					
					//get orders based on order create time
					$eachSchedule['datetimeBegin'] = $day." ".$eachSchedule['datetimeBegin'];
					$eachSchedule['datetimeEnd'] = $day." ".$eachSchedule['datetimeEnd'];
					$userid = $eachSchedule['userid'];
					$users[] = $userid;
					
					$userSchedule[$userid][] = $eachSchedule;

					if(!array_key_exists($userid, $userStatistic))
					{
						$userStatistic[$userid] = $template;
					}
				}
			}
		}
	
		//get orders by order create time
		$statusArray = $this->_getMyOrderDS()->getAllStatus();
		unset($statusArray['7']); //客户取消的单子
		unset($statusArray['-1']); //缺货的单子
		unset($statusArray['0']); //等待授理的单子

		$shops = $this->_getShopDS()->getBySchoolId($schoolId);
		$shops[] = array("id" => $this->getIncidentallyShopId(),"name" => "顺带");

		$shopNames = array();
		foreach ($shops as $key => $eachShop) {
			$shopNames[$eachShop['id']] = $eachShop['name'];
		}

		$this->setOutput($shopNames,"shopNames");

		$shopids = ' -1 ';
		foreach ($shops as $key => $eachShop) {
			$shopids = $shopids.",".$eachShop['id'];
		}

		$userInfos = $this->_getUserDS()->fetchUserByUid($users);

		$ordersByTiming = $this->_getMyOrderDS()->getOrderItemsByShops($shopids,$statusArray,$fromTime);
		foreach ($ordersByTiming as $key => $eachorderitem) {
			
			$shopid = $eachorderitem['shopid'];
			$orderdate = $eachorderitem['orderdate'];
			$needPackingPrice = $eachorderitem['needPackingPrice'];
			$currentPrice = $eachorderitem['currentprice'];
			$quatity = $eachorderitem['quatity'];
			$packingprice = $eachorderitem['packingprice'];


			foreach($userSchedule as $userid => $eachSchedules)
			{
				$match = $this->matchesInSchedule($shopid,$orderdate,$eachSchedules);
				if($match)
				{

					$userStatistic[$userid]['totalOrders'] = $userStatistic[$userid]['totalOrders'] + 1;
					$userStatistic[$userid]['totalQuantity'] = $userStatistic[$userid]['totalQuantity'] + $quatity;

					//user's shops information
					$userStatistic[$userid]['shop'][$shopid]['totalOrders'] = $userStatistic[$userid]['shop'][$shopid]['totalOrders'] + 1;
					$userStatistic[$userid]['shop'][$shopid]['totalQuantity'] = $userStatistic[$userid]['shop'][$shopid]['totalQuantity'] + $quatity;


					if($shopid == $this->getIncidentallyShopId())
					{
						$calPrice = $currentPrice * $quatity;
						$userStatistic[$userid]['totalShunDaiQuantity'] = $userStatistic[$userid]['totalShunDaiQuantity'] + $quatity;
						$userStatistic[$userid]['totalMoney'] = $userStatistic[$userid]['totalMoney'] + $calPrice;

						//user's shops information
						$userStatistic[$userid]['shop'][$shopid]['totalShunDaiQuantity'] = $userStatistic[$userid]['shop'][$shopid]['totalShunDaiQuantity'] + $quatity;
						$userStatistic[$userid]['shop'][$shopid]['totalMoney'] = $userStatistic[$userid]['shop'][$shopid]['totalMoney'] + $calPrice;

						continue;
					}

					if($needPackingPrice == 1)
					{
						$calPrice = ($currentPrice + $packingprice) * $quatity ;
						$userStatistic[$userid]['totalMoney'] = $userStatistic[$userid]['totalMoney'] + $calPrice;
						$userStatistic[$userid]['totalBonusQuantity'] = $userStatistic[$userid]['totalBonusQuantity'] + $quatity;

						//user's shops information
						$userStatistic[$userid]['shop'][$shopid]['totalMoney'] = $userStatistic[$userid]['shop'][$shopid]['totalMoney'] + $calPrice;
						$userStatistic[$userid]['shop'][$shopid]['totalBonusQuantity'] = $userStatistic[$userid]['shop'][$shopid]['totalBonusQuantity'] + $quatity;

					}
					else
					{
						$calPrice = $currentPrice * $quatity;
						$userStatistic[$userid]['totalMoney'] = $userStatistic[$userid]['totalMoney'] + $calPrice;
						$userStatistic[$userid]['totalNoBonusQuantity'] = $userStatistic[$userid]['totalNoBonusQuantity'] + $quatity;

						////user's shops information
						$userStatistic[$userid]['shop'][$shopid]['totalMoney'] = $userStatistic[$userid]['shop'][$shopid]['totalMoney'] + $calPrice;
						$userStatistic[$userid]['shop'][$shopid]['totalNoBonusQuantity'] = $userStatistic[$userid]['shop'][$shopid]['totalNoBonusQuantity'] + $quatity;
					}
				}
			}
		}

		foreach ($userStatistic as $key => $eachStatistic) {
			
			$userStatistic[-1]['totalMoney'] += $eachStatistic['totalMoney'];
			$userStatistic[-1]['totalQuantity'] += $eachStatistic['totalQuantity'];
			$userStatistic[-1]['totalOrders'] += $eachStatistic['totalOrders'];
			$userStatistic[-1]['totalShunDaiQuantity'] += $eachStatistic['totalShunDaiQuantity'];
			$userStatistic[-1]['totalBonusQuantity'] += $eachStatistic['totalBonusQuantity'];
			$userStatistic[-1]['totalNoBonusQuantity'] += $eachStatistic['totalNoBonusQuantity'];

		}

		$userInfos['-1']['username'] = "汇总";

		$this->setOutput($userStatistic,"userStatistic");
		$this->setOutput($userInfos,"userInfos");
		$this->setOutput($schoolId,"schoolId");
	}

	private function matchesInSchedule($shopid,$orderdate,$eachSchedules)
	{
		foreach($eachSchedules as $key => $schedule)
		{
			
			if($schedule['shopid'] == $shopid
				&& $schedule['datetimeBegin'] <= $orderdate
				&& $schedule['datetimeEnd'] >= $orderdate)
			{
				return true;
			}
		}

		return false;
	}

	protected function getIncidentallyShopId()
    {
        return 28;
    }


    /**
     * @return App_MyOrder
     */
	private function _getMyOrderDS()
	{
		return Wekit::load('EXT:4tschool.service.myorder.App_MyOrder');
	}

	private function _getMyFavoriteDS()
	{
		return Wekit::load('EXT:4tschool.service.myfavorite.App_MyFavorite');
	}

	private function _getUserMobileDS()
	{
		return Wekit::load('SRV:user.PwUserMobile');
	}

	private function _getSchoolAreaDS()
	{
		return Wekit::load('EXT:4tschool.service.schoolarea.App_SchoolArea');
	}

	private function _getSchoolDS()
	{
		return Wekit::load('EXT:4tschool.service.school.App_School');
	}

	private function _getSchoolPeopleDS()
	{
		return Wekit::load('EXT:4tschool.service.schoolpeople.App_SchoolPeople');
	}

	private function _getMerchandiseDS()
	{
		return Wekit::load('EXT:4tschool.service.merchandise.App_Merchandise');
	}

	private function _getShopDS()
	{
		return Wekit::load('EXT:4tschool.service.shop.App_Shop');
	}

	private function _getSearchDS()
	{
		return Wekit::load('EXT:4tschool.service.searches.App_Search');
	}

	private function _getMyMoneyDS()
	{
		return Wekit::load('EXT:4tschool.service.mymoney.App_MyMoney');
	}

	private function _getUserDS()
	{
		return Wekit::load('SRV:user.PwUser');
	}

	private function _getShopCommentDS()
    {
        RETURN Wekit::LOAD('EXT:4tschool.service.mercomment.App_MerComment');
    }

}