<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_Head - 数据服务接口
 */
class App_Head {
	
	public function searchShop($keyword) {
		return $this->loadDao()->searchShop($keyword);
	}
	
	public function searchMerchandise($keyword) {
		return $this->loadDao()->searchMerchandise($keyword);
	}	
	
	/**
	 * @return App_Head_Dao
	 */
	private function loadDao() {
		return Wekit::loadDao('EXT:4tschool.service.Head.dao.App_Head_Dao');
	}
}

?>