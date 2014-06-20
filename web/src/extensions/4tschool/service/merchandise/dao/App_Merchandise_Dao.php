<?php

defined('WEKIT_VERSION') or exit(403);

class App_Merchandise_Dao extends PwBaseDao
{

    /**
     * table name
     */
    protected $_table = '4t_merchandise';

    protected $_shopTable = '4t_shop';

    protected $_areaTable = '4t_school_area';

    protected $_schoolOpendTable = '4t_school_opened';

    protected $_schoolAreatable ='4t_school_area';

    protected $_tagTable = '4t_tag';

    protected  $_merchandisePromoTable='4t_merchandise_promo';

    protected  $_shopPromoTable='4t_shop_promo';

    protected  $_promoTemplateTable='4t_promo_template';

    protected $_merchandiseTagTable='4t_merchandise_tag';


    /**
     * primary key
     */
    protected $_pk = 'id';

    /**
     * table fields
     */
    protected $_dataStruct = array('id', 
                                   'shopid', 
                                   'address', 
                                   'tagid', 
                                   'name',
                                   'needPackingPrice', 
                                   'price', 
                                   'currentprice', 
                                   'unit', 
                                   'remainder',
                                   'recommend',
                                   'active', 
                                   'isstar',
                                   'ordercount', 
                                   'imageurl', 
                                   'description', 
                                   'merchandisedescription', 
                                   'descriptionurl', 
                                   'createdate', 
                                   'lastupdatetime');

    public function add($merchandise)
    {
        return $this->_add($merchandise, true);
    }

    public function update($id, $merchandise)
    {
        return $this->_update($id, $merchandise);
    }

    public function updateCollectCountByMerchandiseId($mid){
        $sql = $this->_bindSql('UPDATE %s SET `collectCount` = collectCount+1 WHERE id = ?', $this->getTable());
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->execute(array($mid));
    }

    public function delete($id)
    {
        return $this->_delete($id);
    }

    public function get($id)
    {
        return $this->_get($id);
    }

    public function getNoItemMerchandisesBySchool($schoolId)
    {
        $sql = $this->_bindSql('SELECT m.*,
                                       s.name as shopname,
                                       s.phonenumber,
                                       s.contactnumber FROM %s m 
                                       LEFT JOIN %s s ON m.shopid=s.id 
                                       LEFT JOIN %s sa ON s.areaid=sa.id 
                                       LEFT JOIN %s so ON sa.schoolid=so.schoolid 
                                WHERE m.remainder <= 0 and 
                                      m.active = 1 and 
                                      s.isactive =1 ORDER BY m.shopid DESC %s', 
                                $this->getTable(), 
                                $this->getTable($this->_shopTable), 
                                $this->getTable($this->_areaTable), 
                                $this->getTable($this->_schoolOpendTable), 
                                $this->sqlLimit($limit, $offset));
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->queryAll(array());
    }

    public function getMerchandiseByShopId($shopId, $schoolid, $start, $limit)
    {
        if($schoolid == '')
        {
            $schoolid = "1 = 1 AND ";
        }
        else
        {
            $schoolid = "sa.schoolid = ".$schoolid.' AND ';
        }

        $sql = $this->_bindSql("SELECT t.`name` AS tagname, 
                                       m.*,
                                       s.packingprice,
                                       s.deliveryprice,
                                       s.startingprice,
                                       s.openorder FROM %s m
                                INNER JOIN %s s on m.shopid = s.id
                                LEFT JOIN %s t on m.tagid=t.id
                                LEFT JOIN %s sa on s.areaid = sa.id
                                WHERE %s m.shopid = ? ORDER BY createdate %s",
                                $this->getTable(),
                                $this->getTable($this->_shopTable),
                                $this->getTable($this->_tagTable),
                                $this->getTable($this->_areaTable),
                                $schoolid,
                                $this->sqlLimit($limit, $start));
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->queryAll(array($shopId));
    }

