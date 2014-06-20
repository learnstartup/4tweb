<?php
defined('WEKIT_VERSION') or exit(403);

class App_Search_Dao extends PwBaseDao{

	protected $_table='4t_search_record';

	protected $_shoptable='4t_shop';

	protected $_merchandisetable='4t_merchandise';

	protected $_schoolAreatable='4t_school_area';

	protected $_merchandisetagtable='4t_merchandise_tag';

	protected $_tag = '4t_tag';

	protected  $_shopSchoolTable='4t_shop_school';

	protected  $_shopSpeedOverallTable='4t_shopspeed_overall';

	protected $_pk='id';

	protected $_datasStruck=array('id','uid','schoolid','keyword','searchtype','createdate');

	public function add($search)
    {
        return $this->_add($search, true);
    }

	public function searchShopBySchoolId($keyword,$schoolId,$limit,$offset,$isPartner){
		$sql = $this->_bindSql('SELECT s.* FROM %s s LEFT JOIN %s a ON a.id=s.areaid WHERE (%s OR %s) AND a.schoolid = ? AND s.isactive=1 AND s.isaudit = 1 AND %s ORDER BY ordercount DESC %s',
                                                        $this->getTable($this->_shoptable),
                                                        $this->getTable($this->_schoolAreatable),
                                                        empty($keyword)?" ( 1 = 1) ":"`name` LIKE"." '".$keyword."'",
                                                        empty($keyword)?" ( 1 = 1) ":"`address` LIKE"." '".$keyword."'",
                                                        isset($isPartner)?"s.ispartner = ".$isPartner : " ( 1 = 1) ",
                                                        $this->sqlLimit($limit,$offset));
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($schoolId));
	}

	public function searchShopByAreaId($keyword,$aid,$limit,$offset){
		$sql = $this->_bindSql('SELECT * FROM %s WHERE areaid = ? AND %s AND isactive=1 ORDER BY ordercount DESC %s',
                                                        $this->getTable($this->_shoptable),
                                                        empty($keyword)?" ( 1 = 1) ":"`name` LIKE"." '".$keyword."'",
                                                        $this->sqlLimit($limit,$offset));
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($aid));
	}

	public function countShops ($keyword,$schoolId,$aid){
		$sql = $this->_bindSql('SELECT COUNT(DISTINCT s.id) FROM %s s LEFT JOIN %s a ON a.id=s.areaid WHERE (%s OR %s) AND %s AND a.schoolid = ? AND s.isactive=1 AND s.isaudit = 1',
                                                        $this->getTable($this->_shoptable),
                                                        $this->getTable($this->_schoolAreatable),
                                                        empty($keyword)?" ( 1 = 1) ":"s.`name` LIKE"." '".$keyword."'",
                                                        empty($keyword)?" ( 1 = 1) ":"s.`address` LIKE"." '".$keyword."'",
                                                        empty($aid)?" ( 1 = 1) ":"areaid=$aid");
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->getValue(array($schoolId));

	}


	public function searchMerchandiseBySchoolId($keyword,$schoolId,$orderBy='',$sort,$limit,$offset)
    {
		$sql = $this->_bindSql('SELECT m.*,s.name AS ShopName,s.phonenumber,s.packingprice,s.deliveryprice,s.openorder,s.startingprice FROM %s m LEFT JOIN %s s ON m.shopid=s.id LEFT JOIN %s a ON s.areaid=a.id WHERE a.schoolid = ?  and m.active = 1  AND %s AND s.isactive=1 AND s.isaudit = 1 and ORDER BY %s %s',
                                                                                         $this->getTable($this->_merchandisetable),
                                                                                         $this->getTable($this->_shoptable),
                                                                                         $this->getTable($this->_schoolAreatable),
                                                                                         empty($keyword)?" ( 1 = 1) ":"m.`name` LIKE"." '".$keyword."'",
                                                                                         empty($orderBy)?" m.createdate ":'m.'.$orderBy.' '.$sort,
                                                                                         $this->sqlLimit($limit, $offset));
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($schoolId));
	}

	public function searchMerchandiseByShopId($keyword,$shopId,$orderBy='',$sort,$limit,$offset)
    {
		$sql = $this->_bindSql('SELECT m.*,
									   s.name AS ShopName,
									   s.phonenumber,
									   s.packingprice,
									   s.deliveryprice,
									   s.openorder,
									   s.startingprice FROM %s m 
								LEFT JOIN %s s ON m.shopid=s.id 
								WHERE s.id = ? AND 
									  %s AND 
									  s.isactive=1 and 
									  s.isaudit = 1 and 
									  m.active =1 ORDER BY %s %s',
                $this->getTable($this->_merchandisetable),
             	$this->getTable($this->_shoptable),
             	empty($keyword)?" ( 1 = 1) ":"m.`name` LIKE"." '".$keyword."'",
             	empty($orderBy)?" m.createdate ":'m.'.$orderBy.' '.$sort,
             	$this->sqlLimit($limit, $offset));
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($shopId));
	}

	public function weixinMerchandiseByShopId($shopId)
    {
		$sql = $this->_bindSql('SELECT m.*,
									   s.name AS ShopName,
									   s.phonenumber,
									   s.packingprice,
									   s.deliveryprice,
									   s.openorder,
									   s.orderbegin,
									   s.orderend,
									   s.startingprice,
									   mt.name as tagname FROM %s m 
								LEFT JOIN %s s ON m.shopid = s.id
								LEFT JOIN %s mt ON m.tagid = mt.id 
								WHERE s.id = ? AND
									  s.isactive = 1 and 
									  s.isaudit = 1 and 
									  m.active = 1',
                $this->getTable($this->_merchandisetable),
             	$this->getTable($this->_shoptable),
             	$this->getTable($this->_tag));

		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($shopId));
	}

	public function searchMerchandiseByAreaId($keyword,$aid,$orderBy='',$sort,$limit,$offset){
		$sql = $this->_bindSql('SELECT m.*,s.name AS ShopName,s.phonenumber,s.packingprice,s.deliveryprice,s.openorder,s.startingprice FROM %s m LEFT JOIN %s s ON m.shopid=s.id and m.active =1 LEFT JOIN %s a ON s.areaid=a.id WHERE a.id=? and m.active = 1 AND %s AND s.isactive=1 and s.isaudit = 1 ORDER BY %s %s',
			                                                                             $this->getTable($this->_merchandisetable),
			                                                                             $this->getTable($this->_shoptable),
			                                                                             $this->getTable($this->_schoolAreatable),
                                                                                         empty($keyword)?" ( 1 = 1) ":"m.`name` LIKE"." '".$keyword."'",
                                                                                         empty($orderBy)?" m.createdate ":'m.'.$orderBy.' '.$sort,
			                                                                             $this->sqlLimit($limit, $offset));
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($aid));
	}

	public function countMerchandises($keyword,$schoolId,$aid){
		$sql=$this->_bindSql('SELECT COUNT(DISTINCT m.id) FROM %s m LEFT JOIN %s s ON m.shopid=s.id and m.active =1 LEFT JOIN %s a ON s.areaid=a.id WHERE m.active = 1 and  %s AND %s AND a.schoolid = ?',
			                                                                              $this->getTable($this->_merchandisetable),
			                                                                              $this->getTable($this->_shoptable),
			                                                                              $this->getTable($this->_schoolAreatable),
			                                                                              empty($aid)?" ( 1 = 1) ":"a.id=$aid",
                                                                                          empty($keyword)?" ( 1 = 1) ":"m.`name` LIKE"." '".$keyword."'");

		$smt = $this->getConnection()->createStatement($sql);

		return $smt->getValue(array($schoolId));

	}

	public function searchMerchandiseByFilter($keyword,$schoolid,$aid,$shopid,$orderBy='',$sort,$limit,$offset){
		$sql = $this->_bindSql('SELECT m.*,s.name AS ShopName,s.phonenumber,s.packingprice,s.deliveryprice,s.openorder,s.startingprice FROM %s m LEFT JOIN %s s ON m.shopid=s.id and m.active =1 LEFT JOIN %s a ON s.areaid=a.id WHERE a.schoolid = ?  and m.active = 1  and  %s AND s.isactive=1 and s.isaudit = 1 and %s and %s ORDER BY  %s %s',
			                                                                             $this->getTable($this->_merchandisetable),
			                                                                             $this->getTable($this->_shoptable),
			                                                                             $this->getTable($this->_schoolAreatable),
                                                                                         empty($keyword)?" ( 1 = 1) ":"m.`name` LIKE"." '".$keyword."'",
                                                                                         $shopid <=0 ? " ( 1=1 ) ":"m.shopid = $shopid",
                                                                                         $aid <=0 ? " ( 1=1 ) ":"a.id = $aid ",
                                                                                         empty($orderBy)?" m.createdate ":'m.'.$orderBy.' '.$sort,
			                                                                             $this->sqlLimit($limit, $offset));
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($schoolid));
	}

	public function countMerchandisesByFilter($keyword,$schoolid,$aid,$shopid){
		$sql=$this->_bindSql('SELECT COUNT(DISTINCT m.id) FROM %s m LEFT JOIN %s s ON m.shopid=s.id and m.active =1  LEFT JOIN %s a ON s.areaid=a.id WHERE a.schoolid = ?  and m.active = 1  and  %s and %s and %s ',
			                                                                              $this->getTable($this->_merchandisetable),
			                                                                              $this->getTable($this->_shoptable),
			                                                                              $this->getTable($this->_schoolAreatable),
			                                                                              $aid <=0 ?" ( 1 = 1) ":"a.id=$aid",
			                                                                              $shopid <=0 ? " ( 1=1 ) ":"m.shopid = $shopid",
                                                                                          empty($keyword)?" ( 1 = 1) ":"m.`name` LIKE"." '".$keyword."'");

		$smt = $this->getConnection()->createStatement($sql);
		return $smt->getValue(array($schoolid));
	}

	public function searchMerchandiseBySysTagId($schoolid,$aid,$tid,$orderBy='',$sort,$limit,$offset)
    {
		$sql = $this->_bindSql('SELECT m.*,s.name AS ShopName,s.phonenumber,s.packingprice,s.deliveryprice,s.openorder,s.startingprice FROM %s m 
			                                                           LEFT JOIN %s s ON m.shopid=s.id 
			                                                           LEFT JOIN %s a ON s.areaid=a.id
			                                                           LEFT JOIN %s mt ON m.id=mt.mid
			                                                           WHERE a.schoolid = ?  
			                                                           AND mt.tid=?
			                                                           AND m.active = 1  
			                                                           AND s.isactive = 1
			                                                           AND s.isaudit = 1 
			                                                           AND %s
			                                                           ORDER BY %s %s',
                                                                       $this->getTable($this->_merchandisetable),
                                                                       $this->getTable($this->_shoptable),
                                                                       $this->getTable($this->_schoolAreatable),
                                                                       $this->getTable($this->_merchandisetagtable),
                                                                       $aid <=0 ?" ( 1 = 1) ":"a.id=$aid",
                                                                       empty($orderBy)?" m.createdate ":'m.'.$orderBy.' '.$sort,
                                                                       $this->sqlLimit($limit, $offset));
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($schoolid,$tid));
	}


	public function countMerchandisesByArgs($schoolid,$searchArgs)
	{
		$keyword = empty($searchArgs['keyword'])?'':$searchArgs['keyword'];
		//$aid = empty($searchArgs['aid'])?0:$searchArgs['aid'];
        $ifdeliver = empty($searchArgs['ifdeliver'])?'':$searchArgs['ifdeliver'];
        $baseprice = empty($searchArgs['baseprice'])?0:$searchArgs['baseprice'];
        $ifdeliverfee = empty($searchArgs['ifdeliverfee'])?'':$searchArgs['ifdeliverfee'];
        $type = empty($searchArgs['type'])?'m':$searchArgs['type'];
        $tagid = empty($searchArgs['tagid'])?0:$searchArgs['tagid'];
        $shopid = empty($searchArgs['shopid'])?0:$searchArgs['shopid'];

		$sql = $this->_bindSql("SELECT COUNT(DISTINCT m.id)
								FROM %s ss
								JOIN %s m ON ss.shopId = m.shopid 
								JOIN %s s ON m.shopid = s.id and m.active = 1 
								LEFT JOIN %s mtag on mtag.mid = m.id
								LEFT JOIN %s shspeed ON s.id = shspeed.shopid
								WHERE ss.schoolid = ? and 
									  s.isactive =1 and 
									  s.isaudit = 1 and 
									  m.active = 1  and  
									  %s and 
									  %s and 
									  %s and 
									  %s and 
									  %s and %s",
								$this->getTable($this->_shopSchoolTable),
			                    $this->getTable($this->_merchandisetable),
			                    $this->getTable($this->_shoptable),
			                    $this->getTable($this->_merchandisetagtable),
			                    $this->getTable($this->_shopSpeedOverallTable),
			                    $shopid <=0 ? " ( 1=1 ) ":"m.shopid = $shopid",
			                    $this->getIfDelivery($ifdeliver),
			                    $this->getIfDeliveryFee($ifdeliverfee),
			                    $tagid <= 0 ? " (1=1) ":"mtag.tid = $tagid",
			                    $this->getBasePrice($baseprice),
                                empty($keyword)?" ( 1 = 1) ":"m.`name` LIKE"." '".$keyword."'");
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->getValue(array($schoolid));
	}

	public function searchMerchandiseIDsByArgs($schoolid,$searchArgs,$limit,$offset)
	{
		$keyword = empty($searchArgs['keyword'])?'':$searchArgs['keyword'];
		//$aid = empty($searchArgs['aid'])?0:$searchArgs['aid'];
        $ifdeliver = empty($searchArgs['ifdeliver'])?'':$searchArgs['ifdeliver'];
        $baseprice = empty($searchArgs['baseprice'])?0:$searchArgs['baseprice'];
        $ifdeliverfee = empty($searchArgs['ifdeliverfee'])?'':$searchArgs['ifdeliverfee'];
        $type = empty($searchArgs['type'])?'m':$searchArgs['type'];
        $tagid = empty($searchArgs['tagid'])?0:$searchArgs['tagid'];
        $shopid = empty($searchArgs['shopid'])?0:$searchArgs['shopid'];
        $sort = empty($searchArgs['sort'])?'ASC':$searchArgs['sort'];
        $orderBy = empty($searchArgs['orderby'])?'':$searchArgs['orderby'];

  		$sql=$this->_bindSql("SELECT DISTINCT m.id, shspeed.averagespeed,shspeed.overallcount,
                                if(CURTIME() > s.orderbegin && 
                                    CURTIME() < s.orderend, 1, 0) AS otherisopen
								FROM %s ss
								JOIN %s m ON ss.shopId = m.shopId 
								JOIN %s s ON m.shopid=s.id and m.active =1 
								LEFT JOIN %s mtag on mtag.mid = m.id
								LEFT JOIN %s shspeed ON s.id = shspeed.shopid
								WHERE ss.schoolid = ? and 
									  s.isactive = 1 and 
									  s.isaudit = 1 and 
									  m.active = 1  and  
									  %s and 
									  %s and 
									  %s and 
									  %s and 
									  %s and 
									  %s order by %s %s",
								$this->getTable($this->_shopSchoolTable),	  
			                    $this->getTable($this->_merchandisetable),
			                    $this->getTable($this->_shoptable),
			                    $this->getTable($this->_merchandisetagtable),
			                    $this->getTable($this->_shopSpeedOverallTable),
			                    $shopid <=0 ? " ( 1=1 ) ":"m.shopid = $shopid",
			                    $this->getIfDelivery($ifdeliver),
			                    $this->getIfDeliveryFee($ifdeliverfee),
			                    $tagid <= 0 ? " (1=1) ":"mtag.tid = $tagid",
			                    $this->getBasePrice($baseprice),
                                empty($keyword)?" ( 1 = 1) ":"m.`name` LIKE"." '".$keyword."'",
                                " s.isshopopen DESC, s.openorder DESC, s.ifrebate DESC, isnull(shspeed.averagespeed), shspeed.averagespeed ASC ",
                                $this->sqlLimit($limit, $offset));

		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($schoolid));
	}

	public function searchMerchandisesByArgs($schoolid,$searchArgs,$limit,$offset)
	{
		$mIdList = $this->searchMerchandiseIDsByArgs($schoolid,$searchArgs,$limit,$offset);
		$idQuery = " ( -1 , ";
		foreach ($mIdList as $key => $value) {
			$idQuery = $idQuery.$value['id'].",";
		}

		$idQuery = $idQuery." -1) ";

		$sort = empty($searchArgs['sort'])?'ASC':$searchArgs['sort'];
        $orderBy = empty($searchArgs['orderby'])?'':$searchArgs['orderby'];

		$sql = $this->_bindSql("SELECT m.*, shspeed.averagespeed,shspeed.overallcount,
                                if(CURTIME() > s.orderbegin && 
                                    CURTIME() < s.orderend, 1, 0) AS otherisopen,
									   s.name AS ShopName,
									   s.phonenumber, 
									   s.isshopopen, 
									   s.packingprice,
									   s.contactnumber,
									   s.deliveryprice,
									   s.openorder,
									   s.startingprice,
									   s.orderbegin, 
									   s.orderend, 
									   s.hasterminal
								FROM %s m 
                               	JOIN %s s ON m.shopid=s.id
                               	LEFT JOIN %s shspeed ON s.id = shspeed.shopid
                                WHERE m.id in %s order by %s",
                                $this->getTable($this->_merchandisetable),
                                $this->getTable($this->_shoptable),
                                $this->getTable($this->_shopSpeedOverallTable),
                                $idQuery,
                                " s.isshopopen DESC, s.openorder DESC, s.ifrebate DESC, isnull(shspeed.averagespeed), shspeed.averagespeed ASC ");
		
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($schoolid));

	}

	public function countShopsByArgs($schoolid,$searchArgs)
	{
		$keyword = empty($searchArgs['keyword'])?'':$searchArgs['keyword'];
		$aid = empty($searchArgs['aid'])?0:$searchArgs['aid'];
        $ifdeliver = empty($searchArgs['ifdeliver'])?'':$searchArgs['ifdeliver'];
        $baseprice = empty($searchArgs['baseprice'])?0:$searchArgs['baseprice'];
        $ifdeliverfee = empty($searchArgs['ifdeliverfee'])?'':$searchArgs['ifdeliverfee'];
        $type = empty($searchArgs['type'])?'m':$searchArgs['type'];
        $tagid = empty($searchArgs['tagid'])?0:$searchArgs['tagid'];
        $shopid = empty($searchArgs['shopid'])?0:$searchArgs['shopid'];

		$sql=$this->_bindSql("SELECT COUNT(DISTINCT s.id) 
								FROM %s m 
								JOIN %s s ON m.shopid=s.id and m.active =1 
								JOIN %s a ON s.areaid=a.id
								LEFT JOIN %s mtag on mtag.mid = m.id
								LEFT JOIN %s shspeed on s.id = shspeed.shopid
								WHERE a.schoolid = ? and s.isactive =1 and s.isaudit = 1 and m.active = 1  and  %s and %s and %s and %s and %s and %s and %s order by %s ",
			                    $this->getTable($this->_merchandisetable),
			                    $this->getTable($this->_shoptable),
			                    $this->getTable($this->_schoolAreatable),
			                    $this->getTable($this->_merchandisetagtable),
			                    $this->getTable($this->_shopSpeedOverallTable),
			                    $aid <=0 ?" ( 1 = 1) ":"a.id=$aid",
			                    $shopid <=0 ? " ( 1=1 ) ":"m.shopid = $shopid",
			                    $this->getIfDelivery($ifdeliver),
			                    $this->getIfDeliveryFee($ifdeliverfee),
			                    $tagid <= 0 ? " (1=1) ":"mtag.tid = $tagid",
			                    $this->getBasePrice($baseprice),
                                empty($keyword)?" ( 1 = 1) ":"s.`name` LIKE"." '".$keyword."'",
                                " s.isshopopen DESC, s.openorder DESC, s.ifrebate DESC, isnull(shspeed.averagespeed), shspeed.averagespeed ASC ");
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->getValue(array($schoolid));
	}

	public function searchShopIDsByArgs($schoolid,$searchArgs,$limit,$offset)
	{
		$keyword = empty($searchArgs['keyword'])?'':$searchArgs['keyword'];
		$aid = empty($searchArgs['aid'])?0:$searchArgs['aid'];
        $ifdeliver = empty($searchArgs['ifdeliver'])?'':$searchArgs['ifdeliver'];
        $baseprice = empty($searchArgs['baseprice'])?0:$searchArgs['baseprice'];
        $ifdeliverfee = empty($searchArgs['ifdeliverfee'])?'':$searchArgs['ifdeliverfee'];
        $type = empty($searchArgs['type'])?'m':$searchArgs['type'];
        $tagid = empty($searchArgs['tagid'])?0:$searchArgs['tagid'];
        $shopid = empty($searchArgs['shopid'])?0:$searchArgs['shopid'];
        $sort = empty($searchArgs['sort'])?'DESC':$searchArgs['sort'];
        $orderBy = empty($searchArgs['orderby'])?'':$searchArgs['orderby'];

  		$sql = $this->_bindSql("SELECT DISTINCT s.id,s.name, shspeed.averagespeed,shspeed.overallcount, if(CURTIME() > s.orderbegin && 
                                    CURTIME() < s.orderend, 1, 0) AS otherisopen 								
							  FROM %s ss 
							  JOIN %s m ON ss.shopId = m.shopid
							  JOIN %s s ON m.shopid = s.id and m.active = 1 
							  LEFT JOIN %s mtag on mtag.mid = m.id
							  LEFT JOIN %s shspeed on s.id = shspeed.shopid
							  WHERE ss.schoolid = ? and s.isactive = 1 and s.isaudit = 1 and m.active = 1  and  %s and %s and %s and %s and %s and %s and %s order by %s %s %s",
			                  $this->getTable($this->_shopSchoolTable),
			                  $this->getTable($this->_merchandisetable),
			                  $this->getTable($this->_shoptable),
			                  $this->getTable($this->_merchandisetagtable),
			                  $this->getTable($this->_shopSpeedOverallTable),
			                  $aid <=0 ?" ( 1 = 1) ":"a.id=$aid",
			                  $shopid <=0 ? " ( 1=1 ) ":"m.shopid = $shopid",
			                  $this->getIfDelivery($ifdeliver),
			                  $this->getIfDeliveryFee($ifdeliverfee),
			                  $tagid <= 0 ? " (1=1) ":"mtag.tid = $tagid",
			                  $this->getBasePrice($baseprice),
                              empty($keyword)?" ( 1 = 1) ":"s.`name` LIKE"." '".$keyword."'",
                              "  ",
                              ' s.isshopopen DESC, s.openorder DESC, s.ifrebate DESC, isnull(shspeed.averagespeed), shspeed.averagespeed ASC ',
                              $this->sqlLimit($limit, $offset));
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($schoolid));
	}

	public function searchShopsByArgs($schoolid,$searchArgs,$limit,$offset)
	{
		$sIdList = $this->searchShopIDsByArgs($schoolid,$searchArgs,$limit,$offset);
		$idQuery = " ( -1 , ";
		foreach ($sIdList as $key => $value) {
			$idQuery = $idQuery.$value['id'].",";
		}

		$idQuery = $idQuery." -1) ";

		$sort = empty($searchArgs['sort'])?'DESC':$searchArgs['sort'];
        $orderBy = empty($searchArgs['orderby'])?'':$searchArgs['orderby'];

		$sql = $this->_bindSql("SELECT s.*, shspeed.averagespeed,shspeed.overallcount, if(CURTIME() > s.orderbegin && 
                                    CURTIME() < s.orderend, 1, 0) AS otherisopen FROM %s s
								LEFT JOIN %s shspeed on s.id = shspeed.shopid
                               WHERE s.id in %s order by %s %s",
                               $this->getTable($this->_shoptable),
                               $this->getTable($this->_shopSpeedOverallTable),
                               $idQuery,
                                "  ",
                                ' s.isshopopen DESC, s.openorder DESC, s.ifrebate DESC, isnull(shspeed.averagespeed), shspeed.averagespeed ASC ');
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($schoolid));

	}


	private function getIfDelivery($ifdeliver)
	{
		if(empty($ifdeliver))
			return " (1 = 1)";

		if($ifdeliver == 'y')
			return " s.openorder = 1";
		else
			return " s.openorder = 0";

	}

	private function getIfDeliveryFee($ifdeliverfee)
	{
		if(empty($ifdeliverfee))
			return " (1 = 1)";

		if($ifdeliverfee == 'y')
			return " s.deliveryprice > 0";
		else
			return " s.deliveryprice = 0";

	}

	private function getBasePrice($baseprice)
	{
		if(empty($baseprice))
			return " (1= 1) ";

		$priceList = explode("-",$baseprice);

		if(count($priceList) == 1)
			return " ( s.startingprice = ".$priceList[0].")";
		else
			return " (s.startingprice >= ".$priceList[0]." and s.startingprice <= ".$priceList[1].")";
	}
}
?>
