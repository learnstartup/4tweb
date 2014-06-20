<?php

defined('WEKIT_VERSION') or exit(403);

class App_Baiduuserchannel_Dao extends PwBaseDao
{

	/**
     * table name
     */
    protected $_table = '4t_baiduuser_channel';

    /**
     * primary key
     */
    protected $_pk = 'id';

    /**
     * table fields
     */
    protected $_dataStruct = array('id', 
    							   'shopid', 
    							   'baiduuserid',
    							   'channelid');

    public function getBaiduuserIdByShopId($shopid)
    {
        $sql = $this->_bindSql("SELECT `baiduuserid` FROM %s 
                                WHERE `shopid` = ?",
                                $this->getTable());

        $smt = $this->getConnection()->createStatement($sql);
        $result = $smt->getOne(array($shopid));
        return $result['baiduuserid'];
    }

    public function baiduchannelifexist($msg)
    {
        $sql = $this->_bindSql("SELECT * FROM %s 
                                WHERE `shopid` = ? AND 
                                      `baiduuserid` = ? AND 
                                      `channelid` = ?",
                                $this->getTable());

        $smt = $this->getConnection()->createStatement($sql);

        $result = $smt->queryAll(array($msg['shopid'], 
                                       $msg['baiduuserid'], 
                                       $msg['channelid']));
        $status = (!empty($result))?true:false;
        
        return $status;
    }

    public function deleteByShopid($shopid)
    {
        $sql = $this->_bindSql("delete FROM %s 
                                WHERE `shopid` = ? ",
                                $this->getTable());

        $smt = $this->getConnection()->createStatement($sql);

        $result = $smt->execute(array($shopid));
                
        return $result;
    }

    public function get($id)
    {
        return $this->_get($id);
    }

    public function add($baiduuserchannel)
	{
	    return $this->_add($baiduuserchannel, true);
	}

    public function update($id, $baiduuserchannel)
    {
        return $this->_update($id, $baiduuserchannel);
    }

    public function delete($id)
    {
        return $this->_delete($id);
    }

}

?>