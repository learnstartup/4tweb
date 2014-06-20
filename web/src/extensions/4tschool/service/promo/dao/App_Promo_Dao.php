<?php
defined('WEKIT_VERSION') or exit(403);

/**
 *
 */
class App_Promo_Dao extends PwBaseDao
{
    protected $_table = '4t_promo_template';

    protected $_pk = 'id';

    protected $_dataStruct = array('id', 'templateid', 'name', 'element', 'createdate', 'lastupdatetime');

    public function add($dm)
    {
        return $this->_add($dm, true);
    }

    public function getPromoByTemplateId($id)
    {
        $sql=$this->_bindSql('SELECT * FROM %s WHERE templateid = ?',$this->getTable());
        $smt=$this->getConnection()->createStatement($sql);
        return $smt->getOne(array($id));
    }

    public function getPromoByTemplateName($name)
    {
        $sql=$this->_bindSql('SELECT * FROM %s WHERE `name` = ?',$this->getTable());
        $smt=$this->getConnection()->createStatement($sql);
        return $smt->queryAll(array($name));
    }

    public function generateTemplateId()
    {
        $sql = $this->_bindSql("SELECT IFNULL(MAX(templateid+1),1) AS templateid FROM %s", $this->getTable());
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->getOne();
    }

    public function checkDuplicateInfo($col, $info)
    {
        $sql = $this->_bindSql('SELECT count(*) as total FROM %s where ' . $col . '=?', $this->getTable(), $info);
        $smt = $this->getConnection()->createStatement($sql);
        $result = $smt->queryAll(array($info));
        return $result[0]['total'] > 0;
    }

    public function getTemplates()
    {
        $sql=$this->_bindSql('SELECT * FROM %s',$this->getTable());
        $smt=$this->getConnection()->createStatement($sql);
        return $smt->queryAll();
    }
}

?>