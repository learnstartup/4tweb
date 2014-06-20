<?php

defined('WEKIT_VERSION') or exit(403);

class App_Merchandise_Tag_Dao extends PwBaseDao
{

    /**
     * table name
     */
    protected $_table = '4t_merchandise_tag';

    /**
     * primary key
     */
    protected $_pk = 'id';

    /**
     * table fields
     */
    protected $_dataStruct = array('id', 'mid', 'tid', 'createdate');

    public function add($merchandiseTag)
    {
        return $this->_add($merchandiseTag, true);
    }

    public function update($id, $merchandiseTag)
    {
        return $this->_update($id, $merchandiseTag);
    }

    public function get($id)
    {
        return $this->_get($id);
    }

    public function delete($mid) {
        $sql = $this->_bindSql('DELETE FROM %s WHERE mid = ?',
                        $this->getTable());

        $smt = $this->getConnection()->createStatement($sql);
        $result = $smt->execute(array($mid)); 
        return ($result);
    }

    public function getMerchandiseTagsByMid ($mid){
        $sql = $this->_bindSql('SELECT * FROM %s WHERE mid = ?',$this->getTable());

        $smt = $this->getConnection()->createStatement($sql);
        return $smt->queryAll(array($mid));

    }
  
}

?>