<?php
Wind::import('EXT:4tschool.admin.T4AdminBaseController');
Wind::import('EXT:4tschool.service.merchandise.dm.App_Merchandise_Dm');
Wind::import('EXT:4tschool.service.promo.dm.App_Shop_Promo_Dm');
Wind::import('EXT:4tschool.service.promo.dm.App_Merchandise_Promo_Dm');
class PromoController extends T4AdminBaseController
{

    public function run()
    {
        $this->_setNavType('promo');

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
    }

    public function discountAction()
    {
        if ($this->getInput('type', 'post') === "do") {
            $existsMerId = "";
            list($shopId, $promotionList, $merchandiseList, $discountList) = $this->getInput(array('shopId', 'promotionList', 'merchandiseList', 'discountList'), 'post');

            //detect to see whether contains same merchandise id
            $uniqueMerchandiseList = array_unique($merchandiseList);
            if (count($uniqueMerchandiseList) != count($merchandiseList)) {
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

                    //get promotion description
                    $mName = $this->_getMerchandiseDs()->getMerchandiseNameByIdList($merchandiseList[$key]);

                    $description = $mName[0]['name']."打".($discountList[$key] * 10)."折";

                    $spId = $this->addShopPromotion($shopId, $value,1,$description);

                    $element = $this->_getPromoDs()->getPromoByTemplateId($value);

                    $this->addMerchandisePromotion($merchandiseList[$key], $spId, $element['element'], $discountList[$key]);

                    $this->updateMerchandiseCurrentPrice($merchandiseList[$key], $discountList[$key], 'Discount');
                }
                $this->showMessage("添加成功！");
            }

            //if invalid, give a prompt
            $merNameList = "";
            $existsMerId = substr($existsMerId, 0, -1);
            foreach ($this->_getMerchandiseDs()->getMerchandiseNameByIdList($existsMerId) as $item) {
                $merNameList .= $item['name'] . ',';
            }

            $this->showError('菜品："' . substr($merNameList, 0, -1) . '"已参与了本活动，无法重复添加！');

        }

        $shopId = $this->getInput('choosenShopid', 'request');
        $this->setOutput($shopId, 'shopId');

        if (!empty($shopId)) {
            $merchandiseList = $this->_getMerchandiseDs()->getMerchandiseByShopId($shopId);
            $this->setOutput($merchandiseList, 'merchandiseList');
        }

