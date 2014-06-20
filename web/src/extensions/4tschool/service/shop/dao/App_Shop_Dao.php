<?php

defined('WEKIT_VERSION') or exit(403);

class App_Shop_Dao extends PwBaseDao
{

    /**
     * table name
     */
    protected $_table = '4t_shop';

    protected $_areaTable = '4t_school_area';

    protected $_schoolTable = 'windid_school';

    protected $_provinceTable = 'windid_area';

    protected  $_schoolOpendTable='4t_school_opened';

    protected  $_shopSchoolTable='4t_shop_school';

    protected  $_shopSpeedOverallTable='4t_shopspeed_overall';


    /**
     * primary key
     */
    protected $_pk = 'id';

    /**
     * table fields
     */
    protected $_dataStruct = array('id', 'userid', 'masterid', 'name', 'address', 'latitude', 'longitude', 'packingprice', 'deliveryprice', 'startingprice', 'areaid', 'phonenumber', 'contactnumber', 'openorder', 'orderbegin', 'orderend', 'createdate', 'lastupdatetime', 'description', 'ordercount', 'imageurl', 'isactive', 'isaudit', 'ispartner','hasterminal','hasprint','isshopopen','ifrebate','rebatefromshop','openordertouser','averagemakeorder','averagebakeout','averagetocenter','averagedelivery','actualmakeorder','actualbakeout','actualtocenter','actualdelivery');

    public function get($id)
    {
        return $this->_get($id);
    }

    public function getAllShops($searchCondition, $start, $limit)
    {
        $condition = $this->searchConditionString($searchCondition);

        $sql = $this->_bindSql("SELECT sa.areaname, sh.* FROM %s sh LEFT JOIN pw_4t_school_area sa on sh.areaid = sa.id WhERE %s order by sh.id ASC %s", 
                                $this->getTable(),
                                $condition,
                                $this->sqlLimit($limit, $start));
        $smt = $this->getConnection()->createStatement($sql);

        return $smt->queryAll();
    }

    public function countAllShop($searchCondition)
    {
        $condition = $this->searchConditionString($searchCondition);

        $sql = $this->_bindSql("SELECT count(*) as totalCount FROM %s sh LEFT JOIN pw_4t_school_area sa on sh.areaid = sa.id WHERE %s", 
                                $this->getTable(),
                                $condition);
        $smt = $this->getConnection()->createStatement($sql);
        $result =  $smt->getOne(array());
    
        return $result['totalCount'];
    }

    public function searchConditionString($searchCondition)
    {
        if($searchCondition['choosenShopid'] == -1 || $searchCondition['choosenShopid'] == '')
        {
            $choosenShopid = "1 = 1";
        }
        else
        {
            $choosenShopid = "sh.id = ".$searchCondition['choosenShopid'];
        }

        if($searchCondition['isactive'] == -1 || $searchCondition['isactive'] == '')
        {
            $isactive = " AND 1 = 1";
        }
        else
        {
            $isactive = " AND sh.isactive = ".$searchCondition['isactive'];
        }

        if($searchCondition['ispartner'] == -1 || $searchCondition['ispartner'] == '')
        {
            $ispartner = " AND 1 = 1";
        }
        else
        {
            $ispartner = " AND sh.ispartner = ".$searchCondition['ispartner'];
        }

        if($searchCondition['isaudit'] == -1 || $searchCondition['isaudit'] == '')
        {
            $isaudit = " AND 1 = 1";
        }
        else
        {
            $isaudit = " AND sh.isaudit = ".$searchCondition['isaudit'];
        }

        if($searchCondition['schoolid'] == '-1' || $searchCondition['schoolid'] == '')
        {
            $schoolid = " AND 1 = 1";
        }
        else
        {
            $schoolid = " AND sa.schoolid = ".$searchCondition['schoolid'];
        }

        if($searchCondition['shopname'] == '')
        {
            $shopname = ' AND 1 = 1';
        }
        else
        {
            $shopname = " AND ( sh.`name` like '%".$searchCondition['shopname']."%')";
        }

        if($searchCondition['shopid'] == '')
        {
            $shopid = ' AND 1 = 1';
        }
        else
        {
            $shopid = " AND sh.id = ".$searchCondition['shopid'];
        }

        if($searchCondition['ifrebate'] == '' || $searchCondition['ifrebate'] == -1)
        {
            $ifrebate = ' AND 1 = 1';
        }
        else
        {
            $ifrebate = " AND sh.ifrebate = ".$searchCondition['ifrebate'];
        }

        if($searchCondition['openordertouser'] == '' || $searchCondition['openordertouser'] == -1)
        {
            $openordertouser = ' AND 1 = 1';
        }
        else
        {
            $openordertouser = " AND sh.openordertouser = ".$searchCondition['openordertouser'];
        }

        $condition = $choosenShopid.$isactive.$ispartner.$isaudit.$schoolid.$shopname.$shopid.$ifrebate.$openordertouser;

        return $condition;
    }

