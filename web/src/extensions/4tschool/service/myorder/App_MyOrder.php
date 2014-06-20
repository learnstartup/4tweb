<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_MyOrder - 数据服务接口
 *
 */
class App_MyOrder
{

    private $statusArray = array
    (
        0 => array(
            "-1" => "缺货",
            "0" => "等待商家确认",
            "1" => "已审核",
            "2" => "制作中",
            "3" => "等待配送",
            "4" => "配送中",
            "5" => "客户签收",
            "6" => "客户拒签",
            "7" => "客户取消",
            "8" => "商家已出餐",
        ),
        1 => array(
            "-1" => "缺货",
            "0" => "等待商家确认",
            "1" => "已审核",
            "2" => "制作中",
            "3" => "等待配送",
            "4" => "配送中",
            "8" => "商家已出餐",
        ),
        2 => array("5" => "客户签收"),
        3 => array(
            "6" => "客户拒签",
            "7" => "客户取消"),
        4 => array(
            "4" => "配送中",
            "5" => "客户签收",
            "6" => "客户拒签"
        ),

        5 => array(
            "2" => "制作中",
            "3" => "等待配送",
            "8" => "商家已出餐"
        ),

        6 => array(
                 "5" => "客户签收",
                "6" => "客户拒签",
                "7" => "客户取消"
            ),
        7 => array('-1' => '缺货'),
        8 => array('0' => '等待商家确认'),
        9 => array(
                "6" => "客户拒签"
            )

    );

    private $deliverMethod = array(

        1 => "商家自主配送",
        2 => "商家自营",

    );


    private $myMenus = array(
        '帐务管理与统计' => array(
            array('name' => "外卖商家统计", 'extra' =>"statistic", 'role' => 'master', 'link' => 'index.php?app=4tschool&m=app&c=agentshoporder&a=run'),
            array('name' => "商品销量统计", 'extra' =>"statistic", 'role' => 'master', 'link' => 'index.php?m=app&c=statistic&page=1&app=4tschool'),

            //array('name' => "下单人员下单统计", 'extra' =>"statistic", 'role' => 'master', 'link' => 'index.php?m=app&c=statistic&page=1&app=4tschool&a=orderfor'),
            //array('name' => "配送人员配送统计", 'extra' =>"statistic", 'role' => 'master', 'link' => 'index.php?m=app&c=statistic&page=1&app=4tschool&a=delivery'),
        ),
        '商家管理' => array(
            array('name' => "管理商家", 'extra' =>"shoplist", 'role' => 'master', 'link' => 'index.php?m=app&c=shoplist&app=4tschool&a=shopmanage'),
        ),
        // '人员排班管理' => array(
        //     array('name' => "下单人员排班管理", 'extra' =>"statistic", 'role' => 'master', 'link' => 'index.php?m=app&c=peopleschedule&page=1&app=4tschool&a=orderfor'),
        // ),
        '学校订单管理' => array(
            array('name' => "订单分配管理", 'extra' =>"order", 'role' => 'master;orderdispatch', 'link' => 'index.php?m=app&c=schoolorder&page=1&app=4tschool'),
            array('name' => "订单缺货管理", 'extra' =>"order", 'role' => 'master;orderdispatch', 'link' => 'index.php?m=app&c=schoolorder&page=1&app=4tschool&a=noItem&choosenStatusCategory=7'),
            //array('name' => "责任人订单",  'extra' =>"order", 'role' => 'master;orderdispatch', 'link' => 'index.php?m=app&c=schoolorder&page=1&app=4tschool&a=responsibles&cassignstatus=undefined'),
            array('name' => "留言管理",  'extra' =>"systemfeedback", 'role' => 'master;orderdispatch', 'link' => 'index.php?m=app&c=myfeedback&page=1&app=4tschool&a=manage'),
        ),
        //'我负责的订单' => array(
        //    array('name' => "负责配送的订单", 'role' => 'delivery', 'link' => 'index.php?m=app&c=schoolorder&page=1&app=4tschool&a=myresponsibles'),
        //    array('name' => "负责下单的订单", 'role' => 'areaorderget', 'link' => 'index.php?m=app&c=schoolorder&page=1&app=4tschool&a=myareaorder'),
        //),
        // '菜品评价' => array(
        //     array('name' => '待评价', 'extra' =>"feedback",  'role' => '', 'link' => 'index.php?m=app&c=shopcomment&page=1&app=4tschool&a=mynocomment'),
        //     array('name' => '已评价', 'extra' =>"feedback", 'role' => '', 'link' => 'index.php?m=app&c=shopcomment&page=1&app=4tschool&a=mycomment'),
        // ),

        '订单管理' => array(
            array('name' => '我的订单', 'extra' =>"order", 'role' => '', 'link' => 'index.php?m=app&c=schoolorder&page=1&app=4tschool&a=myorder'),
            array('name' => '零钱包(点币)', 'extra' =>"mywallet", 'role' => '', 'isnew'=>'true','link' => 'index.php?m=app&c=myaccount&page=1&app=4tschool&a=mymoney'),
        ),
        '我的收藏' => array(
            array('name' => '已购菜品', 'extra' =>"order", 'role' => '', 'link' => 'index.php?m=app&c=myfavorite&page=1&app=4tschool&a=orderedmechandise'),
            array('name' => '我的收藏', 'extra' =>"myfavorite", 'role' => '', 'link' => 'index.php?m=app&c=myfavorite&page=1&app=4tschool&a=run')
        ),
        '账户管理' => array(
            array('name' => '编辑个人档案', 'extra' =>"myinfo", 'role' => '', 'link' => 'index.php?m=app&c=myaccount&page=1&app=4tschool&a=run'),
            array('name' => '安全中心', 'extra' =>"security", 'role' => '', 'link' => 'index.php?m=app&c=myaccount&page=1&app=4tschool&a=securitycenter'),
            array('name' => '我的积分', 'extra' =>"mycredit", 'role' => '', 'link' => 'index.php?m=app&c=myaccount&page=1&app=4tschool&a=mycredit'),
            array('name' => '送餐地址','extra' =>"myaddress",  'role' => '', 'link' => 'index.php?m=app&c=myaccount&page=1&app=4tschool&a=orderaddress'),
            array('name' => '我的留言','extra' =>"systemfeedback",  'role' => '', 'link' => 'index.php?m=app&c=myfeedback&page=1&app=4tschool&a=run'),

        ),
    );


