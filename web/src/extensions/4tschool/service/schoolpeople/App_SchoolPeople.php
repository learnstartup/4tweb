<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_SchoolArea- 数据服务接口
 *
 */
class App_SchoolPeople {

	public function getMasterKeyValue()
	{
		return array("key"=>"master","value"=>"学校管理员");
	}

	public function getOrderdispatchKeyValue()
	{
		return array("key"=>"orderdispatch","value"=>"订单分配");
	}

	public function getdeliveryKeyValue()
	{
		return array("key"=>"delivery","value"=>"订单配送");
	}

	public function getorderfoKeyValue()
	{
		return array("key"=>"areaorderget","value"=>"下单人");
	}

	public function getshopaccountValue()
	{
		return array("key"=>"shopaccount","value"=>"商家帐号");
	}

	public function isMaster($schoolid,$userid)
	{
		return $this->checkIfExists($schoolid,$userid,"master");
	}

	public function isAssigneer($schoolid,$userid)
	{
		return $this->checkIfExists($schoolid,$userid,"orderdispatch");
	}

	public function isDelivery($schoolid,$useid)
	{
		return $this->checkIfExists($schoolid,$userid,"delivery");
	}

	public function isShopAccount($schoolid,$useid)
	{
		return $this->checkIfExists($schoolid,$userid,"shopaccount");
	}

	public function getMasterId($schoolid, $type)
	{
		return $this->_loadDao()->getMasterId($schoolid, $type);
	}
	
	/**
	 * get school area by id
	 *
	 * @param unknown_type $id
	 * @return Ambigous <multitype:, multitype:unknown , mixed>
	 */
	public function getByOpenSchool() {
		return $this->_loadDao()->getByOpenSchool();
	}

	public function getSchoolPeople($schoolid,$type)
	{
		return $this->_loadDao()->getSchoolPeople($schoolid,$type);
	}

	public function getPeopleByType($type)
	{
		return $this->_loadDao()->getPeopleByType($type);
	}

	public function getMyRolesInSchool($schoolid,$userid)
	{
		return $this->_loadDao()->getSchoolPeople($schoolid,$userid);
	}

	public function checkIfExists($schoolid,$userid,$type)
	{
		return $this->_loadDao()->checkIfExists($schoolid,$userid,$type);	
	}

	public function checkIfAccount($userid,$type,$areaid = 0)
	{
		return $this->_loadDao()->checkIfAccount($userid,$type,$areaid = 0);
	}

	public function checkIfExistsInRoles($schoolid,$userid,$roles)
	{
		$roleArray = explode(";",$roles);
		foreach($roleArray as $key => $eachRole)
		{
			$canVisit = $this->checkIfExists($schoolid,$userid,$eachRole);
			if($canVisit)
				return true;
		}
		
		return false;	
	}

	public function checkIfAreaExistPPL($schoolid,$userid,$type,$areaid = 0)
	{
		return $this->_loadDao()->checkIfAreaExistPPL($schoolid,$userid,$type,$areaid);	
	}

	public function addSchoolUser(App_SchoolPeople_Dm $dm)
	{
		return $this->_loadDao()->add($dm->getData());
	}

	public function delete($id) {
		return $this->_loadDao()->delete($id);
	}


	//========================================================================================
	//
	//	peope schedule
	//
	//========================================================================================
	public function getPeopleScheduleById($scheduleId)
	{
		$scheduleInfo = $this->_loadPeopleScheduleDao()->getPeopleScheduleById($scheduleId);
		return $scheduleInfo;
	}

	public function getPeopleScheduleShop($uid,$datetimeIn)
	{
		$shopIds = $this->_loadPeopleScheduleDao()->getPeopleScheduleShop($uid,$datetimeIn);
		return $shopIds;
	}


	public function getPeopleSchedule($userid,$schoolid,$shopid,$timeBegin,$timeEnd)
	{
		$result = $this->_loadPeopleScheduleDao()->getPeopleSchedule($userid,$schoolid,$shopid,$timeBegin,$timeEnd);

		$shopList = $this->_loadShopDao()->getBySchoolId($schoolid);

		$mergedResult = array();
		$timeScanBegin = $timeBegin;
		$timeScanEnd = $timeEnd;
		$beginDateArray = getdate(strtotime($timeScanBegin));
		$endDateArray = getdate(strtotime($timeScanEnd));

		if($timeBegin >  $timeEnd)
			return;


		//通过timeBegin, timeEnd开始把时间分成有多少天
		while (1==1)
		{
			$eachDay = mktime(0, 0, 0, $beginDateArray['mon'], $beginDateArray['mday'], $beginDateArray['year']);
	    	$eachDay = date('Y-m-d', $eachDay);

			$mergedResult[$eachDay] = array();

			$nextDay = mktime(0, 0, 0, $beginDateArray['mon'], $beginDateArray['mday'] + 1, $beginDateArray['year']);
	    	$nextDay = date('Y-m-d', $nextDay);
	    	$beginDateArray = getdate(strtotime($nextDay));

	    	if($nextDay > $timeEnd)
	    		break;

		}


		//需要进行分组, 按照时间(日期) -> 商店分组
		foreach ($result as $key => $eachSchedule) {

			$currentArray =	getdate(strtotime($eachSchedule['datetimeBegin']));
			$currentDay = mktime(0, 0, 0, $currentArray['mon'], $currentArray['mday'], $currentArray['year']);
        	$currentDay = date('Y-m-d', $currentDay);

        	$eachSchedule['datetimeBegin'] = date('H:i:s',strtotime($eachSchedule['datetimeBegin']));
        	$eachSchedule['datetimeEnd'] = date('H:i:s',strtotime($eachSchedule['datetimeEnd']));


        	$currentShopId = $eachSchedule['shopid'];

        	if(array_key_exists($currentShopId, $mergedResult[$currentDay]))
        	{
        		$mergedResult[$currentDay][$currentShopId][] = $eachSchedule;
        	}
        	else
        	{	
        		$mergedResult[$currentDay][$currentShopId] = array();
        		$mergedResult[$currentDay][$currentShopId][] = $eachSchedule;
        	}
		}

		return $mergedResult;
	}


	public function saveSchedule(App_PeopleSchedule_Dm $dm)
	{
		return $this->_loadPeopleScheduleDao()->add($dm->getData());
	}

	public function updateSchedule($id,App_PeopleSchedule_Dm $dm)
	{
		return $this->_loadPeopleScheduleDao()->update($id,$dm->getData());
	}

	public function deleteByScheduleId($scheduleId)
	{
		return $this->_loadPeopleScheduleDao()->deleteByScheduleId($scheduleId);
	}

	public function deleteByShopIdandDate($shopid,$timeBegin,$timeEnd) 
	{
		return $this->_loadPeopleScheduleDao()->deleteByShopIdandDate($shopid,$timeBegin,$timeEnd);
	}

	/**
	 * @return App_SchoolPeople_Dao
	 */
	private function _loadDao() {
		return Wekit::loadDao('EXT:4tschool.service.schoolpeople.dao.App_SchoolPeople_Dao');
	}


	/**
	 * @return App_PeopleSchedule_Dao
	 */
	private function _loadPeopleScheduleDao() {
		return Wekit::loadDao('EXT:4tschool.service.schoolpeople.dao.App_PeopleSchedule_Dao');
	}

	/**
     * @return App_Shop_Dao
     */
    private function _loadShopDao()
    {
        return Wekit::loadDao('EXT:4tschool.service.shop.dao.App_Shop_Dao');
    }
}