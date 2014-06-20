<?php
defined('WEKIT_VERSION') or exit(403);

class App_OrderItem_Dao extends PwBaseDao
{

    /**
     * table name
     */
    protected $_table = '4t_order_item';

    /**
     * merchandise name
     */
    protected $_merchandiseTable = '4t_merchandise';

    /**
     * order name
     */
    protected $_orderTable = '4t_order';

    /**
     * shop name
     */
    protected $_shopTable = '4t_shop';

    /**
     * primary key
     */
    protected $_pk = 'id';
    /**
     * table fields
     */
    protected $_dataStruct = array('id', 'orderid', 'merchandiseid', 'schoolareaid', 'quatity', 'priceoriginal', 'priceofferdescription', 'price', 'saving', 'integral','sequence','packingprice','changeFromItemId','valid','status','totalMoney','promoUsed','lastUpdated','commented');

    public function getOrderItemById($id)
    {
        $sql = $this->_bindSql('SELECT * from %s where id = ?',
            $this->getTable());
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->queryAll(array($id));
    }

    public function getOrderItems($orderid, $limit, $offset)
    {
        $sql = $this->_bindSql('SELECT oi.*,sm.shopid,sm.unit,sm.name as mname,sm.needPackingPrice,shop.name as shopname from %s oi Inner Join %s sm on oi.merchandiseid = sm.id JOIN pw_4t_shop shop on shop.id = sm.shopid where valid = 1 and  orderid in ( %s ) %s',
            $this->getTable(),
            $this->getTable($this->_merchandiseTable),
            $orderid,
            $this->sqlLimit($limit, $offset));
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->queryAll(array());
    }

    public function getOrderItemByOrderIds($orderids, $limit, $offset)
    {

        $sql = $this->_bindSql('SELECT oi.*,
                                       o.tomobile,
                                       o.firstorder,
                                       sm.shopid,
                                       sm.unit,
                                       sm.name as mname,
                                       sm.needPackingPrice,
                                       shop.name as shopname,
                                       shop.phonenumber,
                                       shop.contactnumber
                                from %s oi
                                left join %s o on oi.orderid = o.id 
                                Inner Join %s sm on oi.merchandiseid = sm.id 
                                JOIN pw_4t_shop shop on shop.id = sm.shopid 
                                where valid = 1 and  orderid in ( %s ) %s',
            $this->getTable(),
            $this->getTable($this->_orderTable),
            $this->getTable($this->_merchandiseTable),
            $orderids,
            $this->sqlLimit($limit, $offset));
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->queryAll(array());
    }

    public function getOrderItemsByUser($schoolid, $userid, $includeCancelled = false, $limit, $offset)
    {
        $sql = $this->_bindSql('SELECT oi.*,
                                       sm.shopid,
                                       shop.name as shopname,
                                       shop.address,
                                       shop.openorder,
                                       shop.orderbegin,
                                       shop.orderend,
                                       shop.isshopopen,
                                       shop.hasterminal,
                                       shop.isshopopen,
                                       sm.needPackingPrice,
                                       sm.imageurl,
                                       sm.unit,
                                       sm.name as mname,
                                       sm.id as mid,
                                       o.orderdate from %s oi 
                                INNER JOIN %s o on oi.orderid = o.id 
                                INNER JOIN %s sm on oi.merchandiseid = sm.id 
                                INNER JOIN %s shop on shop.id = sm.shopid 
                                where o.schoolid = ? and valid = 1 and  
                                      o.userid = ? and 
                                      %s order by oi.orderid desc %s',
            $this->getTable(),
            $this->getTable($this->_orderTable),
            $this->getTable($this->_merchandiseTable),
            $this->getTable($this->_shopTable),
            ($includeCancelled ? " 1=1 " : " o.status = 5 "),
            $this->sqlLimit($limit, $offset));
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->queryAll(array($schoolid, $userid));
    }

