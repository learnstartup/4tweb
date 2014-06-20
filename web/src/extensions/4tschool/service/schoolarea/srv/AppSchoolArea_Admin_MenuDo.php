<?php
defined('WEKIT_VERSION') or exit(403);
/**
 * 编辑器扩展
 *
 * @author yang <yangyan7777@gmail.com>
 * @copyright http://www.fenxiangyo.com
 */
class AppSchoolArea_Admin_MenuDo {
	
	/**
	 * @param array $config 后台菜单配置
	 * @return array
	 */
	public function appSchoolAreaDo($config) {
		$config += array(
			'app_schoolarea' => array('学校区域管理', 'app/manage/*?app=schoolarea', '', '', 'appcenter'),
			);
		return $config;
	}
}

?>