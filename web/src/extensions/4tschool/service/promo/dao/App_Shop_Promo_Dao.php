<?php
defined('WEKIT_VERSION') or exit(403);

/**
 *
 */
class App_Shop_Promo_Dao extends PwBaseDao
{
    protected $_table = '4t_shop_promo';

    protected $_promoTemplateTable='4t_promo_template';

    protected $_merchandisePromoTable='4t_merchandise_promo';

    protected $_merchandiseTable='4t_merchandise';

    protected $_pk = 'id';

    protected $_dataStruct = array('id', 'shopid', 'templateid', 'isactive', 'createdate', 'lastupdatetime','description');

    public function add($dm)
    {
        return $this->_add($dm, true);
    }

    public function update($spid, $fields)
    {
        return $this->_update($spid,$fields);
    }

    public function getShopPromotionsByShopId($shopId)
    {
        $sql=$this->_bindSql('SELECT pt.`name` AS promoName, mp.`value`, m.`name` AS merchandiseName, m.price, m.currentprice, sp.* from %s sp
                                     LEFT JOIN (SELECT * FROM %s GROUP BY templateid ) pt on sp.templateid=pt.templateid
                                     LEFT JOIN (SELECT * FROM %s GROUP BY shoppromoid) mp on sp.id=mp.shoppromoid
                                     LEFT JOIN %s m on mp.merchandiseid=m.id WHERE sp.isactive =1 and sp.shopid = ?',$this->getTable(),$this->getTable($this->_promoTemplateTable),$this->getTable($this->_merchandisePromoTable),$this->getTable($this->_merchandiseTable));
        $smt=$this->getConnection()->createStatement($sql);

        return $smt->queryAll(array($shopId));
    }

    public function getPromotionById($id)
    {
        $sql=$this->_bindSql('SELECT pt.`name`,mp.* FROM %s mp
                                              LEFT JOIN %s sp ON mp.shoppromoid=sp.id
                                              LEFT JOIN (SELECT * FROM %s GROUP BY templateid) pt ON sp.templateid=pt.templateid
                                              WHERE sp.id=?',
                                              $this->getTable($this->_merchandisePromoTable),$this->getTable(),$this->getTable($this->_promoTemplateTable));

        $smt=$this->getConnection()->createStatement($sql);
        return $smt->queryAll(array($id));
    }

    public function getTemplateNameBySPID($spid)
    {
        $sql=$this->_bindSql('SELECT distinct pt.`name` FROM %s sp
                                              JOIN %s pt ON pt.templateid=sp.templateid
                                              WHERE sp.id=?',
                                              $this->getTable(),
                                              $this->getTable($this->_promoTemplateTable));

        $smt=$this->getConnection()->createStatement($sql);
        return $smt->queryAll(array($spid));
    }
}

?>