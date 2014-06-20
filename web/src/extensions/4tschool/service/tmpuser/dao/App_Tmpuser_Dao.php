<?php

defined('WEKIT_VERSION') or exit(403);

class App_Tmpuser_Dao extends PwBaseDao
{
	/**
     * table name
     */
    protected $_table = '4t_tmpuser';


    /**
     * primary key
     */
    protected $_pk = 'id';

    /**
     * table fields
     */
    protected $_dataStruct = array('id', 'userid','from','key');

    public function get($id)
    {
        return $this->_get($id);
    }

    public function add($user)
    {
        return $this->_add($user, true);
    }

    public function whereUserFrom($userid)
    {
        $sql = $this->_bindSql('SELECT * FROM %s WHERE userid = ?',
                               $this->getTable());
        $smt = $this->getConnection()->createStatement($sql);
        $result = $smt->getOne(array($userid));
        return $result;
    }

    public function getbyKey($from,$key)
    {
        $sql = $this->_bindSql('SELECT * FROM %s WHERE `from` = ? and `key` = ?',
                               $this->getTable());
        $smt = $this->getConnection()->createStatement($sql);
        $result = $smt->getOne(array($from,$key));
        return $result;
    }
}

?>