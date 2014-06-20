<?php
/**
 * @author Qiong Wu <papa0924@gmail.com> 2010-11-2
 * @link http://www.phpwind.com
 * @copyright Copyright &copy; 2003-2010 phpwind.com
 * @license
 */

return array(
	'aliyun' => array(
		'name' => '阿里云短信平台', 
		'alias' => 'aliyun', 
		'managelink' => '',
		'description' => '欢迎使用阿里云短信平台', 
		'components' => array('path' => 'SRV:mobile.srv.plat.PwPlatAliyun')
	), 
	'wangjiansms' => array(
		'name' => '网建SMS平台', 
		'alias' => 'wangjiansms', 
		'managelink' => '',
		'description' => '使用网建SMS平台', 
		'components' => array('path' => 'SRV:mobile.srv.plat.T4Mobilewangjian')
	), 
	'shengdasms' => array(
		'name' => '盛大SMS平台', 
		'alias' => '盛大sms', 
		'managelink' => '',
		'description' => '使用盛大SMS平台', 
		'components' => array('path' => 'SRV:mobile.srv.plat.T4Mobileshengda')
	), 
);