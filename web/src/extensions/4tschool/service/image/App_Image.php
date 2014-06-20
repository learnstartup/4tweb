<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_Image - 数据服务接口
 */
class App_Search {
	
	
	
	/**
	 * @return App_Image_Dao
	 */
	private function loadDao() {
		return Wekit::loadDao('EXT:4tschool.service.searches.dao.App_Search_Dao');
	}
}

?>