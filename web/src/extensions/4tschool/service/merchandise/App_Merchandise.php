<?php

defined('WEKIT_VERSION') or exit(403);

/**
 * App_Merchandise - 数据服务接口
 */
class App_Merchandise {

	public function get($id)
	{
        return $this->loadDao()->get($id);
    }

	/**
	 * add record
	 *
	 * @param Shop Id
	 * @return multitype:|Ambigous <boolean, number, string, rowCount>
	 */
	public function getMerchandiseByShopId($shopId, $schoolId, $start, $limit) {

		return $this->loadDao()->getMerchandiseByShopId($shopId, $schoolId, $start, $limit);
	}

	public function countGetMerchandiseByShopId($shopId, $schoolId) {

		return $this->loadDao()->countGetMerchandiseByShopId($shopId, $schoolId);
	}

	public function getNoItemMerchandisesBySchool($schoolId)
	{
		return $this->loadDao()->getNoItemMerchandisesBySchool($schoolId);
	}

	public function getActiveMerchandiseByShopId($shopId) {

		return $this->loadDao()->getActiveMerchandiseByShopId($shopId);
	}

	public function getMerchandiseByShopIdAndTagId($getFilterArg, $limit, $offset) {

		return $this->loadDao()->getMerchandiseByShopIdAndTagId($getFilterArg, $limit, $offset);
	}

	public function getMerchandiseById($merchandiseId) {

		return $this->loadDao()->getMerchandiseById($merchandiseId);
	}

    public function getMerchandiseNameByIdList($idList)
    {
        return $this->loadDao()->getMerchandiseNameByIdList($idList);
    }

    public function orderCountIncrease($merchandiseId)
    {
        return $this->loadDao()->orderCountIncrease($merchandiseId);
    }

    public function getIncidentallyMerchandises($shopId)
    {
        return $this->loadDao()->getIncidentallyMerchandises($shopId);
    }

    public function getHotMerchandises($schoolId, $limit, $offset)
    {
        return $this->loadDao() ->getHotMerchandises($schoolId,$limit,$offset);
    }

    public function getHotMerchandisesByShopId($shopId, $limit, $offset)
    {
        return $this->loadDao() ->getHotMerchandisesByShopId($shopId,$limit,$offset);
    }

    public function getPromoMerchandisesBySchoolId($schoolId,$promoName,$orderBy,$sort, $LIMIT, $OFFSET)
    {
        return $this->loadDao()->getPromoMerchandisesBySchoolId($schoolId,$promoName,$orderBy,$sort, $LIMIT, $OFFSET);
    }

    public function batchUpdateMerchandiseStockoutStatus($ids,$status){
    	return $this->loadDao()->batchUpdateMerchandiseStockoutStatus($ids,$status);
    }

    public function getMerchandiseBySysTagIds ($ids, $schoolId, $orderBy,$sort, $LIMIT, $OFFSET){
    	return $this->loadDao()->getMerchandiseBySysTagIds($ids, $schoolId, $orderBy,$sort, $LIMIT, $OFFSET);
    }

    public function getShopIdByMid($mid)
    {
    	return $this->loadDao()->getShopIdByMid($mid);
    }

    public function getAllMerchandises(){
    	return $this->loadDao()->getAllMerchandises();
    }
	/**
	 * add record
	 *
	 * @param App_Merchandise_Dm $dm
	 * @return multitype:|Ambigous <boolean, number, string, rowCount>
	 */
	public function add(App_Merchandise_Dm $dm) {
		if (true !== ($r = $dm->beforeAdd()))
			return $r;
		return $this->loadDao()->add($dm->getData());
	}

	/**
	 * add record
	 *
	 * @param App_Merchandise_Tag_Dm $dm
	 * @return multitype:|Ambigous <boolean, number, string, rowCount>
	 */
	public function addMerchandiseTag(App_Merchandise_Tag_Dm $dm) {
		if (true !== ($r = $dm->beforeAdd()))
			return $r;
		return $this->loadMerchandiseTagDao()->add($dm->getData());
	}	

	/**
	 * update record
	 *
	 * @param App_Merchandise_Dm $dm
	 * @return multitype:|Ambigous <boolean, number, rowCount>
	 */
	public function update($id, App_Merchandise_Dm $dm) {
		if (true !== ($r = $dm->beforeUpdate()))
			return $r;
		return $this->loadDao()->update($id, $dm->getData());
	}

	public function updateCollectCountByMerchandiseId($mid){
		return $this->loadDao()->updateCollectCountByMerchandiseId($mid);
	}

	/**
	 * delete a record
	 *
	 * @param unknown_type $id
	 * @return Ambigous <number, boolean, rowCount>
	 */
	public function delete($id) {
		return $this->loadDao()->delete($id);
	}

	public function deleteMerchandiseTag($mid) {
		return $this->loadMerchandiseTagDao()->delete($mid);
	}	

	public function checkDuplicateInfo($col, $info) {
		return $this->loadDao()->checkDuplicateInfo($col, $info);
	}

	public function getMerchandiseTagsByMid ($mid){
		return $this->loadMerchandiseTagDao()->getMerchandiseTagsByMid($mid);
	}

	public function getMerchandiseBySpecialFilter ($filed, $value, $schoolId, $start, $limit){
		return $this->loadDao()->getMerchandiseBySpecialFilter($filed, $value, $schoolId, $start, $limit);
	}

	public function countGetMerchandiseBySpecialFilter ($filed, $value, $schoolId){
		return $this->loadDao()->countGetMerchandiseBySpecialFilter($filed, $value, $schoolId);
	}

	public function searchMerchandiseCountByString($keyword, $schoolId){
		
		return $this->loadDao()->searchMerchandiseCountByString($keyword, $schoolId);
	}

	/**
	 * @return App_Merchandise_Dao
	 */
	private function loadDao() {
		return Wekit::loadDao('EXT:4tschool.service.merchandise.dao.App_Merchandise_Dao');
	}

	/**
	 * @return App_Merchandise_Tag_Dao
	 */
	private function loadMerchandiseTagDao() {
		return Wekit::loadDao('EXT:4tschool.service.merchandise.dao.App_Merchandise_Tag_Dao');
	}	

}

?>