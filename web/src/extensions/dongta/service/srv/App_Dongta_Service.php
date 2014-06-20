<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * 动他一下服务
 *
 * @author chenjm <sky_hold@163.com>
 * @copyright http://www.phpwind.net
 * @license http://www.phpwind.net
 */
class App_Dongta_Service {
	
	/**
	 * 获取动他一下后台菜单
	 *
	 * @param array $config
	 * @return array 
	 */
	public function spaceButton($space) {
		echo '<a rel="nofollow" href="' . WindUrlHelper::createUrl('app/dongta/index/act') . '" class="message J_qlogin_trigger J_dongta_act" data-uid="' . $space->spaceUser['uid'] . '"><em></em>打招呼</a>';
		echo '<script>var URL_DONGTA = \'' . WindUrlHelper::createUrl('app/dongta/index/send') . '\';Wind.ready(function(){Wind.js(\'' . Wekit::V('url')->extres . '/dongta/js/dongta.js\');});</script>';
	}
}

?>