    public function countGetMerchandiseByShopId($shopId, $schoolid)
    {
        if($schoolid == '')
        {
            $schoolid = "1 = 1 AND ";
        }
        else
        {
            $schoolid = "sa.schoolid = ".$schoolid.' AND ';
        }

        $sql = $this->_bindSql("SELECT count(*) FROM %s m
                                INNER JOIN %s s on m.shopid = s.id
                                LEFT JOIN %s t on m.tagid = t.id
                                LEFT JOIN %s sa on s.areaid = sa.id
                                WHERE %s m.shopid = ".$shopId."",
                                $this->getTable(),
                                $this->getTable($this->_shopTable),
                                $this->getTable($this->_tagTable),
                                $this->getTable($this->_areaTable),
                                $schoolid);
        $smt = $this->getConnection()->query($sql);
        return $smt->fetchColumn(); 
    }

    public function getActiveMerchandiseByShopId($shopId, $limit, $offset)
    {
        $sql = $this->_bindSql('SELECT t.`name` AS tagname, 
                                                m.*,s.packingprice,
                                                s.deliveryprice,
                                                s.startingprice,
                                                s.orderbegin,
                                                s.orderend,
                                                s.openorder,
                                                s.isshopopen,
                                                s.name as shopname FROM %s m
                                                INNER JOIN %s s on m.shopid = s.id
                                                LEFT JOIN %s t on m.tagid=t.id
                                                WHERE m.shopid=? and m.active =1 ORDER BY m.price %s',
                                                $this->getTable(),
                                                $this->getTable($this->_shopTable),
                                                $this->getTable($this->_tagTable),
                                                $this->sqlLimit($limit, $offset));
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->queryAll(array($shopId));
    }

    public function getMerchandiseByShopIdAndTagId($getFilterArg, $limit, $offset)
    {
        $sql = $this->_bindSql('SELECT m.*,
                                       s.packingprice,
                                       s.deliveryprice,
                                       s.startingprice,
                                       s.openorder,
                                       s.phonenumber,
                                       s.contactnumber, 
                                       s.hasterminal, 
                                       s.orderbegin,
                                       s.orderend,
                                       s.isshopopen,
                                       s.name as shopname FROM %s m
                                INNER JOIN %s s on m.shopid = s.id
                                LEFT JOIN %s t on m.tagid = t.id
                                WHERE m.shopid = ? and m.active = 1 %s ORDER BY m.price %s',
                                $this->getTable(),
                                $this->getTable($this->_shopTable),
                                $this->getTable($this->_tagTable),
                                empty($getFilterArg['tagId'])?'':'AND t.id = '.$getFilterArg['tagId'],
                                $this->sqlLimit($limit, $offset));
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->queryAll(array($getFilterArg['shopId']));
    }

    public function getMerchandiseById($merchandiseId)
    {
        $sql = $this->_bindSql('SELECT m.*, 
                                s.phonenumber, 
                                s.contactnumber,
                                s.openorder,
                                s.isshopopen,
                                s.startingprice,
                                s.orderbegin,
                                s.orderend,
                                s.hasterminal, 
                                s.name as shopname FROM %s as m
                               INNER JOIN %s s on m.shopid = s.id WHERE m.id = ?',
                    $this->getTable(),
                    $this->getTable($this->_shopTable));
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->getOne(array($merchandiseId));
    }

    public function getMerchandiseNameByIdList($idList)
    {
        $sql = $this->_bindSql('SELECT `name` FROM %s WHERE id in (' . $idList . ')', $this->getTable());
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->queryAll();
    }

    public function getMerchandiseBySpecialFilter ($filed, $value, $schoolid, $start, $limit)
    {
        $schoolidstring = empty($schoolid)?" AND 1 = 1 ":" And sa.schoolid = ".$schoolid;

        $sql = $this->_bindSql("SELECT m.* FROM %s m
                                INNER JOIN %s s on m.shopid = s.id
                                LEFT JOIN %s t on m.tagid = t.id
                                LEFT JOIN %s sa on s.areaid = sa.id
                                WHERE m.".$filed." = %s %s order by id ASC %s",
                                $this->getTable(),
                                $this->getTable($this->_shopTable),
                                $this->getTable($this->_tagTable),
                                $this->getTable($this->_areaTable),
                                $value,
                                $schoolidstring,
                                $this->sqlLimit($limit, $start));
        $smt= $this->getConnection()->createStatement($sql);
        return $smt->queryAll(array($value));
    }

