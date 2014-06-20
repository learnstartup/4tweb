<?php

Wind::import('EXT:4tschool.controller.T4BaseNotLoginController');

class MobileorderController extends T4BaseNotLoginController
{
    public function beforeAction($handlerAdapter) {
        parent::beforeAction($handlerAdapter);

        $is_weixin=$this->_getCommonDs()->is_weixin();
        if (!$is_weixin) {
            return;
        }        
        $this->setOutput($is_weixin,'is_weixin');         

    }    

    private $_need_confrim_orders=0;
    private $_deserved_total_dmoney=0;

    public function run()
    {
        $openid=$this->getInput('openid');
        $this->setOutput($openid,'openId');

        $myOrderList = $this->getMyOrder();

        $this->setOutput($myOrderList, 'myOrderList');
        $this->setOutput(count($myOrderList),'orderCount');
        $this->setOutput($this->_need_confrim_orders,'needConfrimOrders');
        $this->setOutput($this->_deserved_total_dmoney,'deservedTotalDmoney');
    }

    public function getMyOrder (){
        list($schoolid, 
             $days, 
             $userid, 
             $offset, 
             $limit) = $this->getInput(array('schoolid', 
                                             'days', 
                                             'userid', 
                                             'offset', 
                                             'limit'), 'get');
        $this->setOutput($schoolid,'schoolId');
        //set delivery method and status
        $statusArray = $this->_getMyOrderDS()->getAllStatus();

        $searchTxt = '';
        $schoolArea = 0;
        $assignedStatus = 0;
        $assignedppl = 0; //no matter assigned or not

        if (empty($userid)) {            
            $user=$this->_getTmpUserDS()->getbyKey($this->_getCommonDs()->getWechatKey(),$this->getInput('openid'));
            $userid=$user['userid'];
        }

        $this->setOutput($userid,'userId');

        if (empty($userid)==false) {
            $myOrderList=$this->_getMyOrderDS()->getOrders($userid,
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
        }

        //get order id list
        $orderIdList=array();
        $shopIdList=array();
        foreach ($myOrderList as $item) {
            if ($item['status']==2||$item['status']==3||$item['status']==4) {
                $this->_need_confrim_orders++;
                $this->_deserved_total_dmoney+=$item['deservedpointcoin'];
            }            
            $orderIdList[]=$item['id'];            
            $shopIdList[]=$item['shopid'];
        }

        $orderIdList=implode(",", $orderIdList);
        $shopIdList=implode(",", $shopIdList);

        if (empty($orderIdList)==false) { 
            //get order items by order id list
            $orderItemList = $this->_getMyOrderDS()->getOrderItemByOrderIds($orderIdList);

            if (empty($shopIdList)==false)
                $shopList = $this->_getShopDs()->getShopsByIdList($shopIdList);

            //push shop name in order list
            foreach ($myOrderList as &$order) {

                $order['statustext']=$statusArray[$order['status']];

                foreach ($orderItemList as $item) {
                    if ($item['orderid']==$order['id']) {
                        $order['shopname']=$item['shopname'];
                        continue;
                    }
                }
                
                foreach ($shopList as $shop) {
                    if ($shop['id']==$order['shopid']) {
                        $order['shopnumber']=(empty($shop['phonenumber'])||$shop['phonenumber']=="无")?$shop['contactnumber']:$shop['phonenumber'];
                    }
                }
            }
        }
        $this->setOutput($orderItemList,'orderItemList');

        return $myOrderList;
    }

    /**
     * [makeOrderAction description]
     * @return [type]
     */
    public function makeOrderAction()
    {
        $schoolId = $this->getCurrentSchoolId();
        $this->setOutput($schoolId,'schoolId');

        $wechatOpenId=$this->getInput('openid');
        $this->setOutput($wechatOpenId,'openId');     

        if ($_SERVER['REQUEST_METHOD']=='GET') {
               $action=$_SERVER['REQUEST_METHOD'];
               $this->setOutput($action,'action');
               return;
        }

        //get data
        $merchandisesInfo = $this->getInput("merchandisesInfo","post");
        $orderId=$this->getInput("orderId","post");
        $to = $this->getInput("orderContactor","post");
        $phone = $this->getInput("orderPhone","post");
        $address = $this->getInput("orderAddress","post");
        $note = $this->getInput("orderRemark","post");
        $orderExpressTime = $this->getInput("orderExpressTime","post");
        $orderHour=$this->getInput('orderHour',"post");
        $orderMinutes=$this->getInput('orderMinutes',"post");
        $orderTime = $orderHour.':'.$orderMinutes;

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

        //generate tmp userid
        $newInfo=$this->_getTmpUserDS()->registerTmpUser($this->_getCommonDs()->getWechatKey(),$wechatOpenId);
        $userid = $newInfo['uid'];

        //save or update the contactor info
        $this->_getOrderAddressDs()->addorUpdateOrderAddress($orderId,$userid,$to,$address,$phone);

        $hasException = false;
        try
        {

            //start transaction
            $this->_getMyOrderDS()->startTran();
            $generatedIds = $this->_getMyOrderDS()->makeOrder(
                                                    $userid,
                                                    $schoolId,
                                                    $orderItems,
                                                    $to,
                                                    $phone,
                                                    $address,
                                                    $note);
        }
        catch(Exception $e)
        {            
            $hasException = true;
            $this->_getMyOrderDS()->rollBack();
        }

        if($hasException == false)
        {
            $message = true;
            $this->_getMyOrderDS()->commit();
        }
        else
            $message =false;


        //清空购物车
        $this->jcart->empty_cart();

        $this->setOutput($message,'msg');
    }

    //ajax
    //cancel order
    public function cancelOrderAction()
    {
        list($openid,$orderid)=$this->getInput(array("curOpenid","curOrderid"));
        $user=$this->_getTmpUserDS()->getbyKey($this->_getCommonDs()->getWechatKey(),$openid);

        $userid=$user['userid'];

        $returnData = "取消成功";
    
        $isMine = $this->_getMyOrderDS()->isMyOrder($userid,$orderid);
        if(!$isMine)
        {
            $returnData = "取消失败,无效订单";

            print_r($orderid);
            die;
        }

        //get order status, if it is already handled, then, can not cancelled
        $order = $this->_getMyOrderDS()->getOrdertail($orderid);
        $order = $order[0];

        if($order['status'] != 0) //只有等待授理的订单才能授理
        {
            $returnData = "订单已被授理或当前状态无法取消";

            print_r($returnData);
            die;
        }

        //set order status
        //update the order status
        $this->_getMyOrderDS()->updateOrderStatus($orderid,7,$userid);

        print_r($returnData);
        die;
    }    


    /**
     * @return App_MyOrder
     */
    private function _getMyOrderDS()
    {
        return Wekit::load('EXT:4tschool.service.myorder.App_MyOrder');
    }

    /**
     * @return App_Promo
     */
    public function _getPromoDs()
    {
        return Wekit::load('EXT:4tschool.service.promo.App_Promo');
    }    
  
    /**
     * @return App_TmpUser
     */
    private function _getTmpUserDS()
    {
        return Wekit::load('EXT:4tschool.service.tmpuser.App_Tmpuser');
    }     

    /**
     * @return App_OrderAddress
     */
    private function _getOrderAddressDs()
    {
        return Wekit::load('EXT:4tschool.service.orderaddress.App_OrderAddress');
    }     

    /**
     * @return App_Shop
     */
    private function _getShopDs()
    {
        return Wekit::load('EXT:4tschool.service.shop.App_Shop');
    }    

    private function _getCommonDs ()
    {
        return Wekit::load('EXT:4tmobile.service.common.App_Common');
    }       
}

?>