    public function canVisitLink($schoolid, $menuName, $userid)
    {
        $roles = '';
        $found = false;
        //1st get menu name to get roles
        foreach ($this->myMenus as $key => $eachArray) {
            if ($found == true) {
                break;
            }

            foreach ($eachArray as $eachkey => $value) {
                if ($value['name'] == $menuName) {
                    $roles = $value['role'];
                    $found = true;
                    break;
                }
            }
        }

        //get check user if in role
        if ($roles == '')
            return true;


        $roleArray = explode(";", $roles);

        foreach ($roleArray as $key => $eachRole) {
            $canVisit = $this->_loadSchoolPeopleDao()->checkIfExists($schoolid, $userid, $eachRole);
            if ($canVisit)
                return true;
        }

        return false;
    }


    public function getAllStatus()
    {
        return $this->statusArray[0];
    }


    public function getOpenStatus()
    {
        return $this->statusArray[1];
    }

    public function getDeliveryMethods()
    {
        return $this->deliverMethod;
    }


    /*
     *
     * 这个状态，和发货的状态是不一致的，例如，这个Order 状态只会具有进行中，已关闭等，但不设计到具体的状体啊，例如配送中等：
     */
    public function getOrderStatusCategory()
    {
        return array(
            0 => "全部订单",
            1 => "交易进行中的订单",
            2 => "交易成功的订单",
            3 => "交易失败的订单",
            8 => "等待授理的订单",
            7 => "缺货的订单"
        );

    }


    //category is 5, that's mean
    public function getAreaOrdererStatusCategory()
    {
        return $this->statusArray[5];

    }

    //category is 4, that's mean
    public function getOrdererDeliveryStatusCategory()
    {
        return $this->statusArray[4];

    }

    //get finished status
    public function getOrdererFinishedStatusCategory()
    {
        return $this->statusArray[6];

    }


    public function getStatusCategoryStatus()
    {
        return $this->statusArray;
    }


    public function getStatusArray($statusCategory)
    {
        $statusChoosen = $this->statusArray[$statusCategory];
        return $statusChoosen;
    }


    public function getRandomTestOrders()
    {
        $orderArr = array();
        for ($i = 0; $i <= 100; $i++) {
            $eachOrder = array(
                "id" => $i + 1,
                "ordernumber" => $i * 100,
                "ordermoney" => $i * 3,
                "paymethod" => 1,
                "userid" => 2,
                "status" => $i,
                "orderdate" => "2013-03-11"
            );
            $orderArr[] = $eachOrder;
        }
        return $orderArr;
    }

    public function startTran()
    {
        return $this->_loadDao()->startTran();
    }

    public function commit()
    {
        return $this->_loadDao()->commit();
    }

    public function rollBack()
    {
        return $this->_loadDao()->rollBack();
    }


    /*
    * 基于我的权限返回我能看到的菜单
    *
    */
    public function getMyMenus($schoolid, $userid)
    {
        //get my roles
        $roles = $this->_loadSchoolPeopleDao()->getMyRolesInSchool($schoolid, $userid);

        //get school extra
        $schoolExtra = $this->_loadSchoolExtraDao()->getSchoolExtra($schoolid);
        $schoolExtra = $schoolExtra[0];
        
        $menuOutput = array();

        foreach ($this->myMenus as $group => $menus) {
            $shallAddGroup = false;
            $menuInsideGroup = array();
            foreach ($menus as $key => $eachMenu) {

                $extra = $eachMenu['extra'];

                $opened = true;

                switch ($extra) {
                    case 'order':
                        if(empty($schoolExtra) == false && $schoolExtra['openorder'] == 0)
                        {
                            $opened = false;
                            continue; //skip this menu and goes to next
                        }
                        break;
                    case "statistic":
                        
                        break;
                    case "systemfeedback":
                        if(empty($schoolExtra) == false && $schoolExtra['openliuyanban'] == 0)
                        {
                            $opened = false;
                            continue; //skip this menu and goes to next
                        }
                        break;
                    case "feedback":
                        if(empty($schoolExtra) == false && $schoolExtra['openorder'] == 0)
                        {
                            $opened = false;
                            continue; //skip this menu and goes to next
                        }
                        break;
                    case "myfavorite":
                        break;
                    case "shoplist":
                        break;
                    case "myinfo":
                        break;
                    case "mycredit":
                        break;
                    case "security":
                        break;
                    case "mywallet":
                        if(empty($schoolExtra) == false && $schoolExtra['openwallet'] == 0)
                        {
                            $opened = false;
                            continue; //skip this menu and goes to next
                        }
                        break;
                    
                    default:
                        break;
                }

                if($opened == false)
                    continue;


                $roleformenu = $eachMenu['role'];
                $rolesArrayForMenu = explode(";", $roleformenu);

                if (empty($roleformenu) || $this->viewableMenu($roles, $rolesArrayForMenu)) {
                    $shallAddGroup = true;
                    $menuInsideGroup[] = $eachMenu;
                }
            }

            if ($shallAddGroup)
                $menuOutput[$group] = $menuInsideGroup;
        }

        return $menuOutput;
    }

    private function viewableMenu($myRoles, $rolesOfMenu)
    {
        foreach ($myRoles as $mykey => $myValue) {
            foreach ($rolesOfMenu as $menukey => $menuValue) {
                if ($myValue["type"] == $menuValue)
                    return true;
            }
        }

        return false;
    }

    /*
    *
    */
    public function getOrderRange()
    {
        $orderRange = array(
            1 => "今天的订单",
            30 => "30天以内订单",
            90 => "3个月以内订单",
            180 => "半年内订单",
            360 => "一年内订单",
            0 => "所有订单"
        );
        return $orderRange;
    }

    public function getOrderShopRange()
    {
        $orderShopRange = array(
            1 => "代客下单",
            2 => "所有商家"
        );

        return $orderShopRange;
    }