    public function countGetMerchandiseBySpecialFilter ($filed, $value, $schoolid)
    {
        if($schoolid == '')
        {
            $schoolid = " AND 1 = 1 ";
        }
        else
        {
            $schoolid = " AND sa.schoolid = ".$schoolid;
        }

        $sql= $this->_bindSql("SELECT count(*) FROM %s m
                                INNER JOIN %s s on m.shopid = s.id
                                LEFT JOIN %s t on m.tagid = t.id
                                LEFT JOIN %s sa on s.areaid = sa.id
                                WHERE m.".$filed." = %s ".$schoolid,
                                $this->getTable(),
                                $this->getTable($this->_shopTable),
                                $this->getTable($this->_tagTable),
                                $this->getTable($this->_areaTable),
                                $value,
                                $schoolid);
        $smt = $this->getConnection()->query($sql);
        return $smt->fetchColumn(); 
    }

    public function getByShopId($shopId)
    {
        $sql = $this->_bindSql('SELECT ar.areaid,sc.schoolid,sa.areaname, sh.* FROM %s AS sh LEFT JOIN %s AS sa on sh.area=sa.id LEFT JOIN %s AS sc on sa.schoolid=sc.schoolid LEFT JOIN %s AS ar on sc.areaid=ar.areaid where sh.id=?', $this->getTable(), $this->getTable($this->_areatable), $this->getTable($this->_schooltable), $this->getTable($this->_provincetable));
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->getOne(array($shopId));
    }

    public function getShopIdByMid($mid)
    {
        $sql = $this->_bindSql("SELECT `shopid` FROM %s WHERE id = ?",
                                $this->getTable());
        $smt = $this->getConnection()->createStatement($sql);
        $result = $smt->getOne(array($mid));
        return $result['shopid'];
    }

    public function getHotMerchandises($schoolId, $limit, $offset = 0)
    {
        $sql = $this->_bindSql('SELECT m.*,s.packingprice,s.deliveryprice,s.startingprice,s.openorder FROM %s m LEFT JOIN %s s ON m.shopid=s.id LEFT JOIN %s sa ON s.areaid=sa.id LEFT JOIN %s so ON m.remainder > 0 and m.active = 1 and m.recommend = 1 and sa.schoolid=so.schoolid WHERE so.schoolid = ? ORDER BY m.ordercount DESC %s', $this->getTable(), $this->getTable($this->_shopTable), $this->getTable($this->_areaTable), $this->getTable($this->_schoolOpendTable), $this->sqlLimit($limit, $offset));
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->queryAll(array($schoolId));
    }

    public function getHotMerchandisesByShopId($shopId, $limit, $offset = 0)
    {
        $sql = $this->_bindSql('SELECT m.*,
                                       s.packingprice,
                                       s.deliveryprice,
                                       s.startingprice,
                                       s.orderbegin,
                                       s.orderend,
                                       s.hasterminal,
                                       s.openorder,
                                       s.isshopopen 
                                       FROM %s m 
                                       LEFT JOIN %s s ON m.shopid=s.id 
                                       LEFT JOIN %s sa ON s.areaid=sa.id 
                                       LEFT JOIN %s so ON sa.schoolid=so.schoolid 
                               WHERE  m.remainder > 0 and 
                                      m.active = 1 and 
                                      m.recommend = 1 and 
                                      s.id = ? ORDER BY m.ordercount DESC %s', 
            $this->getTable(), 
            $this->getTable($this->_shopTable), 
            $this->getTable($this->_areaTable), 
            $this->getTable($this->_schoolOpendTable), 
            $this->sqlLimit($limit, $offset));
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->queryAll(array($shopId));
    }

    public function getIncidentallyMerchandises($shopId)
    {
        $sql = $this->_bindSql('SELECT m.*,s.packingprice,s.deliveryprice,s.startingprice,s.openorder FROM %s m INNER JOIN %s s ON m.shopid = s.id  where m.remainder > 0 and m.active = 1 and shopid = ? ORDER BY currentprice', $this->getTable(),$this->getTable($this->_shopTable));
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->queryAll(array($shopId));
    }

    public function checkDuplicateInfo($col, $info)
    {
        $sql = $this->_bindSql('SELECT count(*) as total FROM %s where ' . $col . '=?', $this->getTable(), $info);
        $smt = $this->getConnection()->createStatement($sql);
        $result = $smt->queryAll(array($info));
        return $result[0]['total'] > 0;
    }

