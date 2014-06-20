<?php

defined('WEKIT_VERSION') or exit(403);

class App_ShopDailySale_Dao extends PwBaseDao
{

    /**
     * table name
     */
    protected $_table = '4t_shopdailysale';

    /**
     * table name
     */
    protected $_shopTable = '4t_shop';

    /*
    *
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
    protected $_dataStruct = array('id', 'shopid', 'datefor','totalorders','validorders','totalmoney','validmoney','totalshopreturn','validshopreturn');

    public function get($id)
    {
        return $this->_get($id);
    }

    public function getSaleByShop($shopid = 0,$startdate,$enddate)
    {
        $sql = $this->_bindSql("select sps.shopid, sp.ifrebate,sp.rebatefromshop, sum(sps.totalorders) as totalorders, sum(sps.validorders) as validorders,sum(sps.totalmoney) as totalmoney,sum(sps.validmoney) as validmoney, sum(sps.totalshopreturn) as totalshopreturn, sum(sps.validshopreturn) as validshopreturn, sp.name \n".
                                "from %s sps INNER JOIN %s sp on sps.shopid = sp.id \n".
                                "where (0 = ? or sps.shopid =?) and datefor >= ? and datefor <= ? group by sps.shopid order by validmoney desc ",
            $this->getTable(),
            $this->getTable($this->_shopTable));

        $smt = $this->getConnection()->createStatement($sql);

        return $smt->queryAll(array($shopid,$shopid,$startdate,$enddate));

    }

    public function getOverAllSales($startdate,$enddate)
    {
        $sql = $this->_bindSql("select sum(sps.totalorders) as totalorders, sum(sps.validorders) as validorders,sum(sps.totalmoney) as totalmoney,sum(sps.validmoney) as validmoney, sum(sps.validshopreturn) validshopreturn \n".
                                "from %s sps INNER JOIN %s sp on sps.shopid = sp.id \n".
                                "where datefor >= ? and datefor <= ?  order by validmoney desc ",
            $this->getTable(),
            $this->getTable($this->_shopTable));

        $smt = $this->getConnection()->createStatement($sql);

        return $smt->getOne(array($startdate,$enddate));

    }

    public function getOverallSalesByAgent($agentid,$startdate,$enddate)
    {
        $sql = $this->_bindSql("select sp.masterid,u.username, sum(sps.totalorders) as totalorders, sum(sps.validorders) as validorders,sum(sps.totalmoney) as totalmoney,sum(sps.validmoney) as validmoney, sum(sps.validshopreturn) validshopreturn \n".
                                "from %s sps INNER JOIN %s sp on sps.shopid = sp.id \n".
                                " INNER JOIN %s u on u.uid = sp.masterid ".
                                "where (0 = ? or sp.masterid =?) and datefor >= ? and datefor <= ? group by sp.masterid  order by validmoney desc ",
            $this->getTable(),
            $this->getTable($this->_shopTable),
            $this->getTable($this->_userTable));

        $smt = $this->getConnection()->createStatement($sql);

        return $smt->queryAll(array($agentid,$agentid,$startdate,$enddate));

    }


    public function getShopSalesByAgent($agentid,$startdate,$enddate)
    {
        $sql = $this->_bindSql("select sp.id, sp.name,sp.rebatefromshop,  sum(sps.totalorders) as totalorders, sum(sps.validorders) as validorders,sum(sps.totalmoney) as totalmoney,sum(sps.validmoney) as validmoney, sum(sps.validshopreturn) validshopreturn \n".
                                "from %s sps INNER JOIN %s sp on sps.shopid = sp.id \n".
                                " INNER JOIN %s u on u.uid = sp.masterid ".
                                "where (0 = ? or sp.masterid =?) and datefor >= ? and datefor <= ? group by sp.id  order by validmoney desc ",
            $this->getTable(),
            $this->getTable($this->_shopTable),
            $this->getTable($this->_userTable));

        $smt = $this->getConnection()->createStatement($sql);

        return $smt->queryAll(array($agentid,$agentid,$startdate,$enddate));

    }

    public function add($shopDailySale)
    {
        return $this->_add($shopDailySale, true);
    }

    public function deleteBy($shopid,$datefor)
    {
        $sql = $this->_bindSql("delete FROM %s where shopid = ? and datefor = ?",
                        $this->getTable());

        $smt = $this->getConnection()->createStatement($sql);
        $smt->execute(array($shopid,$datefor));
    }

    public function delete($id)
    {
        return $this->_delete($id);
    }
}

?>