    public function countDelayConfirmOrder($timeDelay = 240)
    {
        $checktime = time() - $timeDelay; //4分钟还没有确认的订单

        return $this->_loadDao()->countDelayConfirmOrder($checktime,$fromDate, $toDate);
    }

     /*列出我的订单急于搜索条件
     *
     */
    public function getOrders($uid,
                              $schoolid,
                              $days,
                              $statusArray,
                              $searchTxt,
                              $schoolArea,
                              $assignedStatus,
                              $assignedppl,
                              $limit,
                              $offset)
    {
        return $this->_loadDao()->getOrders($uid,
            $schoolid,
            $days,
            $statusArray,
            $searchTxt,
            $schoolArea,
            $assignedStatus,
            $assignedppl,
            $limit,
            $offset);
    }

    public function getToUserOrders($uid,
                              $schoolid,
                              $days,
                              $statusArray,
                              $searchTxt,
                              $schoolArea,
                              $assignedStatus,
                              $assignedppl,
                              $ifallShopOrder,
                              $orderRjectApproved,
                              $limit,
                              $offset)
    {
        return $this->_loadDao()->getToUserOrders($uid,
            $schoolid,
            $days,
            $statusArray,
            $searchTxt,
            $schoolArea,
            $assignedStatus,
            $assignedppl,
            $ifallShopOrder,
            $orderRjectApproved,
            $limit,
            $offset);
    }

    public function countOrders($uid,
                                $schoolid,
                                $days,
                                $statusArray,
                                $searchTxt,
                                $schoolArea,
                                $assignedStatus,
                                $assignedppl,
                                $limit,
                                $offset)
    {
        return $this->_loadDao()->countOrders($uid,
            $schoolid,
            $days,
            $statusArray,
            $searchTxt,
            $schoolArea,
            $assignedStatus,
            $assignedppl,
            $limit,
            $offset);
    }
    public function countAgentOrders($schoolid, $shopId, $fromDate, $toDate)
    {
        return $this->_loadDao()->countAgentOrders($schoolid, $shopId, $fromDate, $toDate);
    }
    public function countAgentOrderMoney($schoolid, $shopId, $fromDate, $toDate) 
    {
        return $this->_loadDao()->countAgentOrderMoney($schoolid, $shopId, $fromDate, $toDate);
    } 

    public function getAgentOrders($schoolid, $shopId, $fromDate, $toDate,$limit, $start)
    {
        return $this->_loadDao()->getAgentOrders($schoolid, $shopId, $fromDate, $toDate,$limit, $start);
    }

    public function countToUserOrders($uid,
                                $schoolid,
                                $days,
                                $statusArray,
                                $searchTxt,
                                $schoolArea,
                                $assignedStatus,
                                $assignedppl,
                                $countToUserOrders,
                                $ifallShopOrder,
                                $orderRjectApproved)
    {
        return $this->_loadDao()->countToUserOrders($uid,
            $schoolid,
            $days,
            $statusArray,
            $searchTxt,
            $schoolArea,
            $assignedStatus,
            $assignedppl,
            $countToUserOrders,
            $ifallShopOrder,
            $orderRjectApproved);
    }

    /*
     *得到商店的订单
     *
     */
    public function getCountShopOrders($shopid,
                              $schoolid,
                              $days,
                              $statusArray,
                              $searchTxt,
                              $schoolArea,
                              $assignedStatus,
                              $assignedppl,
                              $limit,
                              $offset)
    {
        return $this->_loadDao()->getCountShopOrders($shopid,
            $schoolid,
            $days,
            $statusArray,
            $searchTxt,
            $schoolArea,
            $assignedStatus,
            $assignedppl,
            $limit,
            $offset);
    }

    public function getShopOrdersByShopId($shopid,
                                    $schoolid,
                                    $statusArray,
                                    $searchTxt,
                                    $schoolArea,
                                    $assignedStatus,
                                    $assignedppl,
                                    $startstrtotime,
                                    $endstrtotime,
                                    $limit,
                                    $offset){
        return $this->_loadDao()->getShopOrdersByShopId($shopid,
                                    $schoolid,
                                    $statusArray,
                                    $searchTxt,
                                    $schoolArea,
                                    $assignedStatus,
                                    $assignedppl,
                                    $startstrtotime,
                                    $endstrtotime,
                                    $limit,
                                    $offset);
    }

    public function countShopOrderMoney($shopid,
                                        $schoolid,
                                        $statusArray,
                                        $searchTxt,
                                        $schoolArea,
                                        $assignedStatus,
                                        $assignedppl,
                                        $startstrtotime,
                                        $endstrtotime)
    {
        return $this->_loadDao()->countShopOrderMoney($shopid,
                                                      $schoolid,
                                                      $statusArray,
                                                      $searchTxt,
                                                      $schoolArea,
                                                      $assignedStatus,
                                                      $assignedppl,
                                                      $startstrtotime,
                                                      $endstrtotime);
    }

    public function getShopOrders($shopid,
                              $schoolid,
                              $days,
                              $statusArray,
                              $searchTxt,
                              $schoolArea,
                              $assignedStatus,
                              $assignedppl,
                              $limit,
                              $offset)
    {
        return $this->_loadDao()->getShopOrders($shopid,
            $schoolid,
            $days,
            $statusArray,
            $searchTxt,
            $schoolArea,
            $assignedStatus,
            $assignedppl,
            $limit,
            $offset);
    }

    //通过订餐时间查询订单数
    public function getOrdersByCreateTime($schoolid,$statusArray,$timeBegin,$timeEnd)
    {
        return $this->_loadDao()->getOrdersByCreateTime($schoolid,$statusArray,$timeBegin,$timeEnd);
    }

    //看看哪些用户是第一次下单(在某个时间点以后)
    public function getFirstOrderInRangeSinceDate($fromTime, $toTime,$firstOrderSince0331 = 1)
    {
        return $this->_loadDao()->getFirstOrderInRangeSinceDate($fromTime,$toTime,$firstOrderSince0331);
    }


    //计算根据订单统计出来的订单的钱
    public function countOrderMoney($uid,
                                $schoolid,
                                $days,
                                $statusArray,
                                $searchTxt,
                                $schoolArea,
                                $assignedStatus,
                                $assignedppl,
                                $limit,
                                $offset)
    {
        return $this->_loadDao()->countOrderMoney($uid,
            $schoolid,
            $days,
            $statusArray,
            $searchTxt,
            $schoolArea,
            $assignedStatus,
            $assignedppl,
            $limit,
            $offset);
    }

