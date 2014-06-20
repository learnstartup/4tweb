<?php

defined('WEKIT_VERSION') or exit(403);

class App_Baidupush_Dao extends PwBaseDao
{

	/**
     * table name
     */
    protected $_table = '4t_baidu_push';

    /**
     * primary key
     */
    protected $_pk = 'id';

    /**
     * table fields
     */
    protected $_dataStruct = array('id', 
    							   'userid', 
    							   'baiduuserid', 
    							   'baiduchannelid', 
    							   'tagid', 
    							   'schoolid');

    public function get($id)
    {
        return $this->_get($id);
    }

    public function add($push)
	{
	    return $this->_add($push, true);
	}

}

?>