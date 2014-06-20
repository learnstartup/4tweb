<?php
Wind::import('APPS:windid.api.OpenBaseController');
Wind::import('WINDID:api.local.WindidUserApi');
Wind::import('SRV:user.srv.PwLoginService');
/**
 * windid用户接口
 * the last known user to change this file in the repository  <$LastChangedBy: gao.wanggao $>
 * @author $Author: gao.wanggao $ Foxsee@aliyun.com
 * @copyright ?2003-2103 phpwind.com
 * @license http://www.phpwind.com
 * @version $Id: UserController.php 23072 2013-01-06 02:12:11Z gao.wanggao $ 
 * @package 
 */
class UserController extends OpenBaseController {

	
	public function loginAction() {
		$username = $this->getInput('username');
		$password = $this->getInput('password');
		$type = $this->getInput('type', 'post');
		$ifcheck = (bool)$this->getInput('ifcheck', 'post');
		$question = $this->getInput('question', 'post');
		$answer = $this->getInput('answer', 'post');
		!$type && $type = 2;

		$result =array();
		$result['Success'] = 1;
		$result['ErrorMessage'] = "";
		$result['User'] = array();


		$login = new PwLoginService();
		$isSuccess = $login->login($username, $password, $this->getRequest()->getClientIp(), $question, $answer);
		if ($isSuccess instanceof PwError) {

			$error = $isSuccess->getError();

			$result['Success'] = -1;

			$message = "";

			switch ($error[0]) {
				case 'USER:login.error.pwd':
					$message = "登录失败, 密码错误";
					break;
				case 'USER:login.error.tryover.pwd':
					$message = "密码错误5次, 账户已被锁";
					break;
				default:
					$message = "登录失败,请检查用户名或密码";
					break;
			}
			$result['ErrorMessage'] = $message;
			$result['ErrorCode'] = $error[0];

			$result['User'] = null;

			return $this->output($result);
			
		}
		else
		{

			$uid = $isSuccess['uid'];
			$result['Success'] = 1;
			$result['ErrorMessage'] = "";


			$result['User'] = $this->getUserInfo($uid);
			$this->output($result);
		}
	}

	public function weiXinLoginAction() {
		
		$username = $this->getInput('username');
		$password = $this->getInput('password');
		$type = $this->getInput('type', 'post');
		$question = $this->getInput('question', 'post');
		$answer = $this->getInput('answer', 'post');
		!$type && $type = 2;

		$result =array();
		$result['Success'] = 1;
		$result['ErrorMessage'] = "";
		$result['User'] = array();


		$login = new PwLoginService();
		$isSuccess = $login->login($username, $password, $this->getRequest()->getClientIp(), $question, $answer);
		if ($isSuccess instanceof PwError) {

			$error = $isSuccess->getError();

			$result['Success'] = -1;

			$message = "";

			switch ($error[0]) {
				case 'USER:login.error.pwd':
					$message = "登录失败, 密码错误";
					break;
				case 'USER:login.error.tryover.pwd':
					$message = "密码错误5次, 账户已被锁";
					break;
				default:
					$message = "登录失败,请检查用户名或密码";
					break;
			}
			$result['ErrorMessage'] = $message;
			$result['ErrorCode'] = $error[0];

			$result['User'] = null;

			return $this->output($result);
			
		}
		else
		{

			$uid = $isSuccess['uid'];
			$result['Success'] = 1;
			$result['ErrorMessage'] = "";


			$result['User'] = $this->getUserInfo($uid);
			$this->output($result);
		}
	}

