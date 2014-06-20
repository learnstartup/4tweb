<?php
Wind::import('EXT:4tschool.controller.T4BaseController');
/**
 */
class ShopcommentController extends T4BaseController {

	private $pageNumber = 10;

	public function beforeAction($handlerAdapter) {

		parent::beforeAction($handlerAdapter);

		if(empty($this->schoolExtra) == false && $this->schoolExtra['openorder'] == 0)
		{
			$this->forwardRedirect(WindUrlHelper::createUrl('app/4tschool/notopen/run'));
		}		
	}

	//get all messages
	public function run() {

		$schoolId = $this->getCurrentSchoolId();
		$userid = $this->loginUser->uid;

		$myMenus =  $this->_getMyOrderDS()->getMyMenus($schoolId,$userid);
		$this->setOutput($myMenus,'myMenus');
	}


	//get my no comment
	public function mynocommentAction() {

		$schoolid = $this->getCurrentSchoolId();
		$userid = $this->loginUser->uid;
		$this->getNoCommentSum($schoolid, $userid);

		$myMenus =  $this->_getMyOrderDS()->getMyMenus($schoolid,$userid);
		$this->setOutput($myMenus,'myMenus');

		$page = $this->getInput('page');
		$count = $this->_getShopCommentDS()->getCountOfMyUnComment($schoolid,$userid);
		if (0 < $count) 
		{
			$totalPage = ceil($count/$this->pageNumber);
			$page > $totalPage && $page = $totalPage;
			list($start, $limit) = Pw::page2limit($page, $this->pageNumber);

			if($page <= 0)
				$page =1;
		}

		$toBeComment = $this->_getShopCommentDS()->getMyUnComment($schoolid,$userid,$limit,$start);
		foreach($toBeComment as $key => &$item)
		{
			if(empty($item['imageurl']))
			{
				//set default image
				$item['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool/uploaded_images/default/sdefault.jpg';
			}
			else
				$item['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool'.str_replace('\\', '/', $item['imageurl']);

			$item['isopen'] = $this->isOpening($item['orderbegin'], $item['orderend']);
		}

		$schoolInfo = $this->_getSchoolDS()->getSchoolExtra($schoolid);
		$this->setOutput($schoolInfo[0],'schoolInfo');
		
		$this->setOutput($toBeComment,'toBeComment');
		$this->setOutput($count, 'count');	
		$this->setOutput($page, 'page');
		$this->setOutput($this->pageNumber, 'perPage');	

		$args['choosenStatus'] = $choosenStatus;
		$args['schoolid'] = $schoolid;
		$this->setOutput($args,"args");

		//set selected menu
		$this->setOutput('待评价','selectedMenu');	
		$this->setOutput('待评价商品列表','subtitle');
		$this->setOutput($schoolid,'schoolId');
		$this->setOutput(Wekit::C('site', 'info.url'),'rooturl');

	}

	public function getNoCommentSum($schoolId, $userid)
	{
		$countNoComment = $this->_getShopCommentDS()->getCountOfMyUnComment($schoolId, $userid);
        $this->setOutput($countNoComment,"countNoComment");
	}
	

	//get my no comment
	public function mycommentAction() {

		$schoolid = $this->getCurrentSchoolId();
		$userid = $this->loginUser->uid;
		$this->getNoCommentSum($schoolid, $userid);

		$myMenus =  $this->_getMyOrderDS()->getMyMenus($schoolid,$userid);
		$this->setOutput($myMenus,'myMenus');

		$page = $this->getInput('page');
		$count = $this->_getShopCommentDS()->getCountOfMyComment($schoolid,$userid);
		if (0 < $count) 
		{
			$totalPage = ceil($count/$this->pageNumber);
			$page > $totalPage && $page = $totalPage;
			list($start, $limit) = Pw::page2limit($page, $this->pageNumber);

			if($page <= 0)
				$page =1;
		}

		$toBeComment = $this->_getShopCommentDS()->getMyComment($schoolid,$userid,$limit,$start);
		foreach($toBeComment as $key => &$item)
		{
			if(empty($item['imageurl']))
			{
				//set default image
				$item['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool/uploaded_images/default/sdefault.jpg';
			}
			else
				$item['imageurl'] =  Wekit::C('site', 'info.url').'/src/extensions/4tschool'.str_replace('\\', '/', $item['imageurl']);

			$item['isopen'] = $this->isOpening($item['orderbegin'], $item['orderend']);
		}

		$schoolInfo = $this->_getSchoolDS()->getSchoolExtra($schoolid);
		$this->setOutput($schoolInfo[0],'schoolInfo');

		$this->setOutput($toBeComment,'toBeComment');
		$this->setOutput($count, 'count');	
		$this->setOutput($page, 'page');
		$this->setOutput($this->pageNumber, 'perPage');	

		$args['choosenStatus'] = $choosenStatus;
		$args['schoolid'] = $schoolid;
		$this->setOutput($args,"args");

		//set selected menu
		$this->setOutput('已评价','selectedMenu');	
		$this->setOutput('已评价商品列表','subtitle');
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

	public function doaddcommentAction()
	{
		$returnData = array(
			"success"	=> true,
			"data"	=> "评价成功, 感谢您的配合"
			);

		$orderidmid = $this->getInput("orderidmid","post");
		$comment = $this->getInput("comment","post");
		$tastescore = $this->getInput("tastescoreshow","post");
		$servicescore = $this->getInput("servicescoreshow","post");

		$inforArray = explode(";", $orderidmid);
		$orderid = $inforArray[0];
		$mid = $inforArray[1];

		if(empty($orderid) || empty($mid))
		{
			$returnData['success'] = false;
			$returnData['data'] = "数据不对,请核实";
			print_r(json_encode($returnData));
			die;
		}

		if(empty($comment))
		{
			$returnData['success'] = false;
			$returnData['data'] = "评论不能为空";
			print_r(json_encode($returnData));
			die;
		}

		//1. 检查是否是我的订单以及这个Item是否被我评论过
		//1. get order item details
		$order = $this->_getMyOrderDS()->getOrdertail($orderid);
		if(empty($order) || $order[0]['userid'] != $this->loginUser->uid)
		{
			$returnData['success'] = false;
			$returnData['data'] = "您不能进行评价,请匹配正确的数据";
			print_r(json_encode($returnData));
			die;
		}

		//2. 检查我是否已经评论过
		$exists = $this->_getShopCommentDS()->checkIfExists($this->loginUser->uid,$orderid,$mid);
		if($exists)
		{
			$returnData['success'] = false;
			$returnData['data'] = "您已经对此订单的商品进行了评价";
			print_r(json_encode($returnData));
			die;
		}

		$id = $this->_getShopCommentDS()->addMyComment($this->loginUser->uid,$mid,$orderid,$comment,0,$servicescore,$tastescore);
		if($id > 0)
		{
			$this->_getMyOrderDS()->updateItemasCommented($orderid,$mid);
			print_r(json_encode($returnData));
			die;
		}
		else
		{
			$returnData['success'] = false;
			$returnData['data'] = "评论失败,请联系系统管理员";
			print_r(json_encode($returnData));
			die;
		}
		
	}


	private function _getShopCommentDS()
	{
		return Wekit::load('EXT:4tschool.service.mercomment.App_MerComment');
	}

	private function _getMyOrderDS()
	{
		return Wekit::load('EXT:4tschool.service.myorder.App_MyOrder');
	}

	private function _getMessageBoardDS()
	{
		return Wekit::load('EXT:4tschool.service.messageboard.App_MessageBoard');
	}

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


}