<?php

/**
 */
class ShopmerchdiseController extends PwBaseController {

	public function beforeAction($handlerAdapter) {
		parent::beforeAction($handlerAdapter);

	}


	public function run()
	{

		$this->getShopMenu();

		//$schoolId = $this->getCurrentSchoolId();
        
        //$this->getWebStatus($schoolId);
        
        // list($shopid, $mid) = $this->getInput(array('shopid', 'mid'), 'request');

        //judge if the shop already marked by current user
        $userId = $this->loginUser->uid;
        $this->setOutput($userId, 'userId');
        // $isFavorite = $this->_getMyFavoriteDS()->checkIfExists($userId, $shopid, 0);
        //$this->setOutput($isFavorite, 'isFavorite');

        //推荐商家
        // $schoolInfo = $this->_getSchoolDS()->getSchoolExtra($schoolId);
        // $this->setOutput($schoolInfo[0],'schoolInfo');

        // $promotionalShopList = $this->_getPromotionalmanageDs()->getPromotionalShops($schoolId);
        // foreach ($promotionalShopList as $key => $value) {
        //     if (empty($promotionalShopList[$key]['imageurl'])) {
        //         //set default image
        //         $promotionalShopList[$key]['imageurl'] = Wekit::C('site', 'info.url') .'/src/extensions/4tschool'. "/uploaded_images/default/sdefault.jpg";
        //     } else {
        //         $promotionalShopList[$key]['imageurl'] = Wekit::C('site', 'info.url') .'/src/extensions/4tschool'.str_replace('\\', '/', $value['imageurl']);
        //     }
        //     $promotionalShopList[$key]['isopen'] = $this->isOpening($promotionalShopList[$key]['orderbegin'], $promotionalShopList[$key]['orderend']);
        // }
        // $this->setOutput($promotionalShopList, 'promotionalShopList');

        // $shop = $this->_getShopDs()->getByShopId($shopid);

        // $this->_cur_shop=$shop;

        // $schoolareaList = $this->setAreaFilterWidgetData();
        
        // foreach ($schoolareaList as $key => $value) 
        // {
        //     if($shop['areaid'] == $value['id'])
        //     {
        //         $schoolName = $value['name'];
        //         $schoolAreaName = $value['areaname'];
        //         break;
        //     }
        // }

        //check if shop is active or not
        // if(empty($shop)
        //     || ($shop['isactive'] == 0))
        //     {
        //         $this->setTemplate("shopdetails_notexist");
        //         return;
        //     }

        // $this->displayShoppingCart($shopid,$shop['packingprice'] + $shop['deliveryprice']);

        $defaultSelected = null;
        $merchandiseList = $this->_getMerchandiseDs()->getActiveMerchandiseByShopId(48);
        // echo "<pre>";print_r($merchandiseList);exit;
        
        foreach ($merchandiseList as $key => $value) {
            if (empty($merchandiseList[$key]['imageurl'])) {
                $merchandiseList[$key]['imageurl'] = $this->getDomain() . "/uploaded_images/default/sdefault.jpg";
            } else {
                $merchandiseList[$key]['imageurl'] = $this->getDomain() . str_replace('\\', '/', $value['imageurl']);
            }
            $merchandiseList[$key]['isopen'] = $this->isOpening($merchandiseList[$key]['orderbegin'], $merchandiseList[$key]['orderend']);
            $tagList[$value['tagid']] = $value['tagname'];

            if ($mid && $mid == $value['id']) {
                $defaultSelected = $value['tagname'];
            }

            $merchandiseList[$key]['dmoney']=0;
            if ($shop['ifrebate']) {
                $merchandiseList[$key]['dmoney']=$this->calculateMerchandiseDMoneyByPrice($value['price']);
            }
        }

        $tagList = array_unique($tagList);
        krsort($tagList);

        if ($defaultSelected == null) {
            $defaultSelected = reset($tagList);
        }
        
        //output this var to judge which tag tab should be shown
        $this->setOutput($defaultSelected, 'defaultSelected');

        $this->setAnchor($mid);

        //set hot merchandises
        // $hotMerchandiseList=$this->_getMerchandiseDs()->getHotMerchandisesByShopId($shopid);
        
        // foreach($hotMerchandiseList as $key => &$item)
        // {
        //     if(empty($item['imageurl']))
        //     {
        //         //set default image
        //         $item['imageurl'] =  Wekit::C('site', 'info.url')."/src/extensions/4tschool/uploaded_images/default/mdefault.jpg";
        //     }
        //     else
        //         $item['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool'.str_replace('\\', '/', $item['imageurl']);

        //     $item['isopen'] = $this->isOpening($mInfo['orderbegin'], $item['orderend']);
        //     $item['substrname'] = mb_substr($item['name'], 0, 10, 'utf-8');

        //     $hotMerchandiseList[$key]['dmoney']=0;
        //     if ($shop['ifrebate']) {
        //         $hotMerchandiseList[$key]['dmoney']=$this->calculateMerchandiseDMoneyByPrice($item['price']);
        //     }            
        // }
        // $this->setOutput($hotMerchandiseList,'hotMerchandiseList');

        //set incidentally merchandise
        // $incidentallyMerchandiseList = $this->_getMerchandiseDs()->getIncidentallyMerchandises($this->getIncidentallyShopId());
        // $this->setOutput($this->getIncidentallyShopId(), 'IncidentallyShopId');
        // $this->setOutput($incidentallyMerchandiseList, 'incidentallyMerchandiseList');

        // //set incidentally tag
        // $incidentallyTagList = $this->_getTagDs()->getIncidentallyTags($this->getIncidentallyTagId());
        // $this->setOutput($incidentallyTagList, 'incidentallyTagList');
        // $this->setOutput($mid, 'mid');
        // $cartMid = $mid;
        // if ($this->addToCart($cartMid)) {
        //     $this->setOutput($cartMid,'cartMid');
        // }
        // $this->setOutput($this->getDomain() . $this->getCartRelayPath(), 'BASE_URL');
        $this->setOutput($shop, 'shop');
        $this->setOutput($tagList, 'tagList');
        
        $this->setOutput($merchandiseList, 'merchandiseList');

        //设置是否学校当前状态为可以订餐，如果可以，才能去结算
        // $schoolid = $this->getCurrentSchoolId();
        // $opening = $this->_getSchoolDS()->isSchoolOpenNow($schoolid);
        // $this->setOutput($opening,"opening");

        //get shop's delivery time
        // $timeList = $this->_getShopDs()->getShopDeliveryTimeByShopId($shopid);
        // $this->setOutput($timeList,'timeList');

        // $SEOTitleKeyword = '点餐哟外卖平台 - '.$shop['name'].'点餐, '.$shop['name'].'外卖, '.$shop['name'].'外卖菜单,'.$shop['name'].'网络订餐';

        // $this->setOutput($SEOTitleKeyword,'SEOTitle');
        // $this->setOutput($SEOTitleKeyword,'SEOKeyword');
        //$this->setOutput(1,'addheaderlong');

		
	}



	public functIon getShopMenu()
	{
		$myMenus =  $this->_getShopMerchdiseDS()->getMyMenus($userid);
		
		$this->setOutput($myMenus,'myMenus');
	}

	private function calculateMerchandiseDMoneyByPrice ($price)
    {
        $rate = $this->_cur_shop['rebatefromshop'];
        $rmbShopReturn = $price * $rate;
        $rmbforUser = $this->_getShopDailySaleDs()->getUserProfit($rmbShopReturn);
        $DMoney = $rmbforUser * 10;
        return $DMoney;
    }    

	private function _getShopMerchdiseDS()
	{
		return Wekit::load('EXT:4tshop.service.shopmerchdise.App_MyShop');
	}

	/**
     * @return App_Merchandise
     */
    private function _getMerchandiseDs()
    {
        return Wekit::load('EXT:4tschool.service.merchandise.App_Merchandise');
    }


}