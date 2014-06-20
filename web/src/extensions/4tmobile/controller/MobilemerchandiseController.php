<?php

Wind::import('EXT:4tschool.controller.T4BaseNotLoginController');
Wind::import('SRV:user.srv.PwLoginService');

class MobilemerchandiseController extends T4BaseNotLoginController
{
    private $_user_rate=0.4;
    private $_tax_rate=0.07;
    private $_cur_shop;

    public function run()
    {
        $is_weixin=$this->_getCommonDs()->is_weixin();
        
        if (!$is_weixin) {
            return;
        }        
        $this->setOutput($is_weixin,'is_weixin');      

        list($shopId,$wechatOpenId) = $this->getInput(array('shopid','openid'), 'get');

        $this->setOutput($wechatOpenId,'openId');

        $merchandiseList = $this->_getMerchandiseDs()->getActiveMerchandiseByShopId($shopId);

        $shop = $this->_getShopDs()->getByShopId($shopId);

        $this->_cur_shop=$shop;

        $this->calculateCurShopDMoney();

        foreach ($merchandiseList as $key => $value) {
            if (empty($merchandiseList[$key]['imageurl'])) {
                $merchandiseList[$key]['imageurl'] = $this->getDomain() . "/uploaded_images/default/sdefault.jpg";
            } else {
                $merchandiseList[$key]['imageurl'] = $this->getDomain() . str_replace('\\', '/', $value['imageurl']);
            }
            $merchandiseList[$key]['isopen'] = $this->isOpening($merchandiseList[$key]['orderbegin'], $merchandiseList[$key]['orderend']);
            $tagList[$value['tagid']] = $value['tagname'];
        }
        $tagList = array_unique($tagList);
        $this->setOutput($tagList,"tagList");

        $tagKeyList=array_keys($tagList);
        $this->setOutput($tagKeyList[0],'firstTagKey');

        $this->setOutput($merchandiseList, 'merchandiseList');
        $this->setOutput($shop, 'shop');
        $this->setOutput(count($merchandiseList), 'merchandisenumber');

        $this->getShoppingCartInfo($shopId);
    }

    private function isOpening($startTime, $endTime)
    {
        date_default_timezone_set("PRC");
        $cur = date('H:i:s');
        if (strtotime($startTime) <= strtotime($cur) && strtotime($cur) <= strtotime($endTime)) {
            return true;
        }
        return false;
    }

    private function getShoppingCartInfo($shopId)
    {
        $perShopSubtotal=$this->jcart->get_shop_subtotal();
        $curShopSubtotal=$perShopSubtotal[$shopId]==null?0:$perShopSubtotal[$shopId];
        $this->setOutput($curShopSubtotal,'curShopSubtotal');

        //merchandise count
        $this->setOutput($this->jcart->get_count(),'merCount');

        //subtotal
        $this->setOutput($this->jcart->get_subtotal(),'subtotal');

        //ordered merchandises of current shop
        $merchandises=$this->jcart->get_merchandises();
        $orderedMerchandises=array();
        foreach ($merchandises as $item) {
            if ($item['shopid']==$shopId) {
                $orderedMerchandises[$item['id']]=$item['qty'];
            }
        }
        $this->setOutput($orderedMerchandises,"orderedMerchandises");
    }

    private function calculateCurShopDMoney (){        
        $curShopDMoney=0;
        if ($this->_cur_shop['ifrebate']) {
            $perShopSubtotal=$this->jcart->get_shop_subtotal();

            $curShopSubtotal=$perShopSubtotal[$this->_cur_shop['id']]==null?0:$perShopSubtotal[$this->_cur_shop['id']];        

            $money=$curShopSubtotal*$this->_cur_shop['rebatefromshop'];

            $userMoeny=$this->_getShopDailySaleDs()->getUserProfit($money);

            //转换为点币
            $curShopDMoney=$userMoeny*10;                    
        }

        $this->setOutput($curShopDMoney,'curShopDMoney');
        $this->setOutput($this->_user_rate,'userRate');
        $this->setOutput($this->_tax_rate,'taxRate');        
    }    

    /**
     * @return App_Shop
     */
    private function _getShopDs()
    {
        return Wekit::load('EXT:4tschool.service.shop.App_Shop');
    }

    /**
     * @return App_ShopDailySale
     */
    private function _getShopDailySaleDs()
    {
        return Wekit::load('EXT:4tschool.service.shopdailysale.App_ShopDailySale');
    }    

    /**
     * @return App_Merchandise
     */
    private function _getMerchandiseDs()
    {
        return Wekit::load('EXT:4tschool.service.merchandise.App_Merchandise');
    }    

    private function _getCommonDs ()
    {
        return Wekit::load('EXT:4tmobile.service.common.App_Common');
    }       
}

?>