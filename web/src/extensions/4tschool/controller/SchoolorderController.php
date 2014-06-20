<?php
Wind::import('EXT:4tschool.controller.T4BaseController');
/**
 */
class SchoolorderController extends T4BaseController {

	
	private $pageNumber = 10;

	public function beforeAction($handlerAdapter) {
		parent::beforeAction($handlerAdapter);

		if(empty($this->schoolExtra) == false && $this->schoolExtra['openorder'] == 0)
		{
			$this->forwardRedirect(WindUrlHelper::createUrl('app/4tschool/shopdetails/whenOpen'));
		}

	}

		
	public function run() {

		//need to check user's role
		//this function only be able to used by 

		//set selected menu
		$this->setOutput('订单分配管理','selectedMenu');


		//we need to do some validation to make it safe
		$schoolId = $this->getCurrentSchoolId();
		$userid = $this->loginUser->uid;

		$this->getNoCommentSum($schoolId, $userid);

		//check if can visit or not
		$canVisist = $this->_getMyOrderDS()->canVisitLink($schoolId,'订单分配管理',$this->loginUser->uid);
		if($canVisist == false)
		{
			$this->forwardRedirect(WindUrlHelper::createUrl('app/4tschool/index/run'));
		}

		//choosen assign status
		$cassignstatus = $this->getInput("cassignstatus");
		if(!isset($cassignstatus))
		{
			$cassignstatus = 0;
		}

		$this->useShareData(0,$cassignstatus,false,8);//default choose 等待确认的订单
		$this->setOutput(true,"showcheckbox");
		$this->setOutput("学校区域订单列表","subtitle");
		$this->setOutput($schoolId, "schoolId");

	}


	//when user choose the item, then user check in preview page
	//after user confirm, will post to this page
	public function makeOrderAction()
	{
		//get data
		$merchandisesInfo = $this->getInput("merchandisesInfo","post");
		$to = $this->getInput("orderContactor","post");
		$phone = $this->getInput("orderPhone","post");
		$address = $this->getInput("orderAddress","post");
		$note = $this->getInput("orderRemark","post");
		$orderExpressTime = $this->getInput("orderExpressTime","post");
        $orderHour=$this->getInput('orderHour',"post");
        $orderMinutes=$this->getInput('orderMinutes',"post");
		$orderTime = $orderHour.':'.$orderMinutes;

		$schoolId = $this->getCurrentSchoolId();

		if(empty($merchandisesInfo))
		{
			//show not correct message
			return;
		}
		else
		{
			$merchandisesInfo = (array)json_decode($merchandisesInfo);
		}

		$orderItems = $merchandisesInfo['merchandises'];
		$shopDeduct = array();
    	
		//calculate the promo
		$orderMerchandiseList = $this->jcart->get_contents();
		$promos = $this->_getPromoDs()->matchedPromoInCart($orderMerchandiseList);

		//calculate deduct price
		foreach ($promos['Match'] as $item) {

			if($item['ShopId'] == $shopid)
			{
        	
        		$shopDeduct['ShopId'] +=$item['Deduct'];

        	}
    	}

    	$hasException = false;
    	try
    	{

    		//start transaction
    		$this->_getMyOrderDS()->startTran();
    		$generatedIds = $this->_getMyOrderDS()->makeOrder(
		                                            $this->loginUser->uid,
		                                            $schoolId,
		                                            $orderItems,
		                                            $to,
		                                            $phone,
		                                            $address,
		                                            $note,
		                                            '微信');
    	}
    	catch(Exception $e)
    	{
    		$hasException = true;
    		$this->_getMyOrderDS()->rollBack();
    	}

    	if($hasException == false)
    	{
    		$message = "下单失败,请联系系统管理员";
    		$this->_getMyOrderDS()->commit();
    	}
    	else
    		$message = "下单成功";


		//清空购物车
		$this->jcart->empty_cart();


		//跳转到我的订单的画面
		$this->forwardRedirect(WindUrlHelper::createUrl('app/4tschool/schoolorder/myorder',array("message"=>$message)));
	}

