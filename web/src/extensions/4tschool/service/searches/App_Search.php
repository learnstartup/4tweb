<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_Search - 数据服务接口
 */
class App_Search {
	
	public function searchShopBySchoolId($keyword,$schoolId,$limit,$offset,$isPartner) {
        $keyword=$this->keywordHandle($keyword);
		return $this->loadDao()->searchShopBySchoolId($keyword,$schoolId,$limit,$offset,$isPartner);
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

    public function weixinMerchandiseByShopId($shopId)
    {
        return $this->loadDao()->weixinMerchandiseByShopId($shopId);
    }

	public function searchMerchandiseByAreaId($keyword,$aid,$orderBy,$sort,$limit,$offset) {
        $keyword=$this->keywordHandle($keyword);
		return $this->loadDao()->searchMerchandiseByAreaId($keyword,$aid,$orderBy,$sort,$limit,$offset);
	}

	public function searchMerchandiseBySysTagId($schoolId, $aid, $systid, $orderBy, $sort, $limit, $offset)
	{
		return $this->loadDao()->searchMerchandiseBySysTagId($schoolId, $aid, $systid, $orderBy, $sort, $limit, $offset);
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

	public function searchMerchandisesByArgs($schoolid,$searchArgs,$limit,$offset)
	{
		$searchArgs['keyword'] = $this->keywordHandle($searchArgs['keyword']);

		return $this->loadDao()->searchMerchandisesByArgs($schoolid,$searchArgs,$limit,$offset);
	}

	public function countMerchandisesByArgs($schoolid,$searchArgs,$limit,$offset)
	{
		$searchArgs['keyword'] = $this->keywordHandle($searchArgs['keyword']);

		return $this->loadDao()->countMerchandisesByArgs($schoolid,$searchArgs,$limit,$offset);
	}

	public function searchShopsByArgs($schoolid,$searchArgs,$limit,$offset)
	{
		$searchArgs['keyword'] = $this->keywordHandle($searchArgs['keyword']);

		return $this->loadDao()->searchShopsByArgs($schoolid,$searchArgs,$limit,$offset);
	}

	public function countShopsByArgs($schoolid,$searchArgs)
	{
		$searchArgs['keyword'] = $this->keywordHandle($searchArgs['keyword']);

		return $this->loadDao()->countShopsByArgs($schoolid,$searchArgs);
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
     * add record
     *
     * @param App_Search_Dm $dm
     * @return multitype:|Ambigous <boolean, number, string, rowCount>
     */
    public function add(App_Search_Dm $dm)
    {

        if (true !== ($r = $dm->beforeAdd())) return $r;
        return $this->loadDao()->add($dm->getData());
    }

	/**
	 * @return App_Search_Dao
	 */
	private function loadDao() {
		return Wekit::loadDao('EXT:4tschool.service.searches.dao.App_Search_Dao');
	}
}

?>