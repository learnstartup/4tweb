<?php
defined('WEKIT_VERSION') or exit(403);
/**
 * App_SchoolFavorite_Dao - dao
 *
 * @author yang <yangyan7777@gmail.com>
 * @copyright http://www.fenxiangyo.net
 * @license http://www.fenxiangyo.net
 */
class App_MerComment_Dao extends PwBaseDao {
	
	/**
	 * table name
	 */
	protected $_table = '4t_m_comment';

	/**
	 * table name
	 */
	protected $_mOverallTable = '4t_m_overallcomment';


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

	/**
	* order table
	*
	*/
	protected $_orderTable = '4t_order';

	/**
	* order item table
	*
	*/
	protected $_orderItemTable = '4t_order_item';

	/**
	* user table
	*
	*/
	protected $_userTable = 'user';


	/**
	 * primary key
	 */
	protected $_pk = 'id';
	/**
	 * table fields
	 */
	protected $_dataStruct = array('id','userid','mid','orderid','comment','environmentscore','servicescore','tastescore');
	

	public function checkIfExists($userid,$orderid,$merchandiseid)
	{ 
		$sql = $this->_bindSql('SELECT count(*) as total from %s mc 
								WHERE mc.userid = ? and mc.orderid = ? and mc.mid = ?',
						$this->getTable(),
						$this->sqlLimit($limit, $offset));
		$smt = $this->getConnection()->createStatement($sql);
		$result = $smt->queryAll(array($userid,$orderid,$merchandiseid));
		return ($result[0]['total'] > 0 );
	}

	public function getMyUnComment($schoolid,$userid,$limit,$offset)
	{
		$sql = $this->_bindSql('SELECT oi.*,
									   o.ordernumber,
									   m.name as mname,
									   m.imageurl,
									   m.commentcount,
									   shop.openorder,
                                       shop.isshopopen,
                                       shop.orderbegin,
                                       shop.orderend,
                                       shop.hasterminal,
                                       shop.isshopopen,
									   o.orderdate,
									   o.shopid FROM %s oi 
								INNER JOIN %s o on o.id = oi.orderid 
								INNER JOIN %s m on m.id = oi.merchandiseid
								INNER JOIN %s shop on shop.id = m.shopid   
								where oi.commented = 0 
									  and oi.valid =1 
									  and oi.status = 5 
									  and o.userid = ? 
									  and o.schoolid = ? order by oi.id DESC %s',
						$this->getTable($this->_orderItemTable),
						$this->getTable($this->_orderTable),
						$this->getTable($this->_merchandiseTable),
						$this->getTable($this->_shopTable),
						$this->sqlLimit($limit, $offset));
		$smt = $this->getConnection()->createStatement($sql);
		$result = $smt->queryAll(array($userid,$schoolid));	
		return $result;
	}

	public function getCountOfMyUnComment($schoolid,$userid)
	{
		$sql = $this->_bindSql('SELECT count(oi.id) as totalCount FROM %s oi INNER JOIN %s o on o.id = oi.orderid where oi.commented = 0 and oi.valid =1 and oi.status = 5  and o.userid = ? and o.schoolid=?',
						$this->getTable($this->_orderItemTable),
						$this->getTable($this->_orderTable),
						$this->sqlLimit($limit, $offset));
		$smt = $this->getConnection()->createStatement($sql);
		$result = $smt->queryAll(array($userid,$schoolid));	
		return $result[0]['totalCount'];
	}

	public function getMyComment($schoolid,$userid,$limit,$offset)
	{
		$sql = $this->_bindSql('SELECT oi.*,
									   o.ordernumber,
									   m.name as mname,
									   m.imageurl,
									   shop.openorder,
                                       shop.isshopopen,
                                       shop.orderbegin,
                                       shop.orderend,
                                       shop.hasterminal,
                                       shop.isshopopen,
									   m.commentcount,
									   o.orderdate,
									   o.shopid FROM %s oi 
								INNER JOIN %s o on o.id = oi.orderid 
								INNER JOIN %s m on m.id = oi.merchandiseid
								INNER JOIN %s shop on shop.id = m.shopid  
								where oi.commented = 1 and 
									  oi.valid = 1 and 
									  oi.status = 5 and 
									  o.userid = ? and 
									  o.schoolid = ? order by oi.id DESC %s',
						$this->getTable($this->_orderItemTable),
						$this->getTable($this->_orderTable),
						$this->getTable($this->_merchandiseTable),
						$this->getTable($this->_shopTable),
						$this->sqlLimit($limit, $offset));
		$smt = $this->getConnection()->createStatement($sql);
		$result = $smt->queryAll(array($userid,$schoolid));	
		return $result;
	}

	public function getCountOfMyComment($schoolid,$userid)
	{
		$sql = $this->_bindSql('SELECT count(oi.id) as totalCount FROM %s oi INNER JOIN %s o on o.id = oi.orderid where oi.commented = 1 and oi.valid =1 and oi.status = 5  and o.userid = ? and o.schoolid=?',
						$this->getTable($this->_orderItemTable),
						$this->getTable($this->_orderTable),
						$this->sqlLimit($limit, $offset));
		$smt = $this->getConnection()->createStatement($sql);
		$result = $smt->queryAll(array($userid,$schoolid));	
		return $result[0]['totalCount'];
	}

	public function getCountOfMcomment($mid)
	{
		$sql = $this->_bindSql('SELECT count(mid) as totalCount FROM %s where mid =?',
						$this->getTable());
		$smt = $this->getConnection()->createStatement($sql);
		$result = $smt->queryAll(array($mid));	
		return $result[0]['totalCount'];
	}

	public function getMcommentMessage($mid)
	{
		$sql = $this->_bindSql('SELECT c.servicescore, 
									   c.tastescore FROM %s AS c WHERE c.mid = ?',
									   $this->getTable());
		$smt = $this->getConnection()->createStatement($sql);
		$result = $smt->queryAll(array($mid));
		return $result;
	}

	public function getMcomment($mid,$limit,$offset)
	{
		$sql = $this->_bindSql('SELECT mc.*, u.username FROM %s mc 
								INNER JOIN %s u on 
								mc.userid = u.uid 
								where mc.mid =? order by mc.id DESC %s',
						$this->getTable(),
						$this->getTable($this->_userTable),
						$this->sqlLimit($limit, $offset));
		$smt = $this->getConnection()->createStatement($sql);
		$result = $smt->queryAll(array($mid));	
		return $result;
	}

	public function getMOverall($shopid)
	{
		$sql = $this->_bindSql('SELECT * FROM %s where shopid =?',
						$this->getTable($this->_mOverallTable));
		$smt = $this->getConnection()->createStatement($sql);
		$result = $smt->getOne(array($shopid));	
		return $result;
	}

	public function add($fields) {
		return $this->_add($fields, true);
	}

	public function delete($id) {
		return $this->_delete($id);
	}

}

?>