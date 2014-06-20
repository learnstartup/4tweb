<?php
Wind::import('EXT:4tschool.controller.T4BaseController');
/**
 */
class MyFavoriteController extends T4BaseController {

	private $pageNumber = 10;

	public function beforeAction($handlerAdapter) {
		parent::beforeAction($handlerAdapter);

	}

	public function run() {

		$schoolId = $this->getCurrentSchoolId();
		$userid = $this->loginUser->uid;
		$this->getNoCommentSum($schoolId, $userid);

		$myMenus =  $this->_getMyOrderDS()->getMyMenus($schoolId,$userid);
		$this->setOutput($myMenus,'myMenus');

		$shopid = $this->getInput("shopid");
		$this->setOutput($shopid,"shopid");

		$page = $this->getInput('page');

		if($shopid > 0)
		{
			$shopInfo = $this->_getShopDS()->getByShopId($shopid);
			$this->setOutput($shopInfo,'shopInfo');

			$count =  $this->_getMyFavoriteDS()->countMyFavoriteItemByShop($userid, $shopid);
			$setPageList = $this->setPage($count, $page);

			$shopItems = $this->_getMyFavoriteDS()->getMyFavoriteItemByShop($userid, 
																			$shopid, 
																			$setPageList['limit'], 
																			$setPageList['offset']);
			$this->setOutput($shopItems,'shopItems');
			$this->setOutput('我的收藏','subtitle');
		}
		else
		{	
			$count = $this->_getMyFavoriteDS()->countMyFavoriteShops($schoolId, $userid);
			$setPageList = $this->setPage($count, $page);
			$this->setOutput("我收藏的店铺","subtitle");
		}
		
		//set selected menu
		$favoriteList = $this->_getMyFavoriteDS()->getMyFavoriteShops($schoolId, $userid, $setPageList['limit'], $setPageList['offset']);
		foreach($favoriteList as $key => &$item)
		{
			if(empty($item['imageurl']))
			{
				//set default image
				$item['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool/uploaded_images/default/sdefault.jpg';
			}
			else
				$item['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool'.str_replace('\\', '/', $item['imageurl']);//
		}
		$args['schoolid'] = $schoolId;
		$this->setOutput($favoriteList,'favoriteList');
		$this->setOutput('app/4tschool/myfavorite/run','url');
		$this->setOutput(true,"showcheckbox");
		$this->setOutput($args,"args");

		$this->setOutput($schoolId, 'schoolId');  
		$this->setOutput('我的收藏','selectedMenu');
		$this->setOutput($count, 'count');  
        $this->setOutput($page, 'page');
        $this->setOutput($this->pageNumber, 'perPage'); 
	}

	public function getNoCommentSum($schoolId, $userid)
	{
		$countNoComment = $this->_getShopCommentDS()->getCountOfMyUnComment($schoolId, $userid);
        $this->setOutput($countNoComment,"countNoComment");
	}

	public function setPage($count, &$page)
	{
		if (0 < $count) 
        {
          $totalPage = ceil($count/$this->pageNumber);
          $page > $totalPage && $page = $totalPage;
          list($limit, $offset) = Pw::page2limit($page, $this->pageNumber);

          if($page <= 0)
            $page =1;
        }
        return array('limit' => $limit,
        			 'offset' => $offset);
	}

	public function orderedMechandiseAction()
	{
		$schoolId = $this->getCurrentSchoolId();
		$userid = $this->loginUser->uid;
		$this->getNoCommentSum($schoolId, $userid);

		$myMenus =  $this->_getMyOrderDS()->getMyMenus($schoolId,$userid);
		$this->setOutput($myMenus,'myMenus');

		$userid = $this->loginUser->uid;
		$page = $this->getInput('page');
		//note that it need to retrive out all orders instead of only userself.
		$count = $this->_getMyOrderDS()->CountOrderItemsByUser($schoolId, $userid,false); 

		if (0 < $count) 
		{
			$totalPage = ceil($count/$this->pageNumber);
			$page > $totalPage && $page = $totalPage;
			list($start, $limit) = Pw::page2limit($page, $this->pageNumber);

			if($page <= 0)
				$page =1;
		}

		$orderItems = $this->_getMyOrderDS()->getOrderItemsByUser($schoolId, $userid,false,$limit,$start);
		foreach($orderItems as $key => &$item)
		{
			if(empty($item['imageurl']))
				$item['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool/uploaded_images/default/mdefault.jpg';
			else
				$item['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool'.str_replace('\\', '/', $item['imageurl']);
			$item['isopen'] = $this->isOpening($item['orderbegin'], $item['orderend']);
		}
		$args['schoolid'] = $schoolId;
		$schoolInfo = $this->_getSchoolDS()->getSchoolExtra($schoolId);
		$this->setOutput($schoolInfo[0],'schoolInfo');
		
		$this->setOutput($orderItems,'orderItems');
		$this->setOutput($args,'args');
		$this->setOutput($count, 'count');	
		$this->setOutput($page, 'page');
		$this->setOutput($this->pageNumber, 'perPage');
		
		//set selected menu
		$this->setOutput('已购菜品','selectedMenu');
		$this->setOutput("我的已购商品","subtitle");
		$this->setOutput($schoolId,"schoolId");
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

	//ajax action
	//delete favorite shop
	public function deleteAction()
	{
		//choosen item
		$shopid = $this->getInput("favoriteToDelete");
		$userid = $this->loginUser->uid;

		$returnData = array(
			"success"	=> true,
			"data"	=> "删除成功，页面将自动刷新"
			);

		$this->_getMyFavoriteDS()->deleteFavorite($userid,$shopid);
		print_r(json_encode($returnData));
		die;
	}

	//ajax action
	//delete favorite M
	public function deleteMAction()
	{
		//choosen item
		$mid = $this->getInput("favoriteMToDelete","post");
		$userid = $this->loginUser->uid;

		$returnData = array(
			"success"	=> true,
			"data"	=> "删除成功，页面将自动刷新"
			);

		$this->_getMyFavoriteDS()->deleteFavoriteM($userid,$mid);
		print_r(json_encode($returnData));
		die;
	}

	private function _getMyOrderDS()
	{
		return Wekit::load('EXT:4tschool.service.myorder.App_MyOrder');
	}

	private function _getMyFavoriteDS()
	{
		return Wekit::load('EXT:4tschool.service.myfavorite.App_MyFavorite');
	}

    /**
     * @return PwUserMobile
     */
	private function _getUserMobileDS()
	{
		return Wekit::load('SRV:user.PwUserMobile');
	}

    /**
     * @return App_SchoolArea
     */
	private function _getSchoolAreaDS()
	{
		return Wekit::load('EXT:4tschool.service.schoolarea.App_SchoolArea');
	}

    /**
     * @return  App_School
     */
	private function _getSchoolDS()
	{
		return Wekit::load('EXT:4tschool.service.school.App_School');
	}

    /**
     * @return  App_SchoolPeople
     */
	private function _getSchoolPeopleDS()
	{
		return Wekit::load('EXT:4tschool.service.schoolpeople.App_SchoolPeople');
	}

    /**
     * @return App_Shop
     */
	private function _getShopDS()
	{
		return Wekit::load('EXT:4tschool.service.shop.App_Shop');
	}

	private function _getShopCommentDS()
    {
        return Wekit::load('EXT:4tschool.service.mercomment.App_MerComment');
    }

}