	/*
	*	
	*
	*/
	public function shopLoginAction()
	{
		$username = $this->getInput('username');
		$password = $this->getInput('password');
		$schoolid = $this->getInput("schoolid");
		$baiduuserid = $this->getInput("baidu_userid");
		$baiduchannelid = $this->getInput("baidu_channelid");

		//1st, check user name and password
		$result =array();
		$result['Success'] = 1;
		$result['ErrorMessage'] = "";
		$result['User'] = array();


		$login = new PwLoginService();
		$isSuccess = $login->login($username, $password, $this->getRequest()->getClientIp(), $question, $answer);
		if ($isSuccess instanceof PwError) {

			$error = $isSuccess->getError();

			$result['Success'] = -1;

			$message = "";

			switch ($error[0]) {
				case 'USER:login.error.pwd':
					$message = "登录失败, 密码错误";
					break;
				case 'USER:login.error.tryover.pwd':
					$message = "密码错误5次, 账户已被锁";
					break;
				default:
					$message = "登录失败,请检查用户名或密码";
					break;
			}
			$result['ErrorMessage'] = $message;
			$result['ErrorCode'] = $error[0];

			$result['User'] = null;
			$result['ShopId'] = null;

			return $this->output($result);
			
		}
		else
		{
			//check if it is school's shop account
			$uid = $isSuccess['uid'];
			$exists = $this->_getSchoolPeopleDS()->checkIfAccount($uid,"shopaccount");

			if($exists == false)
			{
				$result['Success'] = -1;
				$message = "此帐号非商家帐号";
				$result['ErrorMessage'] = $message;
				$result['User'] = null;
				$result['ShopId'] = null;
				return $this->output($result);
			}
			
			//check if relates to shop
			$shopid = $this->_getShopDs()->getOneShopIdbyUid($uid);

			$baiduUserChannelArr = array('shopid' => $shopid['id'],
    								     'baiduuserid' => $baiduuserid,
    								 	 'channelid' => $baiduchannelid);
			
	    	$ifexist = $this->_getBaiduuserchannelDs()->baiduchannelifexist($baiduUserChannelArr);
	    	
	    	if($ifexist == false)
	    	{
	    		$this->_getBaiduuserchannelDs()->addBaiduuserChannelMsg($baiduUserChannelArr);
	    	}

			if(empty($shopid))
			{
				$result['Success'] = -1;
				$message = "未绑定商家";
				$result['ErrorMessage'] = $message;
				$result['User'] = null;
				$result['ShopId'] = null;
				return $this->output($result);
			}


			$result['Success'] = 1;
			$result['ErrorMessage'] = "";
			$result['ShopId'] = $shopid['id'];
			$result['User'] = $this->getUserInfo($uid);
			$this->output($result);
		}
	}
	
	public function getAction() {
		$userid = $this->getInput('userid', 'get');
		$type = $this->getInput('type', 'get');
		!$type && $type = 1;
		$result = $this->getApi()->getUser($userid, $type);
		$this->output($result);
	}

	public function getInfoAction() {
		$userid = $this->getInput('userid', 'get');
		$type = $this->getInput('type', 'get');
		!$type && $type = 1;
		$result = $this->getApi()->getUserInfo($userid, $type);
		$this->output($result);
	}
	
	/**
	 * 批量获取用户信息
	 */
	public function fecthInfoAction() {
		$uids = explode('_',$this->getInput('uids', 'get'));
		$type = $this->getInput('type', 'get');
		!$type && $type = 1;
		$result = $this->getApi()->getUserInfo($uids, $type);
		$this->output($result);
	}

	/*
	*  return registration mobile activation setting
	*/
	public function getMobileActivationSettingAction()
	{
		$intervals = 180; //in s
		$timesPerDay = 6;

		$result['intervals'] = $intervals;
		$result['timesPerDay'] = $timesPerDay;

		$this->output($result);
	}

	/*
	* send mobile activation message
	*/
	public function sendActivationMessageAction()
	{
		$mobile = $this->getInput("mobile");

		$pwmobileService = Wekit::load('mobile.srv.PwMobileService');
  		$result = $pwmobileService->sendMobileMessage($mobile);

  		if ($result instanceof PwError) {
			$this->output(false);
		}else
			$this->output(true);

		return;
	}

	/*
	* check if user name duplicated
	*/
	public function checkUserNameAction()
	{
		Wind::import('SRV:user.srv.PwUserValidator');

		//check if user name duplicated
		$checkResult = PwUserValidator::isUsernameValid($username);
		if($checkResult instanceof PwError) {
			$error = $checkResult->getError(false);
			if($error == 'USER:user.error.-5' || $error == 'USER:user.error.-4')
			{
				$result['Success'] = 0;
				$result['ErrorMessage'] = '用户已存在,请重新注册';
				$this->output($result);
			}
		}
		else
		{
			$result['Success'] = 1;
			$result['ErrorMessage'] = '';
			$this->output($result);
		}
	}

