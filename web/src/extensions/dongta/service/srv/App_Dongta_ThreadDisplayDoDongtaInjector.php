<?php
defined('WEKIT_VERSION') || exit('Forbidden');

/**
 * 动他一下服务
 *
 * @author MingXing Sun <mingxing.sun@aliyun-inc.com>
 * @copyright ©2003-2103 phpwind.com
 * @license http://www.phpwind.com
 * @version $Id: App_Dongta_ThreadDisplayDoDongtaInjector.php 22627 2012-12-26 03:54:26Z jieyin $
 * @package forum
 */

class App_Dongta_ThreadDisplayDoDongtaInjector extends PwBaseHookInjector {
	
	public function run() {
		Wind::import('EXT:dongta.service.srv.App_Dongta_ThreadDisplay');
		return new App_Dongta_ThreadDisplay($this->bp);
	}
}