    public function countToUserOrderMoney($uid,
                                          $schoolid,
                                          $days,
                                          $statusArray,
                                          $searchTxt,
                                          $schoolArea,
                                          $assignedStatus,
                                          $assignedppl,
                                          $ifallShopOrder,
                                          $orderRjectApproved)
    {
        return $this->_loadDao()->countToUserOrderMoney($uid,
            $schoolid,
            $days,
            $statusArray,
            $searchTxt,
            $schoolArea,
            $assignedStatus,
            $assignedppl,
            $ifallShopOrder,
            $orderRjectApproved);
    }

    public function getOrderDeservedPointCoinByOrderId($orderid)
    {
        return $this->_loadDao()->getOrderDeservedPointCoinByOrderId($orderid);
    }

    /*
     *
     * 某个订单的基本信息
     */
    public function getOrdertail($id)
    {
        return $this->_loadDao()->getOrderDetail($id);
    }

    /*
    * 通过Order Item的主键得到它的信息
    */
    public function getOrderItemById($id)
    {
        return $this->_loadOrderItemDao()->getOrderItemById($id);
    }

    /*
     *
     * 一个订单的订的商品信息
     */
    public function getOrderItems($orderid)
    {
        return $this->_loadOrderItemDao()->getOrderItems($orderid);
    }


    /*
    * 通过  order id 列表获取 order item
    */
    public function getOrderItemByOrderIds($orderids, $limit, $offset)
    {
        return $this->_loadOrderItemDao()->getOrderItemByOrderIds($orderids, $limit, $offset);
    }


    /*
    * 提取某个人的所有已经购买的菜品
    * 取消的订单的商品不会被拿出来
    */
    public function getOrderItemsByUser($schoolid, $userid, $includeCancelled = false, $limit, $offset)
    {
        return $this->_loadOrderItemDao()->getOrderItemsByUser($schoolid, $userid, $includeCancelled, $limit, $offset);
    }

    /*
    * 总数: 某个人的所有已经购买的菜品
    */
    public function CountOrderItemsByUser($schoolid, $userid,$includeCancelled = false, $limit, $offset)
    {
        return $this->_loadOrderItemDao()->CountOrderItemsByUser($schoolid, $userid, $includeCancelled, $limit, $offset);
    }


    /*
    * 下单最多的
    */
    public function getOrderedMost($count)
    {
        $resultTxt = array();
        $resultList = $this->_loadDao()->getOrderedMost($count);
        foreach ($resultList as $key => $item) {

            $shopLink = WindUrlHelper::createUrl('app/4tschool/shopdetails/run', array('shopid' => $shopid));
            $merchadiseLink = WindUrlHelper::createUrl('app/4tschool/shopdetails/run', array('shopid' => $shopid));

            $item['shopLink'] = $shopLink;
            $item['merchadiseLink'] = $merchadiseLink;

            $resultTxt[] = $item;
        }

        return $resultTxt;
    }

    /*
    * 得到最近的几条订单（谁在哪买了什么）
    */
    public function getLatestOrder($count)
    {
        return $this->_loadDao()->getLatestOrder($count);
    }

    /*
    * 得到最近的几条订单（谁在哪买了什么）文本
    */
    public function getLatestOrderTxt($count)
    {
        $resultTxt = array();
        $resultList = $this->getLatestOrder($count);
        foreach ($resultList as $key => $item) {
            $eachLine = array();
            //who
            $user = $item['username'];
            $shop = $item['name'];
            $shopid = $item['shopid'];
            $merchadise = $item['merchandisename'];


            $shopLink = WindUrlHelper::createUrl('app/4tschool/shopdetails/run', array('shopid' => $shopid));
            $merchadiseLink = WindUrlHelper::createUrl('app/4tschool/shopdetails/run', array('shopid' => $shopid));

            $item['shopLink'] = $shopLink;
            $item['merchadiseLink'] = $merchadiseLink;

            $resultTxt[] = $item;
        }

        return $resultTxt;
    }

    /*
    * 判断订单是否是所有者的
    */
    public function isMyOrder($userid, $orderid)
    {
        return $this->_loadDao()->isMyOrder($userid, $orderid);
    }

    /*
    * 得到订单的顺序号
    */
    public function getOrderSequence($orderid)
    {
        $result =  $this->_loadDao()->getOrderSequence($orderid);

        if(!empty($result))
        {
            return $result[0]['sequence'];
        }
    }


    /*
    *	通过商家分组查看
    */
    public function getOrdersGroupbyShop($schoolid, $shopId, $statusArray, $fromTime, $toTime)
    {
        $result = $this->_loadDao()->getOrdersGroupbyShop($schoolid,$shopId, $statusArray, $fromTime,$toTime);

        //try group by
        $orderGroup = array();
        $shops = array();
        foreach ($result as $key => $eachItem) {
            $shopname = $eachItem['shopname'];
            if (!isset($shops[$shopname])) {
                $shops[$shopname] = array("Name" => $shopname,
                    "Address" => $eachItem['address'],
                    "Phone" => $eachItem['phone'],
                    "PayTotal" => 0,
                    "Items" => array());

            }

            $finded = false;
            //check if exiting shop has that merchadise or not
            foreach ($shops[$shopname]['Items'] as $eachShop => &$groupedItem) {

                if ($groupedItem['mid'] == $eachItem['mid']
                    && $groupedItem['price'] == $eachItem['price']
                ) //find same item, then count
                {

                    $finded = true;
                    $groupedItem['quatity'] += $eachItem['quatity'];

                    $msequence = $eachItem['msequence'];
                    $groupedItem['msequence'][] = array("sequence" => $msequence, "oid" => $eachItem['oid']);

                    //calcute the total money need to pay
                    $shops[$shopname]['PayTotal'] += $eachItem['price'] * $eachItem['quatity'];

                    break;
                }
            }

            if ($finded == false) {

                $msequence = $eachItem['msequence'];
                unset($eachItem['msequence']);
                $eachItem['msequence'][] = array("sequence" => $msequence, "oid" => $eachItem['oid']);

                $shops[$shopname]['Items'][] = $eachItem;

                //calculate the total money need to pay
                $shops[$shopname]['PayTotal'] += $eachItem['price'] * $eachItem['quatity'];
            }

            continue;


        }
        $r = array();
        foreach ($shops as $key => $value) {
            $r[] = $value;
        }

        return $r;


    }


