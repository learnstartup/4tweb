<?php
Wind::import('EXT:4tschool.controller.T4BaseNotLoginController');
/**
 */
class FeedbackController extends T4BaseNotLoginController {

	private $pageNumber = 10;

	public function beforeAction($handlerAdapter) {

		parent::beforeAction($handlerAdapter);

		$schoolId = $this->getCurrentSchoolId();
		if(!isset($schoolId) || $schoolId <= 0)
		{
			print_r("请选择学校");
		}

		if(empty($this->schoolExtra) == false && $this->schoolExtra['openliuyanban'] == 0)
		{
			$this->forwardRedirect(WindUrlHelper::createUrl('app/4tschool/notopen/run'));
		}	

		//SEO Information
        $SEOInfo = $this->getSEOInfo();

        
        $this->setOutput($SEOInfo['School'].'点餐反馈与建议,'.$SEOInfo['SEOTitle'],'SEOTitle');
        $this->setOutput($SEOInfo['School'].'点餐反馈与建议 '.$SEOInfo['SEOKeyword'],'SEOKeyword');
        $this->setOutput($SEOInfo['School'].'点餐反馈与建议,'.$SEOInfo['SEODescription'],'SEODescription');


		
	}

	//get all approved messages
	public function run() {

		$schoolId = $this->getCurrentSchoolId();

		$page = $this->getInput('page');
		$count = $this->_getMessageBoardDS()->countMessages($schoolId,-1,1);

		if (0 < $count) 
		{
			$totalPage = ceil($count/$this->pageNumber);
			$page > $totalPage && $page = $totalPage;
			list($start, $limit) = Pw::page2limit($page, $this->pageNumber);

			if($page <= 0)
				$page =1;
		}


		$messageList = $this->_getMessageBoardDS()->getMessages($schoolId,-1,1,$limit,$start);


		$this->setOutput($messageList,'messageList');
		$this->setOutput($count, 'count');	
		$this->setOutput($page, 'page');
		$this->setOutput($this->pageNumber, 'perPage');	
		


	}


	public function savemessageAction()
	{

		$schoolId = $this->getCurrentSchoolId();

		$returnData = array(
			"success"	=> true,
			"data"	=> "留言成功，正在审核并等待回复，谢谢"
			);

		$content = $this->getInput("content");
		$scode = $this->getInput("scode");

		if(empty($content))
		{
			$returnData['success'] = false;
			$returnData['data'] = "请输入留言内容";
			print_r(json_encode($returnData));
			die;

		}

		if(empty($scode))
		{
			$returnData['success'] = false;
			$returnData['data'] = "请输入验证码";
			print_r(json_encode($returnData));
			die;

		}

		$veryfy = Wekit::load("verify.srv.PwCheckVerifyService");
		if (false === $veryfy->checkVerify($scode))
		{
			$returnData['success'] = false;
			$returnData['data'] = "验证码输入不正确";
			print_r(json_encode($returnData));
			die;
		}


		//check 验证码是否正确
		$id = $this->_getMessageBoardDS()->insertFeedback($schoolId,$this->loginUser->uid,$content);


		print_r(json_encode($returnData));
		die;
	}


    /**
     * @return  App_MessageBoard
     */
	private function _getMessageBoardDS()
	{
		return Wekit::load('EXT:4tschool.service.messageboard.App_MessageBoard');
	}

    /**
     * @return App_SchoolArea
     */
	private function _getSchoolAreaDS()
	{
		return Wekit::load('EXT:4tschool.service.schoolarea.App_SchoolArea');
	}




}