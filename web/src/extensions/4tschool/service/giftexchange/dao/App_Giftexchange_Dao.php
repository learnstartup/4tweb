<?php

defined('WEKIT_VERSION') or exit(403);

class App_Giftexchange_Dao extends PwBaseDao
{

	/**
     * table name
     */
    protected $_table = '4t_gift_exchange';

    protected $_windid = 'windid_user';

    /**
     * primary key
     */
    protected $_pk = 'id';

    /**
     * table fields
     */
    protected $_dataStruct = array('id', 
    							   'userid', 
    							   'contact', 
    							   'phonenumber', 
    							   'qq',
    							   'address',
    							   'productid',
    							   'exchangesuccess',
    							   'createtime',
    							   'updatetime',
    							   'exceptionexchange');

    public function getAllGiftExchange($searchCondition,$start,$limit)
    {
        //$condition = $this->searchConditionString($searchCondition);
        $sql = $this->_bindSql("SELECT ge.*,wu.username FROM %s ge
        						LEFT JOIN %s wu ON ge.userid = wu.uid ORDER BY id DESC", 
                                $this->getTable(),
                                $this->getTable($this->_windid),
                                $this->sqlLimit($limit, $start));
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->queryAll();
    }

    public function getOneGiftExchange($id)
    {
    	$sql = $this->_bindSql("SELECT ge.*,wu.username FROM %s ge
        						LEFT JOIN %s wu ON ge.userid = wu.uid 
        						WHERE ge.id = ?", 
                                $this->getTable(),
                                $this->getTable($this->_windid));
    	
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->getOne(array($id));
    }

    public function get($id)
    {
        return $this->_get($id);
    }

    public function add($giftexchange)
    {
        return $this->_add($giftexchange, true);
    }

    public function update($id, $giftexchange)
    {
        return $this->_update($id, $giftexchange);
    }

    public function delete($id)
    {
        return $this->_delete($id);
    }
}

?>