    /*
    *   通过配送人分组查看
    */
    public function getOrdersGroupbyDelivery($schoolid,$deliveryId, $statusArray, $fromTime, $toTime)
    {
        $result = $this->_loadDao()->getOrdersGroupbyDelivery($schoolid,$deliveryId,$statusArray, $fromTime,$toTime);
        $userDelivery = array();
        $countedOrder = array();
        //do the calculation and grouping
        foreach ($result as $key => $eachItem) {
            $userid = $eachItem['deliverId'];
            $orderid = $eachItem['orderid'];
            $ordermoney = $eachItem['ordermoney'];
            $shopid = $eachItem['shopid'];
            $needPackingPrice = $eachItem['needPackingPrice'];
            $status = $eachItem['status'];
            $quatity = $eachItem['quatity'];
            $deliverby = $eachItem['deliverby'];

            if($userid <= 0)
                $userid = -1;

            if(array_key_exists($userid, $userDelivery) == false)
            {
                $userDelivery[$userid] = array();
            }

            if($status != 5 && $status != 6) //客户签收，客户拒绝
            {
                 $userDelivery[$userid]['NotFinishOrder'] = true;
                 continue;
            }

            
            if(array_key_exists($orderid, $countedOrder) == false)
            {
                $countedOrder[$orderid] = array();
                $userDelivery[$userid]['totalMoney'] += $ordermoney;
                $userDelivery[$userid]['totalOrder'] += 1;
                $userDelivery[$userid]['deliverby'] = $deliverby;

                if($status == 5)
                    $userDelivery[$userid]['totalAcceptMoney'] += $ordermoney;
                else if($status == 6)
                    $userDelivery[$userid]['totalDeclineMoney'] += $ordermoney;

            }

            //总份数
            $userDelivery[$userid]['totalQuantity'] += $quatity;

            //check if it is 顺带
            if($shopid == $this->getIncidentallyShopId())
            {
                $userDelivery[$userid]['totalShunDaiQuantity'] += $quatity;
            }
            else
            {
                if($needPackingPrice)
                    $userDelivery[$userid]['totalBonusQuantity'] += $quatity;
                else
                    $userDelivery[$userid]['totalNoBonusQuantity'] += $quatity;
            }

        }

        return $userDelivery;

    }

    /*
    *   通过下单人分组查看
    */
    public function getOrdersGroupbyOrderPeople($schoolid, $shopId, $statusArray, $fromTime, $toTime)
    {
        $result = $this->_loadDao()->getOrdersGroupbyShop($schoolid,$shopId, $statusArray, $fromTime,$toTime);

        //try group by
        $orderGroup = array();
        $shops = array();
        foreach ($result as $key => $eachItem) {
            $shopname = $eachItem['shopname'];
            if (!isset($shops[$shopname])) {
                $shops[$shopname] = array("Name" => $shopname,
                    "Address" => $eachItem['address'],
                    "Phone" => $eachItem['phone'],
                    "PayTotal" => 0,
                    "Items" => array());

            }

            $finded = false;
            //check if exiting shop has that merchadise or not
            foreach ($shops[$shopname]['Items'] as $eachShop => &$groupedItem) {

                if ($groupedItem['mid'] == $eachItem['mid']
                    && $groupedItem['price'] == $eachItem['price']
                ) //find same item, then count
                {

                    $finded = true;
                    $groupedItem['quatity'] += $eachItem['quatity'];

                    $msequence = $eachItem['msequence'];
                    $groupedItem['msequence'][] = array("sequence" => $msequence, "oid" => $eachItem['oid']);

                    //calcute the total money need to pay
                    $shops[$shopname]['PayTotal'] += $eachItem['price'] * $eachItem['quatity'];

                    break;
                }
            }

            if ($finded == false) {

                $msequence = $eachItem['msequence'];
                unset($eachItem['msequence']);
                $eachItem['msequence'][] = array("sequence" => $msequence, "oid" => $eachItem['oid']);

                $shops[$shopname]['Items'][] = $eachItem;

                //calculate the total money need to pay
                $shops[$shopname]['PayTotal'] += $eachItem['price'] * $eachItem['quatity'];
            }

            continue;


        }
        $r = array();
        foreach ($shops as $key => $value) {
            $r[] = $value;
        }

        return $r;


    }