    public function getByShopId($shopid)
    {
        $sql = $this->_bindSql('SELECT ar.areaid AS provinceid,
                                       sc.schoolid,
                                       sa.areaname, 
                                       sh.*,
                                       shspeed.averagespeed,
                                       shspeed.overallcount
                                       FROM %s AS sh 
                                LEFT JOIN %s AS sa on sh.areaid = sa.id 
                                LEFT JOIN %s AS sc on sa.schoolid = sc.schoolid 
                                LEFT JOIN %s AS ar on sc.areaid = ar.areaid 
                                LEFT JOIN %s shspeed on sh.id = shspeed.shopid
                                where sh.id=?', 
                                $this->getTable(), 
                                $this->getTable($this->_areaTable), 
                                $this->getTable($this->_schoolTable), 
                                $this->getTable($this->_provinceTable),
                                $this->getTable($this->_shopSpeedOverallTable));
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->getOne(array($shopid));
    }

    public function getBySchoolId($schoolId, $searchArgs, $limit, $offset, $ismerchandise)
    {
        $sort = empty($searchArgs['sort'])?'DESC':$searchArgs['sort'];
        $orderBy = empty($searchArgs['orderby'])?'':$searchArgs['orderby'];
        $sql = $this->_bindSql('SELECT s.*, shspeed.averagespeed,shspeed.overallcount, 
                                if(CURTIME() > s.orderbegin && 
                                    CURTIME() < s.orderend, 1, 0) AS otherisopen 
                                FROM %s ss
                                LEFT JOIN %s s ON ss.shopId = s.id 
                                LEFT JOIN %s so ON ss.schoolid = so.schoolid
                                LEFT JOIN %s shspeed on s.id = shspeed.shopid
                                WHERE s.isactive = 1 and 
                                      s.isaudit = 1 and
                                      s.openorder = 1 and  
                                      so.schoolid = ? order by %s %s', 
            $this->getTable($this->_shopSchoolTable),
            $this->getTable(),
            $this->getTable($this->_schoolOpendTable), 
            $this->getTable($this->_shopSpeedOverallTable), 
            " s.isshopopen DESC, s.openorder DESC, s.ifrebate DESC, isnull(shspeed.averagespeed), shspeed.averagespeed ASC ",
            $this->sqlLimit($limit, $offset));
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->queryAll(array($schoolId));
    }

    public function getShopBySchoolId($schoolId, $searchArgs, $limit, $offset, $ismerchandise)
    {
        $sort = empty($searchArgs['sort'])?'DESC':$searchArgs['sort'];
        $orderBy = empty($searchArgs['orderby'])?'':$searchArgs['orderby'];
        $sql = $this->_bindSql('SELECT s. *, shspeed.averagespeed,shspeed.overallcount FROM %s ss
                                LEFT JOIN %s s ON ss.shopId = s.id 
                                LEFT JOIN %s so ON ss.schoolid = so.schoolid 
                                LEFT JOIN %s shspeed on s.id = shspeed.shopid
                                WHERE s.isactive = 1 and 
                                      s.isaudit = 1 and 
                                      ss.schoolid = ? order by %s %s', 
            $this->getTable($this->_shopSchoolTable),
            $this->getTable(),
            $this->getTable($this->_schoolOpendTable), 
            $this->getTable($this->_shopSpeedOverallTable), 
            empty($orderBy)?" s.hasterminal DESC, s.startingprice ASC, s.openorder DESC ":'  s.'.$orderBy.' ASC ',
            $this->sqlLimit($limit, $offset));
        
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->queryAll(array($schoolId));
    }

