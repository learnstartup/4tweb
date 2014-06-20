<?php

defined('WEKIT_VERSION') or exit(403);

class App_ShopPhone_Dao extends PwBaseDao
{

    /**
     * table name
     */
    protected $_table = '4t_shop_phonechecked';

    /**
     * primary key
     */
    protected $_pk = 'id';

    /**
     * table fields
     */
    protected $_dataStruct = array('id', 'shopid', 'uid', 'clientip','created');

    public function add($shopphonechecked)
    {
        return $this->_add($shopphonechecked, true);
    }

}

?>