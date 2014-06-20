<?php
defined('WEKIT_VERSION') or exit(403);

class App_MyOrder_Dao extends PwBaseDao {
	
	/**
	 * table name
	 */
	protected $_table = '4t_order';

	/**
	 * primary key
	 */
	protected $_pk = 'id';

	/*
	* user table
	*/
	protected $_userTable = "user";

	/*
	* order item table
	*/
	protected $_orderItemTable = "4t_order_item";

	/*
	* school area table
	*/
	protected $_school_areaTable = "4t_school_area";

	/*
	* shop table
	*/
	protected $_shop = "4t_shop";

	protected $_wind_school_table = 'windid_school';

	/**
	 * table fields
	 */
	protected $_dataStruct = array('id', 'userid', 'ordernumber','schoolid','shopid','orderdate','ordermoney','rebatefromshop','shopreturn','status','paymethod','delivermethod','to','towho','tomobile','preorder','preorderat','deliverby','delivercontact','savingtotal','note','sequence','firstorder','estimatetime','estimatedeliveryat','lastUpdated','source', 'isordertouser','deservedpointcoin','ifusersigninorder','firstordersince0331');
	

	public function updateOrderResponsible($orderid, $deliveryuserid)
	{
		$sql = $this->_bindSql("UPDATE %s set deliverby = %s where id = %s",
				$this->getTable(),
				$deliveryuserid,
				$orderid
			);
		$smt = $this->getConnection()->createStatement($sql);
		$smt->execute();
	}

	public function getOrderStatusByOrderId($orderid)
	{
		$sql = $this->_bindSql("SELECT `status` FROM %s WHERE id = ?", 
								$this->getTable());
		$smt = $this->getConnection()->createStatement($sql);
		$beforeupdatestatus = $smt->getOne(array($orderid));

		return $beforeupdatestatus['status'];

	}

	public function getOrderDeservedPointCoinByOrderId($orderid)
	{
		$sql = $this->_bindSql("SELECT `deservedpointcoin` FROM %s WHERE id = ?", 
								$this->getTable());
		$smt = $this->getConnection()->createStatement($sql);
		$beforeupdatestatus = $smt->getOne(array($orderid));

		return $beforeupdatestatus['deservedpointcoin'];

	}

	public function updateOrderStatus($orderid, $status)
	{
		$sql = $this->_bindSql("UPDATE %s set status = %s, lastUpdated=now() where id = %s",
				$this->getTable(),
				$status,
				$orderid
			);
		$smt = $this->getConnection()->createStatement($sql);
		$smt->execute();
	}

	public function updateRejectApprovedStatus($orderid)
	{
		$sql = $this->_bindSql("UPDATE %s set ifrejectapproved = 1, lastUpdated=now() where id = %s",
				$this->getTable(),
				$orderid
			);
		$smt = $this->getConnection()->createStatement($sql);
		$smt->execute();
	}	

	//base on Item status to update other status
	public function updateOrderStatusByOrderItemStatus($orderItemIdList,$status)
	{
		$orderItemIdArray =  explode(",",$orderItemIdList);

		foreach ($orderItemIdArray as $key => $orderItemId) {
	
			if($orderItemId <=0 )
				continue;

			//get order id
			$sql = $this->_bindSql("select orderid from %s where id = ?",
						$this->getTable($this->_orderItemTable));

			$smt = $this->getConnection()->createStatement($sql);
			$result = $smt->queryAll(array($orderItemId));

			if(empty($result) || $result[0]['orderid'] <=0)
				continue;

			$orderid = $result[0]['orderid'];
			$oldOrderStatus = $result[0]['status'];

			//update based on 
			$sql = $this->_bindSql("UPDATE %s o set status = %s, lastUpdated = now() where o.id =? and o.id not in (select orderid from %s m where m.valid = 1 and  m.orderid = ? and m.status != ?) ",
					$this->getTable(),
					$status,
					$this->getTable($this->_orderItemTable),
					$orderItemId
				);
			$smt = $this->getConnection()->createStatement($sql);
			$smt->execute(array($orderid,$orderid,$status));

		}
	}

	//update order as 缺货 status
	public function updateOrderStatusAsNoItem($orderItemIds,$status)
	{
		$sql = $this->_bindSql("UPDATE %s o set status = %s, lastUpdated = now() where o.id in (select orderid from %s m where m.id in ( %s )) ",
				$this->getTable(),
				$status,
				$this->getTable($this->_orderItemTable),
				$orderItemIds
			);
		$smt = $this->getConnection()->createStatement($sql);
		$smt->execute();
	}

