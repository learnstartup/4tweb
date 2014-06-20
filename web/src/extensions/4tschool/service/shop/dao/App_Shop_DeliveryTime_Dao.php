<?php

defined('WEKIT_VERSION') or exit(403);

class App_Shop_DeliveryTime_Dao extends PwBaseDao
{

    /**
     * table name
     */
    protected $_table = '4t_shop_deliverytime';


    /**
     * primary key
     */
    protected $_pk = 'id';

    /**
     * table fields
     */
    protected $_dataStruct = array('id', 'shopid', 'begintime', 'endtime', 'weights', 'isactive');

    public function get($id)
    {
        return $this->_get($id);
    }

    public function add($dm)
    {
        return $this->_add($dm, true);
    }

    public function update($id, $dm)
    {
        return $this->_update($id, $dm);
    }

    public function delete($id)
    {
        return $this->_delete($id);
    }

    public function getAllShopDeliveryTimes (){
        $sql = $this->_bindSql('SELECT * FROM %s', $this->getTable());
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->queryAll();
    }

    public function getByShopId ($shopId){
        $sql = $this->_bindSql('SELECT * FROM %s WHERE shopid=? ORDER BY weights ASC',$this->getTable());
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->queryAll(array($shopId));        
    }

    public function getByShopIds ($shopIds, $schoolId){
        $sql = $this->_bindSql('SELECT '.$schoolId.' as schoolId, `shopid`, `begintime`, `endtime` FROM %s WHERE shopid in('."$shopIds".') ORDER BY weights ASC',$this->getTable());
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->queryAll();        
    }

}

?>