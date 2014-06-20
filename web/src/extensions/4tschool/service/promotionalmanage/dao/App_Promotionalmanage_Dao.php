<?php
defined('WEKIT_VERSION') or exit(403);

/**
 *
 */
class App_Promotionalmanage_Dao extends PwBaseDao
{
	protected $_table = '4t_promotional_manage';
	protected $_shop = '4t_shop';
    protected $_wind_school_table ='windid_school';

    protected $_pk = 'id';

    protected $_dataStruct = array('id', 
                                   'schoolid',
    							   'shopid', 
    							   'promotionalstatus', 
    							   'promotionalstartime', 
    							   'promotionalendtime', 
    							   'promotionalcreatedate', 
    							   'promotionalupdate');
    public function getAllShopsPromotional($searchCondition, $start, $limit)
    {
        if($searchCondition['choosenSchoolId'] == -1)
        {
            $schoolid = "1 = 1";
        }
        else
        {
            $schoolid = "pm.schoolid = ".$searchCondition['choosenSchoolId'];
        }

        if($searchCondition['promotionalstatus'] == -1)
        {
            $promotionalstatus = "1 = 1";
        }
        else
        {
            $promotionalstatus = "pm.promotionalstatus = ".$searchCondition['promotionalstatus'];
        }

        $sql = $this->_bindSql("SELECT pm.*, sh.name, ws.name as schoolname FROM %s AS pm 
                                left join %s AS sh ON sh.id = pm.shopid 
                                left join %s as ws ON pm.schoolid = ws.schoolid 
                                where ".$schoolid." AND ".$promotionalstatus." order by pm.promotionalupdate desc %s", 
                	            $this->getTable(),
                	            $this->getTable($this->_shop),
                                $this->getTable($this->_wind_school_table),
                                $this->sqlLimit($limit, $start));
        $smt = $this->getConnection()->createStatement($sql);

        return $smt->queryAll();
    }

    public function getShopPromotionalBySchoolIdShopId($choosenSchoolId, $choosenShopId)
    {
        $sql = $this->_bindSql('SELECT count(*) FROM %s AS pm 
                                left join %s AS sh ON sh.id = pm.shopid 
                                left join %s as ws ON pm.schoolid = ws.schoolid 
                                where pm.schoolid = ? AND pm.shopid = ?', 
                                $this->getTable(),
                                $this->getTable($this->_shop),
                                $this->getTable($this->_wind_school_table));
        $smt = $this->getConnection()->createStatement($sql);

        return $smt->queryAll(array($choosenSchoolId, $choosenShopId));
    }

    public function getOneShopsPromotional($id)
    {
        $sql = $this->_bindSql('SELECT pm.*, sh.name FROM %s AS pm 
                                left join %s AS sh ON sh.id = pm.shopid 
                                WHERE pm.id = ?', 
                	            $this->getTable(),
                	            $this->getTable($this->_shop));
        $smt = $this->getConnection()->createStatement($sql);

        return $smt->getOne(array($id));
    }

    public function countPromotional($searchCondition)
    {
        if($searchCondition['choosenSchoolId'] == -1)
        {
            $schoolid = "1 = 1";
        }
        else
        {
            $schoolid = "pm.schoolid = ".$searchCondition['choosenSchoolId'];
        }

        if($searchCondition['promotionalstatus'] == -1)
        {
            $promotionalstatus = "1 = 1";
        }
        else
        {
            $promotionalstatus = "pm.promotionalstatus = ".$searchCondition['promotionalstatus'];
        }
        
        $sql = $this->_bindSql("SELECT count(*) FROM %s AS pm 
                                left join %s AS sh ON sh.id = pm.shopid 
                                left join %s as ws ON pm.schoolid = ws.schoolid 
                                where ".$schoolid." AND ".$promotionalstatus."",
                                $this->getTable(),
                                $this->getTable($this->_shop),
                                $this->getTable($this->_wind_school_table));
        
        $smt = $this->getConnection()->query($sql);
        return $smt->fetchColumn();
    }

    public function getPromotionalShops($schoolid)
    {
        $currentime = "'".date('Y-m-d H:i:s')."'";
        $sql = $this->_bindSql("SELECT pm.id as pmId, pm.schoolid, pm.promotionalstartime, 
                                                      pm.promotionalendtime,
                                                      pm.promotionalstatus, 
                                                      pm.shopid,
                                                      sh.id, 
                                                      sh.imageurl, 
                                                      sh.description, 
                                                      sh.orderbegin, 
                                                      sh.orderend, 
                                                      sh.startingprice,
                                                      sh.hasterminal,
                                                      sh.openorder,
                                                      sh.ordercount,
                                                      sh.name,
                                                      sh.isshopopen,
                                                      sh.hasprint,
                                                      sh.name as shopname, 
                                                      ws.name as schoolname  FROM %s AS pm 
                                LEFT JOIN %s AS sh ON sh.id = pm.shopid 
                                LEFT JOIN %s as ws ON pm.schoolid = ws.schoolid
        WHERE sh.isactive = 1 and sh.isshopopen = 1 and sh.openorder = 1 and pm.schoolid = ? and ".$currentime." > pm.promotionalstartime and ".$currentime." < pm.promotionalendtime and pm.promotionalstatus = 1",
                                $this->getTable(),
                                $this->getTable($this->_shop),
                                $this->getTable($this->_wind_school_table));
        $smt = $this->getConnection()->createStatement($sql);

        return $smt->queryAll(array($schoolid));
    }

    public function add($promotinalmanage)
    {
        return $this->_add($promotinalmanage, true);
    }

    public function update($id, $promotinalmanage)
    {
        return $this->_update($id, $promotinalmanage);
    }
}

?>