    public function CountOrderItemsByUser($schoolid, $userid, $includeCancelled = false, $limit, $offset)
    {
        $sql = $this->_bindSql('SELECT count(oi.id) from %s oi 
                               INNER JOIN %s o on oi.orderid = o.id 
                               INNER JOIN %s sm on oi.merchandiseid = sm.id 
                               INNER JOIN %s shop on shop.id = sm.shopid 
                               where o.schoolid = ? and valid = 1 and  o.userid =  ? and %s ',
                            $this->getTable(),
                            $this->getTable($this->_orderTable),
                            $this->getTable($this->_merchandiseTable),
                            $this->getTable($this->_shopTable),
                            ($includeCancelled ? " 1=1 " : " o.status = 5 "));
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->getValue(array($schoolid, $userid));
    }

    public function getOrderItemsByShops($shopIdList,$orderStatusArray,$lastRetrived)
    {
        $sql = $this->_bindSql('SELECT oi.*,o.note,o.to,o.ordernumber,o.status as orderStatus,o.tomobile,o.towho, s.id as shopid, s.name as shopname, s.phonenumber, s.packingprice,s.deliveryprice, m.name as merchandisename, m.currentprice,m.needPackingPrice, o.orderdate FROM %s oi
                                                LEFT JOIN %s o ON oi.orderid=o.id
                                                LEFT JOIN %s m ON oi.merchandiseid=m.id
                                                LEFT JOIN %s s ON m.shopid=s.id
                                                WHERE valid = 1 and  o.status in %s and oi.merchandiseid IN (SELECT id FROM pw_4t_merchandise WHERE shopid IN (%s)) %s order by o.id asc',
            $this->getTable(),
            $this->getTable($this->_orderTable),
            $this->getTable($this->_merchandiseTable),
            $this->getTable($this->_shopTable),
            $this->getStatusFilterSQL($orderStatusArray),
            $shopIdList,
            'AND o.orderdate >= ?');
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->queryAll(array($lastRetrived));
    }

    public function getOrderIntegral($orderid)
    {
        $sql = $this->_bindSql("select sum(integral) as totalIntegral from %s oi where oi.valid = 1 and oi.orderid =? ",
                $this->getTable());
        $smt = $this->getConnection()->createStatement($sql);
        $result = $smt->queryAll(array($orderid));
        return $result[0]['totalIntegral'];
    }

    public function getOrderId($ids)
    {
        $sql = $this->_bindSql("select orderid from %s where id in ( %s ) limit 1",
            $this->getTable(),
            $ids);
        $smt = $this->getConnection()->createStatement($sql);

        return $smt->getOne();
    }

    public function updateOrderItemStatus($ids, $status)
    {
        $sql = $this->_bindSql("UPDATE %s set status = %s , lastUpdated = now() where id in ( %s )",
            $this->getTable(),
            $status,
            $ids
        );
        $smt = $this->getConnection()->createStatement($sql);

        return $smt->execute();
    }

    public function updateOrderItemStatusByOrderId($orderId, $status)
    {
        $sql = $this->_bindSql("UPDATE %s set status = %s , lastUpdated = now()  where orderid = ?",
            $this->getTable(),
            $status
        );
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->execute(array($orderId));
    }

    public function updateMStatusAsNoItem($orderitemids)
    {
        $sql = $this->_bindSql("UPDATE %s set remainder = -1  where id in (select distinct merchandiseid from %s m where m.id in ( %s ))",
            $this->getTable($this->_merchandiseTable),
            $this->getTable(),
            $orderitemids
        );

        $smt = $this->getConnection()->createStatement($sql);
        return $smt->execute(array());
    }

    public function updateItemasCommented($orderid,$merchandiseid)
    {
        $sql = $this->_bindSql("update %s set commented = 1 where orderid=? and merchandiseid=?",
            $this->getTable());

         $smt = $this->getConnection()->createStatement($sql);
        return $smt->execute(array($orderid,$merchandiseid));
    }

    public function add($fields)
    {
        $fields['lastUpdated'] = date("Y-m-d H:i:s");
        return $this->_add($fields, true);
    }

    public function update($id, $fields) {

        $fields['lastUpdated'] = date("Y-m-d H:i:s");

        return $this->_update($id, $fields);
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

}

?>