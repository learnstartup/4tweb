<?php

Wind::import('EXT:4tschool.controller.T4BaseNotLoginController');

class MobileshopController extends T4BaseNotLoginController
{    
    public function run()
    {

        $is_weixin=$this->_getCommonDs()->is_weixin();

        if (!$is_weixin) {
            return;
        }        
        $this->setOutput($is_weixin,'is_weixin');   

        list($schoolid, 
             $offset, 
             $limit,
             $wechatOpenId) = $this->getInput(array('schoolid', 
                                             'offset', 
                                             'limit',
                                             'openid'), 'get');

        $schoolid=$this->getCurrentSchoolId();
        $this->setOutput($wechatOpenId,'openId');

        $shopList=$this->_getShopDs()->getBySchoolId($schoolid);

        $promotionalShopList = $this->_getPromotionalmanageDs()->getPromotionalShops($schoolid);

        $promotionalShopIdList = array();
        $newPromotionalList = array();
        $unNewPromotionalList = array();
        foreach ($promotionalShopList as $key => $value) 
        {
            array_push($promotionalShopIdList, $value['shopid']);
        }

        foreach ($shopList as $key => $value) 
        {
            if (empty($shopList[$key]['imageurl'])) 
            {
                $shopList[$key]['imageurl'] = Wekit::C('site', 'info.url') .'/src/extensions/4tschool'. "/uploaded_images/default/sdefault.jpg";
            } 
            else 
            {
                $shopList[$key]['imageurl'] = Wekit::C('site', 'info.url') .'/src/extensions/4tschool'. str_replace('\\', '/', $value['imageurl']);
            }

            $shopList[$key]['isopen'] = $this->isOpening($shopList[$key]['orderbegin'], $shopList[$key]['orderend']);

            if(in_array($value['id'], $promotionalShopIdList))
            {
                array_push($newPromotionalList, $shopList[$key]);
            }
            else
            {
                array_push($unNewPromotionalList, $shopList[$key]);
            }
        } 

        $result = array_merge($newPromotionalList, $unNewPromotionalList);       

        $this->setOutput($result, 'shopList');
        $this->setOutput(count($result), 'shopnumber');
        $this->setOutput($schoolid,'schoolId');
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

    /**
     * @return App_Promotionalmanage
     */
    private function _getPromotionalmanageDs()
    {
        return Wekit::load('EXT:4tschool.service.promotionalmanage.App_Promotionalmanage');
    }    
}

?>