    public function orderCountIncrease($merchandiseId)
    {
        $sql = $this->_bindSql('UPDATE %s SET ordercount=ordercount+1 WHERE id = ?', $this->getTable());
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->execute(array($merchandiseId), true);
    }

    public function getPromoMerchandisesBySchoolId($schoolId,$promoName,$orderBy,$sort, $LIMIT, $OFFSET)
    {
        $sql = $this->_bindSql('SELECT m.*,s.name AS ShopName, s.phonenumber, s.packingprice,s.deliveryprice,s.startingprice,s.openorder FROM %s m
                                                JOIN (SELECT id,merchandiseid,shoppromoid FROM %s GROUP BY shoppromoid) mp ON mp.merchandiseid=m.id
                                                JOIN %s s ON m.shopid=s.id and s.isactive =1
                                                JOIN %s sa ON s.areaid=sa.id
                                                JOIN %s so ON sa.schoolid=so.schoolid
                                                JOIN %s sp ON mp.shoppromoid=sp.id and sp.isactive =1
                                                JOIN (SELECT * FROM %s GROUP BY templateid) pt ON sp.templateid=pt.templateid
                                                WHERE m.remainder > 0 and m.recommend = 1 and m.active =1 and so.schoolid=? AND %s order by %s %s',
                                                $this->getTable(),
                                                $this->getTable($this->_merchandisePromoTable),
                                                $this->getTable($this->_shopTable),
                                                $this->getTable($this->_areaTable),
                                                $this->getTable($this->_schoolOpendTable),
                                                $this->getTable($this->_shopPromoTable),
                                                $this->getTable($this->_promoTemplateTable),
                                                empty($promoName)?" 1 = 1 ":" pt.`name`= '$promoName' ",
                                                empty($orderBy)?" m.createdate ":'m.'.$orderBy.' '.$sort,
                                                $this->sqlLimit($LIMIT, $OFFSET));

        $smt=$this->getConnection()->createStatement($sql);
        return $smt->queryAll(array($schoolId));
    }

    public function getStarMerchandiseBySchoolId ($schoolId){
        $sql=$this->_bindSql('SELECT m.* FROM %s m 
                                         LEFT JOIN %s s ON m.shopid=s.id and s.isactive=1
                                         LEFT JOIN %s sa ON s.areaid=sa.id
                                         LEFT JOIN %s so ON sa.schoolid=so.schoolid
                                         WHERE m.isstar=1 and m.active=1 and so.schoolid = ?',
                                         $this->getTable(),
                                         $this->getTable($this->_shopTable),
                                         $this->getTable($this->_areaTable),
                                         $this->getTable($this->_schoolOpendTable));
        $smt=$this->getConnection()->createStatement($sql);
        return $smt->queryAll(array($schoolId));
    }

    public function batchUpdateMerchandiseStockoutStatus ($ids,$status){
        $sql=$this->_bindSql('UPDATE %s SET remainder = %s , 
                                            lastupdatetime = now() 
                              WHERE id IN ( %s )',
                        $this->getTable(),
                        $status,
                        $ids);
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->execute();
    }