	/*
	* check if has any not confirmed order by time range
	 */
	public function countDelayConfirmOrder($timeDelay)
	{
		$sql = $this->_bindSql("select count(id) as totalCount from %s o where o.status = 0 and UNIX_TIMESTAMP(orderdate) > ? and UNIX_TIMESTAMP(orderdate) <= ?",
			$this->getTable());

		$smt = $this->getConnection()->createStatement($sql);
		$result = $smt->getOne(array($this->getDaysTimeStamp(1),$timeDelay));
		return $result['totalCount'];
	}
		
	public function getOrders($uid,
							  $schoolid,
							  $days,
							  $statusArray,
							  $searchTxt,
							  $schoolArea,
							  $assignedStatus,
							  $assignedppl,
							  $limit,
							  $offset)
	 {
		$sql = $this->_bindSql("SELECT distinct mo.*, 
									u.username,
									u1.username as deliveruser from %s mo 
								Join %s u on mo.userid = u.uid 
								Left Join %s u1 on mo.deliverby = u1.uid 
								Left Join %s sa on sa.schoolid =  mo.schoolid 
								Left JOIN %s oi on mo.id = oi.orderid 
									and oi.schoolareaid = sa.id	
								where UNIX_TIMESTAMP(orderdate) > ?  
									and %s  and %s  and mo.status in %s  
									and (towho like ? or mo.ordernumber like ?)  
									and %s and  %s and %s  ORDER BY mo.id DESC %s",
						$this->getTable(),
						$this->getTable($this->_userTable),
						$this->getTable($this->_userTable),
						$this->getTable($this->_school_areaTable),
						$this->getTable($this->_orderItemTable),
						($uid <= 0)?" ( 1 = 1) ":" mo.userid = $uid ",
						($schoolid <= 0)?" ( 1 = 1 ) ":" mo.schoolid = $schoolid ",	
						$this->getStatusFilterSQL($statusArray),
						($schoolArea <= 0)?" ( 1= 1) ":" oi.schoolareaid = $schoolArea ",
						$this->getAssignedSQL($assignedStatus),
						$this->getAssignResponsibleSQL($assignedppl),
						$this->sqlLimit($limit, $offset));

		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($this->getDaysTimeStamp($days),'%'.$searchTxt.'%','%'.$searchTxt.'%'));
	}

	public function getAgentOrders($schoolid, $shopId, $fromDate, $toDate, $limit, $start)
	 {
		$sql = $this->_bindSql("SELECT distinct mo.*, 
									u.username,
									u1.username as deliveruser from %s mo 
								Join %s u on mo.userid = u.uid 
								Left Join %s u1 on mo.deliverby = u1.uid 
								Left Join %s sa on sa.schoolid =  mo.schoolid 
								Left JOIN %s oi on mo.id = oi.orderid 
									and oi.schoolareaid = sa.id	
								where mo.schoolid = ? and
									  mo.shopId = ? and
									  oi.schoolareaid = sa.id and 
									  UNIX_TIMESTAMP(orderdate) > ? and 
									  UNIX_TIMESTAMP(orderdate) < ? 
								ORDER BY mo.id DESC %s",
						$this->getTable(),
						$this->getTable($this->_userTable),
						$this->getTable($this->_userTable),
						$this->getTable($this->_school_areaTable),
						$this->getTable($this->_orderItemTable),
						$this->sqlLimit($limit, $start));

		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($schoolid, $shopId, strtotime($fromDate), strtotime($toDate)));
	}

	public function getToUserOrders($uid,
									$schoolid,
									$days,
									$statusArray,
									$searchTxt,
									$schoolArea,
									$assignedStatus,
									$assignedppl,
									$ifallShopOrder,
									$orderRjectApproved,
									$limit,
									$offset)
	 {
	 	$orderRange = ($ifallShopOrder == 2)?"1=1":"shop.openordertouser = 1";
	 	$orderRjectApproved = (!empty($orderRjectApproved))?"mo.ifrejectapproved != 1 ":"1=1";

		$sql = $this->_bindSql("SELECT distinct mo.*, 
									u.username,
									u1.username as deliveruser, ws.name as schoolname from %s mo 
								Join %s u on mo.userid = u.uid 
								Left Join %s u1 on mo.deliverby = u1.uid 
								Left Join %s sa on sa.schoolid =  mo.schoolid 
								Left JOIN %s oi on mo.id = oi.orderid 
									and oi.schoolareaid = sa.id	
								Left Join %s shop on mo.shopid = shop.id
								left join %s ws on mo.schoolid = ws.schoolid
								where UNIX_TIMESTAMP(orderdate) > ?  
									and %s
									and %s  and %s and %s and mo.status in %s  
									and (towho like ? or mo.ordernumber like ?)  
									and %s and  %s and %s  ORDER BY mo.id DESC %s",
						$this->getTable(),
						$this->getTable($this->_userTable),
						$this->getTable($this->_userTable),
						$this->getTable($this->_school_areaTable),
						$this->getTable($this->_orderItemTable),
						$this->getTable($this->_shop),
						$this->getTable($this->_wind_school_table),
						$orderRange,
						($uid <= 0)?" ( 1 = 1) ":" mo.userid = $uid ",
						($schoolid <= 0)?" ( 1 = 1 ) ":" mo.schoolid = $schoolid ",	
						$orderRjectApproved,
						$this->getStatusFilterSQL($statusArray),
						($schoolArea <= 0)?" ( 1= 1) ":" oi.schoolareaid = $schoolArea ",
						$this->getAssignedSQL($assignedStatus),
						$this->getAssignResponsibleSQL($assignedppl),
						$this->sqlLimit($limit, $offset));

		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($this->getDaysTimeStamp($days),'%'.$searchTxt.'%','%'.$searchTxt.'%'));
	}

	public function countOrders($uid,
								$schoolid,
								$days,
								$statusArray,
								$searchTxt,
								$schoolArea,
								$assignedStatus,
								$assignedppl,
								$limit,
								$offset) 
	{
		$sql = $this->_bindSql("SELECT count(distinct mo.id) from %s mo 
									Join %s u on mo.userid = u.uid 
									Left Join %s u1 on mo.deliverby = u1.uid 
								where UNIX_TIMESTAMP(orderdate) > ? 
									and %s 
									and %s 
									and mo.status in %s 
									and (towho like ? or mo.ordernumber like ?) 
									and %s 
									and %s ORDER BY mo.id ASC ",
						$this->getTable(),
						$this->getTable($this->_userTable),
						$this->getTable($this->_userTable),
						($uid <= 0)?" ( 1 = 1) ":" mo.userid = $uid ",
						($schoolid <= 0)?" ( 1 = 1 ) ":" mo.schoolid = $schoolid ",	
						$this->getStatusFilterSQL($statusArray),
						$this->getAssignedSQL($assignedStatus),
						$this->getAssignResponsibleSQL($assignedppl));

		$smt = $this->getConnection()->createStatement($sql);
		return $smt->getValue(array($this->getDaysTimeStamp($days),'%'.$searchTxt.'%','%'.$searchTxt.'%'));
	}

	public function countAgentOrders($schoolid, $shopId, $fromDate, $toDate) 
	{
		$sql = $this->_bindSql("SELECT count(distinct mo.id) from %s mo 
								where mo.schoolid = ? and 
									  mo.shopId = ? and 
									  UNIX_TIMESTAMP(mo.orderdate) > ? and
									  UNIX_TIMESTAMP(mo.orderdate) < ?",
						$this->getTable());

		$smt = $this->getConnection()->createStatement($sql);

		return $smt->getValue(array($schoolid, $shopId, strtotime($fromDate), strtotime($toDate)));
	}

	public function countToUserOrders($uid,
								$schoolid,
								$days,
								$statusArray,
								$searchTxt,
								$schoolArea,
								$assignedStatus,
								$assignedppl,
								$ifallShopOrder,
								$orderRjectApproved) 
	{
		$orderRange = ($ifallShopOrder == 2)?"1=1":"shop.openordertouser = 1";
		$orderRjectApproved = (!empty($orderRjectApproved))?"mo.ifrejectapproved != 1 ":"1=1";
		
		$sql = $this->_bindSql("SELECT count(distinct mo.id) from %s mo 
									Join %s u on mo.userid = u.uid 
									Left Join %s u1 on mo.deliverby = u1.uid 
									Left Join %s shop on mo.shopid = shop.id
								where UNIX_TIMESTAMP(orderdate) > ? 
									and %s 
									and %s 
									and %s
									and %s
									and mo.status in %s 
									and (towho like ? or mo.ordernumber like ?) 
									and %s 
									and %s ORDER BY mo.id ASC ",
						$this->getTable(),
						$this->getTable($this->_userTable),
						$this->getTable($this->_userTable),
						$this->getTable($this->_shop),
						($uid <= 0)?" ( 1 = 1) ":" mo.userid = $uid ",
						($schoolid <= 0)?" ( 1 = 1 ) ":" mo.schoolid = $schoolid ",	
						$orderRange,
						$orderRjectApproved,
						$this->getStatusFilterSQL($statusArray),
						$this->getAssignedSQL($assignedStatus),
						$this->getAssignResponsibleSQL($assignedppl));
		
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->getValue(array($this->getDaysTimeStamp($days),'%'.$searchTxt.'%','%'.$searchTxt.'%'));
	}


	public function countOrderMoney($uid,
									$schoolid,
									$days,
									$statusArray,
									$searchTxt,
									$schoolArea,
									$assignedStatus,
									$assignedppl,
									$limit,
									$offset) 
	{
		$sql = $this->_bindSql("SELECT sum(mo.ordermoney) from %s mo 
									Join %s u on mo.userid = u.uid 
									Left Join %s u1 on mo.deliverby = u1.uid 
								where UNIX_TIMESTAMP(orderdate) > ? 
									and %s 
									and %s 
									and mo.status in %s 
									and (towho like ? or mo.ordernumber like ?) 
									and %s and %s ORDER BY mo.id ASC ",
						$this->getTable(),
						$this->getTable($this->_userTable),
						$this->getTable($this->_userTable),
						($uid <= 0)?" ( 1 = 1) ":" mo.userid = $uid ",
						($schoolid <= 0)?" ( 1 = 1 ) ":" mo.schoolid = $schoolid ",	
						$this->getStatusFilterSQL($statusArray),
						$this->getAssignedSQL($assignedStatus),
						$this->getAssignResponsibleSQL($assignedppl));

		$smt = $this->getConnection()->createStatement($sql);
		return $smt->getValue(array($this->getDaysTimeStamp($days),'%'.$searchTxt.'%','%'.$searchTxt.'%'));
	}

	public function countShopOrderMoney($shopid,
										$schoolid,
										$statusArray,
										$searchTxt,
										$schoolArea,
										$assignedStatus,
										$assignedppl,
										$startstrtotime,
										$endstrtotime)
	 {
		$sql = $this->_bindSql("SELECT sum(mo.ordermoney) from %s mo 
								Join %s u on mo.userid = u.uid 
								where UNIX_TIMESTAMP(mo.orderdate) > ? 
								and UNIX_TIMESTAMP(mo.orderdate) < ? 
								and %s 
								and %s 
								and mo.status in %s 
								and (towho like ? or mo.ordernumber like ?) 
								and %s 
								and %s and %s ",
						$this->getTable(),
						$this->getTable($this->_userTable),
						($shopid <= 0)?" ( 1 = 1) ":" mo.shopid = $shopid ",
						($schoolid <= 0)?" ( 1 = 1 ) ":" mo.schoolid = $schoolid ",	
						$this->getStatusFilterSQL($statusArray),
						($schoolArea <= 0)?" ( 1= 1) ":" oi.schoolareaid = $schoolArea ",
						$this->getAssignedSQL($assignedStatus),
						$this->getAssignResponsibleSQL($assignedppl));

		$smt = $this->getConnection()->createStatement($sql);
		return $smt->getValue(array($startstrtotime,$endstrtotime,'%'.$searchTxt.'%','%'.$searchTxt.'%'));
	}

	public function countAgentOrderMoney($schoolid, $shopId, $fromDate, $toDate) 
	{
		$sql = $this->_bindSql("SELECT sum(mo.ordermoney) from %s mo 
								where mo.schoolid = ? and 
									  mo.shopId = ? and 
									  UNIX_TIMESTAMP(mo.orderdate) > ? and
									  UNIX_TIMESTAMP(mo.orderdate) < ?",
						$this->getTable());

		$smt = $this->getConnection()->createStatement($sql);
		return $smt->getValue(array($schoolid, $shopId, strtotime($fromDate), strtotime($toDate)));
	}

	public function countToUserOrderMoney($uid,
										  $schoolid,
										  $days,
										  $statusArray,
										  $searchTxt,
										  $schoolArea,
										  $assignedStatus,
										  $assignedppl,
										  $ifallShopOrder,
										  $orderRjectApproved) 
	{
		$orderRange = ($ifallShopOrder == 2)?"1=1":"shop.openordertouser = 1";
		$orderRjectApproved = (!empty($orderRjectApproved))?"mo.ifrejectapproved != 1 ":"1=1";

		$sql = $this->_bindSql("SELECT sum(mo.ordermoney) from %s mo 
									Join %s u on mo.userid = u.uid 
									Left Join %s u1 on mo.deliverby = u1.uid 
									Left Join %s shop on mo.shopid = shop.id
								where UNIX_TIMESTAMP(orderdate) > ? 
									and %s
									and %s 
									and %s 
									and %s
									and mo.status in %s 
									and (towho like ? or mo.ordernumber like ?) 
									and %s and %s ORDER BY mo.id ASC ",
						$this->getTable(),
						$this->getTable($this->_userTable),
						$this->getTable($this->_userTable),
						$this->getTable($this->_shop),
						$orderRange,
						($uid <= 0)?" ( 1 = 1) ":" mo.userid = $uid ",
						($schoolid <= 0)?" ( 1 = 1 ) ":" mo.schoolid = $schoolid ",	
						$orderRjectApproved,
						$this->getStatusFilterSQL($statusArray),
						$this->getAssignedSQL($assignedStatus),
						$this->getAssignResponsibleSQL($assignedppl));

		$smt = $this->getConnection()->createStatement($sql);
		return $smt->getValue(array($this->getDaysTimeStamp($days),'%'.$searchTxt.'%','%'.$searchTxt.'%'));
	}

	/*
     *得到商店的订单
     *
     */
	public function getShopOrders($shopid,
									$schoolid,
									$days,
									$statusArray,
									$searchTxt,
									$schoolArea,
									$assignedStatus,
									$assignedppl,
									$limit,
									$offset)
	 {
		$sql = $this->_bindSql("SELECT distinct mo.*, u.username,u1.username as deliveruser from %s mo Join %s u on mo.userid = u.uid Left Join %s u1 on mo.deliverby = u1.uid Left Join %s sa on sa.schoolid =  mo.schoolid Left JOIN %s oi on mo.id = oi.orderid and oi.schoolareaid = sa.id	where UNIX_TIMESTAMP(orderdate) > ?  and %s  and %s  and mo.status in %s  and (towho like ? or mo.ordernumber like ?)  and %s and  %s and %s  ORDER BY mo.id DESC %s",
						$this->getTable(),
						$this->getTable($this->_userTable),
						$this->getTable($this->_userTable),
						$this->getTable($this->_school_areaTable),
						$this->getTable($this->_orderItemTable),
						($shopid <= 0)?" ( 1 = 1) ":" mo.shopid = $shopid ",
						($schoolid <= 0)?" ( 1 = 1 ) ":" mo.schoolid = $schoolid ",	
						$this->getStatusFilterSQL($statusArray),
						($schoolArea <= 0)?" ( 1= 1) ":" oi.schoolareaid = $schoolArea ",
						$this->getAssignedSQL($assignedStatus),
						$this->getAssignResponsibleSQL($assignedppl),
						$this->sqlLimit($limit, $offset));


		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($this->getDaysTimeStamp($days),'%'.$searchTxt.'%','%'.$searchTxt.'%'));
	}

	public function getShopOrdersByShopId($shopid,
									$schoolid,
									$statusArray,
									$searchTxt,
									$schoolArea,
									$assignedStatus,
									$assignedppl,
									$startstrtotime,
									$endstrtotime,
									$limit,
									$offset)
	 {
		$sql = $this->_bindSql("SELECT distinct mo.*, 
									   u.username,
									   u1.username as deliveruser from %s mo 
								Join %s u on mo.userid = u.uid 
								Left Join %s u1 on mo.deliverby = u1.uid 
								Left Join %s sa on sa.schoolid =  mo.schoolid 
								Left JOIN %s oi on mo.id = oi.orderid and oi.schoolareaid = sa.id 
								where UNIX_TIMESTAMP(orderdate) > ? and 
									  UNIX_TIMESTAMP(orderdate) < ? and 
									  %s and 
									  %s and 
									  mo.status in %s and (towho like ? or mo.ordernumber like ?)  and %s and  %s and %s  ORDER BY mo.id DESC %s",
						$this->getTable(),
						$this->getTable($this->_userTable),
						$this->getTable($this->_userTable),
						$this->getTable($this->_school_areaTable),
						$this->getTable($this->_orderItemTable),
						($shopid <= 0)?" ( 1 = 1) ":" mo.shopid = $shopid ",
						($schoolid <= 0)?" ( 1 = 1 ) ":" mo.schoolid = $schoolid ",	
						$this->getStatusFilterSQL($statusArray),
						($schoolArea <= 0)?" ( 1= 1) ":" oi.schoolareaid = $schoolArea ",
						$this->getAssignedSQL($assignedStatus),
						$this->getAssignResponsibleSQL($assignedppl),
						$this->sqlLimit($limit, $offset));


		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($startstrtotime,$endstrtotime,'%'.$searchTxt.'%','%'.$searchTxt.'%'));
	}

	public function getCountShopOrders($shopid,
									$schoolid,
									$statusArray,
									$searchTxt,
									$schoolArea,
									$assignedStatus,
									$assignedppl,
									$startDate,
									$endDate)
	 {

		$sql = $this->_bindSql("SELECT count(distinct mo.id) as totalCount FROM %s mo 
								Join %s u on mo.userid = u.uid 
								Left Join %s u1 on mo.deliverby = u1.uid 
								Left Join %s sa on sa.schoolid = mo.schoolid 
								Left JOIN %s oi on mo.id = oi.orderid and oi.schoolareaid = sa.id 
								where UNIX_TIMESTAMP(orderdate) > ? 
								and UNIX_TIMESTAMP(orderdate) < ? 
								and %s and %s and mo.status in %s and (towho like ? or mo.ordernumber like ?) and %s and  %s and %s ",
						$this->getTable(),
						$this->getTable($this->_userTable),
						$this->getTable($this->_userTable),
						$this->getTable($this->_school_areaTable),
						$this->getTable($this->_orderItemTable),
						($shopid <= 0)?" ( 1 = 1) ":" mo.shopid = $shopid ",
						($schoolid <= 0)?" ( 1 = 1 ) ":" mo.schoolid = $schoolid ",	
						$this->getStatusFilterSQL($statusArray),
						($schoolArea <= 0)?" ( 1= 1) ":" oi.schoolareaid = $schoolArea ",
						$this->getAssignedSQL($assignedStatus),
						$this->getAssignResponsibleSQL($assignedppl));

		$smt = $this->getConnection()->createStatement($sql);
		$result = $smt->queryAll(array($startDate,$endDate,'%'.$searchTxt.'%','%'.$searchTxt.'%'));

		return $result[0]['totalCount'];
	}

	public function getOrderDetail($id) 
	{
		$sql = $this->_bindSql('SELECT mo.*,u.username,u1.username as deliveruser from %s mo JOIN %s u on mo.userid = u.uid LEFT JOIN %s u1 on mo.deliverby = u1.uid where mo.id=? ',
						$this->getTable(),
						$this->getTable($this->_userTable),
						$this->getTable($this->_userTable));
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($id));	
	}

	public function getLatestOrder($count)
	{
		$sql = $this->_bindSql("SELECT u.username, m.id AS merchandiseid, m.name AS merchandisename, m.shopid, s.name
								FROM %s o
								JOIN %s u ON o.userid = u.uid
								JOIN %s oi ON o.id = oi.orderid
								JOIN %s m ON oi.merchandiseid = m.id
								JOIN %s s ON m.shopid = s.id
								GROUP BY o.userid
								ORDER BY o.orderdate DESC 
								LIMIT 0 , $count",
						$this->getTable("4t_order"),
						$this->getTable("user"),
						$this->getTable('4t_order_item'),
						$this->getTable('4t_merchandise'),
						$this->getTable('4t_shop'));
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array());	
		
	}

	public function isMyOrder($userid,$orderid)
	{
		$sql = $this->_bindSql("SELECT count(*) as totalCount FROM %s where userid = ? and id = ?",
						$this->getTable());

		$smt = $this->getConnection()->createStatement($sql);
		$result = $smt->queryAll(array($userid,$orderid));
		return ($result[0]['totalCount'] > 0);
	}

	public function getOrderedMost($count)
	{
		$sql = $this->_bindSql("SELECT m.id AS merchandiseid,m.ordercount, m.name AS merchandisename, m.shopid, s.name
								FROM %s m
								JOIN %s s ON m.shopid = s.id
								GROUP BY m.id
								ORDER BY m.ordercount DESC
								LIMIT 0 , $count",
						$this->getTable('4t_merchandise'),
						$this->getTable('4t_shop'));

		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array());	
		
	}

	public function getOrderSequence($orderid)
	{
		$sql = $this->_bindSql("select sequence from %s where id = ?",
					$this->getTable());
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($orderid));
	}


	//get data based on shop(group by shop)
	public function getOrdersGroupbyShop($schoolid, $shopId, $statusArray, $fromTime, $toTime)
	{
		$sqlStatement = "SELECT  shop.name as shopname,shop.phonenumber as phone, shop.id as shopid, m.name as mname,m.unit, m.id as mid,area.areaname as areaname,oi.id as oid,
o.id as orderid, o.ordernumber,o.orderdate,o.status,o.sequence,oi.sequence as msequence, user.username as orderby,user1.username as deliverby,oi.price,oi.quatity,shop.address \n".
							"FROM pw_4t_shop shop \n".
							"JOIN pw_4t_school_area area on area.id = shop.areaid \n".
							"JOIN pw_windid_school school on area.schoolid = school.schoolid \n".
							"JOIN pw_4t_merchandise m ON shop.id = m.shopid \n".
							"JOIN pw_4t_order_item oi ON oi.merchandiseid = m.id \n".
							"JOIN pw_4t_order o ON o.id = oi.orderid \n".
							"JOIN pw_user user ON user.uid = o.userid \n".
							"LEFT JOIN pw_user user1 ON user1.uid = o.deliverby \n".
							"WHERE oi.valid = 1 and %s and o.status in %s and o.schoolid = ? and (o.orderdate >= ? and o.orderdate <= ?) ";

		$sql = $this->_bindSql($sqlStatement,
								($shopId <= 0?" 1=1 ":" m.shopid = $shopId "),
								$this->getStatusFilterSQL($statusArray));

		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($schoolid,$fromTime,$toTime));

	}

	//get data based on delivery ppl
	public function getOrdersGroupbyDelivery($schoolid,$deliveryId, $statusArray, $fromTime, $toTime)
	{
		$sqlStatement = "SELECT user1.username as deliverby,o.id as orderid,user1.uid as deliverId,o.shopid,o.status, o.delivercontact,o.ordermoney,m.needPackingPrice,m.id as mid, oi.quatity,oi.merchandiseid \n".
							"FROM pw_4t_order o \n".
							"JOIN pw_4t_order_item oi ON o.id = oi.orderid \n".
							"JOIN pw_4t_merchandise m ON m.id = oi.merchandiseid \n".
							"JOIN pw_user user ON user.uid = o.userid \n".
							"LEFT JOIN pw_user user1 ON user1.uid = o.deliverby \n".
							"WHERE %s and o.status in %s and oi.valid =1 and o.schoolid = ? and (o.orderdate >= ? and o.orderdate <= ?) ";

		$sql = $this->_bindSql($sqlStatement,
								$deliveryId <=0? " 1=1 ": " o.deliverby = ? ",
								$this->getStatusFilterSQL($statusArray));


		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($schoolid,$fromTime,$toTime));

	}

	//get data based on Orders' create time
	public function getOrdersByCreateTime($schoolid =0, $statusArray, $fromTime, $toTime)
	{
		$sqlStatement = "SELECT o.id,o.status, o.ordermoney,o.shopid,o.shopreturn \n".
							"FROM pw_4t_order o \n".
							"WHERE o.status in %s and (o.orderdate >= ? and o.orderdate <= ?) ";

		$sql = $this->_bindSql($sqlStatement,
								$this->getStatusFilterSQL($statusArray));
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($fromTime,$toTime));

	}

	//get orders in date which is first order since 0331(首次下单送可乐)
	public function getFirstOrderInRangeSinceDate($fromTime, $toTime,$firstOrderSince0331 = 1)
	{
		$sqlStatement = "SELECT o.id,o.status, o.to,o.towho,o.tomobile,o.ordernumber \n".
							"FROM pw_4t_order o \n".
							"WHERE o.firstordersince0331 = ? and (o.orderdate >= ? and o.orderdate <= ?) and o.status not in (-1,6,7) ";
		$sql = $this->_bindSql($sqlStatement);
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($firstOrderSince0331,$fromTime,$toTime));

	}

	

	/*
	* 查看是否有Item没有订单
	*/
	public function anyNoItemOrders($schoolid,$lastRetrived)
	{
		$sql = $this->_bindSql("SELECT count(*) as totalCount FROM %s o Join %s oi on o.id = oi.orderid where schoolid = ? and oi.valid =1 and (oi.status = -1 or o.status = -1) and oi.lastUpdated > ? ",
						$this->getTable(),
						$this->getTable($this->_orderItemTable)
						);
		$smt = $this->getConnection()->createStatement($sql);
		$result = $smt->queryAll(array($schoolid,$lastRetrived));

		return $result[0]['totalCount'];
	}


	/*
    *   看是否这个订单在某个状态下是否可以让客户自己取消
    *   只有当订单中所有的商品的状态都是未向商家下单的话,用户才能取消
    */
    public function canCancelOrderByStatus($orderid)
    {
        $sql = $this->_bindSql("SELECT count(*) as totalCount FROM %s o Join %s oi on o.id = oi.orderid where o.id = ? and oi.valid =1 and oi.status != 0 and  oi.status != 1 ",
						$this->getTable(),
						$this->getTable($this->_orderItemTable)
						);
		$smt = $this->getConnection()->createStatement($sql);
		$result = $smt->queryAll(array($orderid));

		return  ($result[0]['totalCount'] <= 0);
    }

    public function getLastOrderByUserId($userId)
    {
    	$sql=$this->_bindSql("SELECT*FROM %s WHERE userid=? ORDER BY lastupdated DESC limit 1",
    		            $this->getTable());

    	$smt=$this->getConnection()->createStatement($sql);
    	$result=$smt->queryAll(array($userId));
    	return $result[0];
    }

    /*
    *	check if it my first order
    */
    public function isFirstOrder($userid,$since='2013-08-01')
    {
    	//
    	$sql = $this->_bindSql("SELECT id FROM pw_4t_order WHERE userid =? AND STATUS IN ( 1, 2, 3, 4, 5 ) and orderdate > ? limit 1",
						$this->getTable()
						);

		$smt = $this->getConnection()->createStatement($sql);
		$result = $smt->queryAll(array($userid,$since));

		return  (empty($result));

    }

    public function getOrderIdByUserId($userid)
    {
        $sql = $this->_bindSql("SELECT `id` FROM %s WHERE userid = ? and firstorder = 1", 
                                $this->getTable());
        $smt = $this->getConnection()->createStatement($sql);
        $msg = $smt->getOne(array($userid));

        return $msg['id'];
    }

	public function add($fields) {

		$fields['lastUpdated'] = date("Y-m-d H:i:s");
		return $this->_add($fields, true);		
		
	}


	public function update($id, $fields) {

		$fields['lastUpdated'] = date("Y-m-d H:i:s");
		return $this->_update($id, $fields);
	}

	public function startTran()
	{
		return $this->execute("START TRANSACTION");
	}

	public function commit()
	{
		return $this->execute("COMMIT");
	}

	public function rollBack()
	{
		return $this->execute("ROLLBACK");
	}
	

	private function getAssignResponsibleSQL($assignedppl)
	{
		if($assignedppl == 0)
			return " ( 1= 1) ";
		else if($assignedppl == -10)
		{
			 return " mo.deliverby = 0 or  mo.deliverby IS NULL ";
		}
		else
			return " mo.deliverby = $assignedppl ";

	}


	private function getDaysTimeStamp($days)
	{
		//days =1 means today
		//days = 2 means today and yesterday
		// if($days == 0)
		// 	return strtotime();

		$days = $days -1;

		$lastRetriveTime = date("Y-m-d",strtotime("-$days day"));
		$fromTime = $this->stringToDateLowerest($lastRetriveTime);

		return strtotime($fromTime);

	}

	protected function stringToDateLowerest($fromTime)
    {
        $fromDateArray = getdate(strtotime($fromTime));
        $fromTime = mktime(0, 0, 0, $fromDateArray['mon'], $fromDateArray['mday'], $fromDateArray['year']);

        return date('Y-m-d H:i:s', $fromTime);
    }

	private function getStatusFilterSQL($statusArray)
	{
		if(count($statusArray) <= 0)
			return "( -10 )";
		$statusStr = "( -10, ";
		foreach($statusArray as $key => $value)
		{
			//$key is status id
			$statusStr.= $key."," ;	
		}

		$statusStr.= " -10)";
		return $statusStr;
	}

	private function getAssignedSQL($assignedStatus)
	{
		$sql = " 1 = 1 ";
		switch($assignedStatus)
		{
			case -1:
				$sql = " (u1.username IS NULL) ";
				break;
			case 1:
				$sql = " u1.username IS NOT NULL ";
				break;
			default:
				break;
		}

		return $sql;
	}


}

?>