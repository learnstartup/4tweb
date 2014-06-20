<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_Security - 数据服务接口
 *
 */
class App_Security{


	public function checkIfEmailVerified($userid,$email)
	{
		return $this->_loadDao()->checkIfEmailVerified($userid,$email);
	}

	public function checkIfMobileVerified($userid,$mobile)
	{
		return $this->_loadDao()->checkIfMobileVerified($userid,$mobile);
	}



	/**
	 * @return App_Security_Dao
	 */
	private function _loadDao() {
		return Wekit::loadDao('EXT:4tschool.service.security.dao.App_Security_Dao');
	}
}

?>