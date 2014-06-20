<?php
Wind::import('EXT:4tschool.controller.T4BaseController');
/**
 */
class PeopleScheduleController extends T4BaseController {

	
	private $pageNumber = 10;

	public function beforeAction($handlerAdapter) {
		parent::beforeAction($handlerAdapter);

	}


	//负责下单的人员的排班管理
	public function orderforAction()
	{
		//set selected menu
		$this->setOutput('下单人员排班管理','selectedMenu');
		$this->setOutput("下单人员排班管理","subtitle");

		//we need to do some validation to make it safe
		$schoolId = $this->getCurrentSchoolId();

		//check if can visit or not
		$canVisist = $this->_getMyOrderDS()->canVisitLink($schoolId,'下单人员排班管理',$this->loginUser->uid);
		if($canVisist == false)
		{
			$this->forwardRedirect(WindUrlHelper::createUrl('app/4tschool/index/run'));
		}

		$myMenus =  $this->_getMyOrderDS()->getMyMenus($schoolId,$this->loginUser->uid);
		$this->setOutput($myMenus,'myMenus');


		$orderForKey = $this->_getSchoolPeopleDS()->getorderfoKeyValue();
		$orderForPPls = $this->_getSchoolPeopleDS()->getSchoolPeople($schoolId,$orderForKey['key']);
		$this->setOutput($orderForPPls,"orderForPPls");

		$todaytime =  strtotime('-3 day');
    	$lastRetriveTime = date("Y-m-d",$todaytime);

		$fromTime = $this->getInput("fromTime");
		if(empty($fromTime))
		{
			$fromTime = date("Y-m-d",strtotime('-0 day'));
		}
		$this->setOutput($fromTime,"fromTime");


		$toTime = $this->getInput("toTime");
		if(empty($toTime))
		{
			$toTime = date("Y-m-d",strtotime('+1 day'));
		}
		$this->setOutput($toTime,"toTime");


		//re-format, say 2013-07-02 to 2013-07-03, shall be 2013-07-02 00:00:00 to 2013-07-03 23:59:59
		//need to use a helper method
		$fromTime = $this->stringToDateLowerest($fromTime);
		$toTime = $this->stringToDateBiggest($toTime);

		//得到所有的商铺列表
		$shopList = $this->_getShopDS()->getBySchoolId($schoolId);
		$shundaiID = $this->getIncidentallyShopId();
		$shopList[] = array("id" => $shundaiID,"name" => "顺带");
		$this->setOutput($shopList,"shopList");


		//前三天到接下来7天也就是10天的排班，前三天的是不可以编辑的，今天以及以后的是可以编辑并更改的
		$mergedResult = $this->_getSchoolPeopleDS()->getPeopleSchedule(0,$schoolId,0,$fromTime,$toTime);

		$this->setOutput($mergedResult,"mergedResult");
		$this->setOutput($schoolId,"schoolId");

	}

	//ajax action
	//save schedule
	public function saveScheduleAction()
	{
		$shopId = $this->getInput("choosenShopId","post");
		$choosenDate = $this->getInput("choosenDate","post");
		$orderfor = $this->getInput("orderfor","post");
		$applyForDays = $this->getInput("applyfordays","post");
		$fromTime = $this->getInput("fromTimeCreate","post");
		$toTime = $this->getInput("toTimeCreate","post");

		$returnData = array(
			"success"	=> true,
			"data"	=> "更新成功" 
			);

		$schoolId = $this->getCurrentSchoolId();

		$days = 0;

		if($applyForDays)
			$days = 7;

		if(empty($fromTime) || empty($toTime))
		{
			$returnData['success'] = false;
			$returnData['data'] = "时间不能为空";
			print_r(json_encode($returnData));
			die;
		}

		if($fromTime > $toTime)
		{
			$returnData['success'] = false;
			$returnData['data'] = "结束时间不能大于开始时间";
			print_r(json_encode($returnData));
			die;
		}

		$i = 0;
		do
		{
			$beginDateArray = getdate(strtotime($choosenDate));
			$rangechoosenDate = mktime(0, 0, 0, $beginDateArray['mon'], $beginDateArray['mday'] + $i, $beginDateArray['year']);

			$beginDateArray = getdate($rangechoosenDate);

			$theday = $beginDateArray['year']."-".$beginDateArray['mon']."-".$beginDateArray['mday'];
			$timeBegin = $theday." ".$fromTime;
			$timeEnd = $theday." ".$toTime;

			//$this->_getSchoolPeopleDS()->deleteByShopIdandDate($shopId,$timeBegin,$timeEnd);

			Wind::import('EXT:4tschool.service.schoolpeople.dm.App_PeopleSchedule_Dm');
			$dmitem = new App_PeopleSchedule_Dm();
			$dmitem->setSchool($schoolId)
				->setUserid($orderfor)
				->setType(1)
				->setActionBy($this->loginUser->uid)
				->setShopId($shopId)
				->setDateTimeBegin($timeBegin)
				->setDateTimeEnd($timeEnd);

			$this->_getSchoolPeopleDS()->saveSchedule($dmitem);

			$i++;
		}
		while($i <= $days);

		print_r(json_encode($returnData));
		die;

	}

