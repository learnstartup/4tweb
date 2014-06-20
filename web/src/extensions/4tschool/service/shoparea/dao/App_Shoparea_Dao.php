<?php

defined('WEKIT_VERSION') or exit(403);

class App_Shoparea_Dao extends PwBaseDao
{

    /**
     * table name
     */
    protected $_table = '4t_shop_school';

    protected $_shop = '4t_shop';

    protected $_windidschool = 'windid_school';

    /**
     * primary key
     */
    protected $_pk = 'id';

    /**
     * table fields
     */
    protected $_dataStruct = array('id', 'shopId', 'schoolId');

    public function get($id)
    {
        return $this->_get($id);
    }

    public function getShopAreaByShopId($shopId)
    {
        $sql = $this->_bindSql("SELECT ss.id, s.id AS shopId, 
        							   s.NAME AS shopname, 
        							   ws.schoolid, 
        							   ws.NAME AS schoolname 
        						FROM %s AS ss 
								LEFT JOIN %s AS s ON  ss.shopId  = s.id 
								LEFT JOIN %s AS ws ON ss.schoolId = ws.schoolid
								where ss.shopId = ?", 
                                $this->getTable(),
                                $this->getTable($this->_shop),
                                $this->getTable($this->_windidschool));
        $smt = $this->getConnection()->createStatement($sql);

        return $smt->queryAll(array($shopId));
    }

    public function checkShopIfExist($schoolId, $shopId)
    {
    	$sql = $this->_bindSql("SELECT * FROM %s 
    							WHERE schoolId = ? and shopId = ?",
               					$this->getTable());
        $smt = $this->getConnection()->createStatement($sql);
        
        return $smt->queryAll(array($schoolId, $shopId));
    }

    public function deleteShopAreaById($id)
    {
        $sql = $this->_bindSql("DELETE FROM %s WHERE id = ?", 
                                $this->getTable());
        $smt = $this->getConnection()->createStatement($sql);

        return $smt->update(array($id));

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
    {echo $id;exit;
        return $this->_delete($id);
    }
}

?>