	public function responsiblesAction()
	{
		//we need to do some validation to make it safe
		$schoolId = $this->getCurrentSchoolId();

		//check if can visit or not
		$canVisist = $this->_getMyOrderDS()->canVisitLink($schoolId,'责任人订单',$this->loginUser->uid);
		if($canVisist == false)
		{
			$this->forwardRedirect(WindUrlHelper::createUrl('app/4tschool/index/run'));
		}

		//responsible ppl
		$cresponsible= $this->getInput("cresponsible");
		if(!isset($cresponsible))
		{
			$cresponsible = -1;
		}
		$this->setOutput($cresponsible,"cresponsibleid");

		//choosen assign status
		$cassignstatus = $this->getInput("cassignstatus");
		if(!isset($cassignstatus))
		{
			$cassignstatus = -1;
		}

		$this->useShareData($cresponsible,$cassignstatus,0);

		//set selected menu
		$this->setOutput('责任人订单','selectedMenu');
		$this->setOutput("管理订单并分配负责人","subtitle");
		$this->setOutput($schoolId,"schoolId");

	}

	public function myresponsiblesAction()
	{
		//we need to do some validation to make it safe
		$schoolId = $this->getCurrentSchoolId();

		//check if can visit or not
		$canVisist = $this->_getMyOrderDS()->canVisitLink($schoolId,'负责配送的订单',$this->loginUser->uid);
		if($canVisist == false)
		{
			$this->forwardRedirect(WindUrlHelper::createUrl('app/4tschool/index/run'));
		}

		$cassignstatus = 0;
		$this->useShareData($this->loginUser->uid,$cassignstatus,false,0);

		//getAreaOrdererStatusCategory
		//override
		$deliverStatus = $this->_getMyOrderDS()->getOrdererDeliveryStatusCategory();
		$this->setOutput($deliverStatus,'deliverStatus');

		//set selected menu
		$this->setOutput('负责配送的订单','selectedMenu');
		$this->setOutput(true,"showcheckbox");
		$this->setOutput("负责配送的订单","subtitle");
		$this->setOutput($schoolId,"schoolId");
	}

	public function myareaorderAction()
	{
		//we need to do some validation to make it safe
		$schoolId = $this->getCurrentSchoolId();

		//check if can visit or not
		$canVisist = $this->_getMyOrderDS()->canVisitLink($schoolId,'负责下单的订单',$this->loginUser->uid);
		if($canVisist == false)
		{
			$this->forwardRedirect(WindUrlHelper::createUrl('app/4tschool/index/run'));
		}

		$cassignstatus = 0;
		$this->useShareData($this->loginUser->uid,$cassignstatus,false,0);

		//override
		$areaOrderStatus = $this->_getMyOrderDS()->getAreaOrdererStatusCategory();
		$this->setOutput($areaOrderStatus,'areaOrderStatus');

		//set view
		$view = $this->getInput("view");
		$this->setOutput($view,"view");

		if($view != 'order')
		{
			$todaytime =  strtotime('today');
        	$lastRetriveTime = date("Y-m-d",$todaytime);

        	$fromTime = $this->stringToDateLowerest($lastRetriveTime);
			$toTime = $this->stringToDateBiggest($lastRetriveTime);

			$shopMOrders = $this->_getMyOrderDS()->getOrdersGroupbyShop($schoolId,0,$fromTime,$toTime);
			$this->setOutput($shopMOrders,"shopMOrders");
		}

		//set selected menu
		$this->setOutput('负责下单的订单','selectedMenu');
		$this->setOutput(true,"showcheckbox");
		$this->setOutput("负责下单的订单","subtitle");
		$this->setOutput($schoolId,"schoolId");
	}

	public function myOrderAction()
	{
		$schoolId = $this->getCurrentSchoolId();
		$this->getWebStatus($schoolId);
		
		//choosen assign status
		$cassignstatus = $this->getInput("cassignstatus");
		if(!isset($cassignstatus))
		{
			$cassignstatus = 0;
		}

		$this->useShareData(0,$cassignstatus,true,0,1);

		$userid = $this->loginUser->uid;

		$this->getNoCommentSum($schoolId, $userid);

		//set if need to change responsible person(set as link or just txt)
		$this->setOutput(false,"allowChangeResponsible");

		//get message
		$message = $this->getInput("message");
		$this->setOutput($message,"message");
		$this->setOutput($schoolId,"schoolId");

		//set selected menu
		$this->setOutput('我的订单','selectedMenu');
		$this->setOutput(false,"showcheckbox");
		$this->setOutput("我下的订单","subtitle");
		$this->setOutput($schoolId,"schoolId");
		$this->setOutput("confirm","needConfirm");
	}

