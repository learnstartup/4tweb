<?php
Wind::import('APPS:appcenter.service.srv.helper.PwApplicationHelper');

/**
 * 网建短信平台
 *
 * @author jinlong.panjl <jinlong.panjl@aliyun-inc.com>
 * @copyright ©2003-2103 phpwind.com
 * @license http://www.phpwind.com
 * @version $Id$
 * @package wind
 */
class T4Mobileshengda {
	public $platUrl = '';
	
	public function __construct() {
		
	}
	
	/**
	 * 获取剩余短信数量
	 *
	 * @return int
	 */
	public function getRestMobileMessage() {
		$sms_uid = 000000;
		$sms_pid = 000000;
		$sms_passwd = 'abcdefghijklmnopqrstuvwxyz';
		
		$url="http://sms.phpcms.cn/api.php?op=sms_get_info&sms_uid=$sms_uid&sms_pid=$sms_pid&sms_passwd=$sms_passwd";
		
		$code = $this->Get($url);
		$result = json_decode($code);
		if($result->msg == -1)
		{
			return 0;
		}
		else
		{
			return	$result->surplus;
		}

	}

	/**
	 * 发送短信
	 *
	 * @return bool
	 */
	public function sendMobileMessage($mobile, $content) {

		$content = mb_convert_encoding($content, 'GB2312', 'UTF-8'); 

		$sms_uid = '259725';
		$sms_pid = '3145';
		$sms_passwd = 'f7e906471bc8a6941b3660416ea69435';
		$tplid = 16; //自定义
		$url = "http://sms.phpcms.cn/api.php?op=sms_service_new&sms_uid=$sms_uid&sms_pid=$sms_pid&sms_passwd=$sms_passwd&mobile=$mobile&send_txt=".urlencode($content)."&charset=utf8&tplid=".$tplid;
		$code = $this->Get($url); //code format is like 0#9573
		
		$result = explode("#",$code);
		return ($result[0] == 0);
	}

	private function Get($url)
	{
		if(function_exists('file_get_contents'))
		{
			$file_contents = file_get_contents($url);
		}
		else
		{
			$ch = curl_init();
			$timeout = 10;
			curl_setopt ($ch, CURLOPT_URL, $url);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$file_contents = curl_exec($ch);
			curl_close($ch);
		}
		return $file_contents;
	}
}
?>