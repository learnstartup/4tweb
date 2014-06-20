<?php
Wind::import('SRV:user.srv.PwRegisterService');
Wind::import('APPS:.profile.controller.BaseProfileController');
Wind::import('SRV:user.srv.PwUserProfileService');
Wind::import('SRV:user.validator.PwUserValidator');
Wind::import('LIB:utility.PwMail');
Wind::import('SRV:user.PwUserBan');
Wind::import('APPS:profile.service.PwUserProfileExtends');
Wind::import('APPS:u.service.helper.PwUserHelper');

Wind::import('EXT:4tschool.controller.T4BaseController');
/**
 */
class MyAccountController extends T4BaseController {

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

		$userInfo = Wekit::load('user.PwUser')->getUserByUid($this->loginUser->uid, PwUser::FETCH_INFO);
		$userInfo = array_merge($this->loginUser->info, $userInfo);
		list($year, $month, $day) = PwUserHelper::getBirthDay();
		$this->setOutput($year, 'years');
		$this->setOutput($month, 'months');
		$this->setOutput($day, 'days');
		$this->setOutput($userInfo, 'userinfo');

		$set = $this->getInput("set");
		$this->setOutput($set,"set");


		//set selected menu
		$this->setOutput('编辑个人档案','selectedMenu');	
		$this->setOutput('个人资料管理','subtitle');
		$this->setOutput($schoolId,'schoolId');
	}

	public function getNoCommentSum($schoolId, $userid)
	{
		$countNoComment = $this->_getShopCommentDS()->getCountOfMyUnComment($schoolId, $userid);
        $this->setOutput($countNoComment,"countNoComment");
	}

	public function securityCenterAction() 
	{
		$schoolId = $this->getCurrentSchoolId();
		$userid = $this->loginUser->uid;
		$this->getNoCommentSum($schoolId, $userid);

		$myMenus =  $this->_getMyOrderDS()->getMyMenus($schoolId,$userid);
		$this->setOutput($myMenus,'myMenus');

		$userInfo = $this->loginUser;
		$email =  $userInfo->info['email'];

		//check if email is verified or not
		$this->setOutput($email,'email');
		$existsEmail = $this->_getSecurityDS()->checkIfEmailVerified($this->loginUser->uid,$userInfo->info['email']);
		$this->setOutput($existsEmail,'emailVerified');

		//get mobile
		$mobile = $this->_getUserMobileDS()->getByUid($this->loginUser->uid);
		$this->setOutput($mobile,"mobile");
		
		//check if mobile is verified or not
		$existsMobile = !empty($mobile);
		$this->setOutput($existsMobile,'mobileVerified');


		$totalScore = ($existsMobile?20:0) + ($existsEmail?20:0) + 60;
		$this->setOutput($totalScore,'totalScore');


		//set selected menu
		$this->setOutput('安全中心','selectedMenu');	
		$this->setOutput('安全中心','subtitle');
		$this->setOutput($schoolId,'schoolId');
	}

	public function verifyMobileAction()
	{
		$schoolId = $this->getCurrentSchoolId();
		$userid = $this->loginUser->uid;

		$myMenus =  $this->_getMyOrderDS()->getMyMenus($schoolId,$userid);
		$this->setOutput($myMenus,'myMenus');

		//set selected menu
		$this->setOutput('安全中心','selectedMenu');	
		$this->setOutput('安全中心','subtitle');
	}

	public function resetPWDAction()
	{
		$schoolId = $this->getCurrentSchoolId();
		$userid = $this->loginUser->uid;

		$myMenus =  $this->_getMyOrderDS()->getMyMenus($schoolId,$userid);
		$this->setOutput($myMenus,'myMenus');

		$resource = Wind::getComponent('i18n');
		list($_pwdMsg, $_pwdArgs) = PwUserValidator::buildPwdShowMsg();
		$this->setOutput($resource->getMessage($_pwdMsg, $_pwdArgs), 'pwdReg');

		//set selected menu
		$this->setOutput('安全中心','selectedMenu');	
		$this->setOutput('安全中心','subtitle');
	}

	public function resetEmailAction()
	{
		$schoolId = $this->getCurrentSchoolId();
		$userid = $this->loginUser->uid;

		//check if has email
		$email = $this->getInput("email");
		if(empty($email))
		{
			$this->setOutput(true,"noEmail");
			$this->forwardRedirect(WindUrlHelper::createUrl('app/4tschool/myaccount/run',array('set' => 'email')));
		}
		$this->setOutput($email,"email");

		//check if email belongs to login user
		if($this->loginUser->info['email'] != $email)
		{
			//这不是您的邮箱帐号
			$this->setOutput(true,"NotMyEmail");
		}

		$emailVerified = $this->_getSecurityDS()->checkIfEmailVerified($this->loginUser->uid,$userInfo->info['email']);
		$this->setOutput($emailVerified,'emailVerified');

		if($emailVerified)
		{

		}


		$myMenus =  $this->_getMyOrderDS()->getMyMenus($schoolId,$userid);
		$this->setOutput($myMenus,'myMenus');

		//set selected menu
		$this->setOutput('安全中心','selectedMenu');	
		$this->setOutput('安全中心','subtitle');
	}

	//ajax send email verification
	public function sendEmailValidationAction()
	{

		//send validation email
		$registerService = new PwRegisterService();
		$info = $this->loginUser->info;
		if (false == $registerService->checkIfActiveEmailSend($info['uid'], $info['email'])) {
			$this->sendEmailActive($info['username'], $info['email'], $statu, $info['uid']);
		}
		else
			$this->sendEmailActive($info['username'], $info['email']);

		$returnData = array(
			"success"	=> true,
			"data"	=> 更新成功
			);

		print_r(json_encode($returnData));
		die;

	}



	public function payPWDAction()
	{
		$schoolId = $this->getCurrentSchoolId();
		$userid = $this->loginUser->uid;

		$myMenus =  $this->_getMyOrderDS()->getMyMenus($schoolId,$userid);
		$this->setOutput($myMenus,'myMenus');

		//set selected menu
		$this->setOutput('安全中心','selectedMenu');	
		$this->setOutput('安全中心','subtitle');
	}



	public function orderAddressAction()
	{
		
		$schoolId = $this->getCurrentSchoolId();
		$userid = $this->loginUser->uid;
		$this->getNoCommentSum($schoolId, $userid);

		$myMenus =  $this->_getMyOrderDS()->getMyMenus($schoolId,$userid);
		$this->setOutput($myMenus,'myMenus');

		$orderAddressList = $this->_getMyOrderAddressDS()->getOrderAddress($userid);
		$this->setOutput($orderAddressList,'orderAddressList');

		$this->setOutput(count($orderAddressList),"totalCount");

		$editId = $this->getInput("editid");
		$this->setOutput($editId,"editId");

		if($editId > 0)
		{
			$addressDetail = $this->_getMyOrderAddressDS()->getOrderAddressbyId($editId);

			$this->setOutput($addressDetail,"addressDetail");
		}

		$this->setOutput('送餐地址','selectedMenu');	
		$this->setOutput('管理收货人及地址','subtitle');
		$this->setOutput($schoolId,'schoolId');
	}

	public function myMoneyAction()
	{
		$schoolId = $this->getCurrentSchoolId();
		$userid = $this->loginUser->uid;

		$myMoney = $this->_getMyMoneyDS()->getMyMoney($userid);
		$this->setOutput($myMoney,"myMoney");

		$page = $this->getInput('page');
		//note that it need to retrive out all orders instead of only userself.
		$count = $this->_getMyMoneyDS()->countMyMoneyHistory($userid); 

		if (0 < $count) 
		{
			$totalPage = ceil($count/$this->pageNumber);
			$page > $totalPage && $page = $totalPage;
			list($start, $limit) = Pw::page2limit($page, $this->pageNumber);

			if($page <= 0)
				$page =1;
		}

		//filter by date range and status
		//note that it need to retrive out all orders instead of only userself.
		$moneyHistory = $this->_getMyMoneyDS()->getMyMoneyHistory($userid,$limit,$start);


		$this->setOutput($moneyHistory,'moneyHistory');
		$this->setOutput($count, 'count');	
		$this->setOutput($page, 'page');
		$this->setOutput($this->pageNumber, 'perPage');	

		
		$myMenus =  $this->_getMyOrderDS()->getMyMenus($schoolId,$userid);
		$this->setOutput($myMenus,'myMenus');
		$this->setOutput('零钱包(点币)','selectedMenu');
	}

	public function myCreditAction()
	{
		$schoolId = $this->getCurrentSchoolId();
		$userid = $this->loginUser->uid;
		$this->getNoCommentSum($schoolId, $userid);

		$myCredit = $this->_getMyMoneyDS()->getMyMoney($userid);
		$this->setOutput($myCredit,"myCredit");

		$page = $this->getInput('page');
		//note that it need to retrive out all orders instead of only userself.
		$count = $this->_getMyMoneyDS()->countMyCreditHistory($userid); 

		if (0 < $count) 
		{
			$totalPage = ceil($count/$this->pageNumber);
			$page > $totalPage && $page = $totalPage;
			list($start, $limit) = Pw::page2limit($page, $this->pageNumber);

			if($page <= 0)
				$page =1;
		}

		//filter by date range and status
		//note that it need to retrive out all orders instead of only userself.
		$creditHistory = $this->_getMyMoneyDS()->getMyCreditHistory($userid,$limit,$start);


		$this->setOutput($creditHistory,'creditHistory');
		$this->setOutput($count, 'count');	
		$this->setOutput($page, 'page');
		$this->setOutput($this->pageNumber, 'perPage');	

		
		$myMenus =  $this->_getMyOrderDS()->getMyMenus($schoolId,$userid);
		$this->setOutput($myMenus,'myMenus');
		$this->setOutput('我的积分','selectedMenu');
		$this->setOutput($schoolId,'schoolId');


	}

	public function checkPwdStrongAction()
	{
		$returnData = array(
			"success"	=> true,
			"data"	=> "符合要求"
			);

		$pwd = $this->getInput('pwd', 'post');
		$rank = PwUserHelper::checkPwdStrong($pwd);
		$message = "";
		switch($rank)
		{
			case 1:
				$message = "非常弱";
				break;
			case 2:
				$message = "弱";
				break;
			case 3:
				$message = "中";
				break;
			case 4:
				$message = "强";
				break;
		}

		$result = "<span class='pwd_strength_".$rank."'".">".$message."</span>".$message;
		$returnData['data'] = $result;

		print_r(json_encode($returnData));
		die;

	}

	/**
	 * 密码校验,ajax action
	 */
	public function checkpwdAction() {

		$returnData = array(
			"success"	=> true,
			"data"	=> "更新成功"
			);

		$pwd = $this->getInput('pwd', 'post');
		$result = PwUserValidator::isPwdValid($pwd, $this->loginUser->username);
		if ($result instanceof PwError) 
		{
			$resource = Wind::getComponent('i18n');
			list($_pwdMsg, $_pwdArgs) = PwUserValidator::buildPwdShowMsg();
			$message = $resource->getMessage($_pwdMsg, $_pwdArgs);
			$returnData['success'] = false;
			$returnData['data'] = $message;

			print_r(json_encode($returnData));
			die;
		}

		$userDm = new PwUserInfoDm($this->loginUser->uid);
		$userDm->setUsername($this->loginUser->username);
		$userDm->setPassword($pwd);

		
		/* @var $userDs PwUser */
		$userDs = Wekit::load('user.PwUser');
		if (($result = $userDs->editUser($userDm, PwUser::FETCH_MAIN)) instanceof PwError) {
			$message = $result->getError();
			$returnData['success'] = false;
			$returnData['data'] = $message;

			print_r(json_encode($returnData));
			die;

		}

		$this->loginUser->reset();

		print_r(json_encode($returnData));
		die;
	}

	//ajax delete my order address
	public function deleteOrderAddressAction()
	{
		//"删除成功，页面将自动刷新"
		$id = $this->getInput("addressToDelete");

		$returnData = array(
			"success"	=> true,
			"data"	=> "删除成功，页面将自动刷新"
			);

		$this->_getMyOrderAddressDS()->deleteOrderAddress($id);

		print_r(json_encode($returnData));
		die;
	}

	//ajax update order address
	public function updateOrderAddressAction()
	{
		$userid = $this->loginUser->uid;
		$id = $this->getInput("editid");
		$txt_ship_man = $this->getInput("txt_ship_man");
		$txt_addr_detail = $this->getInput("txt_addr_detail");
		$txt_ship_tel = $this->getInput("txt_ship_tel");



		$returnData = array(
			"success"	=> true,
			"duplicate" => false,
			"data"	=> "更新成功, 页面将刷新"
			);

		$result =$this->_getMyOrderAddressDS()->addorUpdateOrderAddress($id,$userid,$txt_ship_man,$txt_addr_detail,$txt_ship_tel);
		if($result == -1)
		{
			//重复数据
			$returnData['success'] = false;
			$returnData['duplicate'] = true;
			$returnData['data'] = "数据已经存在";
		}
		else if($result > 0)
		{
			//插入或者更新成功
			$returnData['success'] = true;
			$returnData['duplicate'] = false;
			$returnData['data'] = "更新成功, 页面将刷新";
		}
		else if($id < 0 && $result <= 0)
		{
			//插入或者更新失败
			$returnData['success'] = false;
			$returnData['duplicate'] = false;
			$returnData['data'] = "数据处理失败,请重试";
		}

		print_r(json_encode($returnData));
		die;
	}

	//ajax update my information
	public function updateMyInfoAction()
	{
		$userid = $this->loginUser->uid;
		$txt_real_name = $this->getInput("Txt_petname");
		$rd_sex = $this->getInput("Rd_sex_1");
		$txt_blog = trim($this->getInput("Txt_blog"));
		$txt_introduce = trim($this->getInput("Txt_introduce"));//Txt_introduce
		$txt_qq = $this->getInput("Txt_qq");//Txt_qq
		$txt_alipay = $this->getInput("Txt_alipay");//Txt_alipay
		$byear = $this->getInput("byear");
		$bmonth = $this->getInput("bmonth");
		$bday = $this->getInput("bday");
		$email = trim($this->getInput('Txt_email', 'post'));

		$userDm = new PwUserInfoDm($this->loginUser->uid);

		$userDm->setRealname($txt_real_name);
		$userDm->setByear($byear);
		$userDm->setBmonth($bmonth);
		$userDm->setBday($bday);
		$userDm->setGender($rd_sex);
		$userDm->setHomepage($txt_blog);
		$userDm->setProfile($txt_introduce);
		$userDm->setAliww($txt_alipay);
		$userDm->setQq($txt_qq);
		$userDm->setEmail($email);


		$returnData = array(
			"success"	=> true,
			"data"	=> "更新成功"
			);

		if ($email) {
			$r = PwUserValidator::isEmailValid($email, $this->loginUser->username);
			if ($r instanceof PwError)
			{
				$code = $r->getError();
				$message = "邮箱地址已经被占用, 请使用另外一个地址";
				if($code == 'USER:user.error.-7')
				{
					$message = "请输入有效的邮箱地址";
				}

				$returnData['success'] = false;
				$returnData['data']	= $message;
				print_r(json_encode($returnData));
				die;
			} 
		}

		//更新成功, 页面将刷新
		$userDs = Wekit::load('user.PwUser');
		$result = $userDs->editUser($userDm, PwUser::FETCH_MAIN + PwUser::FETCH_INFO);
		if ($result instanceof PwError) {
			$code = $result->getError();

			if($code == "USER:error.profile.length")
			{
				$message = "您最多输入250个字的自我描述";
			}
			else if($code == "USER:error.homepage")
			{
				$message = "博客地址不正确，需要以http开头";
			}
			else
				$message = "信息填写不完全".$code;


			$returnData['success'] = false;
			$returnData['data'] = $message;// "请设置正确的博客链接";
			print_r(json_encode($returnData));
			die;
		}

		print_r(json_encode($returnData));
		die;	
	}

	/*
	* send mobile message
	*/
	public function sendMobileMessageAction()
	{
		//get mobile
		$mobile = $this->getInput("change_mobile_txt");
		$returnData = array(
			"success"	=> true,
			"data"	=> "更新成功"
			);

		$result = Wekit::load('SRV:mobile.srv.PwMobileService')->sendMobileMessage($mobile);

		if ( $result == false) {
			
			$returnData = array(
			"success"	=> false,
			"data"	=> "发送验证码失败,请重试"
			);
		}

		print_r(json_encode($returnData));
		die;

	}

	/*
	* ajax action
	* when user input message code from mobile, then verify
	*/
	public function verifyMobileCodeAction()
	{
		//get mobile
		$mobile = $this->getInput("change_mobile_txt");

		//sms_verify_code
		$mobileCode = $this->getInput("sms_verify_code");

		$returnData = array(
			"success"	=> true,
			"data"	=> "更新成功"
			);

		$mobileCheck = Wekit::load('mobile.srv.PwMobileService')->checkVerify($mobile, $mobileCode);
		if($mobileCheck instanceof PwError)
		{
			$returnData['data'] = "验证失败, 请检查或点击重新发送";
			$returnData['success'] = false;
			
		}
		else
		{
			//record the relationship between current user and its mobile
			$pwUserMobile = Wekit::load('user.PwUserMobile');
    		$pwUserMobile->replaceMobile($this->loginUser->uid,$mobile);

			$returnData['data'] = "验证成功";
			$returnData['success'] = true;
		}

		print_r(json_encode($returnData));
		die;
	}

	//ajax action
	//set address as default
	public function setasDefaultAddressAction()
	{
		$id = $this->getInput("addressToDelete");

		$returnData = array(
			"success"	=> true,
			"data"	=> "更新成功"
			);

		if($id <=0)
		{
			$returnData['data'] = "数据验证失败,请联系管理员";
			$returnData['success'] = false;

			print_r(json_encode($returnData));die;
		}

		$userid = $this->loginUser->uid;

		$affectedRows = $this->_getMyOrderAddressDS()->setasDefaultAddress($userid,$id);
		if($affectedRows <= 0)
		{
			$returnData['data'] = "数据验证失败,请联系管理员";
			$returnData['success'] = false;
		}

		print_r(json_encode($returnData));die;

	}


	private function sendEmailActive($username,$email, $statu = '', $uid) {
	
		$code = substr(md5(Pw::getTime()), mt_rand(1, 8), 8);
		$url = WindUrlHelper::createUrl('app/4tschool/emailvalidation/run', array('code' => $code, '_statu' => $statu));
		list($title, $content) = $this->_buildTitleAndContent('active.mail.title', 'active.mail.content', $username, $url);
		/* @var $activeCodeDs PwUserActiveCode */
		$activeCodeDs = Wekit::load('user.PwUserActiveCode');
		$activeCodeDs->addActiveCode($uid, $email, $code, Pw::getTime());
		$mail = new PwMail();
		$mail->sendMail($email, $title, $content);
		return true;
	}


	private function _buildTitleAndContent($titleKey, $contentKey, $username, $url = '') {
		$config = Wekit::C('register');

		$search = array('{username}', '{sitename}');
		$replace = array($username, Wekit::C('site', 'info.name'));
		$title = str_replace($search, $replace, $config[$titleKey]);
		$search[] = '{time}';
		$search[] = '{url}';
		$replace[] = Pw::time2str(Pw::getTime(), 'Y-m-d H:i:s');
		$replace[] = $url ? sprintf('<a href="%s">%s</a>', $url, $url) : '';
		$content = str_replace($search, $replace, $config[$contentKey]);
		return array($title, $content);
	}


    /**
     * @return App_MyOrder
     */
	private function _getMyOrderDS()
	{
		return Wekit::load('EXT:4tschool.service.myorder.App_MyOrder');
	}

    /**
     * @return App_MyFavorite
     */
	private function _getMyFavoriteDS()
	{
		return Wekit::load('EXT:4tschool.service.myfavorite.App_MyFavorite');
	}

    /**
     * @return App_MyMoney
     */
	private function _getMyMoneyDS()
	{
		return Wekit::load('EXT:4tschool.service.mymoney.App_MyMoney');
	}

    /**
     * @return App_OrderAddress
     */
	private function _getMyOrderAddressDS()
	{
		return Wekit::load('EXT:4tschool.service.orderaddress.App_OrderAddress');
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
     * @return App_School
     */
	private function _getSchoolDS()
	{
		return Wekit::load('EXT:4tschool.service.school.App_School');
	}

    /**
     * @return App_SchoolPeople
     */
	private function _getSchoolPeopleDS()
	{
		return Wekit::load('EXT:4tschool.service.schoolpeople.App_SchoolPeople');
	}

    /**
     * @return App_Security
     */
	private function _getSecurityDS()
	{
		return Wekit::load('EXT:4tschool.service.security.App_Security');
	}

	private function _getShopCommentDS()
    {
        return Wekit::load('EXT:4tschool.service.mercomment.App_MerComment');
    }


}