	public function doSaveCommentAction (){
		list($orderid, $shopid, $deliveryTime, $comment)=$this->getInput(array('orderId', 'shopId','deliveryTime', 'comment'),'post');
		$ordertail=$this->_getMyOrderDS()->getOrdertail($orderid);
		$ordertail=$ordertail[0];

		$returnMsg;
		$msg="";

		//120 min
		$maxDeliveryTime=120;		

		if (($ordertail['status']==2||3||4)==false) {
			$msg="订单状态不正确，无法评论。";
			$returnMsg=$this->CreateRedirectUrl($msg);
		}

		$userid = $this->loginUser->uid;
		if (($userid>0)==false) {
			$msg="您还没有登录，无法评论。";
			$returnMsg=$this->CreateRedirectUrl($msg);
		}

		//检查该订单是否已评论过，防止直接POST该链接刷点币
		
		$exits=$this->_getMyMoneyDS()->getOneByOrderId($orderid);	

		if (empty($exits)) {
			
			$this->_getMyOrderDS()->updateOrderStatus($orderid, 5, $userid);

            $deliveryTime=$deliveryTime+0;            
            if ($deliveryTime>0) {
            	if ($deliveryTime>$maxDeliveryTime) {
            		$deliveryTime=$maxDeliveryTime;
            	}            	

            	$this->_getShopDs()->addShopComment($userid,$shopid,$orderid,$deliveryTime,$comment);
            }

            $msg="订单".$ordertail['ordernumber']."确认收货成功, 感谢您的评价！";

			if ($ordertail['deservedpointcoin']>0) {
				$this->_getMyMoneyDS()->updateMyMoney($userid,$ordertail['deservedpointcoin'],$orderid);
				$msg="订单".$ordertail['ordernumber']."确认收货成功,".$ordertail['deservedpointcoin']."点币已转入到零钱包。感谢您的评价！";
			}            
		}

		$returnMsg=$this->CreateRedirectUrl($msg);
		print_r($returnMsg);
		die;
	}

	public function getNoCommentSum($schoolId, $userid)
	{
		$countNoComment = $this->_getShopCommentDS()->getCountOfMyUnComment($schoolId, $userid);
        $this->setOutput($countNoComment,"countNoComment");
	}

	//缺货管理
	public function noItemAction()
	{
		
		//we need to do some validation to make it safe
		$schoolId = $this->getCurrentSchoolId();
		$userid = $this->loginUser->uid;
		$this->getNoCommentSum($schoolId, $userid);

		//check if can visit or not
		$canVisist = $this->_getMyOrderDS()->canVisitLink($schoolId,'订单缺货管理',$this->loginUser->uid);
		if($canVisist == false)
		{
			$this->forwardRedirect(WindUrlHelper::createUrl('app/4tschool/index/run'));
		}

		$todaytime =  strtotime('now');
        $lastRetrived = date("Y-m-d H:i:s",$todaytime);
        $this->setOutput($lastRetrived,"lastRetrived");


		$cassignstatus = 0; //任何状态
		$this->useShareData(0,$cassignstatus,false,0);

		//设置允许换货
		$this->setOutput(true,"allowChangeItem");

		//set selected menu
		$this->setOutput('订单缺货管理','selectedMenu');
		$this->setOutput(false,"showcheckbox");
		$this->setOutput("订单缺货管理","subtitle");
		$this->setOutput($schoolId,"schoolId");
	}

