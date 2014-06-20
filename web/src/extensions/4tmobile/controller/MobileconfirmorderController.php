<?php

Wind::import('EXT:4tschool.controller.T4BaseNotLoginController');

class MobileconfirmorderController extends T4BaseNotLoginController
{
    public function beforeAction($handlerAdapter) {
        parent::beforeAction($handlerAdapter);

        $is_weixin=$this->_getCommonDs()->is_weixin();
        if (!$is_weixin) {
            return;
        }        
        $this->setOutput($is_weixin,'is_weixin');         

    }    

    public function run()
    {
        list($orderid,$openid,$shopname)=$this->getInput(array('orderid', 'openid','shopname'),'get');
        $this->setOutput($openid,'openId');

        $this->setOutput($this->getCurrentSchoolId(),'schoolId');

        $ordertail=$this->_getMyOrderDS()->getOrdertail($orderid);   

        $order=$ordertail[0];

        $user=$this->getUserByOpenId($openid);
        $userid=$user['userid'];
        $order['isvalid']=$order['userid']==$userid;
        $order['shopname']=$shopname;
        $this->setOutput($order,'order');        
    }
            
    // "-1" => "缺货",
    // "0" => "等待确认",
    // "1" => "已审核",
    // "2" => "制作中",
    // "3" => "等待配送",
    // "4" => "配送中",
    // "5" => "客户签收",
    // "6" => "客户拒签",
    // "7" => "客户取消",
    // "8" => "商家已出餐",
    public function dosavecommentAction (){
        list($openid, $orderid, $shopid, $deliveryTime, $comment)=$this->getInput(array('openId','orderId', 'shopId','deliveryTime', 'comment'),'post');
        $openid=$this->getInput('openid');
        $this->setOutput($openid,'openId');

        if ($_SERVER['REQUEST_METHOD']=='GET') {
               $action=$_SERVER['REQUEST_METHOD'];
               $this->setOutput($action,'action');
               return;
        }        

        $ordertail=$this->_getMyOrderDS()->getOrdertail($orderid);

        $ordertail=$ordertail[0];

        //120 min
        $maxDeliveryTime=120;

        $exits=$this->_getMyMoneyDS()->getOneByOrderId($orderid);

        //check the order status        
        if ($ordertail['status']==2||3||4) {

            $user=$this->getUserByOpenId($openid);

            $userid=$user['userid'];

            $this->_getMyOrderDS()->updateOrderStatus($orderid, 5, $userid);

            if ($ordertail['deservedpointcoin']>0&&empty($exits)) {
                $result=$this->_getMyMoneyDS()->updateMyMoney($userid,$ordertail['deservedpointcoin'],$orderid);
            }

            if ($deliveryTime>$maxDeliveryTime) {
                $deliveryTime=$maxDeliveryTime;
            }

            $this->_getShopDs()->addShopComment($userid,$shopid,$orderid,$deliveryTime,$comment);

            $this->setOutput($result,"result");
            $this->setOutput($ordertail,"ordertail");
        }
    }

    public function getUserByOpenId ($openid){
        return $this->_getTmpUserDS()->getbyKey($this->_getCommonDs()->getWechatKey(),$openid);
    }


    /**
     * @return App_MyOrder
     */
    private function _getMyOrderDS()
    {
        return Wekit::load('EXT:4tschool.service.myorder.App_MyOrder');
    } 

    /**
     * @return App_MyOrder
     */
    private function _getMyMoneyDS()
    {
        return Wekit::load('EXT:4tschool.service.mymoney.App_MyMoney');
    }    
  
    /**
     * @return App_TmpUser
     */
    private function _getTmpUserDS()
    {
        return Wekit::load('EXT:4tschool.service.tmpuser.App_Tmpuser');
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