        $promoTemplateList = $this->_getPromoDs()->getTemplates();
        $this->setOutput($promoTemplateList, 'promoTemplateList');
    }

    public function meetDeductAction()
    {
        if ($this->getInput('type', 'post') === "do") {
            $existsMerId = "";
            list($shopId, $merchandiseList, $conditionList, $deductList) = $this->getInput(array('shopId', 'merchandiseList', 'conditionList', 'deductList'), 'post');

            //detect to see whether contains same merchandise id
            $uniqueMerchandiseList = array_unique($merchandiseList);
            if (count($uniqueMerchandiseList) != count($merchandiseList)) {
                $this->showError("有重复的菜品，菜品不能重复参与活动！");
            }

            //detect to see if the merchandises already participated the promotion.
            foreach ($merchandiseList as $key => $value) {
                if ($this->_getPromoDs()->hasPromotion($shopId, $merchandiseList[$key])) {
                    $existsMerId .= $merchandiseList[$key] . ',';
                    continue;
                }
            }

            //if valid, add to database
            if (empty($existsMerId)) {
                foreach ($merchandiseList as $key => $value) {

                    //get meet deduct promotion template
                    $promo = $this->_getPromoDs()->getPromoByTemplateName('MeetDeduct');

                    //get shop promo id
                    $spId = $this->addShopPromotion($shopId, $promo[0]['templateid']);

                    $elementValue = null;

                    
                    foreach ($promo as $index => $item) {
                        if ($item['element'] == 'M') {
                            //no value for this element of this promo
                            $elementValue = $merchandiseList[$key];
                        } elseif ($item['element'] == 'C') {
                            $elementValue = $conditionList[$key];
                        } elseif ($item['element'] == 'A') {
                            $elementValue = $deductList[$key];
                        }

                        $this->addMerchandisePromotion($merchandiseList[$key], $spId, $promo[$index]['element'], $elementValue);
                    }

                    $mId = $merchandiseList[$key];
                    $condition = $conditionList[$key];
                    $deduct = $deductList[$key];

                    //get promotion description
                    $mName = $this->_getMerchandiseDs()->getMerchandiseNameByIdList($mId);
                    $description = "商店购物满".$condition.'元'.$mName[0]['name'].'立减'.$deduct.'元';
                    $this->updateShopPromotion($spId,$description);

                }
                $this->showMessage("添加成功！");
            }

            //if invalid, give a prompt
            $merNameList = "";
            $existsMerId = substr($existsMerId, 0, -1);
            foreach ($this->_getMerchandiseDs()->getMerchandiseNameByIdList($existsMerId) as $item) {
                $merNameList .= $item['name'] . ',';
            }

            $this->showError('菜品："' . substr($merNameList, 0, -1) . '"已参与了本活动，无法重复添加！');

        }

        $shopId = $this->getInput('choosenShopid', 'request');
        $this->setOutput($shopId, 'shopId');

        if (!empty($shopId)) {
            $merchandiseList = $this->_getMerchandiseDs()->getMerchandiseByShopId($shopId);
            $this->setOutput($merchandiseList, 'merchandiseList');
        }
    }

    //dialog
    //edit discount of merchandise
    public function editAction()
    {
        if ($this->getInput('type', 'post') === 'do') {
            list($id, $merchandiseId, $spId) = $this->getInput(array('id', 'mid', 'spid'), 'request');

            $discount = $this->getInput('discount', 'post');

            //更新描述信息
            $mName = $this->_getMerchandiseDs()->getMerchandiseNameByIdList($merchandiseId);
            $description = $mName[0]['name']."打".($discount * 10)."折";
            $this->updateShopPromotion($spId,$description);

            //更新商品的活动存储
            $dm = new App_Merchandise_Promo_Dm();
            $dm->setValue($discount)
                ->setLastUpdateTime(Pw::getTime());

            $this->_getPromoDs()->updateMerchandisePromo($id, $dm);

            //把价格更新回商品的主表
            $this->updateMerchandiseCurrentPrice($merchandiseId, $discount, 'Discount');

            $this->showMessage('更新成功!');
        }
        $spId = $this->getInput('spid', 'request');
        $merchandisePromotion = $this->_getPromoDs()->getMerchandisePromotionBySPID($spId);

        $this->setOutput($spId, 'spid');
        $this->setOutput($merchandisePromotion[0], 'merchandisePromotion');
    }

    //dialog
    //edit meet deduct of merchandise
    public function editmeetdeductAction()
    {

        $spid = $this->getInput('spid');
        if(empty($spid))
        {
            $this->showError("无效的ID");
        }
 

        if ($this->getInput('type', 'post') === 'do') {

            list($meetV, $deductV,$mid) = $this->getInput(array('meetV', 'deductV','mid'), 'request');

            $mid = $this->getInput('mid');
            if(empty($mid))
            {
                $this->showError("无效的MID");
            }

            //update information back
            $affectedRow = $this->_getPromoDs()->updateMerchandisePromotion($mid,$spid,'C',$meetV);
            $this->_getPromoDs()->updateMerchandisePromotion($mid,$spid,'A',$deductV);
            $this->_getPromoDs()->updateMerchandisePromotion($mid,$spid,'M',$mid);

            $mName = $this->_getMerchandiseDs()->getMerchandiseNameByIdList($mid);
            $description = "商店购物满".$meetV.'元'.$mName[0]['name'].'立减'.$deductV.'元';
            $this->updateShopPromotion($spid,$description);

            $this->showMessage('更新成功!');

        }

        //get information
        $mMeetDeducts = $this->_getPromoDs()->getMerchandisePromotionBySPID($spid);

        if(count($mMeetDeducts) < 3)
            $this->showError("无效的满减活动");

        $mName = '';
        $meetV = 0;
        $deductV = 0;
        $mid = 0;

        foreach ($mMeetDeducts as $key => $eachone) {
            if ($eachone['element'] == 'M') {
                        $mName = $eachone['name'];
                        $mid =$eachone['merchandiseid'];

                } elseif ($eachone['element'] == 'C') {

                    $meetV = $eachone['value'];

                } elseif ($eachone['element'] == 'A') {

                    $deductV = $eachone['value'];

                }
        }

        $this->setOutput($spid,'spid');
        $this->setOutput($mName,'mName');
        $this->setOutput($mid,'mid');
        $this->setOutput($meetV,'meetV');
        $this->setOutput($deductV,'deductV');


    }

    //ajax
    //cancel discount
    public function cancelDiscountAction()
    {
        $returnData = array(
            "success"   => true,
            "data"  => "操作成功"
            );

        $spid = $this->getInput('spid');

        if(empty($spid))
        {
            $returnData['success'] = false;
            $returnData['data'] = '无效ID';

            print_r($returnData);die;
        }

        //判断是否为折扣
        $name = $this->_getPromoDs()->getTemplateNameBySPID($spid);
        if($name != 'Discount')
        {
            $returnData['success'] = false;
            $returnData['data'] = '无效类型';

            print_r($returnData);die;
        }

        //调用方法，取消折扣
        $this->_getPromotionsDs()->getPromo('Discount')->cancel($spid);

        //update M's price back to original
        $this->updateMerchandiseCurrentPrice($this->_getPromoDs()->GetMIdbySPID($spid),1,'Discount');

        $returnData['success'] = true;
        $returnData['data'] = '取消折扣成功';

        print_r($returnData);die;

    }

    //ajax
    //cancel meet deduct
    public function cancelMeetDeductAction()
    {
        $returnData = array(
            "success"   => true,
            "data"  => "操作成功"
            );

        $spid = $this->getInput('spid');

        if(empty($spid))
        {
            $returnData['success'] = false;
            $returnData['data'] = '无效ID';

            print_r($returnData);die;
        }

        //判断是否为折扣
        $name = $this->_getPromoDs()->getTemplateNameBySPID($spid);
        if($name != 'MeetDeduct')
        {
            $returnData['success'] = false;
            $returnData['data'] = '无效类型';

            print_r($returnData);die;
        }

        //调用方法, 变成 isactive =0
        $this->_getPromotionsDs()->getPromo()->cancel($spid);

        $returnData['success'] = true;
        $returnData['data'] = '取消折扣成功';

        print_r($returnData);die;

    }

    private function addShopPromotion($shopId, $promoTemplateId, $isActive = 1,$description='')
    {
        $spdm = new App_Shop_Promo_Dm();
        $spdm->setShopId($shopId)
            ->setTemplateId($promoTemplateId)
            ->setIsActive($isActive)
            ->setDescription($description)
            ->setCreateDate(Pw::getTime())
            ->setLastUpdateTime(Pw::getTime());

        return $this->_getPromoDs()->insertShopPromo($spdm);
    }

    private function updateShopPromotion($spid,$description='')
    {
        $spdm = new App_Shop_Promo_Dm();
        $spdm->setDescription($description)
            ->setLastUpdateTime(Pw::getTime());

        return $this->_getPromoDs()->UpdateShopPromo($spid,$spdm);
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


    private function updateMerchandiseCurrentPrice($merchandiseId, $discount, $name)
    {
        $merchandise = $this->_getMerchandiseDs()->getMerchandiseById($merchandiseId);

        $discountedPrice = $this->_getPromotionsDs()->getPromo($name)->get_promo_price($merchandise['price'], $discount);

        $dm = new App_Merchandise_Dm();
        $dm->setCurrentPrice($discountedPrice)
            ->setLastUpdateTime(Pw::getTime());

        $this->_getMerchandiseDs()->update($merchandiseId, $dm);

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
        return Wekit::load('EXT:4tschool.service.shop.App_Shop');
    }

    /**
     * @return App_Merchandise
     */
    private function _getMerchandiseDs()
    {
        return Wekit::load('EXT:4tschool.service.merchandise.App_Merchandise');
    }

    /**
     * @return Promotions
     */
    private function _getPromotionsDs()
    {
        return Wekit::load('EXT:4tschool.service.promo.Promotions');
    }

    /**
     * @return App_Promo
     */
    private function _getPromoDs()
    {
        return Wekit::load('EXT:4tschool.service.promo.App_Promo');
    }

    /**
     * @return App_MyOrder
     */
    private function _getMyOrderDS()
    {
        return Wekit::load('EXT:4tschool.service.myorder.App_MyOrder');
    }
}