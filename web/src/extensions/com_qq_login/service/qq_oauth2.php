<?php
function httpget($url,&$error=''){
	if(!function_exists('curl_init')){
		return file_get_contents($url);
	} else {
		static $ch;
		if(is_null($ch)){
			$ch = curl_init();
		}
		curl_setopt_array($ch,array(
			CURLOPT_URL=>$url,
			CURLOPT_TIMEOUT=>30,
			CURLOPT_RETURNTRANSFER=>true,
			CURLOPT_SSL_VERIFYPEER=>false,
			CURLOPT_SSL_VERIFYHOST=>false
		));
		$content = curl_exec($ch);
		if(!$content){
			$error = curl_error();
		}
		return $content;
	}
}
function is_utf8(){
	$teststr = '中文';
	return preg_match('/^.*$/u', $teststr) > 0;
}
function convert_encoding($str){
	if(is_utf8()){
		return $str;
	} else {
		if(function_exists("iconv")){
			return iconv('utf-8','gbk',$str);
		} else if(function_exists("mb_convert_encoding")){
			return mb_convert_encoding($str,'gbk','utf-8');
		} else {
			throw new Exception('请先安装 MBString 或 iconv 扩展!');
		}
	}
}
class qq_oauth2{
	private $appid;
	private $appkey;
	private $state;
	private $openid;
	private $oauth_url = 'https://graph.qq.com/oauth2.0/';
	private $uinfo_url = 'https://graph.qq.com/user/get_user_info'; 
	private $access_token;
	/**
	 * 初始化
	 * @param object $cfg 配置对象，具有 appid 和 secret 两个成员
	 */
	function __construct($cfg){
		if(!is_object($cfg) || !$cfg->appid || !$cfg->secret ){
			throw new Exception('You SHOULD set your QQ API KEY first!');
		} else {
			$this->appid = $cfg->appid;
			$this->appkey = $cfg->secret;
		}
	}
	/**
	 * redirect to get auth code
	 */
	function get_auth_code(){
		!session_id() && session_start();
		$_SESSION['qq_oauth_state'] = $state = md5(uniqid(rand(), TRUE));  //protected from CSFR
		$url = $this->oauth_url.'authorize?response_type=code&client_id='.$this->appid.'&state='.$state.'&redirect_uri='.$this->get_current_url();
		header('Location: '.$url);
		exit;
	}
	function generate_state($cfg){
		return md5($this->appid.$this->appkey.$this->state);
	}
	/**
	 * 获取当前QQ用户的信息
	 * @return array 
	 */
	function get_user_info(){
		$uinfo_url = $this->uinfo_url.'?access_token='.$this->access_token.'&oauth_consumer_key='.$this->appid.'&openid='.$this->openid;
		$user_info = httpget($uinfo_url,$error);
		$user_info = json_decode($user_info,TRUE);
		if(empty($user_info) || $user_info['ret']!=0){
			throw new Exception('Can not get user info.'.$error);
		} 
		 //patch for gbk
		$user_info['nickname'] = convert_encoding($user_info['nickname']);
		$user_info['gender'] = convert_encoding($user_info['gender']);
		!session_id() && session_start();
		$_SESSION['qq_oauth_figureurl_2'] = $user_info['figureurl_2'];
		return $user_info;
	}
	/**
	 * 将QQ用户绑定到指定的uid
	 * @param int $uid
	 */
	function bind_user($uid){
		if(empty($this->openid)){
			throw new exception('openid is empty');
		} else {
			$dao = $this->_getInfo();
			$info = $this->get_user_info();
			$dao->add($uid,$this->access_token, $info['nickname'], $info['figureurl_2'], $info['gender'], $info['vip'], $info['level'], $info['is_yellow_year_vip'],$this->openid);
			
		}
	}
	/**
	 * 根据authorized code 获取绑定的uid，如果用户未绑定，则返回 0
	 * @param string $code
	 * @return int $uid
	 */
	function get_uid($code){
		$access_token = $this->get_access_token($code);
		if($content = httpget($this->oauth_url.'me?access_token='.$access_token,$error)){
			if(preg_match('/,"openid":"([a-zA-Z0-9]+)"}/', $content,$result)){
				$this->openid = $result[1];
			} else {
				throw new exception('can not get openid.'.$content.':'.$error);
			}
			$data = $this->_getInfo();
			$fields = $data->getOne($this->openid);
			!session_id() && session_start();
			$_SESSION['qq_oauth_openid'] = $this->openid;
			$_SESSION['qq_oauth_access_token'] = $access_token;
			if(!empty($fields)){
				return $fields['uid'];
			} else {
				return 0;
			}
		} else {
			throw new Exception('Can not connect to tencent server.'.$error);
		}
	}
	/**
	 * 根据 authorized code 换取 access token
	 * @param string $code authorized code
	 * @return string $access_token
	 */
	function get_access_token($code){
		!session_id() && session_start();
		if($_REQUEST['state'] != $_SESSION['qq_oauth_state']){ //protected from CSFR
			throw new Exception('state not match!');
		}
		$url = $this->oauth_url.'token?grant_type=authorization_code&client_id='.$this->appid.'&client_secret='.$this->appkey.'&code='.$code.'&redirect_uri='.$this->get_current_url();
		if($content = httpget($url,$error)){
			parse_str($content);
			$this->access_token = $access_token;
			if(empty($access_token)){
				throw new Exception('Can not get access token'.$content);
			}
			return $access_token;
		} else {
			throw new Exception('Can not connect to tencent server.'.$error);
		}
	}
	/**
	 * 获取urlencode过的当前URL，用于跳转回来
	 * @return string $url
	 */
	function get_current_url(){
		$url = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 'https://' : 'http://';
		$url .= $_SERVER['HTTP_HOST'];
		if($_SERVER['SERVER_PORT']!=80){
			$url .= ':'.$_SERVER['SERVER_PORT'];
		}
		$url .= $_SERVER['REQUEST_URI'];
		return urlencode($url);
	}
	/**
	 * 在 PHPWind 中注册用户、绑定用户的QQ、并返回新的Uid
	 * @param string $mail
	 * @param string $nick
	 * @param &$error 传引用，如果不为空则发生了错误
	 * @return int uid
	 */
	function register_user($mobile,$mobilecode,&$error=false){
		!session_id() && session_start();
		if(empty($_SESSION['qq_oauth_openid']) || empty($_SESSION['qq_oauth_access_token']) || empty($_SESSION['qq_oauth_figureurl_2'])){
			$error = '会话丢失，请重新绑定。';
			return;
		} else {				
			$this->openid = $_SESSION['qq_oauth_openid'];
			$this->access_token = $_SESSION['qq_oauth_access_token'];
		}
		
		Wind::import('SRV:user.srv.PwRegisterService');
		Wind::import('APPS:u.service.helper.PwUserHelper');
		Wind::import('SRV:user.validator.PwUserValidator');
		Wind::import('Wind:utility.WindValidator');
		
		
		$registerService = new PwRegisterService();
		$UserDM = $this->_UserDM($mobile,$mobilecode);
		$registerService->setUserDm($UserDM);
		if (($info = $registerService->register()) instanceof PwError) {
			$error = $info->getError(false);
		}  else {
			if(!empty($_SESSION['qq_oauth_figureurl_2'])){
				$this->restore_avatar($info['uid'],$_SESSION['qq_oauth_figureurl_2']);
			}
			return $info['uid'];
		}
	}

