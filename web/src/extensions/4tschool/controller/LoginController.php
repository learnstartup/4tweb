<?php

/**
 */
class LoginController extends PwBaseController {

	private $pageNumber = 10;

	public function beforeAction($handlerAdapter) {
		parent::beforeAction($handlerAdapter);

		echo "<pre/>";

		$orderStatuses = $this->_getMyOrderDS()->getAllStatus();

		$shopOrders = $this->_getMyOrderDS()->getShopOrders(1,
												11045,
												1,
												$orderStatuses,
												'',
												-1,
												2,
												0);

		print_r($shopOrders);
		//UPDATE  `pw4t`.`pw_windid_user` SET  `password` =  'b3ff2df1b3ca95d9ae2c03d93f821201' WHERE  `pw_windid_user`.`uid` =1 LIMIT 1 ;
		//UPDATE  `pw4t`.`pw_user` SET  `password` =  'ece4f4a60b764339b94a07c84e338a27' WHERE  `pw_user`.`uid` =1 LIMIT 1 ;
		echo md5(md5('ece4f4a60b764339b94a07c84e338a27') . "2GGDpd");

		date_default_timezone_set("Asia/Shanghai");
		$now = date("Y-m-d H:i:s",strtotime('now'));
		echo $now;

		$info = $this->_getMyOrderDS()->updateOrderItemStatus("464,465",-1);


		$myOrderShops = $this->_getSchoolPeopleDS()->getPeopleSchedule($this->loginUser->uid,11045,0,'2013-08-08 00:00:00','2013-08-08 23:59:59');
		
		
		$shopids = " -1 ";
		foreach($myOrderShops as $day => $shopSchedules)
		{
			foreach($shopSchedules as $shopid => $eachshopschedules)
			{
				$shopids = $shopids.",".$shopid;

				foreach ($eachshopschedules as $key => &$eachschedule) {
					$eachschedule['datetimeBegin'] = $day." ".$eachschedule['datetimeBegin'];
					$eachschedule['datetimeEnd'] = $day." ".$eachschedule['datetimeEnd'];

					$schedules[] = $eachschedule;
				}
			}
		}

		print_r($shopids);
		print_r($schedules);

		print_r($myOrderShops);echo "<br/>";

		$estimatetime = $this->_getShopDS()->getShopOrderTimeBase(1);

		print_r($estimatetime);

		date_default_timezone_set("Asia/Shanghai");
		$schoolSchedule = include Wind::getRealPath('ROOT:conf.schoolOpenSchedule.php', true);

		$opening = $this->_getSchoolDS()->isSchoolOpenNow(11045);
		var_dump($opening);

		$result = $this->_getMyOrderDS()->getSchoolPeopleStatistics(11045,10, 0);
		print_r($result);

		

		$time = Windid::getTime();
		echo "time:".$time;echo "<br/>";
		echo "key_1: ".md5('1'.'||'.'b6a76c3e4aa21dbf9aeee10bfaba1f2a');echo "<br/>";
		print md5(md5('1'.'||'.'b6a76c3e4aa21dbf9aeee10bfaba1f2a').$time);
		die;
	}

		
	public function run() {

		print_r("用户".$this->loginUser->uid);
	}

	public function registerAction()
	{

	}

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

	private function _getShopDS()
    {
        return Wekit::load('EXT:4tschool.service.shop.App_Shop');
    }

}