<?php
defined('WEKIT_VERSION') or exit(403);

class App_OrderAddress_Dao extends PwBaseDao
{

    /**
     * table name
     */
    protected $_table = '4t_order_address';

    protected $_userTable = 'windid_user';

    protected $_userInfoTable = 'windid_user_info';

    /**
     * primary key
     */
    protected $_pk = 'id';
    /**
     * table fields
     */
    protected $_dataStruct = array('id', 'userid', 'rname', 'raddress', 'rphone', 'createdate');


    public function getOrderAddress($userid)
    {
        $sql = $this->_bindSql('SELECT * from %s where userid =  ? order by isdefault DESC ',
            $this->getTable());
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->queryAll(array($userid));
    }

    public function getOrderAddressForFirstTime($userId)
    {
        $sql = $this->_bindSql('SELECT u.uid AS id, u.username AS rname, ui.mobile AS rphone, NULL AS raddress FROM %s u LEFT JOIN %s ui ON u.uid=ui.uid WHERE u.uid=?',
                                              $this->getTable($this->_userTable), $this->getTable($this->_userInfoTable));
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->getOne(array($userId));
    }

    public function getOrderAddressbyId($id)
    {
        $sql = $this->_bindSql('SELECT * from %s where id =  ? ',
            $this->getTable());
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->queryAll(array($id));
    }

    public function checkExists($userid,$rname,$raddress,$rphone)
    {
        $sql = $this->_bindSql("SELECT count(*) as totalCount FROM %s where userid = ? and rname = ? and raddress=? and rphone=? ",
                $this->getTable());
        $smt = $this->getConnection()->createStatement($sql);
        $result = $smt->queryAll(array($userid, $rname, $raddress, $rphone));
        return ($result[0]['totalCount'] > 0);
    }

    public function update($id, $userid, $rname, $raddress, $rphone)
    {
        $sql = $this->_bindSql('UPDATE %s SET rname =?, raddress=?, rphone=? where id =?',
            $this->getTable());
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->execute(array($rname, $raddress, $rphone, $id));
    }

    public function setasDefaultAddress($userid, $id)
    {
        //set current user's is default as 0
        $sql = $this->_bindSql('UPDATE %s SET isdefault =0 where userid =?',
            $this->getTable());
        $smt = $this->getConnection()->createStatement($sql);
        $smt->execute(array($userid));

        //set current address as default
        $sql = $this->_bindSql('UPDATE %s SET isdefault =1 where userid =? and id =?',
            $this->getTable());
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->execute(array($userid, $id));
    }

    public function clearDefaultAddress($userid)
    {
        //set current user's is default as 0
        $sql = $this->_bindSql('UPDATE %s SET isdefault = 0 where userid = ?',
            $this->getTable());
        $smt = $this->getConnection()->createStatement($sql);
        $smt->execute(array($userid));
    }

    public function add($fields)
    {
        return $this->_add($fields, true);
    }


    public function delete($id)
    {
        return $this->_delete($id);
    }


}

?>