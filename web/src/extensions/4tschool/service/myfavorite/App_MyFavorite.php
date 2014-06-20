<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_SchoolMyFavorite- 数据服务接口
 *
 */
class App_MyFavorite {
	

	public function getMyFavoriteShops($schoolId, $userid, $limit, $offset)
	{
		return $this->_loadDao()->getMyFavoriteShops($schoolId, $userid, $limit, $offset);
	}

	public function countMyFavoriteShops($schoolId, $userid)
	{
		return $this->_loadDao()->countMyFavoriteShops($schoolId, $userid);
	}

	public function getMyFavoriteMIdByShop($userid)
	{
		return $this->_loadDao()->getMyFavoriteMIdByShop($userid);
	}

	public function getMyFavoriteItemByShop($userid, $shopid, $limit, $offset)
	{
		return $this->_loadDao()->getMyFavoriteItemByShop($userid, $shopid, $limit, $offset);
	}

	public function getOpenMyFavoriteItemByShop($userid, $limit, $offset)
	{
		return $this->_loadDao()->getOpenMyFavoriteItemByShop($userid, $limit, $offset);
	}

	public function countMyFavoriteItemByShop($userid, $shopid)
	{
		return $this->_loadDao()->countMyFavoriteItemByShop($userid, $shopid);
	}

	public function countOpenMyFavoriteItemByShop($userid)
	{
		return $this->_loadDao()->countOpenMyFavoriteItemByShop($userid);
	}

	public function getMyFavoriteShopItems($schoolId, $userid,$shopid)
	{
		return $this->_loadDao()->getMyFavoriteShops($schoolId, $userid, $shopid);
	}

	public function checkIfExists($userid,$shopid,$merchandiseid)
	{
		return $this->_loadDao()->checkIfExists($userid,$shopid,$merchandiseid);	
	}

	public function addMyFavorite($userid,$shopid,$merchandiseid)
	{
		if($this->checkIfExists($userid,$shopid,$merchandiseid))
		{
			return;
		}
		Wind::import('EXT:4tschool.service.myfavorite.dm.App_MyFavorite_Dm');
		$dm = new App_MyFavorite_Dm();
		$dm->setShop($shopid)
			->setUser($userid)
			->setMerchandiseid($merchandiseid);
		return $this->_loadDao()->add($dm->getData());
	}

	public function deleteFavorite($userid,$shopid)
	{
		return $this->_loadDao()->deleteFavorite($userid,$shopid);
	}

	public function deleteFavoriteM($userid,$mid)
	{
		return $this->_loadDao()->deleteFavoriteM($userid,$mid);
	}

	public function delete($id) {
		return $this->_loadDao()->delete($id);
	}

	/**
	 * @return App_MyFavorite_Dao
	 */
	private function _loadDao() {
		return Wekit::loadDao('EXT:4tschool.service.myfavorite.dao.App_MyFavorite_Dao');
	}
}