	//更改订单的缺货的商品
	public function changeItemAction()
	{

		$userid = $this->loginUser->uid;

		//list all order items of order
		//1. get order id
		$orderid = $this->getInput("orderid");
		$orderItemId = $this->getInput("orderItemId");
		$chooseShopId = $this->getInput("chooseShopId");
		$chooseAreaId = $this->getInput("chooseAreaId");
		$searchTxt = $this->getInput("searchTxt");

		$this->setOutput($orderid,"orderid");
		$this->setOutput($orderItemId,"orderItemId");

		//check if order id is valid or not
		if(!isset($orderid) ||  $orderid <= 0)
		{
			$this->showError("无效的订单号");	
		}

		//get current schoolid
		$schoolid = $this->getCurrentSchoolId();

		//check if can visit or not
		$canVisist = $this->_getMyOrderDS()->canVisitLink($schoolid,'订单缺货管理',$this->loginUser->uid);
		if($canVisist == false)
		{
			print_r("No Permission, please contact admin.");
			die;
		}

		//1. get order item details
		$order = $this->_getMyOrderDS()->getOrdertail($orderid);
		$order = $order[0];
		$this->setOutput($order,"order");

		$orderitems = $this->_getMyOrderDS()->getOrderItems($orderid);
		$this->setOutput($orderitems,"orderitems");

		//insert order log
		$this->_getMyOrderDS()->insertOrderLog($orderid,$this->loginUser->username,"进入更改订单商品详情");

		$shopIdArray =array();

		//get all status
		$this->setOutput($this->_getMyOrderDS()->getAllStatus(),"allStatus");

		//get order items
		$orderItems = $this->_getMyOrderDS()->getOrderItems($orderid);

		//str_replace('\\', '/', $value['imageurl']);
		foreach($orderItems as $key => &$item)
		{
			if($item['id'] == $orderItemId)
			{
				$missedItemInfo = $item;
			}

			if(empty($item['imageurl']))
			{
				//set default image
				$item['imageurl'] =  Wekit::C('site', 'info.url')."/src/extensions/4tschool/uploaded_images/default/mdefault.jpg";
			}
			else
				$item['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool'.str_replace('\\', '/', $item['imageurl']);
		}
		$this->setOutput($orderItems,'orderItems');

		$areaList = $this->_getSchoolAreaDS()->getBySchoolid($schoolid);
		$this->setOutput($areaList,"areaList");


		$shopList = $this->_getShopDS()->getBySchoolId($schoolid);
		$shundaiID = $this->getIncidentallyShopId();
		$shopList[] = array("id" => $shundaiID,"name" => "顺带");
		$this->setOutput($shopList,"shopList");

		if(!isset($chooseShopId) || $chooseShopId <= 0)
		{
			$chooseShopId = $missedItemInfo['shopid'];
			$this->setOutput($chooseShopId,"chooseShopId");
		}

		$page = $this->getInput('page');
		$count = $this->_getSearchDS()->countMerchandisesByFilter($searchTxt,$schoolid,$chooseAreaId,$chooseShopId);
		if (0 < $count) 
		{
			$totalPage = ceil($count/$this->pageNumber);
			$page > $totalPage && $page = $totalPage;
			list($start, $limit) = Pw::page2limit($page, $this->pageNumber);

			if($page <= 0)
				$page =1;
		}

		$merchandiseList = $this->_getSearchDS()->searchMerchandiseByFilter($searchTxt,$schoolid,$chooseAreaId,$chooseShopId,"","",$limit, $start);

		if(count($merchandiseList) > 0)
		{
			foreach($merchandiseList as $key => &$eachM)
			{

				if(empty($eachM['imageurl']))
				{
					//set default image
					$eachM['imageurl'] =  Wekit::C('site', 'info.url')."/src/extensions/4tschool/uploaded_images/default/mdefault.jpg";
				}
				else
					$eachM['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool'.str_replace('\\', '/', $eachM['imageurl']);
			}
		}

		$this->setOutput($merchandiseList,"merchandiseList");

		$args['searchTxt'] = $searchTxt;
		$args['chooseShopId'] = $chooseShopId;
		$args['chooseAreaId'] = $chooseAreaId;
		$args['orderid'] = $orderid;
		$args['orderItemId'] = $orderItemId;
		$this->setOutput($count, 'count');	
		$this->setOutput($page, 'page');
		$this->setOutput($this->pageNumber, 'perPage');	
		$this->setOutput($args,"args");


		//get current user id
		$loginuserid = $this->loginUser->uid;
		$this->setOutput($loginuserid,"loginuserid");

		$this->setOutput($chooseShopId,"chooseShopId");
		$this->setOutput($chooseAreaId,"chooseAreaId");

		$myMenus =  $this->_getMyOrderDS()->getMyMenus($schoolid,$userid);
		//$this->setOutput($myMenus,'myMenus');
		$this->setOutput('订单缺货管理','selectedMenu');
		$this->setOutput($schoolid,"schoold");

	}

	//订单详情
	public function orderitemAction()
	{
		$userid = $this->loginUser->uid;

		//we need to do some validation to make it safe
		$schoolId = $this->getCurrentSchoolId();
		$roles = $this->_loadSchoolPeopleDao()->getMyRolesInSchool($schoolId, $userid);
		foreach ($roles as $key => $value) {
			if($value['type'] == 'master'){
				$canCancelUser = 1;
				break;
			}
		}

		$this->setOutput($canCancelUser,"canCancelUser");
		
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
		//2. check if this order belongs to me or my roles are able to view the order item
		if(($order[0]['userid'] != $this->loginUser->uid) && (false == $this->_getSchoolPeopleDS()->checkIfExistsInRoles($schoolId,$this->loginUser->uid,$roles)))
		{
			$this->showError("无效的订单号");
		}

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
		$this->setTemplate("schoolorder_orderitem");
		
	}

	//ajax action
	//check how many newly coming no item order
	public function getNewlyComingNoItemOrderAction()
	{
		//get current schoolid
		$schoolid = $this->getCurrentSchoolId();
		$lastRetrived = $this->getInput("lastRetrived","post");

		if($lastRetriveTime == "")
		{
        	$lastRetrived = date("Y-m-d");
		}

		$returnData = array(
			"success"	=> true,
			"data"	=> ""
			);

		$total = $this->_getMyOrderDS()->anyNoItemOrders($schoolid,$lastRetrived);
		$returnData['data'] = $total;
		$returnData['lastRetrived'] = $total;

		print_r(json_encode($returnData));
		die;

	}

	//ajax action
	//update ordered item to be another one
	public function updateItemtoAnotherAction()
	{

		//get current schoolid
		$schoolid = $this->getCurrentSchoolId();
		$returnData = array(
			"success"	=> true,
			"data"	=> ""
			);

		$orderid = $this->getInput("orderid","post");
		$orderItemId = $this->getInput("fromItemId","post");
		$toMId = $this->getInput("toMId","post");

		if($orderid <= 0 || $orderItemId <= 0)
		{
			$returnData['success'] = false;
			$returnData['data'] = "数据未准备完全";
			print_r(json_encode($returnData));
			die;
		}

		//old Order and order Item infor
		$orderItemInfo = $this->_getMyOrderDS()->getOrderItemById($orderItemId);
		$orderItemInfo = $orderItemInfo[0];
		$originalItemMoney = $orderItemInfo['price'];

		$orderInfo = $this->_getMyOrderDS()->getOrdertail($orderid);
		$orderInfo = $orderInfo[0];

		if($toMId <= 0)
		{
			//cancel the order item
			//remove old item to archive table and create new table
			Wind::import('EXT:4tschool.service.myorder.dm.App_OrderItem_Dm');
			$dmitem = new App_OrderItem_Dm();
			$dmitem->setValid(0); //not valid anymore
			$this->_getMyOrderDS()->updateOrderItem($orderItemId,$dmitem);

			//need to update old order total money
			$newOrderMoney = $orderInfo['ordermoney']  - $originalItemMoney;

			//如果订单中只有一个商品, 当商品被取消时, 那么这个订单就应该被取消
			$this->_getMyOrderDS()->updateOrderItemStatus($orderItemId,7); //客户取消

			//当订单中没有缺货了的Item的时候，应该更新为其中某个Item的状态
			$orderItems = $this->_getMyOrderDS()->getOrderItems($orderInfo['id']);

			//得到order item里面最小的状态
			if(count($orderItems) > 0)
			{
				$lowestStatus = $orderInfo['status'];
				foreach($orderitems as $key => $eachItem)
				{
					if($eachItem['status'] < $lowestStatus)
						$lowestStatus = $eachItem['status'];
				}
			}
			else
				$lowestStatus = 7;//已取消，当这个订单没有物品时，应取消订单

			//

			//compose order data and update total money
			Wind::import('EXT:4tschool.service.myorder.dm.App_Order_Dm');
			$dmorder = new App_Order_Dm();
			$dmorder->setOrdermoney($newOrderMoney)
					->setStatus($lowestStatus);
			$this->_getMyOrderDS()->updateOrder($orderid,$dmorder);

			$returnData['success'] = true;
			$returnData['data'] = "取消菜品成功, 返回缺货列表";
			print_r(json_encode($returnData));
			die;

		}
		else
		{
			//new order Item infor
			$merchandiseInfo = $this->_getMerchandiseDS()->getMerchandiseById($toMId);
			$shopInfo = $this->_getShopDS()->getByShopId($merchandiseInfo['shopid']);

			$needPackingPrice = $merchandiseInfo['needPackingPrice'];

            if($needPackingPrice == 1)
                $packingPrice = $shopInfo['packingprice'] + $shopInfo['deliveryprice'] ; //打包费用
            else
                $packingPrice = 0.0;
			
			//check and compare price
			$newItemMoney = ($merchandiseInfo['currentprice'] + $packingPrice) * $orderItemInfo['quatity'];

			//need to update old order total money
			$newOrderMoney = $orderInfo['ordermoney'] + ($newItemMoney - $originalItemMoney);


			//compose order data and update total money
			Wind::import('EXT:4tschool.service.myorder.dm.App_Order_Dm');
			$dmorder = new App_Order_Dm();
			$dmorder->setOrdermoney($newOrderMoney);

			$this->_getMyOrderDS()->updateOrder($orderid,$dmorder);

			//remove old item to archive table and create new table
			Wind::import('EXT:4tschool.service.myorder.dm.App_OrderItem_Dm');
			$dmitem = new App_OrderItem_Dm();
			$dmitem->setValid(0); //not valid anymore
			$this->_getMyOrderDS()->updateOrderItem($orderItemId,$dmitem);

			//create new order item
			Wind::import('EXT:4tschool.service.myorder.dm.App_OrderItem_Dm');
			$dmnewitem = new App_OrderItem_Dm();
			$dmnewitem->setOrderId($orderid)
				->setMerchandiseId($toMId)
				->setSchoolAreaId($shopInfo['areaid'])
				->setQuatity($orderItemInfo['quatity'])
				->setPriceOriginal($merchandiseInfo['price'])
				->setPriceOfferDescription("优惠了".(($merchandiseInfo['price'] - $merchandiseInfo['currentprice']) * $value['qty'])."元")
				->setPrice($merchandiseInfo['currentprice'] + $packingPrice)
				->setSaving(($merchandiseInfo['price'] - $merchandiseInfo['currentprice']) * $value['qty']) //tobe
				->setIntegral($newItemMoney * 1.5)
				->setSequence($orderItemInfo['sequence'])
				->setPackingprice($packingPrice)
				->setChangeFromItemId($orderItemId)
				->setStatus(1); //已受理

			$generatedItemId = $this->_getMyOrderDS()->insertOrderItem($dmnewitem);

			$this->_getMyOrderDS()->updateOrderItemStatus($generatedItemId,1); //已下单

			$returnData['success'] = true;
			$returnData['data'] = "替换菜品成功, 返回缺菜列表";
			print_r(json_encode($returnData));
			die;
		}

	}

	
	//ajax action
	//update order responsibles
	public function updateOrderResponsibleAction()
	{
		$returnData = array(
			"success"	=> true,
			"data"	=> ""
			);
		//choosen item
		$checkeditem = $this->getInput("checkeditem","post");

		//choosen user
		$deliveryUser = $this->getInput("pplinarea","post");
		if($deliveryUser == 0)
		{
			$returnData['success']	= false;
			$returnData['data']	= "请要分配给谁";
			print_r(json_encode($returnData));
			die;
		}

		
		foreach($checkeditem as $key => $value)
		{
			//key is orderid
			//update the order with assigned user
			$this->_getMyOrderDS()->updateOrderResponsible($key,$deliveryUser);

			//当更新人后,顺便把状态更新为已授理，请注意，只有当订单是等待确认的状态时才行
			$orderInfo = $this->_getMyOrderDS()->getOrdertail($key);
			$orderInfo = $orderInfo[0];
			if($orderInfo['status'] == 0)
			{
				$this->_getMyOrderDS()->updateOrderStatus($key,1,$this->loginUser->uid);
			}


			//insert order status history
			//1 means 已分配
			//经过讨论你认为没有必要更新订单的状态
			//$this->_getMyOrderDS()->updateOrderStatus($key,1 ,$this->loginUser->uid);

			//insert order log
			$this->_getMyOrderDS()->insertOrderLog($key,$this->loginUser->username,"更新了订单负责人: $deliveryUser");
		}
		$returnData['success']	= true;
		$returnData['data']	= "更新成功，页面会刷新";

		print_r(json_encode($returnData));
		die;
	}


	//ajax action
	//update order status
	public function updateOrderStatusAction()
	{
		$orderid = $this->getInput('orderid','post');
		$status = 2;
		$returnData = array(
			"success"	=> true,
			"data"	=> "更新成功，页面会刷新"
			);

		//choosen item
		// $checkeditem = $this->getInput("checkeditem","post");

		//choosen user
		// $status = $this->getInput("orderstatus","post");
		// if($status < -1) //-1已经被占用
		// {
		// 	$returnData['success']	= false;
		// 	$returnData['data']	= $status;
		// 	print_r(json_encode($returnData));
		// 	die;
		// }

		$userid = $this->loginUser->uid;

		// foreach($checkeditem as $key => $value)
		// {
		// 	//update the order status
		// 	$this->_getMyOrderDS()->updateOrderStatus($key,$status,$userid);

		// 	//insert order log
		// 	$this->_getMyOrderDS()->insertOrderLog($key,$this->loginUser->username,"负责人更新了状态: $status");
		// }

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

		//
		$isMine = $this->_getMyOrderDS()->isMyOrder($userid,$orderid);
		if(!$isMine)
		{
			$returnData['success'] =false;
			$returnData['data'] = "取消失败,无效订单";

			print_r(json_encode($returnData));
			die;
		}

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

	/*
	*  parameters:
	*  cresponsible:  负责人
	*  cassignstatus:  分配状态
	*/
	private function useShareData($cresponsible,$cassignstatus,$onlyLoginUser,$defaultStatusCategory = 1, $defaultShowPhone = 0)
	{
		$schoolId = $this->getCurrentSchoolId();
		$userid = $this->loginUser->uid;

		$myMenus =  $this->_getMyOrderDS()->getMyMenus($schoolId,$userid);
		
		$this->setOutput($myMenus,'myMenus');

		//order date range
		$dateRange = $this->getInput("choosenDaterange");
		if(!isset($dateRange))
		{
			$dateRange = 30;
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

		//get order range
		$orderRange = $this->_getMyOrderDS()->getOrderRange();
		$this->setOutput($orderRange,'orderRange');
		$this->setOutput($dateRange,'choosenDaterangeid');
		

		//get order category
		$orderStatusCategory =$this->_getMyOrderDS()->getOrderStatusCategory();
		$this->setOutput($orderStatusCategory,'orderStatusCategory');
		$this->setOutput($statusCategory,'choosenStatusCategoryid');
		

		//get order area from school
		$schoolId = $this->getCurrentSchoolId();
		$areaList = $this->_getSchoolAreaDS()->getBySchoolid($schoolId);
		$this->setOutput($areaList,"areaList");
		$this->setOutput($careaid,"careaid");

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
		$count = $this->_getMyOrderDS()->countOrders($userid,
													 -1,
													 $dateRange,
													 $this->_getMyOrderDS()->getStatusArray($statusCategory),
													 $searchTxt,
													 $schoolArea,
												 	 $cassignstatus,
													 $cresponsible); 

		//note that it need to retrive out all orders instead of only userself.
		$orderTotalMoney = $this->_getMyOrderDS()->countOrderMoney($userid,
														-1,
														$dateRange,
														$this->_getMyOrderDS()->getStatusArray($statusCategory),
														$searchTxt,
														$schoolArea,
														$cassignstatus,
														$cresponsible
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
		$orderList = $this->_getMyOrderDS()->getOrders($userid,
													   -1,
													   $dateRange,
													   $this->_getMyOrderDS()->getStatusArray($statusCategory),
													   $searchTxt,
													   $schoolArea,
													   $cassignstatus,
													   $cresponsible,
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
		$this->setOutput($defaultShowPhone,'defaultShowPhone');
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

	private function getWebStatus($schoolId)
    {
        $webstatus = $this->_getSchoolDS()->getWebSiteStatus($schoolId);
            
        if(!$webstatus)
        {   
            $this->setOutput($webstatus, 'webstatus');
            $this->setTemplate("ifopenwebsite");
        }
    }

	private function CreateRedirectUrl($message){
		$url=WindUrlHelper::createUrl('app/4tschool/schoolorder/myorder',array('message' => $message));
		return $url;		
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

    private function _getOrderAddressDs()
    {
    	return Wekit::load('EXT:4tschool.service.orderaddress.App_OrderAddress');
    } 

    /**
     * @return App_SchoolPeople_Dao
     */
    private function _loadSchoolPeopleDao()
    {
        return Wekit::loadDao('EXT:4tschool.service.schoolpeople.dao.App_SchoolPeople_Dao');
    }

}