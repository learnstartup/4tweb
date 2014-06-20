<?php

defined('WEKIT_VERSION') or exit(403);

class App_Push_Dao extends PwBaseDao
{

    /**
     * table name
     */
    protected $_table = '4t_push';

    protected $_schoolTable = 'windid_school';

    /**
     * primary key
     */
    protected $_pk = 'id';

    /**
     * table fields
     */
    protected $_dataStruct = array('id', 
                                   'schoolid', 
                                   'type', 
                                   'title', 
                                   'content',
                                   'status', 
                                   'creator', 
                                   'createdate', 
                                   'updatedate');
    /**
     * 取得推送内容
     */
    public function getSearchPushData($searchCondition, $start, $limit)
    {
        $condition = '';
        if($searchCondition['schoolid'] == -1 || $searchCondition['schoolid'] == '')
        {
            $schoolid = "1 = 1";
        }
        else
        {
            $schoolid = "p.schoolid = ".$searchCondition['schoolid'];
        }

        if($searchCondition['type'] == -1 || $searchCondition['type'] == '')
        {
            $type = " AND 1 = 1";
        }
        else
        {
            $type = " AND p.type = ".$searchCondition['type'];
        }

        if($searchCondition['status'] == -1 || $searchCondition['status'] == '')
        {
            $status = " AND 1 = 1";
        }
        else
        {
            $status = " AND p.status = ".$searchCondition['status'];
        }

        $condition = $schoolid.$type.$status;

        $sql = $this->_bindSql("SELECT p.*, w.name FROM %s AS p 
                               LEFT JOIN %s AS w ON p.schoolid = w.schoolid 
                               WHERE ".$condition." order by p.id DESC %s", 
                               $this->getTable(), 
                               $this->getTable($this->_schoolTable),
                               $this->sqlLimit($limit, $start));
        $smt = $this->getConnection()->createStatement($sql);

        return $smt->queryAll(array($schoolId));
    }

    /**
     * 计算数据的数量
     */
    public function countPush($searchCondition)
    {
        $condition = '';
        if($searchCondition['schoolid'] == -1 || $searchCondition['schoolid'] == '')
        {
            $schoolid = "1 = 1";
        }
        else
        {
            $schoolid = "p.schoolid = ".$searchCondition['schoolid'];
        }

        if($searchCondition['type'] == -1 || $searchCondition['type'] == '')
        {
            $type = " AND 1 = 1";
        }
        else
        {
            $type = " AND p.type = ".$searchCondition['type'];
        }

        if($searchCondition['status'] == -1 || $searchCondition['status'] == '')
        {
            $status = " AND 1 = 1";
        }
        else
        {
            $status = " AND p.status = ".$searchCondition['status'];
        }

        $condition = $schoolid.$type.$status;

        $sql = $this->_bindSql("SELECT COUNT(*) FROM %s AS p 
                               LEFT JOIN %s AS w ON p.schoolid = w.schoolid 
                               WHERE ".$condition."", 
                               $this->getTable(), 
                               $this->getTable($this->_schoolTable));
        $smt = $this->getConnection()->query($sql);

        return $smt->fetchColumn(); 
    }

    /**
     * 根据表主id, 取出一条数据, Web, 手机端共用
     */
    public function getOnePushById($id)
    {
        $sql = $this->_bindSql("SELECT p.*, w.name FROM %s AS p 
                               LEFT JOIN %s AS w ON p.schoolid = w.schoolid 
                               WHERE p.id = ?", 
                               $this->getTable(), 
                               $this->getTable($this->_schoolTable));
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->getOne(array($id));  
    }

    /**
     * 
     */

    /**
     * table add, delete, get, update
     */
    public function get($id)
    {
        return $this->_get($id);
    }

    public function add($push)
    {
        return $this->_add($push, true);
    }

    public function update($id, $push)
    {
        return $this->_update($id, $push);
    }

    public function delete($id)
    {
        return $this->_delete($id);
    }
}

?>