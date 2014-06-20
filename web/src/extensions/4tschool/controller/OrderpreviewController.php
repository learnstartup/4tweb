<?php

Wind::import('EXT:4tschool.controller.T4BaseNotLoginController');
Wind::import('EXT:4tschool.service.tmpuser.dm.App_Tmpuser_Dm');

class OrderPreviewController extends T4BaseNotLoginController
{

    public function beforeAction($handlerAdapter) {
        parent::beforeAction($handlerAdapter);

        if(empty($this->schoolExtra) == false && $this->schoolExtra['openorder'] == 0)
        {
            $this->forwardRedirect(WindUrlHelper::createUrl('app/4tschool/shopdetails/whenOpen'));
        }

    }
    
    public function run()
    {
        $userId = $this->loginUser->uid;
        $this->setOutput($userId,'userId');

        $shopIdList = $this->jcart->get_shop_subtotal();
        foreach ($shopIdList as $key => $value) 
        {
            $shopidstring .= $key.',';
        }
        $shopidstring = substr($shopidstring, 0, -1);

        if(!empty($shopidstring))
        {
            $orderShopList = $this->_getShopDs()->getShopsByIdList($shopidstring);
        }
    
        $shopnamestring = '';
        foreach ($orderShopList as $key => $value) {
            if(!$value['isshopopen']){
                $shopnamestring .= $value['name'].' ';
            }
        }
        $this->setOutput($shopnamestring, 'shopnamestring');
        $this->setOutput($orderShopList, 'orderShopList');

        $clear = $this->getInput('clear','get');
        if($clear == 'clear')
        {
            foreach ($orderShopList as $key => $value) 
            {
                if(!$value['isshopopen'])
                {
                    $this->jcart->clearItemsByshopId($value['id']);

                }
            }
            $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            header("location:index.php?m=app&c=orderpreview&app=4tschool");
        }

        //get all order info
        if (!empty($userId)) {
            $orderInfoList = $this->_getOrderAdressDs()->getOrderAddress($userId);
        } else {
            //to do
        }

        $this->setOutput($orderInfoList[0], 'orderInfo'); //default

        //if have not  order info, get current user name and mobile as default.
        if (empty($orderInfoList)) {
            $defaultOrderInfo = $this->_getOrderAdressDs()->getOrderAddressForFirstTime($userId);
            $this->setOutput($defaultOrderInfo, 'orderInfo');
        }

        $this->setOutput($orderInfoList, 'orderInfoList');

        //Set as true if in order preview, should be can't delete merchandise and change the quantity.
        $this->jcart->in_order_preview(true);


        //set the order's merchandises info
        $orderMerchandiseList = $this->jcart->get_contents();

        foreach ($orderMerchandiseList as $key => $value) {
            $key == 0 ? $merchandisesInfo['totalIntegral'] = $value['totalIntegral'] : null;
            $merchandisesInfo['merchandises'][$key]['merchandiseId'] = $value['id'];
            $merchandisesInfo['merchandises'][$key]['qty'] = $value['qty'];
            $merchandisesInfo['merchandises'][$key]['integral'] = $value['integral'];
            $merchandisesInfo['merchandises'][$key]['shopid'] = $value['vendor'];
        }
        $this->setOutput(json_encode($merchandisesInfo), 'merchandisesInfo');
        //extends from T4BaseController
        $this->setOutput($this->jcart, 'jcart');
        $this->setOutput($this->getDomain() . $this->getCartRelayPath(), 'BASE_URL');

        $promos = $this->_getPromoDs()->matchedPromoInCart($orderMerchandiseList);

        //set promotion info
        $this->calculateTotalPrice($promos['Match']);
        $this->setOutput($promos['Match'], 'promotionList');
        
        //设置是否学校当前状态为可以订餐，如果可以，才能去结算
        // $schoolid = $this->getCurrentSchoolId();
        // $opening = $this->_getSchoolDS()->isSchoolOpenNow($schoolid);
        // $this->setOutput($opening,"opening");
    }

    //when user choose the item, then user check in preview page
    //after user confirm, will post to this page
    public function makeOrderAction()
    {
        //get data
        $merchandisesInfo = $this->getInput("merchandisesInfo","post");
        $id = $this->getInput("id","post");
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

        $to = trim($to);
        $phone = trim($phone);
        $address = trim($address);

        if(empty($to)
        	|| empty($phone)
        	|| empty($address))
        {
        	echo '无效的数据';die;
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

        $userid = $this->loginUser->uid;
        
        $this->_getOrderAddressDs()->addorUpdateOrderAddress($id, $userid, $to,$address, $phone);

        $newCreated = false;
        if($userid <= 0)
        {
            //generate tmp userid
            $newInfo = $this->_getTmpUserDS()->registerTmpUser(1);
            $userid = $newInfo['uid'];
            $newCreated = true;
        }

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
                                                    $note,
                                                    '网站');
        }
        catch(Exception $e)
        {
        	$hasException = true;
            $this->_getMyOrderDS()->rollBack();
        }

        if($hasException == false)
        {
            $message = "下单成功";
            $this->_getMyOrderDS()->commit();
        }
        else
            $message = "下单失败,请联系系统管理员";


        //清空购物车
        $this->jcart->empty_cart();

        if($newCreated == true)
        {

            Wind::import('SRV:user.srv.PwLoginService');
            $service = new PwLoginService();
            Windid::load('user.WindidUser');
            $info = $service->sysUser($userid);
            $identity = PwLoginService::createLoginIdentify($info);
            $identity = base64_encode($identity);
            $userService = Wekit::load('user.srv.PwUserService');
            $userService->createIdentity($info['uid'], $info['password']);

            //跳转到我的订单的画面
            $this->forwardRedirect(WindUrlHelper::createUrl('app/4tschool/schoolorder/myorder',array("message"=>$message)));

                   
        }
        else
        {
            //跳转到我的订单的画面
            $this->forwardRedirect(WindUrlHelper::createUrl('app/4tschool/schoolorder/myorder',array("message"=>$message)));
        }
        
    }


    private function getPromotions($merPromotion)
    {
        $this->calculateTotalPrice($merPromotion);
        return $promotionList;
    }

    public function calculateTotalPrice($merPromotion)
    {
        $totalPrice = $this->jcart->get_subtotal();
        foreach ($merPromotion as $item) {
            $totalPrice-=$item['Deduct'];
        }
        $this->setOutput($totalPrice,'totalPrice');
    }

    
    /*
    *
    */
    private function _getMyOrderDS()
    {
        return Wekit::load('EXT:4tschool.service.myorder.App_MyOrder');
    }

    /**
     * @return App_OrderAddress
     */
    private function _getOrderAdressDs()
    {
        return Wekit::load('EXT:4tschool.service.orderaddress.App_OrderAddress');
    }

    /**
     * @return promotions
     */
    private function _getPromotion()
    {
        return Wekit::load('EXT:4tschool.service.promo.Promotions');
    }

    /**
     * @return App_Promo
     */
    public function _getPromoDs()
    {
        return Wekit::load('EXT:4tschool.service.promo.App_Promo');
    }

    /**
     * @return App_School
     */
    private function _getSchoolDS()
    {
        return Wekit::load('EXT:4tschool.service.school.App_School');
    }

    /**
     * @return App_TmpUser
     */
    private function _getTmpUserDS()
    {
        return Wekit::load('EXT:4tschool.service.tmpuser.App_Tmpuser');
    }

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

}