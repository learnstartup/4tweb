<?php
defined('WEKIT_VERSION') or exit(403);
/**
 * App_SchoolFavorite_Dao - dao
 *
 * @author yang <yangyan7777@gmail.com>
 * @copyright http://www.fenxiangyo.net
 * @license http://www.fenxiangyo.net
 */
class App_MyFavorite_Dao extends PwBaseDao {
	
	/**
	 * table name
	 */
	protected $_table = '4t_my_favorite';


	/**
	* shop table
	*
	*/
	protected $_shopTable = '4t_shop';

	/**
	* merchandise table
	*
	*/
	protected $_merchandiseTable = '4t_merchandise';

	/*
	*
	*/
	protected $_areaTable = '4t_school_area';
	
	/**
	 * primary key
	 */
	protected $_pk = 'id';
	/**
	 * table fields
	 */
	protected $_dataStruct = array('id', 'shopid','userid','merchandiseid','createdate');
	
	
	public function getMyFavoriteShops($schoolid, $userid, $limit, $offset)
	{
		$sql = $this->_bindSql('SELECT DISTINCT mf.shopid, 
									   mf.userid, 
									   mf.shopid,
									   s.name, 
									   s.address,
									   s.phonenumber,
									   s.contactnumber,
									   s.orderbegin,
									   s.orderend,
									   ar.areaname,
									   s.imageurl from %s mf 
									   INNER JOIN %s s on mf.shopid = s.id 
									   JOIN %s ar on ar.id = s.areaid 
						where ar.schoolid = ? and s.isactive = 1 and mf.userid = ? %s',
						$this->getTable(),
						$this->getTable($this->_shopTable),
						$this->getTable($this->_areaTable),
						$this->sqlLimit($offset, $limit));

		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($schoolid, $userid));
	}

	public function countMyFavoriteShops($schoolid, $userid)
	{
		$sql = $this->_bindSql('SELECT DISTINCT mf.shopid, 
									   mf.userid, 
									   mf.shopid,
									   s.name, 
									   s.address,
									   s.phonenumber,
									   s.contactnumber,
									   s.orderbegin,
									   s.orderend,
									   ar.areaname,
									   s.imageurl from %s mf 
									   INNER JOIN %s s on mf.shopid = s.id 
									   JOIN %s ar on ar.id = s.areaid 
						where ar.schoolid = '.$schoolid.' and s.isactive = 1 and mf.userid = '.$userid.'',
						$this->getTable(),
						$this->getTable($this->_shopTable),
						$this->getTable($this->_areaTable));

		$smt = $this->getConnection()->createStatement($sql);
		$count = $smt->queryAll();
		$count = count($count);
		return $count; 
	}

	public function getMyFavoriteItemByShop($userid, $shopid, $limit, $offset)
	{
		$sql = $this->_bindSql('SELECT mf.*,m.name,m.imageurl from %s mf 
								INNER JOIN %s s on mf.shopid = s.id 
								JOIN %s m on m.id = mf.merchandiseid 
								where mf.userid = ? and mf.shopid = ? %s',
						$this->getTable(),
						$this->getTable($this->_shopTable),
						$this->getTable($this->_merchandiseTable),
						$this->sqlLimit($offset, $limit));
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($userid,$shopid));
	}

	public function getOpenMyFavoriteItemByShop($userid, $limit, $offset)
	{
		$sql = $this->_bindSql('SELECT mf.*, s.name, s.isshopopen, m.*, s.hasterminal, s.name as shopname, s.phonenumber, s.contactnumber, s.startingprice, s.openorder from %s mf 
								INNER JOIN %s s on mf.shopid = s.id 
								JOIN %s m on m.id = mf.merchandiseid 
								where mf.userid = ? %s',
						$this->getTable(),
						$this->getTable($this->_shopTable),
						$this->getTable($this->_merchandiseTable),
						$this->sqlLimit($offset, $limit));
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($userid));
	}

	public function getMyFavoriteMIdByShop($userid)
	{
		$sql = $this->_bindSql('SELECT mf.merchandiseid from %s mf 
								INNER JOIN %s s on mf.shopid = s.id 
								JOIN %s m on m.id = mf.merchandiseid 
								where mf.userid = ?',
						$this->getTable(),
						$this->getTable($this->_shopTable),
						$this->getTable($this->_merchandiseTable));
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($userid));
	}

	public function countMyFavoriteItemByShop($userid, $shopid)
	{
		$sql = $this->_bindSql('SELECT COUNT(*) from %s mf 
								INNER JOIN %s s on mf.shopid = s.id 
								JOIN %s m on m.id = mf.merchandiseid 
								where mf.userid = '.$userid.' and mf.shopid = '.$shopid.'',
						$this->getTable(),
						$this->getTable($this->_shopTable),
						$this->getTable($this->_merchandiseTable));
		
		$smt = $this->getConnection()->query($sql);
        return $smt->fetchColumn(); 
	}

	public function countOpenMyFavoriteItemByShop($userid)
	{
		$sql = $this->_bindSql('SELECT COUNT(*) from %s mf 
								INNER JOIN %s s on mf.shopid = s.id 
								JOIN %s m on m.id = mf.merchandiseid 
								where mf.userid = '.$userid.'',
						$this->getTable(),
						$this->getTable($this->_shopTable),
						$this->getTable($this->_merchandiseTable));
		
		$smt = $this->getConnection()->query($sql);
        return $smt->fetchColumn(); 
	}

	public function checkIfExists($userid,$shopid,$merchandiseid)
	{ 
		//check if merchandise id is empty or not, if yes, this shall not be an filter
		if(empty($merchandiseid))
		{
			$merchandiseid = "s.merchandiseid";
		}
		$sql = $this->_bindSql('SELECT count(*) as total from %s s WHERE s.userid = ? and s.shopid = ? and s.merchandiseid =?',
						$this->getTable(),
						$this->sqlLimit($limit, $offset));
		$smt = $this->getConnection()->createStatement($sql);
		$result = $smt->queryAll(array($userid,$shopid,$merchandiseid));	
		return ($result[0]['total'] > 0 );
	}

	public function getMyFavoriteShopItems($userid,$shopid)
	{
		$sql = $this->_bindSql('SELECT * from %s where userid = ? and shopid =? ',
						$this->getTable(),
						$this->sqlLimit($limit, $offset));
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($userid,$shopid));	
	}

	public function deleteFavorite($userid,$shopid)
	{
		$sql = $this->_bindSql('delete from %s where userid = ? and shopid = ? ',
						$this->getTable());
		$smt = $this->getConnection()->createStatement($sql);
		$smt->execute(array($userid,$shopid));
	}

	public function deleteFavoriteM($userid, $mid)
	{
		$sql = $this->_bindSql('delete from %s where userid = ? and merchandiseid = ? ',
						$this->getTable());
		$smt = $this->getConnection()->createStatement($sql);
		$smt->execute(array($userid,$mid));
	}

	public function add($fields) {
		return $this->_add($fields, true);
	}

	public function delete($id) {
		return $this->_delete($id);
	}

}

?>