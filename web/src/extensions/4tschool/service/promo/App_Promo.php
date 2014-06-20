<?php

defined('WEKIT_VERSION') or exit(403);
/**
 *
 */
class App_Promo
{

    public function insertPromoTemplate(App_Promo_Dm $dm)
    {
        if (true != ($r = $dm->beforeAdd())) {
            return $r;
        }
        return $this->_loadPromoDao()->add($dm->getData());
    }

    public function insertShopPromo(App_Shop_Promo_Dm $dm){
        if (true != ($r = $dm->beforeAdd())) {
            return $r;
        }
        return $this->_loadShopPromoDao()->add($dm->getData());
    }

    public function UpdateShopPromo($spid, App_Shop_Promo_Dm $dm){
        
        return $this->_loadShopPromoDao()->update($spid,$dm->getData());
    }

    public function insertMerchandisePromo(App_Merchandise_Promo_Dm $dm){
        if (true != ($r = $dm->beforeAdd())) {
            return $r;
        }
        return $this->_loadMerchandisePromoDao()->add($dm->getData());
    }

    public function updateMerchandisePromo($id,App_Merchandise_Promo_Dm $dm) {
        if (true !== ($r = $dm->beforeUpdate())) return $r;
        return $this->_loadMerchandisePromoDao()->update($id, $dm->getData());
    }

    public function generateTemplateid()
    {
        return $this->_loadPromoDao()->generateTemplateid();
    }

    public function checkDuplicateInfo($col, $info)
    {
        return $this->_loadPromoDao()->checkDuplicateInfo($col, $info);
    }

    public function getTemplates(){
        return $this->_loadPromoDao()->getTemplates();
    }

    public function getPromoByTemplateId($id)
    {
        return $this->_loadPromoDao()->getPromoByTemplateId($id);
    }

    public function getPromoByTemplateName($name)
    {
        return $this->_loadPromoDao()->getPromoByTemplateName($name);
    }

    public function getShopPromotionsByShopId($shopId)
    {
        return $this->_loadShopPromoDao()->getShopPromotionsByShopId($shopId);
    }

    public function getPromotionById($id)
    {
        return $this->_loadShopPromoDao()->getPromotionById($id);
    }

    public function getTemplateNameBySPID($spId)
    {
        $result = $this->_loadShopPromoDao()->getTemplateNameBySPID($spId);
        return $result[0]['name'];
    }

    public function getMerchandisePromotionBySPID($spId)
    {
        return $this->_loadMerchandisePromoDao()->getMerchandisePromotionBySPID($spId);
    }

    public function hasPromotion($shopId, $merchandiseId)
    {
        return $this->_loadMerchandisePromoDao()->hasPromotion($shopId,$merchandiseId);
    }

    public function getPromotionByMids($midList)
    {
        return $this->_loadMerchandisePromoDao()->getPromotionByMids($midList);
    }

    public function GetMIdbySPID($spid)
    {
        $mInfor = $this->_loadMerchandisePromoDao()->getMerchandisePromotionBySPID($spid);

        if(empty($mInfor))
        {
            return;
        }

        $mid = $mInfor['merchandiseid'];

        return $mid;
    }

    public function matchedPromoInCart($orderMerchandiseList)
    {
        if(empty($orderMerchandiseList))
            return;

        //try group by shop
        $groupOrder = array();
        foreach ($orderMerchandiseList as $key => $orderItem) {
            
            if(!array_key_exists($orderItem['vendor'], $groupOrder))
            {
                $groupOrder[$orderItem['vendor']] = array("Total" => 0,"Items" => array());
            }

            $groupOrder[$orderItem['vendor']]["Total"] = $groupOrder[$orderItem['vendor']]["Total"] + $orderItem['price'] * $orderItem['qty'];
            $groupOrder[$orderItem['vendor']]["Items"][] = $orderItem;

        }


        //get m list and get active shop promotion
        //verify which can be matched and which isn't
        $midList = "  -1, ";
        foreach ($orderMerchandiseList as $key => $eachOM) {
            $midList = $midList.$eachOM['id']." ,";
        }

        $midList = $midList." -1 ";

        $proMotions = $this->getPromotionByMids($midList);

        //group by shop promotion id
        //discount shall be discard, as this has been handled
        $groupProMo = array();
        foreach ($proMotions as $key => $eachP) {

            if($eachP['PromotionName'] != 'MeetDeduct')
                continue;

            if(!array_key_exists($eachP['shoppromoid'], $groupProMo))
            {
                $groupProMo[$eachP['shoppromoid']] = array("Shoppromoid" =>$eachP['shoppromoid'],
                                                            "ShopId" => $eachP['ShopId'],
                                                            "ShopName" => $eachP['ShopName'],
                                                            "MerchandiseName" => $eachP['MerchandiseName'],
                                                            "MID" => $eachP['merchandiseid'],
                                                            "Meet" => "",
                                                            "Deduct" => "");
            }

            switch ($eachP['element']) {
                case 'C':
                    $groupProMo[$eachP['shoppromoid']]['Meet'] = $eachP['value'];
                    break;
                case 'A':
                    $groupProMo[$eachP['shoppromoid']]['Deduct'] = $eachP['value'];
                    break;
                default:
                    break;
            }
     
        }

        //check existing order items, check which one is matched, which ones are not matched
        $result = array("Match" => array(),"NotMatch" => array());

        foreach ($groupProMo as $key1 => $eachPromo) {

            $matched = false;
            foreach ($groupOrder as $key => $eachShop) {
            
                if($eachPromo['ShopId'] == $key)
                {
                    //check if match
                    if( $eachShop['Total'] >= $eachPromo["Meet"])
                    {
                        $result['Match'][] = $eachPromo;
                        $matched = true;
                    }
                }
            }

            if($matched == false)
            {
                $result['NotMatch'][] = $eachPromo;
            }
        }

        return $result;
    }


    //更新M Promotion 的值
    public function updateMerchandisePromotion($mid, $spid, $element, $value)
    {
        return $this->_loadMerchandisePromoDao()->updateMerchandisePromotion($mid,$spid,$element,$value);
    }


    /**
     * @return App_Promo_Dao
     */
    private function _loadPromoDao()
    {
        return Wekit::loadDao('EXT:4tschool.service.promo.dao.App_Promo_Dao');
    }

    /**
     * @return App_Shop_Promo_Dao
     */
    private function _loadShopPromoDao()
    {
        return Wekit::loadDao('EXT:4tschool.service.promo.dao.App_Shop_Promo_Dao');
    }

    /**
     * @return App_Merchandise_Promo_Dao
     */
    private function _loadMerchandisePromoDao()
    {
        return Wekit::loadDao('EXT:4tschool.service.promo.dao.App_Merchandise_Promo_Dao');
    }
}

?>