<?php

defined('WEKIT_VERSION') or exit(403);

class App_ShopSpeed_Overall_Dao extends PwBaseDao
{

    /**
     * table name
     */
    protected $_table = '4t_shopspeed_overall';

    /**
     * primary key
     */
    protected $_pk = 'id';

    /**
     * table fields
     */
    protected $_dataStruct = array('id', 'shopid', 'overallspeed', 'overallcount','averagespeed');

    public function add($fields)
    {
        return $this->_add($fields, true);
    }

    public function update($id,$fields)
    {
        return $this->_update($id,$fields);
    }

    public function getByShopId($shopid)
    {
    	$sql = $this->_bindSql("SELECT *  FROM %s 
                                where shopid = ? ",
                        $this->getTable());

    	$smt = $this->getConnection()->createStatement($sql);
        $result = $smt->getOne(array($shopid));

        return $result;
    }

    public function checkIfExists($shopid)
    {
    	$sql = $this->_bindSql("SELECT count(*) AS totalCount FROM %s 
                                where shopid = ? ",
                        $this->getTable());

    	$smt = $this->getConnection()->createStatement($sql);
        $result = $smt->queryAll(array($shopid));

        return ($result[0]['totalCount'] > 0);
    }

}

?>