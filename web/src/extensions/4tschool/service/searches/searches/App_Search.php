<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_Search - 数据服务接口
 */
class App_Search {	

	public function searchShopBySchoolId($keyword,$schoolId,$limit,$offset) {
        $keyword=$this->keywordHandle($keyword);
		return $this->loadDao()->searchShopBySchoolId($keyword,$schoolId,$limit,$offset);
	}

	public function searchMerchandiseByShopId($keyword,$shopId,$orderBy,$sort,$limit,$offset) {
        $keyword=$this->keywordHandle($keyword);
		return $this->loadDao()->searchMerchandiseByShopId($keyword,$shopId,$orderBy,$sort,$limit,$offset);
	}
	
	public function searchMerchandiseBySchoolId($keyword,$schoolId,$orderBy,$sort,$limit,$offset) {
        $keyword=$this->keywordHandle($keyword);
		return $this->loadDao()->searchMerchandiseBySchoolId($keyword,$schoolId,$orderBy,$sort,$limit,$offset);
	}

    public function searchMerchandiseDefault($limit,$offset)
    {
        return $this->loadDao()->searchMerchandiseDefault($limit,$offset);
    }

	public function searchMerchandiseByAreaId($keyword,$aid,$orderBy,$sort,$limit,$offset) {
        $keyword=$this->keywordHandle($keyword);
		return $this->loadDao()->searchMerchandiseByAreaId($keyword,$aid,$orderBy,$sort,$limit,$offset);
	}

	public function searchShopByAreaId($keyword,$aid,$limit,$offset) {
        $keyword=$this->keywordHandle($keyword);
		return $this->loadDao()->searchShopByAreaId($keyword,$aid,$limit,$offset);
	}
	
	public function countMerchandises ($keyword,$schoolId,$aid){
        $keyword=$this->keywordHandle($keyword);
		return $this->loadDao()->countMerchandises($keyword,$schoolId,$aid);
	}

	public function countShops ($keyword,$schoolId,$aid){
        $keyword=$this->keywordHandle($keyword);
		return $this->loadDao()->countShops($keyword,$schoolId,$aid);
	}

	public function searchMerchandiseByFilter($keyword,$schoolid,$aid,$shopid,$orderBy='',$sort,$limit,$offset){
		$keyword=$this->keywordHandle($keyword);
		return $this->loadDao()->searchMerchandiseByFilter($keyword,$schoolid,$aid,$shopid,$orderBy,$sort,$limit,$offset);
	}

	public function countMerchandisesByFilter($keyword,$schoolid,$aid,$shopid){
		$keyword=$this->keywordHandle($keyword);
		return $this->loadDao()->countMerchandisesByFilter($keyword,$schoolid,$aid,$shopid);

	}

    private function keywordHandle($keyword)
    {
        $keyword=trim($keyword);
        if (!empty($keyword)) {
            $keyword='%'.$keyword.'%';
        }
        return $keyword;
    }

	/**
	 * @return App_Search_Dao
	 */
	private function loadDao() {
		return Wekit::loadDao('EXT:4tschool.service.searches.dao.App_Search_Dao');
	}
}

?>