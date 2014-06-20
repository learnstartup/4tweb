<?php

Wind::import('EXT:4tschool.admin.T4AdminBaseController');

class SchoolusersorderController extends T4AdminBaseController {

	private $pageNumber = 10;

	public function schoolOrderAction()
	{
		//choosen assign status
		$cassignstatus = $this->getInput("cassignstatus");
		if(!isset($cassignstatus))
		{
			$cassignstatus = 0;
		}

		$this->useShareData(0,$cassignstatus,true,8);

		$userid = $this->loginUser->uid;

		//$this->getNoCommentSum($schoolId, $userid);

		//set if need to change responsible person(set as link or just txt)
		$this->setOutput(false,"allowChangeResponsible");

		//get message
		$message = $this->getInput("message");
		$this->setOutput($message,"message");
		$this->setOutput($schoolId,"schoolId");

		//set selected menu
		//$this->setOutput('我的订单','selectedMenu');
		$this->setOutput(false,"showcheckbox");
		$this->setOutput("所有代客下单的订单","subtitle");
		$this->setOutput($schoolId,"schoolId");
	}

	private function useShareData($cresponsible,$cassignstatus,$onlyLoginUser,$defaultStatusCategory = 8)
	{
		//order by shop range
		$ordeTypeRange = $this->getInput("chooseOrderShoprange");
		if(!isset($ordeTypeRange))
		{
			$ordeTypeRange = 1;
		}

		//order date range
		$dateRange = $this->getInput("choosenDaterange");
		if(!isset($dateRange))
		{
			$dateRange = 1;
		}

		//order status category
		$statusCategory= $this->getInput("choosenStatusCategory");
		if(!isset($statusCategory))
		{
			$statusCategory = $defaultStatusCategory;
		}

		//choosen School Area
		$schoolArea = $this->getInput("carea");
		$this->setOutput($schoolArea,"carea");

		$this->setOutput($cassignstatus,"cassignstatus");

		//search Txt
		$searchTxt = $this->getInput("searchTxt");
		if($searchTxt == '订单号、收货人姓名')
			$searchTxt = '';
		$this->setOutput($searchTxt,'searchTxt');

		//get order by shop range
		$shopOrderRange = $this->_getMyOrderDS()->getOrderShopRange();
		$this->setOutput($shopOrderRange,'shopOrderRange');
		$this->setOutput($ordeTypeRange, 'chooseOrderShoprange');

		//get order range
		$orderRange = $this->_getMyOrderDS()->getOrderRange();
		$this->setOutput($orderRange,'orderRange');
		$this->setOutput($dateRange,'choosenDaterangeid');

		//get order category
		$orderStatusCategory =$this->_getMyOrderDS()->getOrderStatusCategory();
		$this->setOutput($orderStatusCategory,'orderStatusCategory');
		$this->setOutput($statusCategory,'choosenStatusCategoryid');
		
		//get order area from school
		// $schoolId = $this->getCurrentSchoolId();
		// $areaList = $this->_getSchoolAreaDS()->getBySchoolid($schoolId);
		// $this->setOutput($areaList,"areaList");
		// $this->setOutput($careaid,"careaid");

		//get selected delivery status
		$cassignid = $this->getInput("cassignid");
		if(!isset($cassignid) || $cassignid < 0)
		{
			$cassignid = 1;
		}
		$this->setOutput($cassignid,"cassignid");

		//get school ppls
		$deliveryppls = $this->_getSchoolPeopleDS()->getSchoolPeople($schoolId,'delivery');
		$this->setOutput($deliveryppls,"deliveryppls");

		//set delivery method and status
		$allStatus = $this->_getMyOrderDS()->getStatusArray(0);
		$this->setOutput($allStatus,'allStatus');

		$deliveryMethods = $this->_getMyOrderDS()->getDeliveryMethods();
		$this->setOutput($deliveryMethods,"deliveryMethods");

		$userid = $onlyLoginUser?$this->loginUser->uid:0;

		//finished status
		$finishedStatus = $this->_getMyOrderDS()->getOrdererFinishedStatusCategory();
		$this->setOutput($finishedStatus,"finishedStatus");

		$page = $this->getInput('page');
		//note that it need to retrive out all orders instead of only userself.
		$count = $this->_getMyOrderDS()->countToUserOrders(-1,
													 -1,
													 $dateRange,
													 $this->_getMyOrderDS()->getStatusArray($statusCategory),
													 $searchTxt,
													 -1,
												 	 $cassignstatus,
													 $cresponsible,
													 $ordeTypeRange);

		//note that it need to retrive out all orders instead of only userself.
		$orderTotalMoney = $this->_getMyOrderDS()->countToUserOrderMoney(-1,
														-1,
														$dateRange,
														$this->_getMyOrderDS()->getStatusArray($statusCategory),
														$searchTxt,
														-1,
														$cassignstatus,
														$cresponsible,
														$ordeTypeRange
														); 
		$this->setOutput($orderTotalMoney,"orderTotalMoney");

		if (0 < $count) 
		{
			$totalPage = ceil($count/$this->pageNumber);
			$page > $totalPage && $page = $totalPage;
			list($start, $limit) = Pw::page2limit($page, $this->pageNumber);

			if($page <= 0)
				$page =1;
		}

		//filter by date range and status
		//note that it need to retrive out all orders instead of only userself.
		$orderList = $this->_getMyOrderDS()->getToUserOrders(-1,
													   -1,
													   $dateRange,
													   $this->_getMyOrderDS()->getStatusArray($statusCategory),
													   $searchTxt,
													   -1,
													   $cassignstatus,
													   $cresponsible,
													   $ordeTypeRange,
													   $limit,
													   $start);
		//get order ids and get its order items
		$orderIds = " -1 ";
		foreach($orderList as $key => $eachOrder)
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
		
		$this->setOutput($orderItems,"orderItems");

		$this->setOutput($orderList,'orderList');
		$this->setOutput($count, 'count');	
		$this->setOutput($page, 'page');
		$this->setOutput($this->pageNumber, 'perPage');	
		
		$args['carea'] = $schoolArea;
		$args['searchTxt'] = $searchTxt;
		$args['cassignstatus'] = $cassignstatus;
		$args['choosenDaterange'] = $dateRange;
		$args['choosenStatusCategory'] = $statusCategory;
		$args['cresponsible'] = $cresponsible;
		$args['chooseOrderShoprange'] = $ordeTypeRange;
		$this->setOutput($args,"args");
	}

