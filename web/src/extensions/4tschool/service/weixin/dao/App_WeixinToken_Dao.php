<?php

defined('WEKIT_VERSION') or exit(403);

class App_WeixinToken_Dao extends PwBaseDao
{
	/**
     * table name
     */
    protected $_table = '4t_weixin_token';


    /**
     * primary key
     */
    protected $_pk = 'id';

    /**
     * table fields
     */
    protected $_dataStruct = array('id', 'token','expireat');

    public function get($id)
    {
        return $this->_get($id);
    }

    public function add($tokenData)
    {
        return $this->_add($tokenData, true);
    }

    public function getToken($currenttime)
    {
        $sql = $this->_bindSql('SELECT token FROM %s WHERE expireat > ? order by expireat desc',
                               $this->getTable());
        $smt = $this->getConnection()->createStatement($sql);
        $result = $smt->getOne(array($currenttime));
        return $result;
    }
 
}

?>