    public function searchMerchandiseIDsByArgs($schoolid,$searchArgs,$limit,$offset)
    {
        $keyword = empty($searchArgs['keyword'])?'':$searchArgs['keyword'];
        $aid = empty($searchArgs['aid'])?0:$searchArgs['aid'];
        $ifdeliver = empty($searchArgs['ifdeliver'])?'':$searchArgs['ifdeliver'];
        $baseprice = empty($searchArgs['baseprice'])?0:$searchArgs['baseprice'];
        $ifdeliverfee = empty($searchArgs['ifdeliverfee'])?'':$searchArgs['ifdeliverfee'];
        $type = empty($searchArgs['type'])?'m':$searchArgs['type'];
        $tagid = empty($searchArgs['tagid'])?0:$searchArgs['tagid'];
        $shopid = empty($searchArgs['shopid'])?0:$searchArgs['shopid'];
        $sort = empty($searchArgs['sort'])?'ASC':$searchArgs['sort'];
        $orderBy = empty($searchArgs['orderby'])?'':$searchArgs['orderby'];

        $sql=$this->_bindSql("SELECT DISTINCT m.id
                                FROM %s m 
                                JOIN %s s ON m.shopid=s.id and m.active =1 
                                JOIN %s a ON s.areaid=a.id
                                LEFT JOIN %s mtag on mtag.mid = m.id
                                WHERE a.schoolid = ? and s.isactive = 1 and s.isaudit = 1 and m.active = 1  and  %s and %s and %s and %s and %s order by %s %s",
                                $this->getTable($this->_merchandisetable),
                                $this->getTable($this->_shopTable),
                                $this->getTable($this->_schoolAreatable),
                                $this->getTable($this->_merchandiseTagTable),
                                $aid <=0 ?" ( 1 = 1) ":"a.id=$aid",
                                $shopid <=0 ? " ( 1=1 ) ":"m.shopid = $shopid",
                                $tagid <= 0 ? " (1=1) ":"mtag.tid in (".$tagid.")",
                                's.openorder = 1',
                                empty($keyword)?" ( 1 = 1) ":"m.`name` LIKE"." '".$keyword."'",
                                "s.hasterminal DESC, s.isshopopen DESC, m.price ASC",
                                $this->sqlLimit($limit, $offset));

        $smt = $this->getConnection()->createStatement($sql);
        return $smt->queryAll(array($schoolid));
    }
    public function getMerchandiseBySysTagIds ($ids, $schoolId, $orderBy,$sort, $limit,$offset)
    {
        $searchArgs['aid'] = 0;
        $searchArgs['ifdeliver'] = 'y';
        $searchArgs['baseprice'] = 0;
        $searchArgs['ifdeliverfee'] = 0;
        $searchArgs['keyword'] = 0;
        $searchArgs['systid'] = 0;
        $searchArgs['sort'] = 0;
        $searchArgs['orderby'] = 0;
        $searchArgs['tagid'] = $ids;
        $mIdList = $this->searchMerchandiseIDsByArgs($schoolId,$searchArgs,$limit,$offset);
        
        $idQuery = " ( -1 , ";
        foreach ($mIdList as $key => $value) {
            $idQuery = $idQuery.$value['id'].",";
        }

        $idQuery = $idQuery." -1) ";

        $sort = empty($searchArgs['sort'])?'ASC':$searchArgs['sort'];
        $orderBy = empty($searchArgs['orderby'])?'':$searchArgs['orderby'];

        $sql=$this->_bindSql('SELECT DISTINCT m.*, 
                                     sh.name as shopname, 
                                     sh.phonenumber, 
                                     sh.contactnumber, 
                                     sh.startingprice, 
                                     sh.orderbegin, 
                                     sh.orderend, 
                                     sh.openorder, 
                                     sh.isshopopen,
                                     sh.hasterminal
                                     FROM %s m 
                                JOIN %s sh ON m.shopid = sh.id
                                LEFT JOIN %s mt ON m.id = mt.mid 
                                WHERE m.id in %s order by %s',
                                $this->getTable($this->_merchandisetable),
                                $this->getTable($this->_shopTable),
                                $this->getTable($this->_merchandiseTagTable),
                                $idQuery,
                                "sh.hasterminal DESC, sh.isshopopen DESC, m.price ASC");

        $smt=$this->getConnection()->createStatement($sql);
        return $smt->queryAll(array($schoolId));
    }

    public function searchMerchandiseCountByString($keyword, $schoolId){

        $sql = $this->_bindSql('SELECT count(*) FROM %s s LEFT JOIN %s a ON a.id=s.areaid WHERE (%s OR %s) AND a.schoolid = ? AND s.isactive=1', 
                                                        $this->getTable($this->_shopTable),
                                                        $this->getTable($this->_areaTable),
                                                        empty($keyword)?" ( 1 = 1) ":"`name` LIKE"." '".'%'.$keyword.'%'."'",
                                                        empty($keyword)?" ( 1 = 1) ":"`address` LIKE"." '".'%'.$keyword.'%'."'");
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->queryAll(array($schoolId));
    }

    public function getAllMerchandises (){
      $sql=$this->_bindSql('SELECT * FROM %s GROUP BY tagid',$this->getTable());
      $smt=$this->getConnection()->createStatement($sql);
      return $smt->queryAll();
    }

}

?>