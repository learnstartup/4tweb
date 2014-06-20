<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_Weixin- 数据服务接口
 *
 */
class App_Common {

	public function weiXinLogin($environment, $username, $password)
	{
		return $this->_loadDao()->weiXinLogin($environment, $username, $password);
	}

	public function getOpenShopList($environment, $schoolId, $offset, $limit) 
	{
		return $this->_loadDao()->getOpenShopList($environment, $schoolId, $offset, $limit);
	}

	public function getMerchandiseList($environment, $shopId)
	{
		return $this->_loadDao()->getMerchandiseList($environment, $shopId);
	}

	public function weixinRegisterUser($environment, 
									   $mobile, 
									   $password, 
									   $username)
	{
		return $this->_loadDao()->weixinRegisterUser($environment, $mobile, $password, $username);
	}

	public function getOpenMyOrder($environment, $schoolid, $days, $myid, $offset, $limit) 
	{
		return $this->_loadDao()->getOpenMyOrder($environment, $schoolid, $days, $myid, $offset, $limit);
	}



	/**
	 * @return App_Weixin_Dao
	 */
	private function _loadDao() {
		return Wekit::loadDao('EXT:4tmobile.service.mobile.dao.App_Common_Dao');
	}
}

?>