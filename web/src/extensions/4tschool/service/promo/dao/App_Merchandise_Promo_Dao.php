<?php
defined('WEKIT_VERSION') or exit(403);

/**
 *
 */
class App_Merchandise_Promo_Dao extends PwBaseDao
{
    protected $_table = '4t_merchandise_promo';

    protected $_shopPromoTable = '4t_shop_promo';

    protected $_merchandiseTable = '4t_merchandise';

    protected $_shopTable = '4t_shop';

    protected $_promoTemplateTable = '4t_promo_template';

    protected $_pk = 'id';

    protected $_dataStruct = array('id', 'merchandiseid', 'shoppromoid', 'element', 'value', 'createdate', 'lastupdatetime');

    public function add($dm)
    {
        return $this->_add($dm, true);
    }

    public function update($id, $dm)
    {
        return $this->_update($id, $dm);
    }

    public function hasPromotion($shopId, $merchandiseId)
    {
        $sql = $this->_bindSql('SELECT count(*) as total FROM %s mp
                                       JOIN %s sp on mp.shoppromoid=sp.id
                                       WHERE sp.isactive =1 and sp.shopid = ? AND mp.merchandiseid = ?', $this->getTable(), $this->getTable($this->_shopPromoTable));

        $smt = $this->getConnection()->createStatement($sql);

        $result = $smt->queryAll(array($shopId, $merchandiseId));

        return $result[0]['total'] > 0;
    }

    public function getMerchandisePromotionBySPID($spId)
    {
        $sql = $this->_bindSql('SELECT m.`name`, sp.templateid, mp.* FROM %s mp
                                       LEFT JOIN %s m ON mp.merchandiseid=m.id
                                       LEFT JOIN %s sp ON mp.shoppromoid=sp.id
                                       WHERE mp.shoppromoid = ?', $this->getTable(), $this->getTable($this->_merchandiseTable), $this->getTable($this->_shopPromoTable));

        $smt = $this->getConnection()->createStatement($sql);

        return $smt->queryAll(array($spId));
    }

    public function  getPromotionByMids($midList)
    {
        $sql = $this->_bindSql('SELECT mp.shoppromoid, s.id AS ShopId, s.`name` AS ShopName,mp.element,mp.`value`,mp.`merchandiseid`,pt.`name` AS PromotionName,m.`name` AS MerchandiseName,m.currentprice FROM %s mp
                                                JOIN %s sp ON mp.shoppromoid=sp.id and sp.isactive = 1
                                                LEFT JOIN (SELECT templateid,`name` FROM %s GROUP BY templateid) pt ON sp.templateid=pt.templateid
                                                LEFT JOIN %s s ON sp.shopid=s.id
                                                LEFT JOIN %s m ON mp.merchandiseid=m.id
                                                WHERE %s', $this->getTable(), $this->getTable($this->_shopPromoTable), $this->getTable($this->_promoTemplateTable), $this->getTable($this->_shopTable), $this->getTable($this->_merchandiseTable), empty($midList) ? '1=2' : 'mp.merchandiseid in (' . $midList . ')');
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->queryAll();
    }

    public function updateMerchandisePromotion($mid, $spid, $element, $value)
    {
        $sql = $this->_bindSql('update %s set value =? where merchandiseid = ? and shoppromoid=? and element =?', 
                $this->getTable());
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->execute(array($value,$mid,$spid,$element));
    }
}

?>