    public function getShopsByAreaId($areaid)
    {
        $sql = $this->_bindSql('SELECT * FROM %s WHERE areaid = ?', $this->getTable());
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->queryAll(array($areaid));
    }

    public function getShopsByIdList($idList)
    {
        $sql = $this->_bindSql('SELECT * FROM %s WHERE id in (' . $idList . ')', $this->getTable());
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->queryAll();
    }

    public function getUnPartnerShopsBySchoolId($schoolId)
    {
        $sql = $this->_bindSql('SELECT s. * FROM %s s LEFT JOIN %s sa ON s.areaid=sa.id LEFT JOIN %s so ON sa.schoolid=so.schoolid WHERE s.isactive = 1 and s.ispartner = 0 and so.schoolid = ?', $this->getTable(),$this->getTable($this->_areaTable),$this->getTable($this->_schoolOpendTable));
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->queryAll(array($schoolId));    
    }

	public function getOneShopIdbyUid($uid)
    {
        $sql = $this->_bindSql('SELECT ss.id FROM %s ss 
                                INNER JOIN %s sa on ss.areaid = sa.id 
                                WHERE ss.userid = ? and 
                                      ss.isactive = 1 ', 
                        $this->getTable(),
                        $this->getTable($this->_areaTable));
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->getOne(array($uid));
    }

    public function updateIsOpenField($status, $userid)
    {
        $sql = $this->_bindSql('UPDATE %s SET `isshopopen` = ? WHERE `userid` = ?', 
                                $this->getTable());
        $smt = $this->getConnection()->createStatement($sql);
        $smt->execute(array($status, $userid));

        $sql = $this->_bindSql('SELECT `isshopopen` FROM %s WHERE `userid` = ?', 
                                $this->getTable());
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->getOne(array($userid));

    }

    public function getShopNameByShopId($shopId)
    {
        $sql = $this->_bindSql('SELECT `name`, `areaid` FROM %s WHERE id = ?',
                              $this->getTable());
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->getOne(array($shopId));
    }

    public function getShopPrintHasterminal($userid)
    {
        $sql = $this->_bindSql('SELECT id, hasterminal,
                                       name as shopname, 
                                       hasprint,
                                       isshopopen FROM %s 
                                WHERE userid = ?',
                                $this->getTable());
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->getOne(array($userid));
    }

    public function isMyShop($areaid, $schoolId)
    {
        $sql = $this->_bindSql("SELECT count(*) AS totalCount FROM %s 
                                where id = ? AND schoolid = ?",
                        $this->getTable($this->_areaTable));

        $smt = $this->getConnection()->createStatement($sql);
        $result = $smt->queryAll(array($areaid, $schoolId));

        return ($result[0]['totalCount'] > 0);
    }

    public function checkIfOrderToUser($shopid)
    {
        $sql = $this->_bindSql("SELECT `openordertouser` FROM %s WHERE id = ?", 
                                $this->getTable());
        $smt = $this->getConnection()->createStatement($sql);
        $ifordertouser = $smt->getOne(array($shopid));

        return $ifordertouser['openordertouser'];
    }

    public function updateIsDaiKe($status)
    {
        $sql = $this->_bindSql('UPDATE %s SET `isshopopen` = ? WHERE `openordertouser` = 1', 
                                $this->getTable());
        $smt = $this->getConnection()->createStatement($sql);
        $smt->execute(array($status));  
    }

    public function add($shop)
    {
        return $this->_add($shop, true);
    }

    public function addMerchandise($merchandise)
    {
        $this->_table = '4t_merchandise';
        return $this->_add($merchandise, true);
    }

    public function update($id, $shop)
    {
        return $this->_update($id, $shop);
    }

    public function delete($id)
    {
        return $this->_delete($id);
    }

    public function checkDuplicateInfo($col, $info, $id)
    {
        $sql = $this->_bindSql('SELECT count(*) as total FROM %s where ' . $col . '=? AND id<>?', $this->getTable());
        $smt = $this->getConnection()->createStatement($sql);
        $result = $smt->queryAll(array($info, $id));
        return $result[0]['total'] > 0;
    }

}

?>