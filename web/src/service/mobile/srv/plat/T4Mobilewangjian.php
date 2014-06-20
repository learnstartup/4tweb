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
class T4Mobilewangjian {
	public $platUrl = '';
	
	public function __construct() {
		
	}
	
	/**
	 * 获取剩余短信数量
	 *
	 * @return int
	 */
	public function getRestMobileMessage() {
		
		$url='http://sms.webchinese.cn/web_api/SMS/?Action=SMS_Num&Uid='.'yourname'.'&Key='.'yourkey';
		$code = $this->Get($url);
		
		return $code;
	}

	/**
	 * 发送短信
	 *
	 * @return bool
	 */
	public function sendMobileMessage($mobile, $content) {

		$url='http://utf8.sms.webchinese.cn/?Uid=yourname&Key=yourkey&smsMob='.$mobile.'&smsText='.urlencode($content);
		$code = $this->Get($url);

		return ($code > 0);
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