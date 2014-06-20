<?php 

Wind::import('EXT:4tschool.admin.T4AdminBaseController');

class RefuseorderController extends T4AdminBaseController
{

	private $pageNumber = 10;

	public function run()
    {

    	$dateRange = 30;
		$ordeTypeRange = 2;

		$this->useShareData($dateRange,$ordeTypeRange);
		
		$this->setOutput("所有拒签的订单","subtitle");

    }

    private function useShareData($dateRange,$ordeTypeRange)
	{
		$page = $this->getInput('page');
		
		//note that it need to retrive out all orders instead of only userself.
		$count = $this->_getMyOrderDS()->countToUserOrders(-1,
													 -1,
													 $dateRange,
													 $this->_getMyOrderDS()->getStatusArray(9),
													 $searchTxt,
													 -1,
												 	 $cassignstatus,
													 $cresponsible,
													 $ordeTypeRange,
													 1);

		//note that it need to retrive out all orders instead of only userself.
		$orderTotalMoney = $this->_getMyOrderDS()->countToUserOrderMoney(-1,
														-1,
														$dateRange,
														$this->_getMyOrderDS()->getStatusArray(9),
														$searchTxt,
														-1,
														$cassignstatus,
														$cresponsible,
														$ordeTypeRange,
														1); 

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
													   $this->_getMyOrderDS()->getStatusArray(9),
													   $searchTxt,
													   -1,
													   $cassignstatus,
													   $cresponsible,
													   $ordeTypeRange,
													   1,
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
		$this->setOutput($args,"args");
	}

	//订单详情
	public function orderitemAction()
	{
		//list all order items of order
		//1. get order id
		 $orderid = $this->getInput("orderid","request");

		//check if order id is valid or not
		if(!isset($orderid) ||  $orderid <= 0)
		{
			$this->showError("无效的订单号");	
		}
		
		//1. get order item details
		$order = $this->_getMyOrderDS()->getOrdertail($orderid);
		$this->setOutput($order[0],"order");

		$roles = 'master;orderdispatch;delivery;areaorderget';
		
		$isCancelOrderStatus = ($order[0]['status'] == 0);

		$this->setOutput($isCancelOrderStatus,"isCancelOrderStatus");

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
		$this->setTemplate("refuseorder_orderitem");
		
	}

	public function orderSubmitAction()
	{
		$orderid = $this->getInput('orderid','get');

		if(!$orderid)
		{
			$returnData = array(
			"success"	=> false,
			"data"	=> "无效的订单号"
			);
			print_r(json_encode($returnData));
			die;
		}

		$orderInfo = $this->_getMyMoneyHistroyDS()->getOneByOrderId($orderid);
		//$statusindb = $this->_getMyOrderDS()->getOrderStatusByOrderId($orderid);
		
		$statusnumber = empty($orderInfo)?2:5;

		if(!empty($orderInfo) && (($orderInfo['moneyincome'] == 0) || ($orderInfo['moneyincome'] == null)))
		{
			$returnData = array(
			"success"	=> false,
			"data"	=> "出现异常"
			);
			print_r(json_encode($returnData));
			die;
		}

		$result = $this->_getMyOrderDS()->updateOrderStatus($orderid, $statusnumber);

		if($result)
		{
			$this->_getMyOrderDS()->updateRejectApprovedStatus($orderid);
			$returnData = array(
			"success"	=> true,
			"data"	=> "后台处理完毕"
			);
			print_r(json_encode($returnData));
			die;
		}
		else
		{
			$returnData = array(
			"success"	=> false,
			"data"	=> "未知处理"
			);
			print_r(json_encode($returnData));
			die;
		}
		
	}

	public function orderRefuseAction()
	{
		$orderid = $this->getInput('orderid','get');
		$userid = $this->getInput('userid','get');
		$deservedpointcoin = $this->_getMyOrderDS()->getOrderDeservedPointCoinByOrderId($orderid);

		if(!$orderid)
		{
			$returnData = array(
			"success"	=> false,
			"data"	=> "无效的订单号"
			);
			print_r(json_encode($returnData));
			die;
		}

		$orderInfo = $this->_getMyMoneyHistroyDS()->getOneByOrderId($orderid);
		
		if(!empty($orderInfo) && (($orderInfo['moneyincome'] > 0)))
		{
			$description = "后台审核用户拒签";
			$this->_getMyMoneyHistroyDS()->updateMyMoney($userid, 0-$deservedpointcoin, $orderid, $description);
		}
		else
		{
			$returnData = array(
			"success"	=> true,
			"data"	=> "已处理, 用户未从此订单得到点币"
			);
			$this->_getMyOrderDS()->updateRejectApprovedStatus($orderid);
			print_r(json_encode($returnData));
			die;
		}

		$result = $this->_getMyOrderDS()->updateOrderStatus($orderid, 6);

		if($result)
		{
			$this->_getMyOrderDS()->updateRejectApprovedStatus($orderid);
			$returnData = array(
			"success"	=> true,
			"data"	=> "处理完毕"
			);
			print_r(json_encode($returnData));
			die;
		}
		else
		{
			$returnData = array(
			"success"	=> false,
			"data"	=> "未知处理"
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

	private function _getSchoolPeopleDS()
	{
		return Wekit::load('EXT:4tschool.service.schoolpeople.App_SchoolPeople');
	}

	private function _getMyMoneyHistroyDS()
	{
		return Wekit::load('EXT:4tschool.service.mymoney.App_MyMoney');
	}

}


?>