	/**
	 * 在 PHPWind 中注册用户、绑定用户的QQ、并返回新的Uid
	 * @param string $mail
	 * @param string $nick
	 * @param &$error 传引用，如果不为空则发生了错误
	 * @return int uid
	 */
	function register_username($nickname,&$error=false){
		!session_id() && session_start();
		if(empty($_SESSION['qq_oauth_openid']) || empty($_SESSION['qq_oauth_access_token']) || empty($_SESSION['qq_oauth_figureurl_2'])){
			$error = '会话丢失，请重新绑定。';
			return;
		} else {				
			$this->openid = $_SESSION['qq_oauth_openid'];
			$this->access_token = $_SESSION['qq_oauth_access_token'];
		}
		
		Wind::import('SRV:user.srv.PwRegisterService');
		Wind::import('APPS:u.service.helper.PwUserHelper');
		Wind::import('SRV:user.validator.PwUserValidator');
		Wind::import('Wind:utility.WindValidator');
		
		
		$registerService = new PwRegisterService();
		$UserDM = $this->_UserDMUserName($nickname);
		$registerService->setUserDm($UserDM);
		if (($info = $registerService->register()) instanceof PwError) {
			$error = $info->getError(false);
		}  else {
			if(!empty($_SESSION['qq_oauth_figureurl_2'])){
				$this->restore_avatar($info['uid'],$_SESSION['qq_oauth_figureurl_2']);
			}
			return $info['uid'];
		}
	}

	/**
	 * 生成UserDM对象
	 * @param string $mail
	 * @param string $nick
	 * @return object UserDM
	 */
	function _UserDM($mobile,$mobilecode){
		Wind::import('SRC:service.user.dm.PwUserInfoDm');
		$userDm = new PwUserInfoDm();
		$password = substr(md5(rand().$mobile),0,15);
		$userDm->setUsername($mobile);
		$userDm->setMobile($mobile);
		$userDm->setPassword($password);
		$userDm->setRegdate(Pw::getTime());
		$userDm->setLastvisit(Pw::getTime());
		$userDm->setRegip(Wekit::app()->clientIp);
		return $userDm;
	}

	/**
	 * 生成UserDM对象
	 * @param string $mail
	 * @param string $nick
	 * @return object UserDM
	 */
	function _UserDMUserName($nickname){
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

	/**
	 * 初始化用户头像
	 * @param int $uid
	 * @param string $url 腾讯头像地址
	 */
	function restore_avatar($uid,$url){
		$store = Wind::getComponent('storage');
		Wind::import('SRV:upload.PwUpload');
		Wind::import('LIB:image.PwImage');
		
		$fileDir = sprintf('avatar/%s/', Pw::getUserDir($uid));
		
		$_avatar = array('.jpg' => 200, '_middle.jpg' => 120, '_small.jpg' =>50);
		$file = tempnam(sys_get_temp_dir(),'avatar');
		$img = httpget($url);
		file_put_contents($file, $img);
		$img = new PwImage($file);
		$thumb = new PwImageThumb($img);
		
		foreach ($_avatar as $des => $size) {
			$toPath = $store->getAbsolutePath($uid . $des, $fileDir);
			PwUpload::createFolder(dirname($toPath));
			if($size<100){
				$thumb->setWidth($size);
				$thumb->setHeight($size);
				$thumb->setDstFile($toPath);
				$thumb->execute();				
			} else {
				copy($file,$toPath);
			}
		}
		Wind::import('SRV:upload.action.PwAvatarUpload');
		Wind::import('SRV:upload.PwUpload');
		PwSimpleHook::getInstance('update_avatar')->runDo($uid);
		
		@unlink($file);
		return true;		
	}
	/**
	 * 获取QQ OAuth Dao
	 * @return object $qq_oauth_dao
	 */
	private function _getInfo() {
		return Wekit::loadDao('SRC:extensions.com_qq_login.service.dao.qq_oauth_dao');
	}
}