	/*
	*	check mobile activation code
	*/
	public function checkMobileActivationCodeAction()
	{
		$mobile = $this->getInput("mobile");
		$code = $this->getInput("code");

		$pwmobileService = Wekit::load('mobile.srv.PwMobileService');
  		$result = $pwmobileService->checkVerify($mobile,$code);

  		if ($result instanceof PwError) {
			$this->output(false);
		}else
			$this->output(true);

		return;

	}

	public function checkMobileUniqueAction()
	{
		$mobile = $this->getInput('mobile'); 

		$checkResult = $this->_checkMobileRight($mobile);

		if($checkResult  instanceof PwError) {

			$result['Success'] = 0;
			$result['ErrorMessage'] = '手机号已存在,请使用找回密码功能';

		}
		else
		{
			$result['Success'] = 1;
			$result['ErrorMessage'] = '';
		}

		$this->output($result);

	}


	/*
	*	check mobile code, password
	*/
	public function registerUserAction()
	{
		$result = array(
                         "Success" => 0,
                         "ErrorMessage" => ""

                );

		$mobile = $this->getInput("mobile");
		$code = $this->getInput("code");
		$password = $this->getInput("password");
		$username = $this->getInput("username");

		//register user
		Wind::import('SRV:user.srv.PwRegisterService');
		Wind::import('APPS:u.service.helper.PwUserHelper');
		Wind::import('SRV:user.validator.PwUserValidator');
		Wind::import('Wind:utility.WindValidator');
		
		
		//check if user name duplicated
		$checkResult = PwUserValidator::isUsernameValid($username);
		if($checkResult instanceof PwError) {
			$error = $checkResult->getError(false);
			if($error == 'USER:user.error.-5' || $error == 'USER:user.error.-4' ||  $error == 'WINDID:code.-5')
			{
				$result['Success'] = 0;
				$result['ErrorMessage'] = '用户已存在,请重新注册';
				$this->output($result);
			}
		}

		$pwmobileService = Wekit::load('mobile.srv.PwMobileService');
  		$checkResult = $pwmobileService->checkVerify($mobile,$code);

  		if ($checkResult instanceof PwError) {
			$result['Success'] = 0;
			$result['ErrorMessage'] = '手机验证码错误或已过期,请重新输入';
			$this->output($result);
		}

		
		$registerService = new PwRegisterService();
		$UserDM = $this->_UserDM($mobile,$password,$username);
		$registerService->setUserDm($UserDM);
		if (($info = $registerService->register()) instanceof PwError) {
			$result['Success'] = 0;
			$result['ErrorMessage'] = '注册错误,请联系管理员';
			$this->output($result);
		}else {
			
			$uid = $info['uid'];
			$pwUserMobile = Wekit::load('user.PwUserMobile');
   			$pwUserMobile->replaceMobile($uid,$mobile);


   			$result['Success'] = 1;
			$result['ErrorMessage'] = '';
			$result['User'] = $this->getUserInfo($uid);

			$this->output($result);

		}
	}

	public function weixinRegisterUserAction()
	{
		$result = array(
                         "Success" => 0,
                         "ErrorMessage" => ""

                );

		$mobile = $this->getInput("mobile");
		//$code = $this->getInput("code");
		$password = $this->getInput("password");
		$username = $this->getInput("username");

		//register user
		Wind::import('SRV:user.srv.PwRegisterService');
		Wind::import('APPS:u.service.helper.PwUserHelper');
		Wind::import('SRV:user.validator.PwUserValidator');
		Wind::import('Wind:utility.WindValidator');
		
		
		//check if user name duplicated
		$checkResult = PwUserValidator::isUsernameValid($username);
		if($checkResult instanceof PwError) {
			$error = $checkResult->getError(false);
			if($error == 'USER:user.error.-5' || $error == 'USER:user.error.-4')
			{
				$result['Success'] = 0;
				$result['ErrorMessage'] = '用户已存在,请重新注册';
				$this->output($result);
			}
		}
		
		$registerService = new PwRegisterService();
		$UserDM = $this->_UserDM($mobile,$password,$username);
		$registerService->setUserDm($UserDM);
		if (($info = $registerService->register()) instanceof PwError) {
			$result['Success'] = 0;
			$result['ErrorMessage'] = '注册错误,请联系管理员';
			$this->output($result);
		}else {
			
			$uid = $info['uid'];
			$pwUserMobile = Wekit::load('user.PwUserMobile');
   			$pwUserMobile->replaceMobile($uid,$mobile);


   			$result['Success'] = 1;
			$result['ErrorMessage'] = '';
			$result['User'] = $this->getUserInfo($uid);

			$this->output($result);

		}
	}

