<?php

defined('WEKIT_VERSION') or exit(403);

class App_ShopComment_Dao extends PwBaseDao
{

    /**
     * table name
     */
    protected $_table = '4t_shop_comment';

    /**
     * primary key
     */
    protected $_pk = 'id';

    /**
     * table fields
     */
    protected $_dataStruct = array('id', 'shopid', 'userid', 'orderid','speed','comment');

    public function add($shopcomment)
    {
        return $this->_add($shopcomment, true);
    }

    public function checkIfAddedComment($userid,$orderid)
    {
    	$sql = $this->_bindSql("SELECT count(*) AS totalCount FROM %s 
                                where userid = ? AND orderid = ?",
                        $this->getTable());

    	$smt = $this->getConnection()->createStatement($sql);
        $result = $smt->queryAll(array($userid, $orderid));

        return ($result[0]['totalCount'] > 0);
    }

}

?>