    public function makeOrder(  
                                $userid,
                                $schoolId,
                                $merchandisesInfo,
                                $to,
                                $phone,
                                $address,
                                $note,
                                $source,
                                $orderExpressTime='',
                                $orderHour='',
                                $orderMinutes='',
                                $shopDeduct=array())
    {
       
        //get ordered merchandise and information relates to it
        //say. 数量，积分
        //基于商店拆分订单

        $groupOrdersByShop = array();

        $orderItems = $merchandisesInfo;
        foreach($orderItems as $key => &$eachItem)
        {
            $eachItem = (array)$eachItem;
            
            $groupOrdersByShop[$eachItem['shopid']][]  = $eachItem;

        }

        $orderTime = $orderHour.':'.$orderMinutes;


        $deliveryInfo = array(
            "to" => $to,
            "phone" => $phone,
            "address" => $address,
            "note" => $note,
            "preorder" => ($orderExpressTime==''),
            "preoderat" => $orderTime,

            );

        $notes = array();
        if(is_array($note)){
            foreach ($note as $key => $value) {
                $notes[$value['shopid']] = $value['note'];
            }
        }

        $generatedOrderIds = array();

        $totalDianMoney = 0;

        $isFirst = $this->isFirstOrder($userid);

        $isFirstSince0331 = ($isFirst || $this->isFirstOrder($userid,'2014-03-31'));

        foreach ($groupOrdersByShop as $shopid => $orderItems) 
        {

        	$shopInfo = $this->_getShopDS()->getByShopId($shopid);

            //generateOrderNumber
            $generatedOrderNumber = $this->generateOrderNumber();
            //$successMessage = "下单成功";

            $totalMoney = 0;
            $totalOriginalMoney = 0;

            //estimate delivery time(from order to user)
            $estimatetime = $this->_getShopDS()->getShopOrderTimeBase($shopid);

            date_default_timezone_set("Asia/Shanghai");
            $currentTime = time() + ($estimatetime * 60);

            $estimateDeliveryat = date('Y-m-d H:i:s', $currentTime);

            if(is_array($note))
            {
                $mark = $notes[$shopid];
            }else{
                $mark = $note;
            }

            //check shop if is order to user(代课下单的意思)
            $ifordertouser = $shopInfo['openordertouser']; //$this->_getShopDS()->checkIfOrderToUser($shopid);

            //check order items
            //compose order data
            Wind::import('EXT:4tschool.service.myorder.dm.App_Order_Dm');
            $dmorder = new App_Order_Dm();
            $dmorder->setUserId($userid)
                ->setSchoolId($schoolId)
                ->setShopId($shopid)
                ->setOrderNumber($generatedOrderNumber)
                ->setStatus(0) //默认为待处理
                ->setPaymethod(1) //货到付款
                ->setDelivermethod() //分享哟品牌自营
                ->setTo($deliveryInfo['address'])
                ->setToWho($deliveryInfo['to'])
                ->setToMobile($deliveryInfo['phone'])
                ->setPreOrder($deliveryInfo['preorder'])
                ->setPreOrderAt($deliveryInfo['preorderat'])
                ->setSavingtotal($totalOriginalMoney - $totalMoney)
                ->setOrdermoney($totalMoney)
                ->setNote($mark)
                ->setEstimatedeliveryat($estimateDeliveryat)
                ->setEstimatetime($estimatetime)
                ->setSource($source)
                ->setFirstOrder($isFirst?1:0)
                ->setFirstOrderSince0331($isFirstSince0331)
                ->setOrderToUser($ifordertouser?1:0);

            $orderid = $this->insertOrder($dmorder);

            //calculate deduct price
            $totalDeduct = 0;


            if($orderid > 0)
            {

                $generatedOrderIds[] = $orderid;

                //insert order status history
                $this->insertOrderStatusHistory($orderid,$this->loginUser->uid,0,1);
                //order sequence
                $sequence = $this->getOrderSequence($orderid);

                $i = 0;

                $totalQuantity = 0;
                foreach($orderItems as $key => $value)
                {
                    $i++;
                    $merchandiseId = $value['merchandiseId'];
                    //check item
                    $merchandiseInfo = $this->_getMerchandiseDS()->getMerchandiseById($merchandiseId);
                    
                    $needPackingPrice = $merchandiseInfo['needPackingPrice'];

                    if($needPackingPrice == 1)
                        $packingPrice = $shopInfo['packingprice'] + $shopInfo['deliveryprice']; //打包费用
                    else
                        $packingPrice = 0.0;

                    $totalMoney = $totalMoney + ($merchandiseInfo['currentprice'] + $packingPrice) * $value['qty'];
                    $totalOriginalMoney = $totalOriginalMoney + ($merchandiseInfo['price'] + $packingPrice) * $value['qty'];


                    //更新商店人气
                    Wind::import('EXT:4tschool.service.shop.dm.App_Shop_Dm');
                    $shopDM = new App_Shop_Dm();
                    $shopDM->setOrderCount($shopInfo['ordercount'] + $value['qty']);
                    $this->_getShopDS()->update($shopInfo['id'],$shopDM);

                    $MDeductMoney = array();

                    $usedPromo = '';

                    //check M deducted price
                    foreach ($promos['Match'] as $key => $eachPromo)
                    {
                        
                        if($eachPromo['MID'] == $merchandiseId)
                        {
                            $MDeductMoney[$merchandiseId] = $eachPromo['Deduct'];
                            $usedPromo = $eachPromo['ShopName']."限时活动, 满".$eachPromo['Meet']."元,".$eachPromo['MerchandiseName']."立减".$eachPromo['Deduct']."元";
                            break;
                        }
                    }

                    $priceIncludingPacking = $merchandiseInfo['currentprice'] + $packingPrice;
                    $MTotalMoney = $priceIncludingPacking * $value['qty'] - $MDeductMoney[$merchandiseId];
                    
                    Wind::import('EXT:4tschool.service.myorder.dm.App_OrderItem_Dm');
                    $dmitem = new App_OrderItem_Dm();
                    $dmitem->setOrderId($orderid)
                        ->setMerchandiseId($merchandiseId)
                        ->setSchoolAreaId($shopInfo['areaid'])
                        ->setQuatity($value['qty'])
                        ->setPriceOriginal($merchandiseInfo['price'])
                        ->setPriceOfferDescription("优惠了".(($merchandiseInfo['price'] - $merchandiseInfo['currentprice']) * $value['qty'])."元")
                        ->setPrice($priceIncludingPacking)
                        ->setSaving(($merchandiseInfo['price'] - $merchandiseInfo['currentprice']) * $value['qty']) //tobe
                        ->setIntegral($MTotalMoney) //1：1（钱和积分)
                        ->setSequence($sequence."-".$i)
                        ->setPackingprice($packingPrice)
                        ->setStatus(0) //等待确认
                        ->setTotalMoney($MTotalMoney)
                        ->setPromoUsed($usedPromo);

                    $generatedItemId = $this->insertOrderItem($dmitem);

                    //update merchandise order count
                    $this->_getMerchandiseDS()->orderCountIncrease($merchandiseId);

                }

                //calculate 点币
                $dianMoney = 0;
        		$ordermoney = $totalMoney - $totalDeduct;
        		//check if shop has 返利
        		$hasShopProfit = $shopInfo['ifrebate'];
        		$rate = $shopInfo['rebatefromshop'];


        		if($hasShopProfit == 1)
        		{
        			$rmbShopReturn = $ordermoney * $rate;
        			$rmbforUser = $this->_getShopDailySaleDs()->getUserProfit($rmbShopReturn);

        			$dianMoney = $rmbforUser * 10;
        			
        		}
                else
                {
                    $rmbShopReturn = 0;
                    $rate = 0;
                }


                Wind::import('EXT:4tschool.service.myorder.dm.App_Order_Dm');
                $dmUpdateOrder = new App_Order_Dm();
                $dmUpdateOrder->setSavingtotal($totalOriginalMoney - $totalMoney + $totalDeduct)
                    ->setOrdermoney($totalMoney - $totalDeduct)
                    ->setDeservedPointcoin($dianMoney)
                    ->setShopreturn($rmbShopReturn)
                    ->setRebatefromshop($rate);

                //更新订单总金额
                $this->updateOrder($orderid,$dmUpdateOrder);

                //notify user
                $this->_getOrderStatusNotifyDs()->SendStatusNotify(0,$orderid); //notify user
            }

            //push message to shop client, notify that there is new order
            $notifytitle = $totalMoney."元新订单等待您接收-点餐哟";
            $notifycontent = "请开启订单接收软件进行接单, 谢谢";

                        
            //notify shop
            $this->_getOrderStatusNotifyDs()->PushToShopClient($shopid,$shopInfo['openordertouser'],$notifytitle,$notifycontent);
            
        }

        return $generatedOrderIds;
    }


