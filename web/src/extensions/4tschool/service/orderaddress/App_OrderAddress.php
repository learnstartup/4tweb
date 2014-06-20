<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_MyOrder - 数据服务接口
 *
 */
class App_OrderAddress{


	/*
	*
	*/
    public function getOrderAddress($userId)
    {
    	return $this->_loadDao()->getOrderAddress($userId);
    }

    public function getOrderAddressForFirstTime($userId){
        return $this->_loadDao()->getOrderAddressForFirstTime($userId);
    }

    public function addorUpdateOrderAddress($id,$userid,$rname,$raddress,$rphone)
    {
    	if($id <= 0)
    	{
            $exists = $this->checkExists($userid,$rname,$raddress,$rphone);
            if($exists)
                return -1;
	    	Wind::import('EXT:4tschool.service.orderaddress.dm.App_OrderAddress_Dm');
			$dm = new App_OrderAddress_Dm();
			$dm->setUserid($userid)
				->setName($rname)
				->setAddress($raddress)
				->setPhone($rphone);
			return $this->_loadDao()->add($dm->getData());
		}
		else
		{
			$this->_loadDao()->update($id,$userid,$rname,$raddress,$rphone);
            return 1;
		}
    }

    public function getOrderAddressbyId($id)
    {
    	return $this->_loadDao()->getOrderAddressbyId($id);
    }

    public function setasDefaultAddress($userid,$id)
    {
    	return $this->_loadDao()->setasDefaultAddress($userid,$id);
    }

    public function clearDefaultAddress($userid)
    {
        return $this->_loadDao()->clearDefaultAddress($userid);
    }

    public function checkExists($userid,$rname,$raddress,$rphone)
    {
        return $this->_loadDao()->checkExists($userid,$rname,$raddress,$rphone);
    }

    /*
    *
    */
    public function deleteOrderAddress($id)
    {
    	return $this->_loadDao()->delete($id);
    }
	
	/**
	 * @return App_OrderAddress_Dao
	 */
	private function _loadDao() {
		return Wekit::loadDao('EXT:4tschool.service.orderaddress.dao.App_OrderAddress_Dao');
	}

	
}

?>