	public function resetPasswordAction()
	{
		$mobile = $this->getInput("mobile");
		$code = $this->getInput("code");
		$password = $this->getInput("password");

		$mobileInfo = Wekit::load('user.PwUserMobile')->getByMobile($mobile);
		if(empty($mobileInfo))
		{
			$result['Success'] = 0;
			$result['ErrorMessage'] = '不存在或非正常账号';
			$this->output($result);
		}
		else
		{
			$uid = $mobileInfo['uid'];
		}


		$pwmobileService = Wekit::load('mobile.srv.PwMobileService');
  		$checkResult = $pwmobileService->checkVerify($mobile,$code);

  		if ($checkResult instanceof PwError) {
			$result['Success'] = 0;
			$result['ErrorMessage'] = '手机验证码错误或已过期,请重新输入';
			$this->output($result);
		}

		//reset password
		Wind::import('SRC:service.user.dm.PwUserInfoDm');
		$userDm = new PwUserInfoDm($uid);
		$userDm->setPassword($password);

		$userDs = Wekit::load('user.PwUser');
		$checkResult = $userDs->editUser($userDm, PwUser::FETCH_MAIN);

		if ($checkResult instanceof PwError) {
			$error = $checkResult->getError();

			$result['Success'] = 0;
			$result['ErrorMessage'] = '重设密码失败';
			$this->output($result);

		} else {
			
			$result['Success'] = 1;
			$result['ErrorMessage'] = '重设密码成功';
			$this->output($result);
		}


	}

	//user by using QQ login
	public function mobileLoginAction()
	{
		//simulate data
		$test = array("openid" => "7E561C40E3443EC7A473DB7D6767419A",
						"gender" => "男",
						"avatar" => "http://qzapp.qlogo.cn/qzapp/100505782/7E561C40E3443EC7A473DB7D6767419A/100",
						"nickname" => "良品-身边",
						"access_token" => "602E4FD23B479E8832D39AB3DAE7E5A9"
						);

		$result = array(
                         "Success" => 0,
                         "ErrorMessage" => ""

                );

		//$testtr = json_encode($test);
		//$testtr = '{"openid":"7E561C40E3443EC7A473DB7D6767419A","gender":"\u7537","avatar":"","nickname":"\u826f\u54c1-\u8eab\u8fb9","access_token":"602E4FD23B479E8832D39AB3DAE7E5A9"}';
		$qqInfo = $this->getInput("qqinfo");

		//urldecode and jsondecode
		$qqInfo = urldecode($qqInfo);
		$qqInfo = json_decode($qqInfo); 
		$qqInfo= $this->class_object_to_array($qqInfo); 


		//check data empty
		if(empty($qqInfo))
		{
			$result['Success'] = 0;
			$result['ErrorMessage'] = "无效的数据";
			$this->output($result);
		}

		//1. openid
		//2. gender
		//3. avatar
		//4. nickname
		//5. access_token
		$openid = $qqInfo['openid'];
		$gender = $qqInfo['gender'];
		$avatar = $qqInfo['avatar'];
		$nickname = $qqInfo['nickname'];
		$access_token = $qqInfo['access_token'];

		if(empty($openid)
			|| empty($nickname)
			|| empty($access_token)
			)
		{
			$result['Success'] = 0;
			$result['ErrorMessage'] = "资料不全";
			$this->output($result);
		}

		//check if this openid already has user
		$qqauth = Wekit::loadDao('SRC:extensions.com_qq_login.service.dao.qq_oauth_dao');
		$fetched = $qqauth->getOne($openid);

		Wind::import('SRV:user.srv.PwRegisterService');
		Wind::import('APPS:u.service.helper.PwUserHelper');
		Wind::import('SRV:user.validator.PwUserValidator');
		Wind::import('Wind:utility.WindValidator');

		//if not registred before
		if(empty($fetched))
		{
			//register user
			//need to rand nickname
			$nickname = $nickname.substr(md5(rand().$access_token),0,6);
			$registerService = new PwRegisterService();
			$UserDM = $this->_UserDMUserName($nickname);
			$registerService->setUserDm($UserDM);
			if (($info = $registerService->register()) instanceof PwError) {
				$error = $info->getError(false);
				$result['Success'] = 0;
				$result['ErrorMessage'] = $error;
				$this->output($result);

			}  else {
				$uid = $info['uid'];
				$qqauth->add($uid,$access_token, $nickname, $avatar, $gender, 0,0, 0,$openid);

			}
		}
		else
		{
			$uid = $fetched['uid'];
		}

		$result['Success'] = 1;
		$result['ErrorMessage'] = "";
		$result['User'] = $this->getUserInfo($uid);
		$this->output($result);

	}

