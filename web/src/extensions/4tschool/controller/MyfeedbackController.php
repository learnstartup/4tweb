<?php
Wind::import('EXT:4tschool.controller.T4BaseController');
/**
 */
class myfeedbackController extends T4BaseController {

	private $pageNumber = 10;

	public function beforeAction($handlerAdapter) {

		parent::beforeAction($handlerAdapter);

		if(empty($this->schoolExtra) == false && $this->schoolExtra['openliuyanban'] == 0)
		{
			$this->forwardRedirect(WindUrlHelper::createUrl('app/4tschool/notopen/run'));
		}
				
	}

	//get all messages
	public function run() {

		$schoolId = $this->getCurrentSchoolId();
		$userid = $this->loginUser->uid;
		$this->getNoCommentSum($schoolId, $userid);

		$myMenus =  $this->_getMyOrderDS()->getMyMenus($schoolId,$userid);
		$this->setOutput($myMenus,'myMenus');


		$schoolId = $this->getCurrentSchoolId();

		$choosenStatus  = $this->getInput("choosenStatus");
		$this->setOutput($choosenStatus,"choosenStatus");


		$page = $this->getInput('page');
		$count = $this->_getMessageBoardDS()->countByUserid($schoolId,$this->loginUser->uid,-1,$choosenStatus);

		if (0 < $count) 
		{
			$totalPage = ceil($count/$this->pageNumber);
			$page > $totalPage && $page = $totalPage;
			list($start, $limit) = Pw::page2limit($page, $this->pageNumber);

			if($page <= 0)
				$page =1;
		}


		$messageList = $this->_getMessageBoardDS()->getByUserid($schoolId,$this->loginUser->uid,-1,$choosenStatus,$limit,$start);


		$this->setOutput($messageList,'messageList');
		$this->setOutput($count, 'count');	
		$this->setOutput($page, 'page');
		$this->setOutput($this->pageNumber, 'perPage');	

		$args['choosenStatus'] = $choosenStatus;
		$this->setOutput($args,"args");

		//set selected menu
		$this->setOutput('我的留言','selectedMenu');	
		$this->setOutput('查看我的留言','subtitle');
		$this->setOutput($schoolId,'schoolId');

	}


	//get all approved messages
	public function manageAction() {

		$schoolId = $this->getCurrentSchoolId();
		$userid = $this->loginUser->uid;
		$this->getNoCommentSum($schoolId, $userid);

		$myMenus =  $this->_getMyOrderDS()->getMyMenus($schoolId,$userid);
		$this->setOutput($myMenus,'myMenus');

		$choosenStatus  = $this->getInput("choosenStatus");
		$this->setOutput($choosenStatus,"choosenStatus");


		$page = $this->getInput('page');
		$count = $this->_getMessageBoardDS()->countMessages($schoolId,-1,$choosenStatus);

		if (0 < $count) 
		{
			$totalPage = ceil($count/$this->pageNumber);
			$page > $totalPage && $page = $totalPage;
			list($start, $limit) = Pw::page2limit($page, $this->pageNumber);

			if($page <= 0)
				$page =1;
		}


		$messageList = $this->_getMessageBoardDS()->getMessages($schoolId,-1,$choosenStatus,$limit,$start);


		$this->setOutput($messageList,'messageList');
		$this->setOutput($count, 'count');	
		$this->setOutput($page, 'page');
		$this->setOutput($this->pageNumber, 'perPage');	

		$args['choosenStatus'] = $choosenStatus;
		$this->setOutput($args,"args");

		//set selected menu
		$this->setOutput('留言管理','selectedMenu');	
		$this->setOutput('管理网站用户的留言','subtitle');
		$this->setOutput($schoolId,'schoolId');

	}

	public function getNoCommentSum($schoolId, $userid)
	{
		$countNoComment = $this->_getShopCommentDS()->getCountOfMyUnComment($schoolId, $userid);
        $this->setOutput($countNoComment,"countNoComment");
	}
	

	//ajax
	//delete message by id
	public function deleteAction()
	{
		$returnData = array(
			"success"	=> true,
			"data"	=> "留言成功，正在审核并等待回复，谢谢"
			);
		//idtodelete
		$id = $this->getInput("idtodelete");
		if($id <= 0)
		{
			$returnData['success'] = false;
			$returnData['data'] = "不正确的删除";
			print_r(json_encode($returnData));
			die;
		}

		//do delete
		$this->_getMessageBoardDS()->updateAsDeleted($id,$this->loginUser->uid);

		$returnData = array(
			"success"	=> true,
			"data"	=> "删除成功, 页面将刷新"
			);

		print_r(json_encode($returnData));
		die;
	}

	//ajax
	//save message
	public function replyAction()
	{

		$schoolId = $this->getCurrentSchoolId();

		$returnData = array(
			"success"	=> true,
			"data"	=> "回复成功,准备刷新"
			);

		//idtodelete
		$id = $this->getInput("idtodelete");
		if($id <= 0)
		{
			$returnData['success'] = false;
			$returnData['data'] = "不正确的标识";
			print_r(json_encode($returnData));
			die;
		}

		$reply = $this->getInput("replyMessage");

		if(empty($reply))
		{
			$returnData['success'] = false;
			$returnData['data'] = "请输入回复内容";
			print_r(json_encode($returnData));
			die;

		}

		//check 验证码是否正确
		$id = $this->_getMessageBoardDS()->reply($id,$this->loginUser->uid,$reply);


		print_r(json_encode($returnData));
		die;
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

	private function _getShopCommentDS()
    {
        return Wekit::load('EXT:4tschool.service.mercomment.App_MerComment');
    }

}