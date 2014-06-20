<?php
Wind::import('EXT:4Tschool.service.merchandise.dm.App_Merchandise_Dm');
Wind::import('EXT:4Tschool.service.promo.dm.App_Shop_Promo_Dm');
Wind::import('EXT:4Tschool.service.promo.dm.App_Merchandise_Promo_Dm');
class PromoController extends PwBaseController
{

    public function run()
    {

        list($choosenSchoolid, $choosenSchoolAreaid, $choosenShopid) = $this->getInput(array('choosenSchoolid', 'choosenSchoolAreaid', 'choosenShopid'), 'requst');

        //set school
        $schoolList = $this->_getSchoolDs()->getOpenedSchools();
        $this->setOutput($schoolList, 'schoolList');

        //set school area by school id
        if (!empty($choosenSchoolid)) {
            $schoolAreaList = $this->_getSchoolAreaDs()->getBySchoolid($choosenSchoolid);
            $this->setOutput($schoolAreaList, 'schoolAreaList');
        }

        //set shop by school area id
        if (!empty($choosenSchoolAreaid)) {
            $shopList = $this->_getShopDs()->getShopsByAreaId($choosenSchoolAreaid);
            $this->setOutput($shopList, 'shopList');
        }

        //set promotions by shop id
        if (!empty($choosenShopid)) {
            $shopPromotionsList = $this->_getPromoDs()->getShopPromotionsByShopId($choosenShopid);
            $this->setOutput($shopPromotionsList, 'shopPromotionsList');
        }

        $this->setOutput($choosenSchoolid, 'choosenSchoolid');
        $this->setOutput($choosenSchoolAreaid, 'choosenSchoolAreaid');
        $this->setOutput($choosenShopid, 'choosenShopid');
        $this->setTemplate('promo/promo_run');
    }

    public function addAction()
    {
        if ($this->getInput('type', 'post') === "do") {
            $existsMerId = "";
            list($shopId, $promotionList, $merchandiseList, $discountList) = $this->getInput(array('shopId', 'promotionList', 'merchandiseList', 'discountList'), 'post');

            //detect to see whether contains same merchandise id
            $uniqueMerchandiseList=array_unique($merchandiseList);
            if (count($uniqueMerchandiseList)!=count($merchandiseList)) {
                $this->showError("有重复的菜品，菜品不能重复参与活动！");
            }

            //detect to see if the merchandises already participated the promotion.
            foreach ($promotionList as $key => $value) {
                if ($this->_getPromoDs()->hasPromotion($shopId, $merchandiseList[$key])) {
                    $existsMerId .= $merchandiseList[$key] . ',';
                    continue;
                }
            }

            //if valid, add to database
            if (empty($existsMerId)) {
                foreach ($promotionList as $key => $value) {

                    $spid = $this->addShopPromotion($shopId, $value);

                    $element = $this->_getPromoDs()->getPromoByTemplateId($value);

                    $this->addMerchandisePromotion($merchandiseList[$key], $spid, $element['element'], $discountList[$key]);

                    $this->updateMerchandiseCurrentPrice($merchandiseList[$key], $discountList[$key], $value);
                }
                $this->showMessage("添加成功！");
            }

            //if invalid, give a prompt
            $merNameList = "";
            $existsMerId = substr($existsMerId, 0, -1);
            foreach ($this->_getMerchandiseDs()->getMerchandiseNameByIdList($existsMerId) as $item) {
                $merNameList .= $item['name'] . ',';
            }

            $this->showError('菜品："' . substr($merNameList,0,-1) . '"已参与了本活动，无法重复添加！');

        }

        $shopId = $this->getInput('choosenShopid', 'request');
        $this->setOutput($shopId, 'shopId');

        if (!empty($shopId)) {
            $merchandiseList = $this->_getMerchandiseDs()->getMerchandiseByShopId($shopId);
            $this->setOutput($merchandiseList, 'merchandiseList');
        }

        $promoTemplateList = $this->_getPromoDs()->getTemplates();
        $this->setOutput($promoTemplateList, 'promoTemplateList');
        $this->setTemplate('promo/promo_add');
    }

    public function editAction()
    {
        if ($this->getInput('type', 'post') === 'do') {
            list($id,$merchandiseId,$templateId) = $this->getInput(array('id','mid','tid'), 'request');

            $discount = $this->getInput('discount', 'post');

            $dm = new App_Merchandise_Promo_Dm();
            $dm->setValue($discount)
                ->setLastUpdateTime(Pw::getTime());

            $this->_getPromoDs()->updateMerchandisePromo($id, $dm);

            $this->updateMerchandiseCurrentPrice($merchandiseId,$discount,$templateId);

            $this->showMessage('更新成功!');
        }
        $spId = $this->getInput('spid', 'request');
        $merchandisePromotion = $this->_getPromoDs()->getMerchandisePromotionBySPID($spId);

        $this->setOutput($spId, 'spid');
        $this->setOutput($merchandisePromotion, 'merchandisePromotion');
        $this->setTemplate('promo/promo_edit');
    }

    private function addShopPromotion($shopId, $promoTemplateId, $isActive = 1)
    {
        $spdm = new App_Shop_Promo_Dm();
        $spdm->setShopId($shopId)
            ->setTemplateId($promoTemplateId)
            ->setIsActive($isActive)
            ->setCreateDate(Pw::getTime())
            ->setLastUpdateTime(Pw::getTime());

        return $this->_getPromoDs()->insertShopPromo($spdm);
    }

    private function addMerchandisePromotion($merchandiseId, $spid, $element, $value)
    {
        $mpdm = new App_Merchandise_Promo_Dm();
        $mpdm->setMerchandiseId($merchandiseId)
            ->setShopPromoId($spid)
            ->setElement($element)
            ->setValue($value)
            ->setCreateDate(Pw::getTime())
            ->setLastUpdateTime(Pw::getTime());

        $this->_getPromoDs()->insertMerchandisePromo($mpdm);
    }

    private function updateMerchandiseCurrentPrice($merchandiseId, $discount, $promoTemplateId)
    {
        $promotion = $this->_getPromoDs()->getPromoByTemplateId($promoTemplateId);

        $merchandise=$this->_getMerchandiseDs()->getMerchandiseById($merchandiseId);

        $discountedPrice = $this->_getPromotionsDs()->getPromo($promotion['name'])->get_discounted_price($merchandise['price'], $discount);

        $dm=new App_Merchandise_Dm();
        $dm->setCurrentPrice($discountedPrice)
            ->setLastUpdateTime(Pw::getTime());

        $this->_getMerchandiseDs()->update($merchandiseId,$dm);
    }

    private function _getSchoolDs()
    {
        return Wekit::load('EXT:4tschool.service.school.App_School');
    }

    private function _getSchoolAreaDs()
    {
        return Wekit::load('EXT:4tschool.service.schoolarea.App_SchoolArea');
    }

    private function _getShopDs()
    {
        return Wekit::load('EXT:4Tschool.service.shop.App_Shop');
    }

    /**
     * @return App_Merchandise
     */
    private function _getMerchandiseDs()
    {
        return Wekit::load('EXT:4Tschool.service.merchandise.App_Merchandise');
    }

    private function _getPromotionsDs()
    {
        return Wekit::load('EXT:4Tschool.service.promo.Promotions');
    }

    /**
     * @return App_Promo
     */
    private function _getPromoDs()
    {
        return Wekit::load('EXT:4Tschool.service.promo.App_Promo');
    }
}