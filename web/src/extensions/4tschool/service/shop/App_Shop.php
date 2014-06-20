<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_shop - 数据服务接口
 */
class App_Shop
{

    public function getAllShops($searchCondition, $start, $limit)
    {
        return $this->loadDao()->getAllShops($searchCondition, $start, $limit);
    }

    public function countAllShop($searchCondition)
    {
        return $this->loadDao()->countAllShop($searchCondition);
    }

    /**
     * get shop
     *
     * @param Shop Id
     * @return shop
     */
    public function getByShopId($shopId)
    {
        return $this->loadDao()->getByShopId($shopId);
    }

    public function getShopNameByShopId($shopId)
    {
        return $this->loadDao()->getShopNameByShopId($shopId);
    }

    //in minutes
    public function getShopOrderTimeBase($shopId)
    {
        $info = $this->getByShopId($shopId);

        //get 4 time and check
        if($info['actualmakeorder'] <= 0
            || $info['actualbakeout'] <= 0
            || $info['actualtocenter'] <= 0
            || $info['actualdelivery'] <= 0)
        {
            return 30; //如果任意一个没有定义，则返回30分钟作为订单的时间
        }
        else
            return ($info['actualmakeorder'] + $info['actualbakeout'] + $info['actualtocenter'] + $info['actualdelivery']);
    }

    public function getShopsByAreaId($areaId)
    {
        return $this->loadDao()->getShopsByAreaId($areaId);
    }

    public function getBySchoolId($schoolId, $searchArgs, $limit, $offset, $ismerchandise)
    {
        return $this->loadDao()->getBySchoolId($schoolId, $searchArgs, $limit, $offset, $ismerchandise);
    }

    public function getShopBySchoolId($schoolId, $searchArgs, $limit, $offset, $ismerchandise)
    {
        return $this->loadDao()->getShopBySchoolId($schoolId, $searchArgs, $limit, $offset, $ismerchandise);
    }

    public function getShopsByIdList($idList)
    {
        return $this->loadDao()->getShopsByIdList($idList);
    }

    public function getActiveMerchandiseByShopId($shopId)
    {
        return $this->loadDao()->getActiveMerchandiseByShopId($shopId);
    }

    public function getUnPartnerShopsBySchoolId($schoolId)
    {
        return $this->loadDao()->getUnPartnerShopsBySchoolId($schoolId);
    }

	public function getOneShopIdbyUid($uid)
    {
        return $this->loadDao()->getOneShopIdbyUid($uid);
    }

    public function updateIsOpenField($status, $userid)
    {
        return $this->loadDao()->updateIsOpenField($status, $userid);
    }

    public function getShopPrintHasterminal($userid)
    {
        return $this->loadDao()->getShopPrintHasterminal($userid);
    }

    public function isMyShop($areaid, $schoolId)
    {
        return $this->loadDao()->isMyShop($areaid, $schoolId);
    }

    public function checkIfOrderToUser($shopid)
    {
        return $this->loadDao()->checkIfOrderToUser($shopid);
    }

    public function updateIsDaiKe($status)
    {
        return $this->loadDao()->updateIsDaiKe($status);
    }

    /**
     * add record
     *
     * @param App_Shop_Dm $dm
     * @return multitype:|Ambigous <boolean, number, string, rowCount>
     */
    public function add(App_Shop_Dm $dm)
    {

        if (true !== ($r = $dm->beforeAdd())) return $r;
        return $this->loadDao()->add($dm->getData());
    }

    /**
     * update record
     *
     * @param App_Shop_Dm $dm
     * @return multitype:|Ambigous <boolean, number, rowCount>
     */
    public function update($id, App_Shop_Dm $dm)
    {
        if (true !== ($r = $dm->beforeUpdate())) return $r;
        return $this->loadDao()->update($id, $dm->getData());
    }

    /**
     * delete a record
     *
     * @param unknown_type $id
     * @return Ambigous <number, boolean, rowCount>
     */
    public function delete($id)
    {
        return $this->loadDao()->delete($id);
    }

    public function checkDuplicateInfo($col, $info, $id)
    {
        return $this->loadDao()->checkDuplicateInfo($col, $info, $id);
    }

    public function addShopDeliveryTime(App_Shop_DeliveryTime_Dm $dm){
        if (true !== ($r = $dm->beforeAdd())) return $r;
        return $this->loadShopDeliveryTimeDao()->add($dm->getData());        
    }

