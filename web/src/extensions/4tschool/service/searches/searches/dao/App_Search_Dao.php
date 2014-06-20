<?php
defined('WEKIT_VERSION') or exit(403);

class App_Search_Dao extends PwBaseDao{

	protected $_table='';

	protected $_shoptable='4t_shop';

	protected $_merchandisetable='4t_merchandise';

	protected $_schoolAreatable='4t_school_area';

	protected $_pk='id';

	protected $_datasStruck=array();

	public function searchShopBySchoolId($keyword,$schoolId,$limit,$offset){
		$sql = $this->_bindSql('SELECT s.* FROM %s s LEFT JOIN %s a ON a.id=s.areaid WHERE (%s OR %s) AND a.schoolid = ? AND s.isactive=1 ORDER BY ordercount DESC %s',
                                                        $this->getTable($this->_shoptable),
                                                        $this->getTable($this->_schoolAreatable),
                                                        empty($keyword)?" ( 1 = 1) ":"`name` LIKE"." '".$keyword."'",
                                                        empty($keyword)?" ( 1 = 1) ":"`address` LIKE"." '".$keyword."'",
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
		$sql = $this->_bindSql('SELECT COUNT(DISTINCT s.id) FROM %s s LEFT JOIN %s a ON a.id=s.areaid WHERE (%s OR %s) AND %s AND a.schoolid = ? AND s.isactive=1',
                                                        $this->getTable($this->_shoptable),
                                                        $this->getTable($this->_schoolAreatable),
                                                        empty($keyword)?" ( 1 = 1) ":"s.`name` LIKE"." '".$keyword."'",
                                                        empty($keyword)?" ( 1 = 1) ":"s.`address` LIKE"." '".$keyword."'",
                                                        empty($aid)?" ( 1 = 1) ":"areaid=$aid");
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->getValue(array($schoolId));

	}

	public function searchMerchandiseByShopId($keyword,$shopId,$orderBy='',$sort,$limit,$offset)
    {
		$sql = $this->_bindSql('SELECT m.*,s.name AS ShopName FROM %s m LEFT JOIN %s s ON m.shopid=s.id WHERE s.shopid = ? AND %s AND s.isactive=1 ORDER BY %s %s',
                                                                                         $this->getTable($this->_merchandisetable),
                                                                                         $this->getTable($this->_shoptable),
                                                                                         empty($keyword)?" ( 1 = 1) ":"m.`name` LIKE"." '".$keyword."'",
                                                                                         empty($orderBy)?" m.createdate ":'m.'.$orderBy.' '.$sort,
                                                                                         $this->sqlLimit($limit, $offset));
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($shopId));
	}

	public function searchMerchandiseBySchoolId($keyword,$schoolId,$orderBy='',$sort,$limit,$offset)
    {
		$sql = $this->_bindSql('SELECT m.*,s.name AS ShopName FROM %s m LEFT JOIN %s s ON m.shopid=s.id LEFT JOIN %s a ON s.areaid=a.id WHERE a.schoolid = ? AND %s AND s.isactive=1 ORDER BY %s %s',
                                                                                         $this->getTable($this->_merchandisetable),
                                                                                         $this->getTable($this->_shoptable),
                                                                                         $this->getTable($this->_schoolAreatable),
                                                                                         empty($keyword)?" ( 1 = 1) ":"m.`name` LIKE"." '".$keyword."'",
                                                                                         empty($orderBy)?" m.createdate ":'m.'.$orderBy.' '.$sort,
                                                                                         $this->sqlLimit($limit, $offset));
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($schoolId));
	}

	public function searchMerchandiseByAreaId($keyword,$aid,$orderBy='',$sort,$limit,$offset){
		$sql = $this->_bindSql('SELECT m.*,s.name AS ShopName FROM %s m LEFT JOIN %s s ON m.shopid=s.id LEFT JOIN %s a ON s.areaid=a.id WHERE a.id=? AND %s AND s.isactive=1 ORDER BY %s %s',
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
		$sql=$this->_bindSql('SELECT COUNT(DISTINCT m.id) FROM %s m LEFT JOIN %s s ON m.shopid=s.id LEFT JOIN %s a ON s.areaid=a.id WHERE %s AND %s AND a.schoolid = ?',
			                                                                              $this->getTable($this->_merchandisetable),
			                                                                              $this->getTable($this->_shoptable),
			                                                                              $this->getTable($this->_schoolAreatable),
			                                                                              empty($aid)?" ( 1 = 1) ":"a.id=$aid",
                                                                                          empty($keyword)?" ( 1 = 1) ":"m.`name` LIKE"." '".$keyword."'");

		$smt = $this->getConnection()->createStatement($sql);

		return $smt->getValue(array($schoolId));

	}

	public function searchMerchandiseByFilter($keyword,$schoolid,$aid,$shopid,$orderBy='',$sort,$limit,$offset){
		$sql = $this->_bindSql('SELECT m.*,s.name AS ShopName, s.packingprice FROM %s m LEFT JOIN %s s ON m.shopid=s.id LEFT JOIN %s a ON s.areaid=a.id WHERE a.schoolid = ? and  %s AND s.isactive=1 and %s and %s ORDER BY  %s %s',
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
		$sql=$this->_bindSql('SELECT COUNT(DISTINCT m.id) FROM %s m LEFT JOIN %s s ON m.shopid=s.id LEFT JOIN %s a ON s.areaid=a.id WHERE a.schoolid = ? and  %s and %s and %s ',
			                                                                              $this->getTable($this->_merchandisetable),
			                                                                              $this->getTable($this->_shoptable),
			                                                                              $this->getTable($this->_schoolAreatable),
			                                                                              $aid <=0 ?" ( 1 = 1) ":"a.id=$aid",
			                                                                              $shopid <=0 ? " ( 1=1 ) ":"m.shopid = $shopid",
                                                                                          empty($keyword)?" ( 1 = 1) ":"m.`name` LIKE"." '".$keyword."'");

		$smt = $this->getConnection()->createStatement($sql);
		return $smt->getValue(array($schoolid));

	}
}
?>
