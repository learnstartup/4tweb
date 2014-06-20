<?php

defined('WEKIT_VERSION') or exit(403);

class App_Cate_Week_Report_Dao extends PwBaseDao
{

    /**
     * table name
     */
    protected $_table = '4t_cate_week_report';

    protected $_schoolTable = 'windid_school';

    /**
     * primary key
     */
    protected $_pk = 'id';

    /**
     * table fields
     */
    protected $_dataStruct = array('id', 'schoolid', 'type', 'title', 'link', 'content', 'breviaryphoto', 'creator', 'contactinfo', 'audited', 'released', 'auditdate', 'releasedate', 'createdate');

    public function get($id)
    {
        return $this->_get($id);
    }

    public function getAllCateWeekReports($start, $limit)
    {
        $sql = $this->_bindSql('SELECT cwr.*, sh.name FROM %s AS cwr LEFT JOIN %s AS sh on cwr.schoolid = sh.schoolid %s ', 
            $this->getTable(), 
            $this->getTable($this->_schoolTable),
            $this->sqlLimit($limit, $start));
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->queryAll();
    }

    public function getSearchCateWeekData($searchCondition, $start, $limit)
    {
        if($searchCondition['choosenSchoolId'] == -1)
        {
            $schoolid = "1 = 1";
        }
        else
        {
            $schoolid = "cwr.schoolid = ".$searchCondition['choosenSchoolId'];
        }

        if($searchCondition['typename'] == -1)
        {
            $type = "1 = 1";
        }
        else
        {
            $type = "cwr.type = ".$searchCondition['typename'];
        }

        if($searchCondition['audited'] == -1)
        {
            $audited = "1 = 1";
        }
        else
        {
            $audited = "cwr.audited = ".$searchCondition['audited'];
        }

        if($searchCondition['released'] == -1)
        {
            $released = "1 = 1";
        }
        else
        {
            $released = "cwr.released = ".$searchCondition['released'];
        }

        $sql = $this->_bindSql("SELECT cwr.*, sh.name FROM %s AS cwr LEFT JOIN %s AS sh on cwr.schoolid = sh.schoolid 
                                WHERE ".$schoolid." AND ".$type." AND ".$audited." AND ".$released." %s", 
                                $this->getTable(), 
                                $this->getTable($this->_schoolTable),
                                $this->sqlLimit($limit, $start));
        $smt = $this->getConnection()->createStatement($sql);

        return $smt->queryAll();

    }

    public function getCateWeekReportById($id)
    {
        $sql = $this->_bindSql('SELECT * FROM %s WHERE `id` = ?', $this->getTable());
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->getOne(array($id));    
    }

    /**
     * 获取周报数
     *
     * @return int
     */
    public function countCateWeek($searchCondition){

        if($searchCondition['choosenSchoolId'] == -1)
        {
            $schoolid = "1 = 1";
        }
        else
        {
            $schoolid = "cwr.schoolid = ".$searchCondition['choosenSchoolId'];
        }

        if($searchCondition['typename'] == -1)
        {
            $type = "1 = 1";
        }
        else
        {
            $type = "cwr.type = ".$searchCondition['typename'];
        }

        if($searchCondition['audited'] == -1)
        {
            $audited = "1 = 1";
        }
        else
        {
            $audited = "cwr.audited = ".$searchCondition['audited'];
        }

        if($searchCondition['released'] == -1)
        {
            $released = "1 = 1";
        }
        else
        {
            $released = "cwr.released = ".$searchCondition['released'];
        }

        $sql = $this->_bindSql("SELECT count(*) FROM %s AS cwr LEFT JOIN %s AS sh on cwr.schoolid = sh.schoolid 
                                WHERE ".$schoolid." AND ".$type." AND ".$audited." AND ".$released."", 
                                $this->getTable(), $this->getTable($this->_schoolTable));
        $smt = $this->getConnection()->query($sql);
        return $smt->fetchColumn(); 
    }

    public function getCakeWeekBySchoolId($schoolId, $start, $limit)
    {
        $sql = $this->_bindSql("SELECT cwr.`id`, cwr.`schoolid`, cwr.`title`, cwr.`link`, cwr.`releasedate`, cwr.`contactinfo`, cwr.`breviaryphoto`, sh.`name` FROM %s AS cwr LEFT JOIN %s AS sh on cwr.`schoolid` = sh.`schoolid` 
                                WHERE sh.`schoolid` = ? AND cwr.`released` = 1 order by cwr.`createdate` DESC %s", 
                                $this->getTable(), 
                                $this->getTable($this->_schoolTable),
                                $this->sqlLimit($limit, $start));
        $smt = $this->getConnection()->createStatement($sql);

        return $smt->queryAll(array($schoolId));
    }

    public function countCakeWeekBySchoolId($schoolId)
    {
        $sql = $this->_bindSql("SELECT count(*) FROM %s AS cwr LEFT JOIN %s AS sh on cwr.schoolid = sh.schoolid 
                                WHERE sh.schoolid = ".$schoolId." AND cwr.`released` = 1", 
                                $this->getTable(), 
                                $this->getTable($this->_schoolTable));

        $smt = $this->getConnection()->query($sql);

        return $smt->fetchColumn(); 
    }

    /**
     * 获取学校的名字
     *
     * @return array
     */
    public function getCurrentSchoolNameById($schoolid)
    {
        $sql = $this->_bindSql('SELECT * FROM %s WHERE `schoolid` = ?', $this->getTable($this->_schoolTable));
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->getOne(array($schoolid));   
    }

    public function add($cateweek)
    {
        return $this->_add($cateweek, true);
    }

    public function update($id, $cateweek)
    {
        return $this->_update($id, $cateweek);
    }

    public function delete($id)
    {
        return $this->_delete($id);
    }

}

?>