    /*
    *   查看是否有缺货的订单: 基于上次更新时间
    */
    public function anyNoItemOrders($schoolid,$lastRetrived)
    {
        return $this->_loadDao()->anyNoItemOrders($schoolid,$lastRetrived);
    }

    /*
    *   看是否这个订单在某个状态下是否可以让客户自己取消
    *   只有当订单中所有的商品的状态都是未向商家下单的话,用户才能取消
    */
    public function canCancelOrderByStatus($orderid)
    {
        return $this->_loadDao()->canCancelOrderByStatus($orderid);
    }


    /*
    * 更新订单的负责人
    */
    public function updateOrderResponsible($orderid, $deliveryuserid)
    {
        return $this->_loadDao()->updateOrderResponsible($orderid, $deliveryuserid);
    }

    /*
    * 基于order item的状态更新订单状态
    */
    public function updateOrderStatusByOrderItemStatus($orderItemIds,$status)
    {

        //如果order item是缺货的状态，那么订单也应该是缺货的状态
        switch ($status) {
            case -1: //缺货状态
                     $this->_loadDao()->updateOrderStatusAsNoItem($orderItemIds,$status);

                     //更新商品的状态为缺货(通过更新商品数量)
                     
                break;
            case 2:  //制作中, 也就是已经下单
                    $this->_loadDao()->updateOrderStatusByOrderItemStatus($orderItemIds,$status);
                break;
            case 8:  //已取单
                    $this->_loadDao()->updateOrderStatusByOrderItemStatus($orderItemIds,$status);
                break;
            case 3:  //等待配额送
                    $this->_loadDao()->updateOrderStatusByOrderItemStatus($orderItemIds,$status);
                break;
            default:
                    $this->_loadDao()->updateOrderStatusByOrderItemStatus($orderItemIds,$status);
                break; 
        }
    }


    /*
    * 更新订单状态
    */
    public function updateOrderStatus($orderid, $status, $uid)
    {
        //get order info
        if($orderid <= 0)
            return;

        $orderInfo = $this->_loadDao()->getOrderDetail($orderid);
        if(empty($orderInfo))
            return;

        $userofOrder = $orderInfo[0]['userid'];
        $orginalStatus = $orderInfo[0]['status'];
        $changedatefrom = $orderInfo[0]['lastUpdated'];

        //insert history
        $this->insertOrderStatusHistory($orderid, $uid, $orginalStatus, $status,$changedatefrom);

        //update order's main status
        $this->_loadDao()->updateOrderStatus($orderid, $status);

        //update order item status base on order status
        $this->_loadOrderItemDao()->updateOrderItemStatusByOrderId($orderid,$status);

        //签收以后才能把积分加上去
        if($status == 5 ) //订单签收
        {
            $integral = $this->getOrderIntegral($orderid);
            $this->_getMyMoneyDS()->updateMyCredit($userofOrder,$integral,"订单签收后转入积分");
        }

        //如果订单状态为制作中或者缺货，需要通知用户
        if($status == 2 || $status == -1 || $status == 6)
        {
            $this->_getOrderStatusNotifyDs()->SendStatusNotify($status,$orderid);
        }

        //if anything special, seems not
        if($status == 5 || $status == 6 || $status ==7) //客户签收 //客户拒签 //客户取消
        {
            //do nothing now
        }

        return true;
    }

    public function openUpdateOrderStatus($orderid, $status)
    {
        return $this->_loadDao()->openUpdateOrderStatus($orderid, $status);
    }

    public function getOrderStatusByOrderId($orderid)
    {
        return $this->_loadDao()->getOrderStatusByOrderId($orderid);
    }


    /*
    *   是否是用户第一个订单(如果用户之前有单但是取消掉了,那么单是不会被考虑在内的)
    */
    public function isFirstOrder($userid,$since='2013-08-01')
    {
        return $this->_loadDao()->isFirstOrder($userid,$since);
    }

    /*
     *
     * 订单状态历史信息，例如制作中，配送中
     */
    public function getOrderHistory($orderid)
    {
        return $this->_loadOrderStatusHistoryDao()->getOrderHistory($orderid);
    }


    /*
    *  查看当次订单的积分
    */
    public function getOrderIntegral($orderid)
    {
        return $this->_loadOrderItemDao()->getOrderIntegral($orderid);
    }

    /*
    *
    */
    public function getSchoolPeopleStatistics($schoolid,$limit, $offset) 
    {
        return $this->_loadPeopleStatisticsDS()->getSchoolPeopleStatistics($schoolid,$limit, $offset);
    }

    public function countMoney($schoolId, $userid)
    {
        return $this->_loadPeopleStatisticsDS()->countMoney($schoolId, $userid);
    }


    /*
    * 插入order action 日志记录, 会记录一下
    * 谁下了订单
    * 谁查看了订单
    * 谁改变了订单状态
    * 谁取消了订单
    */
    public function insertOrderLog($orderid, $by, $action)
    {
        Wind::import('EXT:4tschool.service.myorder.dm.App_OrderLog_Dm');
        $dm = new App_OrderLog_Dm();
        $dm->setOrderId($orderid)
            ->setby($by)
            ->setAction($action);
        return $this->_loadOrderLogDao()->add($dm->getData());
    }