    public function updateShopDeliveryTime ($id, App_Shop_DeliveryTime_Dm $dm){
        if (true !== ($r = $dm->beforeUpdate())) return $r;
        return $this->loadShopDeliveryTimeDao()->update($id, $dm->getData());            
    }

    public function getShopDeliveryTimeByShopId ($shopid){
        return $this->loadShopDeliveryTimeDao()->getByShopId($shopid);
    }

    public function getShopDeliveryTimeByShopIds ($shopList, $schoolId){
        $deliverytimelist = array();
        
        foreach($shopList as $key=>$val)
        {
           array_push($deliverytimelist, $val['id']);
        }
        $shopids = implode(',', $deliverytimelist);
        return $this->loadShopDeliveryTimeDao()->getByShopIds($shopids, $schoolId);
    }

    public function addShopPhoneChecked(App_ShopPhone_Dm $dm)
    {
        return $this->loadShopPhoneCheckedDao()->add($dm->getdata());
    }

    public function get($id){
        return $this->loadDao()->get($id);
    }

    public function addShopComment($userid,$shopid,$orderid,$speed,$comment='')
    {
    	Wind::import('EXT:4tschool.service.shop.dm.App_ShopComment_Dm');
		$dm = new App_ShopComment_Dm();
		$dm->setUserId($userid)
			->setShopId($shopid)
			->setOrderId($orderid)
			->setComment($comment)
			->setSpeed($speed);

		//update overall speed
		$shopOverallSpeed = $this->loadShopOverallSpeedDao()->getByShopId($shopid);
		if(empty($shopOverallSpeed))
		{
			$shopOverallSpeed['overallspeed'] = $speed;
			$shopOverallSpeed['overallcount'] = 1;
			$shopOverallSpeed['averagespeed'] = $speed;
			$shopOverallSpeed['shopid'] = $shopid;

			//insert
			$this->loadShopOverallSpeedDao()->add($shopOverallSpeed);
		}
		else
		{
			$overallspeed = $shopOverallSpeed['overallspeed'] + $speed;
			$overallcount = $shopOverallSpeed['overallcount'] + 1;
			$averagespeed = $overallspeed/$overallcount;
			
			$shopOverallSpeed['overallspeed'] = $overallspeed;
			$shopOverallSpeed['overallcount'] = $overallcount;
			$shopOverallSpeed['averagespeed'] = $averagespeed;

			//update
			$this->loadShopOverallSpeedDao()->update($shopOverallSpeed['id'],$shopOverallSpeed);
			
		}
		


		return $this->loadShopCommentDao()->add($dm->getData());
    }

    public function checkIfAddedComment($userid,$orderid)
    {
    	return $this->loadShopCommentDao()->checkIfAddedComment($userid,$orderid);
    }

    public function getShopComment($shopid, $limit, $start)
    {
        return $this->loadShopCommentDao()->getShopComment($shopid, $limit, $start);
    }

    public function countGetShopComment($shopid)
    {
        return $this->loadShopCommentDao()->countGetShopComment($shopid);
    }


    /**
     * @return App_Shop_Dao
     */
    private function loadDao()
    {
        return Wekit::loadDao('EXT:4tschool.service.shop.dao.App_Shop_Dao');
    }

    /**
     * @return App_Shop_DeliveryTime_Dao
     */
    private function loadShopDeliveryTimeDao()
    {
        return Wekit::loadDao('EXT:4tschool.service.shop.dao.App_Shop_DeliveryTime_Dao');
    }        

    /**
     * @return App_ShopPhone_Dao
     */
    private function loadShopPhoneCheckedDao()
    {
        return Wekit::loadDao('EXT:4tschool.service.shop.dao.App_ShopPhone_Dao');
    }

    /**
     * @return App_ShopComment_Dao
     */
    private function loadShopCommentDao()
    {
        return Wekit::loadDao('EXT:4tschool.service.shop.dao.App_ShopComment_Dao');
    }

    /**
     * @return App_ShopSpeed_Overall_Dao
     */
    private function loadShopOverallSpeedDao()
    {
        return Wekit::loadDao('EXT:4tschool.service.shop.dao.App_ShopSpeed_Overall_Dao');
    }
}