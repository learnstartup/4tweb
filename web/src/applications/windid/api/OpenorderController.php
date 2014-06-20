<?php
Wind::import('APPS:windid.api.OpenBaseController');
/**
 * the last known user to change this file in the repository  <$LastChangedBy: Peter.yan $>
 * @author $Author: Peter.yan $ 215169718@qq.com
 * @copyright ?2003-2103 fenxiangyo.com
 * @license http://www.fenxiangyo.com
 * @package
 */
class OpenOrderController extends OpenBaseController
{

    //get order list based on last retrive date
    public function getOrderAction($lastRetrived)
    {
        $todaytime = strtotime('today');
        $today = date("Y-m-d", $todaytime);

        $result = $this->_getMyOrderDS()->getOrdersGroupbyShop(11045, $lastRetrived);
        $this->output($result);
    }

    //get order delivery status
    public function getOrderDeliveryStatusAction()
    {
        $result = $this->_getMyOrderDS()->getOrdererDeliveryStatusCategory();
        $this->output($result);
    }

    //根据订单id更新订单状态
    public function updateOrderStatusAction()
    {
        $userid = $this->getInput('userid','get');
        $orderid = $this->getInput('orderid','get');
        $status = $this->getInput('status','get');

        $statusindb = $this->_getMyOrderDS()->getOrderStatusByOrderId($orderid);

        //如果是客户申请取消, 并且订单已被处理，那么就不能被取消
        if($status == 7 && $statusindb != 0)
        {
            $this->output(-1);
            return;
        }

        if(empty($userid) || empty($orderid) || empty($status))
        {
            $this->output(-1);
            return;
        }

        $result = $this->_getMyOrderDS()->updateOrderStatus($orderid,$status);

        //check if status is -1, then need to send message to user,
        if($status == -1)
        {
        	
        }

        if($result)
        {
            $this->output(1);
        }
        else
        {
            $this->output(0);
        }
    }


    //get my deliveries
    public function getOrderByUserAction()
    {
        $userid = $this->getInput('userid','get');
        $schoolid = $this->getInput('schoolid','get');
        $days = $this->getInput('days','get');
        
        
        //3 -- 等待配送
        //$statusArray["3"] = "等待配送";
        $statusArray = $this->_getMyOrderDS()->getAllStatus();
        //取消的和等待确认的不能给我
        unset($statusArray['-1']);
        unset($statusArray['0']);

        $searchTxt = '';
        $schoolArea = 0;
        $assignedStatus = 0;
        $assignedppl = $userid;
        $limit = $this->getInput('limit','get');
        $offset = $this->getInput('offset','get');


        $orderList = $this->_getMyOrderDS()->getOrders(0,
                                                        $schoolid,
                                                        $days,
                                                        $statusArray,
                                                        $searchTxt,
                                                        $schoolArea,
                                                        $assignedStatus,
                                                        $assignedppl,
                                                        $limit,
                                                        $offset
                                                        );
//echo "<pre>";print_r($orderList);
        //get order ids and get its order items
        $orderIds = " -1 ";
        foreach($orderList as $key => &$eachOrder)
        {
            if($this->getIncidentallyShopId() == $eachOrder['shopid'])
            {
                $eachOrder['isshundai'] = true;
            }
            else
            {
                $eachOrder['isshundai'] = false;
            }
            $orderIds = $orderIds.",".$eachOrder['id'];
        }

        $orderIds = $orderIds." ,-1 ";

        $orderItems = $this->_getMyOrderDS()->getOrderItemByOrderIds($orderIds);
        foreach ($orderItems as $key => &$eachItem) {
            
            if($eachItem['needPackingPrice'] == 1)
                $eachItem['needPackingPrice'] = true;
            else
                $eachItem['needPackingPrice'] = false;
        }

        $result['order'] = $orderList;
        $result['orderItems'] = $orderItems;

        $this->output($result);
    }

    //get number of no item order
    public function getNumberOfNoItemOrderAction()
    {
        $schoolid = $this->getInput('schoolid','get');
        $days = $this->getInput('days','get');

        $statusArray = array("-1" => "缺货");
        $searchTxt = '';
        $schoolArea = 0;
        $assignedStatus = 0;
        $assignedppl = 0; //no matter assigned or not
        $count = $this->_getMyOrderDS()->countOrders(0,
                                                                $schoolid,
                                                                $days,
                                                                $statusArray,
                                                                $searchTxt,
                                                                $schoolArea,
                                                                $assignedStatus,
                                                                $assignedppl
                                                                );

        $this->output($count);
    }