	//ajax action
	//change schedule
	public function changeScheduleAction()
	{
		$changeShopId = $this->getInput("changeShopId","post");
		$changeScheduleId = $this->getInput("changeScheduleId","post");
		$orderChangefor = $this->getInput("orderChangefor","post");
		$splitTime = $this->getInput("splitTime","post");

		$returnData = array(
			"success"	=> true,
			"data"	=> "更新成功" 
			);

		$schoolId = $this->getCurrentSchoolId();

		if(empty($splitTime))
		{
			$returnData['success'] = false;
			$returnData['data'] = '分割时间请进行更改';

			print_r(json_encode($returnData));
			die;
		}

		if(empty($changeScheduleId))
		{
			$returnData['success'] = false;
			$returnData['data'] = '无效的计划号';

			print_r(json_encode($returnData));
			die;
		}

		if(empty($orderChangefor))
		{
			$returnData['success'] = false;
			$returnData['data'] = '请选择人员';

			print_r(json_encode($returnData));
			die;
		}

		//get schedule time
		$scheduleInfo = $this->_getSchoolPeopleDS()->getPeopleScheduleById($changeScheduleId);
		if(empty($scheduleInfo))
		{
			$returnData['success'] = false;
			$returnData['data'] = $changeScheduleId;//'查不到相关的计划';

			print_r(json_encode($returnData));
			die;
		}

		//加上日期
		$fromDateArray = getdate(strtotime($scheduleInfo['datetimeBegin']));
		$theday = $fromDateArray['year']."-".$fromDateArray['mon']."-".$fromDateArray['mday'];
		$splitTime = $theday." ".$splitTime;


		if(strtotime($scheduleInfo['datetimeBegin']) > strtotime($splitTime)
			||  strtotime($scheduleInfo['datetimeEnd']) < strtotime($splitTime))
		{
			$returnData['success'] = false;
			$returnData['data'] = "填写的分割时间需要在被分割的中间";// '填写的分割时间需要在被分割的中间';

			print_r(json_encode($returnData));
			die;
		}

		Wind::import('EXT:4tschool.service.schoolpeople.dm.App_PeopleSchedule_Dm');
		$dmitem = new App_PeopleSchedule_Dm();
		$dmitem->setSchool($schoolId)
				->setUserid($orderChangefor)
				->setType(1)
				->setActionBy($this->loginUser->uid)
				->setShopId($changeShopId)
				->setDateTimeBegin($splitTime)
				->setDateTimeEnd($scheduleInfo['datetimeEnd']);

		$generatedId = $this->_getSchoolPeopleDS()->saveSchedule($dmitem);
		if($generatedId > 0)
		{
			Wind::import('EXT:4tschool.service.schoolpeople.dm.App_PeopleSchedule_Dm');
			$dmupdateitem = new App_PeopleSchedule_Dm();
			$dmupdateitem->setDateTimeBegin($scheduleInfo['datetimeBegin'])
						->setDateTimeEnd($splitTime);

			$this->_getSchoolPeopleDS()->updateSchedule($changeScheduleId,$dmupdateitem);
		}

		print_r(json_encode($returnData));
		die;


	}

	public function deleteAction()
	{
		$deleteScheduleId = $this->getInput("deleteScheduleId");
		$returnData = array(
			"success"	=> true,
			"data"	=> "删除成功" 
			);

		if($deleteScheduleId <= 0)
		{
			$returnData['success'] = false;
			$returnData['data'] =" 无效的ID ";
			print_r((json_encode($returnData)));
			die;
		}

		$this->_getSchoolPeopleDS()->deleteByScheduleId($deleteScheduleId);

		print_r((json_encode($returnData)));
		die;


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

}