	/*
	* check if mobile is right
	*/
	private function _checkMobileRight($mobile) {
		$config = Wekit::C('register');
		if (!$config['active.phone']) {
			return new PwError('USER:mobile.reg.open.error');
		}
		Wind::import('SRV:user.validator.PwUserValidator');
		if (!PwUserValidator::isMobileValid($mobile)) {
			return new PwError('USER:error.mobile');
		}
		$mobileInfo = Wekit::load('user.PwUserMobile')->getByMobile($mobile);
		if ($mobileInfo) return new PwError('USER:mobile.mobile.exist');
		return true;
	}

	/**
	 * 生成UserDM对象
	 */
	private function _UserDMUserName($nickname){
		Wind::import('SRC:service.user.dm.PwUserInfoDm');
		$userDm = new PwUserInfoDm();
		$password = substr(md5(rand().'123456'),0,15);
		$userDm->setUsername($nickname);
		$userDm->setPassword($password);
		$userDm->setRegdate(Pw::getTime());
		$userDm->setLastvisit(Pw::getTime());
		$userDm->setRegip(Wekit::app()->clientIp);
		return $userDm;
	}

 	private function _UserDM($mobile,$password,$username = '')
 	{
 		Wind::import('SRC:service.user.dm.PwUserInfoDm');
		$userDm = new PwUserInfoDm();
		$userDm->setUsername(empty($username)?$mobile:$username);
		$userDm->setMobile($mobile);
		$userDm->setPassword($password);
		$userDm->setRegdate(Pw::getTime());
		$userDm->setLastvisit(Pw::getTime());
		$userDm->setRegip(Wekit::app()->clientIp);
		return $userDm;
 	}


	//通过uid 得到用户的信息
	private function getUserInfo($uid)
	{
		$result = $this->getApi()->getUserInfo($uid, 1); //1 mean use useid
		return $result;
	}
	
	
	protected function getApi() {
		return new WindidUserApi();
	}
	
	protected function getUserDs() {
		return Windid::load('user.WindidUser');
	}

	/**
     * @return App_SchoolPeople
     */
	protected function _getSchoolPeopleDS()
	{
		return Wekit::load('EXT:4tschool.service.schoolpeople.App_SchoolPeople');
	}

	/**
     * @return App_Shop
     */
    private function _getShopDs()
    {
        return Wekit::load('EXT:4tschool.service.shop.App_Shop');
    }
	
	protected function getBlackDs() {
		return Windid::load('user.WindidUserBlack');
	}
	
	private function _getNotifyClient() {
		return Windid::load('notify.srv.WindidNotifyClient');
	}

	/**
	 * @return App_Baiduuserchannel
	 */
    private function _getBaiduuserchannelDs()
    {
        return Wekit::load('EXT:4tschool.service.baidupush.App_Baiduuserchannel');
    }
	
}
?>