    //get number of waiting for confirm order
    public function getNumberOfWaitingOrderAction()
    {
        $schoolid = $this->getInput('schoolid','get');
        $days = $this->getInput('days','get');

        $statusArray = array("0" => "等待确认");
        $searchTxt = '';
        $schoolArea = 0;
        $assignedStatus = 0;
        $assignedppl = 0; //no matter assigned or not
        $count = $this->_getMyOrderDS()->countOrders(0,
                                                                $schoolid,
                                                                $days,
                                                                $statusArray,
                                                                $searchTxt,
                                                                $schoolArea,
                                                                $assignedStatus,
                                                                $assignedppl
                                                                );

        $this->output($count);
    }


    //get my deliveries
    public function getMyOrderAction()
    {
        $schoolid = $this->getInput('schoolid','get');
        $days = $this->getInput('days','get');
        $myid = $this->getInput('myid','get');

        if(empty($myid))
            return '';


        $statusArray = $this->_getMyOrderDS()->getAllStatus();

        $searchTxt = '';
        $schoolArea = 0;
        $assignedStatus = 0;
        $assignedppl = 0; //no matter assigned or not
        $limit = $this->getInput('limit','get');
        $offset = $this->getInput('offset','get');


        $orderList = $this->_getMyOrderDS()->getOrders($myid,
                                                       $schoolid,
                                                       $days,
                                                       $statusArray,
                                                       $searchTxt,
                                                       $schoolArea,
                                                       $assignedStatus,
                                                       $assignedppl,
                                                       $limit,
                                                       $offset
                                                       );

        //get order shop images
        $shopList = $this->_getShopDs()->getShopBySchoolId($schoolid);
        foreach($orderList as $okey => &$eachOrder)
        {
            $find = false;
            foreach ($shopList as $skey => $eachShop) {

                if($eachShop['id'] == $eachOrder['shopid'] )
                {
                    $eachOrder['imageurl'] = $eachShop['imageurl'];
                    $eachOrder['shopname'] = $eachShop['name'];
                    if(empty($eachOrder['imageurl']))
                    {
                        //set default image
                        $eachOrder['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool/uploaded_images/default/sdefault.jpg';
                    }
                    else
                        $eachOrder['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool'.str_replace('\\', '/', $eachShop['imageurl']);//
                    
                    $find = true;
                    break;    
                }
                
            }

            if($find == false)
            {
                $eachOrder['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool/uploaded_images/default/sdefault.jpg';
                $eachOrder['shopname'] = "未定义";
            }
        }

        $this->output($orderList);
    }




    //通过员工号得到员工能够看到的订单列表
    public function  getOrderItemByStaffIdAction()
    {
        $staffId = $this->getInput('staffId', 'get');
        $lastRetrived = $this->getInput("lastRetrived",'get');

        if(!isset($lastRetrived) || empty($lastRetrived))
        {
            $todaytime = strtotime('today');
            $lastRetrived = date("Y-m-d", $todaytime);
        }
        else
        {
            //时间戳
            $lastRetrived  = date("Y-m-d H:i:s", $lastRetrived);
            //echo $lastRetrived;die;
        }

        // get order status, except cancelled order
        $orderStatus = $this->_getMyOrderDS()->getAllStatus();
        unset($orderStatus['0']);

        $now = date("Y-m-d H:i:s",strtotime('now'));
        $fromTime = $this->stringToDateLowerest($now);
        $toTime = $this->stringToDateBiggest($now);

        $myOrderShops = $this->_getSchoolPeopleDS()->getPeopleSchedule($staffId,11045,0,$fromTime,$toTime);
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


        $result = $this->_getMyOrderDS()->getOrderItemsByShops($shopids,$orderStatus,$lastRetrived);
        $filteredResult = array();
        foreach($result as $key => &$eachOne)
        {
            if($eachOne['shopid'] == $this->getIncidentallyShopId())
            {
                $eachOne['isshundai'] = true;
            }
            else
                $eachOne['isshundai'] = false;

            //check if order create date is within schedule
            $orderdate = $eachOne['orderdate'];

            //check schedule, see if orderdate inside one of those
            foreach($schedules as $key => $eachschedule)
            {
                if($eachschedule['datetimeBegin'] <= $orderdate
                    && $eachschedule['datetimeEnd'] >= $orderdate)
                {
                    //match, then it is the result we need
                    $filteredResult[] = $eachOne;
                    break;
                }
            }

        }

        $this->output($filteredResult);
    }


    //通过订单ID得到订单详情，包括
    //1. 订单的Item
    //2. 状态的流转
    public function  getOrderItemByOrderIdAction()
    {
        $userid = $this->getInput('userid', 'get');
        $orderid = $this->getInput("orderid",'get');

        //应该要判断是否是我的订单
        $result =array();
        $result['Success'] = 1;
        $result['ErrorMessage'] = "";

        if(empty($userid) || empty($orderid))
        {
            $result['Success'] = -1;
            $result['ErrorMessage'] = "无效的参数";

            return $this->output($result);
        }

        $orderItems = $this->_getMyOrderDS()->getOrderItemByOrderIds($orderid);
        $statusFlows = $this->_getMyOrderDS()->getOrderHistory($orderid);
        //$allStatus = $this->_getMyOrderDS()->getAllStatus();

        //foreach ($statusFlows as $key => &$eachFlow) {
            
        //    unset($eachFlow['changedby']);
        //    $eachFlow['statusfrom'] = $allStatus[$eachFlow['statusfrom']];
        //    $eachFlow['statusto'] = $allStatus[$eachFlow['statusto']];

        //}
        $result['Items'] = $orderItems;
        $result['StatusFlow'] = $statusFlows;

       
        return $this->output($result);
    }

    /*
    *   得到商店今日的等待的订单
    *   
    */
    public function getShopWaitingOrdersAction()
    {
        $shopid = $this->getInput("shopid");
        $schoolid = $this->getInput("schoolid");
        $statusid = $this->getInput("statusid");

        $days = 1;

        switch ($statusid) {
            case '-1':
                $statusArray = array("-1" => "缺货");
                break;
            case '0':
                $statusArray = array("0" => "等待确认");
                break;
            case '1':
                $statusArray = array("1" => "已审核");
                break;
            case '2':
                $statusArray = array("2" => "制作中");
                break;
            case '3':
                $statusArray = array("3" => "等待配送");
                break;
            case '4':
                $statusArray = array("4" => "配送中");
                break;
            case '5':
                $statusArray = array("5" => "客户签收");
                break;
            case '6':
                $statusArray = array("6" => "客户拒签");
                break;
            case '7':
                $statusArray = array("7" => "客户取消");
                break; 
            case '8':
                $statusArray = array("8" => "商家已出餐");
                break;          
            
            default:
                $statusArray = array("7" => "商家已出餐");
                break;
        }

        $orderList = $this->_getMyOrderDS()->getShopOrders($shopid,
                                                0,
                                                $days,
                                                $statusArray,
                                                '',
                                                -1,
                                                2,
                                                0);

        //get order ids and get its order items
        $orderIds = " -1 ";
        foreach($orderList as $key => &$eachOrder)
        {
            $orderIds = $orderIds.",".$eachOrder['id'];
        }

        $orderIds = $orderIds." ,-1 ";

        $orderItems = $this->_getMyOrderDS()->getOrderItemByOrderIds($orderIds);

        $result['order'] = $orderList;
        $result['orderItems'] = $orderItems;

        $this->output($result);

    }

    /*
    *   得到商店今日的订单
    *   
    */
    public function getShopTodayOrdersAction()
    {
        $shopid = $this->getInput("shopid");
        $schoolid = $this->getInput("schoolid");

        $days = 1;

        // get order status, except cancelled order
        $statusArray = $this->_getMyOrderDS()->getAllStatus();
        unset($statusArray['0']);
        unset($statusArray['1']);
        unset($statusArray['7']);

        $orderList = $this->_getMyOrderDS()->getShopOrders($shopid,
                                                -1,
                                                $days,
                                                $statusArray,
                                                '',
                                                -1,
                                                2,
                                                0);

        //get order ids and get its order items
        $orderIds = " -1 ";
        foreach($orderList as $key => &$eachOrder)
        {
            $orderIds = $orderIds.",".$eachOrder['id'];
        }

        $orderIds = $orderIds." ,-1 ";

        $orderItems = $this->_getMyOrderDS()->getOrderItemByOrderIds($orderIds);

        $result['order'] = $orderList;
        $result['orderItems'] = $orderItems;

        $this->output($result);

    }


    //根据购物篮选择的商品进行下单
    public function makeOrderAction()
    {
        //模拟数据源
        //$simulatedData =  '{"totalIntegral":27,"merchandises":[{"merchandiseId":"3","qty":"1","integral":2,"shopid":"1"},{"merchandiseId":"8","qty":"1","integral":23,"shopid":"1"}]}';
        //$simulatedData =  json_decode($simulatedData);
        //$simulatedData = $this->class_object_to_array($simulatedData);
        //$simulatedData['orderContactor'] = 'Yang';
        //$simulatedData['orderPhone'] = '15270011972';
        //$simulatedData['orderAddress'] = '311';
        //$simulatedData['orderRemark'] = '不加辣椒';

        $simulatedData = $this->getInput("orderinfo",'get');

        //模拟数据
        //$simulatedData = '{"totalIntegral":27,"merchandises":[{"merchandiseId":"3","qty":"1","integral":2,"shopid":"1"},{"merchandiseId":"8","qty":"1","integral":23,"shopid":"1"}],"orderContactor":"Yang","orderPhone":"15270011972","orderAddress":"311","orderRemark":"\u4e0d\u52a0\u8fa3\u6912"}';
        $simulatedData = urldecode($simulatedData);
        $simulatedData = json_decode($simulatedData);
        $simulatedData = $this->class_object_to_array($simulatedData);

        $result = array("Success" => false,
                        "Message" => "");

        $schoolid = $this->getInput("schoolid");
        $userid = $this->getInput("userid");

        if(empty($schoolid))
        {
            $result['Success'] = false;
            $result['Message'] = "无效的学校ID";

            $this->output($result);
            return;
        }

        //1. check order address etc information
        if(empty($simulatedData['orderContactor'])
            || empty($simulatedData['orderPhone'])
            || empty($simulatedData['orderAddress']))
        {
            $result['Success'] = false;
            $result['Message'] = "订单配送信息不全";

            $this->output($result);
            return;
        }


        //check 是否购买的商品
        if(empty($simulatedData['merchandises']))
        {
            $result['Success'] = false;
            $result['Message'] = "购物车无商品,不能提交订单";

            $this->output($result);
            return;
        }

        //check 每个购买的商品的信息是否有效
        $verfied = true;
        foreach ($simulatedData['merchandises'] as $key => $eachItem) {
            
            if($eachItem['merchandiseId'] <=0
                || $eachItem['qty'] <= 0
                || $eachItem['shopid'] <= 0)
            {
                 $verfied = false;
                 break;
            }

        }

        if($verfied == false)
        {
            $result['Success'] = false;
            $result['Message'] = "购物车商品信息不全,不能提交订单";

            $this->output($result);
            return;
        }

        if($userid <= 0)
        {
            //generate tmp userid
            $newInfo = $this->_getTmpUserDS()->registerTmpUser(2);
            $userid = $newInfo['uid'];
        }


        //开始创建订单
        $generatedIds = $this->_getMyOrderDS()->makeOrder(
                                            $userid,
                                            $schoolid,
                                            $simulatedData['merchandises'],
                                            $simulatedData['orderContactor'],
                                            $simulatedData['orderPhone'],
                                            $simulatedData['orderAddress'],
                                            $simulatedData['ordernotes'],
                                            '手机');

        if(empty($result))
        {
            $result['Success'] = false;
            $result['Message'] = "创建订单失败,无订单ID返回";
            $result['User'] = $newInfo;
            $this->output($result);
            return;
        }
        else
        {
            $result['Success'] = true;
            $result['Message'] = "";
            $result['GeneratedIds'] = $generatedIds;
            $result['User'] = $newInfo;

            $this->output($result);
            return;
        }

        
    }



    /*
    * 更新订单的状态
    * 传过来的是Json格式的数据, 例如，order item的id 为11，12，13，他们的状态都已经为已下单(状态为2)，
    * 那么就是 11,12,13:2 类似的json格式
    * 如果以json之前的数组，那就是
    * ("11,12,13" => 2)
    *
    * 返回受影响的行数
    */
    public function updateOrderItemStatusAction()
    {

        $items = $this->getInput("items");
        $status = $this->getInput("status");
        $itemArray = (array)json_decode($items);


        //key is order ids
        //value is status to be updated
        $strItems = " -1, ";
        foreach ($itemArray as $key => $orderitemid) {
            if(empty($orderitemid) || empty($status))
            {
                continue;
            }
            
            $strItems = $strItems.$orderitemid.", ";
            
        }
        $strItems .= " -1 ";

        $result = $this->_getMyOrderDS()->updateOrderItemStatus($strItems,$status);
        
        $this->output(($result >= 0 ));
    }


    /*
    * 更新订单的状态
    * 传过来的是Json格式的数据
    * [{"ids": [12,21,2],"status":1},{"ids":[30,28],"status" : 2}]
    * 返回受影响的行数
    */
    public function batchUpdateOrderItemStatusAction()
    {

        $itemStatus = $this->getInput("itemStatus");
        $itemStatus = urldecode($itemStatus);

        $itemStatusArray = (array)json_decode($itemStatus);


        foreach ($itemStatusArray as $key => $eachItemStatus) {
            
                $eachItemStatus = (array)$eachItemStatus;

                $itemArray = $eachItemStatus['ids'];
                $status = $eachItemStatus['status'];

                //key is order ids
                //value is status to be updated
                $strItems = " -1, ";
                foreach ($itemArray as $key => $orderitemid) {
                    if(empty($orderitemid) || empty($status))
                    {
                        continue;
                    }
                    
                    $strItems = $strItems.$orderitemid.", ";
                    
                }
                $strItems .= " -1 ";


                $result = $this->_getMyOrderDS()->updateOrderItemStatus($strItems,$status);
                
                
            }

            $this->output(($result >= 0 ));
    }


    public function getCurrentStampAction()
    {
        $result = time();
        $this->output($result);
    }


    private function  getShopIdListByStaffId($staffId)
    {
        $shopIdWithStaffMapping = array(
            7 => '28,29,30,31,32,33,34,35',
            1 => " 1, 2 ,3"
        );

        if(array_key_exists($staffId, $shopIdWithStaffMapping))
        {
            return $shopIdWithStaffMapping[$staffId];
        }
        else
            return ' -1 ';

    }

    /**
     * 生成UserDM对象
     * @param string $mail
     * @param string $nick
     * @return object UserDM
     */
    private function _registerTmpUser(){
        Wind::import('SRC:service.user.dm.PwUserInfoDm');
        $userDm = new PwUserInfoDm();
        $password = substr(md5(rand().'123456'),0,15);

        //order number: 13 number and 3 random number
        $currentTimeStamp = strtotime("+0 day");
        $username = 'app'.rand(10, 99) . $currentTimeStamp;

        $userDm->setUsername($username);
        $userDm->setPassword($password);
        $userDm->setRegdate(Pw::getTime());
        $userDm->setLastvisit(Pw::getTime());
        $userDm->setRegip(Wekit::app()->clientIp);

        Wind::import('SRV:user.srv.PwRegisterService');
        Wind::import('APPS:u.service.helper.PwUserHelper');
        Wind::import('SRV:user.validator.PwUserValidator');
        Wind::import('Wind:utility.WindValidator');
        Wind::import('SRV:user.srv.PwLoginService');
        
        $registerService = new PwRegisterService();
        $registerService->setUserDm($userDm);
        $info = $registerService->register();

        $userService = Wekit::load('user.srv.PwUserService');
        $userService->updateLastLoginData($info['uid'], Wekit::app()->clientIp);
        $userService->createIdentity($info['uid'], $password);

        
        return $info;
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
     * @return App_SchoolPeople
     */
    private function _getSchoolPeopleDS()
    {
        return Wekit::load('EXT:4tschool.service.schoolpeople.App_SchoolPeople');
    }

    /**
     * @return App_TmpUser
     */
    private function _getTmpUserDS()
    {
        return Wekit::load('EXT:4tschool.service.tmpuser.App_Tmpuser');
    }
}

?>