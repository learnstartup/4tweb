<?php

defined('WEKIT_VERSION') or exit(403);

class App_Shopstatusrecord_Dao extends PwBaseDao
{

    /**
     * table name
     */
    protected $_table = '4t_shop_status_record';

    protected $_shop = '4t_shop';

    protected $_schoolarea = '4t_school_area';

    protected $_windidschool = 'windid_school';

    /**
     * primary key
     */
    protected $_pk = 'id';

    /**
     * table fields
     */
    protected $_dataStruct = array('id', 'shopId', 'userId', 'actiontime', 'actionstatus');

    public function get($id)
    {
        return $this->_get($id);
    }

    public function getAllShopStatusRecord($searchCondition, $start, $limit)
    {
        $condition = $this->searchConditionString($searchCondition);
        $sql = $this->_bindSql("SELECT ssr.*, 
                                       shop.NAME AS shopname, 
                                       shop.areaid, 
                                       sa.schoolid, 
                                       ws.NAME AS schoolname FROM %s AS ssr 
                                    LEFT JOIN %s AS shop ON ssr.shopId = shop.id
                                    LEFT JOIN %s AS sa ON sa.id = shop.areaid
                                    LEFT JOIN %s AS ws ON ws.schoolid = sa.schoolid
                                where ".$condition." order by ssr.id ASC %s", 
                                $this->getTable(),
                                $this->getTable($this->_shop),
                                $this->getTable($this->_schoolarea),
                                $this->getTable($this->_windidschool),
                                $this->sqlLimit($limit, $start));
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->queryAll();
    }

    function countAllShopStatusRecord($searchCondition)
    {
        $condition = $this->searchConditionString($searchCondition);
        $sql = $this->_bindSql("SELECT count(*) FROM %s AS ssr 
                                    LEFT JOIN %s AS shop ON ssr.shopId = shop.id
                                    LEFT JOIN %s AS sa ON sa.id = shop.areaid
                                    LEFT JOIN %s AS ws ON ws.schoolid = sa.schoolid
                                where ".$condition."", 
                                $this->getTable(),
                                $this->getTable($this->_shop),
                                $this->getTable($this->_schoolarea),
                                $this->getTable($this->_windidschool));
        $smt = $this->getConnection()->query($sql);
        return $smt->fetchColumn();
    }

    function searchConditionString($searchCondition)
    {
        $shopId = ($searchCondition['shopId'] == '')?'1 = 1':
                         'shop.id = '.$searchCondition['shopId'];
        $condition = $shopId;
        
        return $condition;
    }

    public function add($shopstatus)
    {
        return $this->_add($shopstatus, true);
    }

    public function update($id, $shopstatus)
    {
        return $this->_update($id, $shopstatus);
    }

    public function delete($id)
    {
        return $this->_delete($id);
    }
}

?>