<?php

Wind::import('EXT:4tschool.controller.T4BaseNotLoginController');

class MobileorderpreviewController extends T4BaseNotLoginController
{

    public function beforeAction($handlerAdapter) {
        parent::beforeAction($handlerAdapter);
    }
    
    public function run()
    {
        $is_weixin=$this->_getCommonDs()->is_weixin();
        if (!$is_weixin) {
            return;
        }        
        $this->setOutput($is_weixin,'is_weixin');     

        $wechatOpenId=$this->getInput('openid','get');

        $this->setOutput($wechatOpenId,'openId');

        $user=$this->_getTmpUserDS()->getbyKey($this->_getCommonDs()->getWechatKey(),$wechatOpenId);

        $userId = $user['userid'];

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

        
        $this->setShoppingCart();

        $this->setOutput($this->getDomain() . $this->getCartRelayPath(), 'BASE_URL');

        $promos = $this->_getPromoDs()->matchedPromoInCart($orderMerchandiseList);

        //set promotion info
        $this->calculateTotalPrice($promos['Match']);
        $this->setOutput($promos['Match'], 'promotionList');
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

    public function setShoppingCart ($args){
        $schoolid = $this->getCurrentSchoolId();
        $this->setOutput($schoolid,'schoolId');

        //jcart extends from T4BaseController
        
        $clearShopId=$this->getInput('clearshopid','get');
        if (empty($clearShopId)==false) {
            $this->jcart->clearItemsByshopId($clearShopId);
        }

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
        
        
        
        //Set as true if in order preview, should be can't delete merchandise and change the quantity.
        $this->jcart->in_order_preview(true);        
        
        //set redirect url
        $url = WindUrlHelper::createUrl('app/4tmobile/mobileshop/run?schoolid='.$schoolid);
        $this->jcart->set_redirect_url($url);

        $merCount=$this->jcart->get_count();
        $this->setOutput($merCount,'merCount');        

        //check per shop starting price
        $shopIdList=array();
        $perShopSubtotal=$this->jcart->get_shop_subtotal();

        foreach ($perShopSubtotal as $key => $value) {
            $shopIdList[]=$key;
        }
        $shopIdList=implode(",", $shopIdList);
        if (empty($shopIdList)==false) {
            $shopList = $this->_getShopDs()->getShopsByIdList($shopIdList);

            $this->calculateCurOrderDMoney($shopList);

            $shutdownShopList=array();
            $unmetStartingPriceShops=array();
            foreach ($shopList as $item) {
                $subtotal=$perShopSubtotal[$item['id']];
                if ($subtotal<$item['startingprice']) {
                    $unmetStartingPriceShops[]=$item;
                }
                //check shops status
                if ($item['isshopopen']==0) {
                    $shutdownShopList[]=$item;
                }
            }

            $this->setOutput($shutdownShopList,"shutdownShopList");   
            $this->setOutput($unmetStartingPriceShops,"unmetStartingPriceShops");  
            $this->setOutput($this->jcart, 'jcart');          
        }
    }

    private function calculateCurOrderDMoney ($shopList){
        $perShopSubtotal=$this->jcart->get_shop_subtotal();
        $totalDMoney=0;
        foreach ($shopList as $key => $item) {
            if ($item['ifrebate']) {
                $curShopSubtotal=$perShopSubtotal[$item['id']];
                $money=$curShopSubtotal*$item['rebatefromshop'];
                $userMoeny=$this->_getShopDailySaleDs()->getUserProfit($money);
                $curShopDMoney=$userMoeny*10;
                $totalDMoney+=$curShopDMoney;
            }
        }

        $this->setOutput($totalDMoney,'totalDMoney');
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
     * @return App_Shop
     */
    private function _getShopDs()
    {
        return Wekit::load('EXT:4tschool.service.shop.App_Shop');
    }    

    /**
     * @return App_TmpUser
     */
    private function _getTmpUserDS()
    {
        return Wekit::load('EXT:4tschool.service.tmpuser.App_Tmpuser');
    }    

    /**
     * @return App_ShopDailySale
     */
    private function _getShopDailySaleDs()
    {
        return Wekit::load('EXT:4tschool.service.shopdailysale.App_ShopDailySale');
    }     

    private function _getCommonDs ()
    {
        return Wekit::load('EXT:4tmobile.service.common.App_Common');
    }       
}