	//订单详情
	public function orderitemAction()
	{
		// $userid = $this->loginUser->uid;

		//we need to do some validation to make it safe
		$schoolId = $this->getCurrentSchoolId();

		//list all order items of order
		//1. get order id
		 $orderid = $this->getInput("orderid","request");

		// $isMine = $this->_getMyOrderDS()->isMyOrder($userid,$orderid);

		// if(!$isMine)
		// {
		// 	$this->setTemplate("manage_ifexists");
  //           return;
		// }

		//check if order id is valid or not
		if(!isset($orderid) ||  $orderid <= 0)
		{
			$this->showError("无效的订单号");	
		}

		
		//1. get order item details
		$order = $this->_getMyOrderDS()->getOrdertail($orderid);
		$this->setOutput($order[0],"order");

		$roles = 'master;orderdispatch;delivery;areaorderget';
		//2. check if this order belongs to me or my roles are able to view the order item
		// if((false == $this->_getSchoolPeopleDS()->checkIfExistsInRoles($schoolId,$this->loginUser->uid,$roles)))
		// {
		// 	$this->showError("无效的订单号");
		// }

		//$cancelroles = 'master;orderdispatch';
		//check if it is master or orderdisptch
		//$canCancelUser = $this->_getSchoolPeopleDS()->checkIfExistsInRoles($schoolId,$this->loginUser->uid,$cancelroles);
		//$this->setOutput($canCancelUser,"canCancelUser");

		//如果有某个单已经下单的话，这个订单客户自己也是不能取消的
		//如果订单是还没有已经授理的话，那么客户是可以去取消的
		//$isCancelOrderStatus = $this->_getMyOrderDS()->canCancelOrderByStatus($order[0]['id']);
		$isCancelOrderStatus = ($order[0]['status'] == 0);

		$this->setOutput($isCancelOrderStatus,"isCancelOrderStatus");


		$deliveryMobile =  $this->_getUserMobileDS()->getByUid($order[0]['deliverby']);
		$this->setOutput($deliveryMobile['mobile'],'deliveryMobile');

		$orderitems = $this->_getMyOrderDS()->getOrderItems($orderid);
		$this->setOutput($orderitems,"orderitems");

		//insert order log
		$this->_getMyOrderDS()->insertOrderLog($orderid,$this->loginUser->username,"进入了订单详情");


		$shopIdArray =array();

		foreach($orderitems as $key => $eachItem)
		{
			$merchandiseId =$eachItem['merchandiseid'];
			$merchandiseIdArray[] = $merchandiseId;
		}

		$merchandiseIdArray = array_unique($merchandiseIdArray);
		$merchandiseIds = implode(",",$merchandiseIdArray);
		$this->setOutput($merchandiseIds,"merchandiseIds");


		$orderStatusHistories = $this->_getMyOrderDS()->getOrderHistory($orderid);
		$this->setOutput($orderStatusHistories,"orderhistories");

		//get current schoolid
		$schoolid = $this->getCurrentSchoolId();
		//get school extras
		$extras = $this->_getSchoolDS()->getSchoolExtra($schoolid);
		$this->setOutput($extras[0],"schoolextra");

		//assign delivery methods
		$deliveryMethods = $this->_getMyOrderDS()->getDeliveryMethods();
		$this->setOutput($deliveryMethods,"deliveryMethods");

		//get all status
		$this->setOutput($this->_getMyOrderDS()->getAllStatus(),"allStatus");

		//get order items
		$orderItems = $this->_getMyOrderDS()->getOrderItems($orderid);

		//str_replace('\\', '/', $value['imageurl']);
		foreach($orderItems as $key => &$item)
		{
			if(empty($item['imageurl']))
			{
				//set default image
				$item['imageurl'] =  Wekit::C('site', 'info.url')."/src/extensions/4tschool/uploaded_images/default/mdefault.jpg";
			}
			else
				$item['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool'.str_replace('\\', '/', $item['imageurl']);
		}
		$this->setOutput($orderItems,'orderItems');

		//get current user id
		$loginuserid = $this->loginUser->uid;
		$this->setOutput($loginuserid,"loginuserid");

		//re-use the template
		$this->setTemplate("schoolusersorder_orderitem");
		
	}

	//ajax action
	//bookmark shop
	public function bookmarkShopAction()
	{
		//choosen item
		$merchandiseIds = $this->getInput("merchandiseIds");
		$userid = $this->loginUser->uid;

		$merchandiseIds = explode(",",$merchandiseIds);

		$returnData = array(
			"success"	=> true,
			"data"	=> "收藏成功"
			);

		//check insert id
		$result = true;
		foreach($merchandiseIds as $key => $merchandiseId)
		{
			//get merchadise's shopid
			$merchInfo = $this->_getMerchandiseDS()->getMerchandiseById($merchandiseId);

			$insert_id = $this->_getMyFavoriteDS()->addMyFavorite($userid,$merchInfo['shopid'],$merchandiseId);
			if($insert_id < 0)
			{
				$result = false;
			}
		}

		if(!$result)
		{
			$returnData['success'] = false;
			$returnData['data'] = '收藏失败';
		}


		print_r(json_encode($returnData));
		die;
	}

	//ajax
	//cancel order
	public function cancelOrderAction()
	{
		$userid = $this->loginUser->uid;
		$orderid = $this->getInput("orderid","post");

		$returnData = array(
			"success"	=> true,
			"data"	=> "取消成功"
			);

		//get order status, if it is already handled, then, can not cancelled
		$order = $this->_getMyOrderDS()->getOrdertail($orderid);
		$order = $order[0];

		if($order['status'] != 0) //只有等待授理的订单才能授理
		{
			$returnData['success'] =false;
			$returnData['data'] = "订单已经被授理了, 您不能取消订单";

			print_r(json_encode($returnData));
			die;
		}

		//set order status
		//update the order status
		$this->_getMyOrderDS()->updateOrderStatus($orderid,7,$userid);

		print_r(json_encode($returnData));
		die;
	}

	//根据订单id更新订单状态
    public function updateOrderStatusAction()
    {
        //$userid = $this->getInput('userid','get');
        $orderid = $this->getInput('orderid','post');
        $status = 2;

        $statusindb = $this->_getMyOrderDS()->getOrderStatusByOrderId($orderid);

        //如果是客户申请取消, 并且订单已被处理，那么就不能被取消
        if($status == 7 && $statusindb != 0)
        {
            $returnData = array(
			"success"	=> false,
			"data"	=> "客户已确定"
			);
			print_r(json_encode($returnData));
			die;
        }

        if(empty($orderid) || empty($status))
        {
            $returnData = array(
			"success"	=> false,
			"data"	=> "更新失败1"
			);
			print_r(json_encode($returnData));
			die;
        }

        $result = $this->_getMyOrderDS()->updateOrderStatus($orderid,$status);

        if($result)
        {
            $returnData = array(
			"success"	=> true,
			"data"	=> "客户已确定"
			);
			print_r(json_encode($returnData));
			die;
        }
        else
        {
            $returnData = array(
			"success"	=> false,
			"data"	=> "更新失败2"
			);
			print_r(json_encode($returnData));
			die;
        }
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

	/**
     * @return App_Promo
     */
    public function _getPromoDs()
    {
        return Wekit::load('EXT:4tschool.service.promo.App_Promo');
    }

    private function _getShopCommentDS()
    {
        return Wekit::load('EXT:4tschool.service.mercomment.App_MerComment');
    }
}

?>