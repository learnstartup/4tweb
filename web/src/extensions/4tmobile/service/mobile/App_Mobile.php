<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_Weixin- 数据服务接口
 *
 */
class App_Mobile {

	public function is_weixin()
	{ 
		if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
			return true;
		}	
		return false;
	}	

	/**
	 * @return App_Weixin_Dao
	 */
	private function _loadDao() {
		return Wekit::loadDao('EXT:4tmobile.service.mobile.dao.App_Weixin_Dao');
	}
}

?>