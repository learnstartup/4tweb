<?php
defined('WEKIT_VERSION') or exit(403);
Wind::import('SRV:forum.srv.threadDisplay.do.PwThreadDisplayDoBase');

/**
 * 动他一下服务
 *
 * @author chenjm <sky_hold@163.com>
 * @copyright http://www.phpwind.net
 * @license http://www.phpwind.net
 */
class App_Dongta_ThreadDisplay extends PwThreadDisplayDoBase {
	
	public function __construct($srv) {

	}

	public function createHtmlForUserButton($user, $read) {
		echo '<a rel="nofollow" href="' . WindUrlHelper::createUrl('app/dongta/index/act') . '" class="message J_qlogin_trigger J_dongta_act" data-uid="' . $user['uid'] . '"><em></em>打招呼</a>';
	}

	public function runJs() {
		echo '<script>var URL_DONGTA = \'' . WindUrlHelper::createUrl('app/dongta/index/send') . '\';</script>';
		echo '<script src="' . Wekit::V('url')->extres . '/dongta/js/dongta.js"></script>';
	}
}

?>