    public function insertOrderStatusHistory($orderid, $changebyid, $statusfrom, $statusto,$changedatefrom='')
    {
        Wind::import('EXT:4tschool.service.myorder.dm.App_OrderStatus_Dm');
        $dm = new App_OrderStatus_Dm();
        $dm->setOrderId($orderid)
            ->setby($changebyid)
            ->setStatusFrom($statusfrom)
            ->setStatusTo($statusto)
            ->setChangeDateFrom($changedatefrom);
        return $this->_loadOrderStatusHistoryDao()->add($dm->getData());
    }

    public function insertOrder($dmorder)
    {
        $orderid = $this->_loadDao()->add($dmorder->getData());

        //insert order sequence number
        $data['orderid'] = $orderid;
        $sequenceId = $this->_loadOrderSequenceDao()->add($data);

        //update sequenceId back to order table
        $orderData['sequence'] = $sequenceId;
        $this->_loadDao()->update($orderid, $orderData);

        return $orderid;
    }

    //更新order
    public function updateOrder($orderid,$dmorder)
    {
        return $this->_loadDao()->update($orderid,$dmorder->getData());
    }

    public function insertOrderItem($dmorderitem)
    {
        $itemid = $this->_loadOrderItemDao()->add($dmorderitem->getData());
        return $itemid;
    }

    public function generateOrderNumber()
    {
        //order number: 13 number and 3 random number
        $currentTimeStamp = strtotime("+0 day");
        $orderNumber = rand(100, 199) . $currentTimeStamp;
        return $orderNumber;
    }

    public function getOrderItemsByShops($shopIdList,$orderStatusArray,$lastRetrived)
    {
        return $this->_loadOrderItemDao()->getOrderItemsByShops($shopIdList,$orderStatusArray,$lastRetrived);
    }


    public function updateOrderItemStatus($ids, $status)
    {
        $affectedRows = $this->_loadOrderItemDao()->updateOrderItemStatus($ids, $status);

        //根据当前的order item的id, 把订单的状态更新
        $this->updateOrderStatusByOrderItemStatus($ids,$status);

        //如果订单状态为缺货,必须更新相应的商品为缺货
        if($status == -1)
        {
            $this->_loadOrderItemDao()->updateMStatusAsNoItem($ids);

            //需要通知用户状态
            //通过order item id 得到 order id
            $orderData = $this->_loadOrderItemDao()->getOrderId($ids);
            
            $this->_getOrderStatusNotifyDs()->SendStatusNotify(-1,$orderData['orderid']);
            
        }

        return 1;
    }

    public function updateRejectApprovedStatus($orderid)
    {
        $this->_loadDao()->updateRejectApprovedStatus($orderid);
    }

    public function updateOrderItem($id, $dmItem)
    {
        
        return $affectedRows = $this->_loadOrderItemDao()->update($id, $dmItem->getData());
    }

    public function updateItemasCommented($orderid,$merchandiseid)
    {
        $this->_loadOrderItemDao()->updateItemasCommented($orderid,$merchandiseid);
    }

    public function resetSequence()
    {
        return $this->_loadOrderSequenceDao()->resetSequence();
    }

    protected function getIncidentallyShopId()
    {
        return 28;
    }

    public function getLastOrderByUserId ($userId){
        return $this->_loadDao()->getLastOrderByUserId($userId);
    }

    public function getOrderIdByUserId($userid)
    {
        return $this->_loadDao()->getOrderIdByUserId($userid);
    }
    /**
     * @return App_MyOrder_Dao
     */
    private function _loadDao()
    {
        return Wekit::loadDao('EXT:4tschool.service.myorder.dao.App_MyOrder_Dao');
    }

    /**
     * @return App_OrderItem_Dao
     */
    private function _loadOrderItemDao()
    {
        return Wekit::loadDao('EXT:4tschool.service.myorder.dao.App_OrderItem_Dao');
    }

    /**
     * @return App_Order_Status_History_Dao
     */
    private function _loadOrderStatusHistoryDao()
    {
        return Wekit::loadDao('EXT:4tschool.service.myorder.dao.App_OrderStatus_Dao');
    }

    /**
     * @return App_Order_Log_Dao
     */
    private function _loadOrderLogDao()
    {
        return Wekit::loadDao('EXT:4tschool.service.myorder.dao.App_OrderLog_Dao');
    }

    /**
     * @return App_SchoolPeople_Dao
     */
    private function _loadSchoolPeopleDao()
    {
        return Wekit::loadDao('EXT:4tschool.service.schoolpeople.dao.App_SchoolPeople_Dao');
    }

    /**
     * @return App_OrderSequence_Dao
     */
    private function _loadOrderSequenceDao()
    {
        return Wekit::loadDao('EXT:4tschool.service.myorder.dao.App_OrderSequence_Dao');
    }

    private function _getMyMoneyDS()
    {
        return Wekit::load('EXT:4tschool.service.mymoney.App_MyMoney');
    }

    private function _getMerchandiseDS()
    {
        return Wekit::load('EXT:4tschool.service.merchandise.App_Merchandise');
    }

    private function _getShopDS()
    {
        return Wekit::load('EXT:4tschool.service.shop.App_Shop');
    }

    private function _loadPeopleStatisticsDS()
    {
        return Wekit::load('EXT:4tschool.service.myorder.dao.App_PeopleOrderStatistics_Dao');
    }

    /**
     * @return App_SchoolExtra_Dao
     */
    private function _loadSchoolExtraDao() {
        return Wekit::loadDao('EXT:4tschool.service.school.dao.App_SchoolExtra_Dao');
    }

    /**
     * @return App_ShopDailySale
     */
    private function _getShopDailySaleDs()
    {
        return Wekit::load('EXT:4tschool.service.shopdailysale.App_ShopDailySale');
    }

    /**
     * @return App_OrderStatusNotify
     */
    private function _getOrderStatusNotifyDs()
    {
        return Wekit::load('EXT:4tschool.service.myorder.App_OrderStatusNotify');
    }
}

?>