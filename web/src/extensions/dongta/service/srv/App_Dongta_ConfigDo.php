<?php
defined('WEKIT_VERSION') or exit(403);
/**
 * 后台菜单添加
 *
 * @author chenjm <sky_hold@163.com>
 * @copyright http://www.phpwind.net
 * @license http://www.phpwind.net
 */
class App_Dongta_ConfigDo {
	
	/**
	 * 获取动他一下后台菜单
	 *
	 * @param array $config
	 * @return array 
	 */
	public function getAdminMenu($config) {
		$config += array(
			'app_dongta' => array('动他一下', 'app/manage/*?app=dongta', '', '', 'appcenter'),
		);
		return $config;
	}
}

?>