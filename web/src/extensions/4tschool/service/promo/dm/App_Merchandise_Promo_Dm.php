<?php
defined('WEKIT_VERSION') or exit(403);

/**
 *
 */
class App_Merchandise_Promo_Dm extends PwBaseDm
{
    protected $id;

    public function setMerchandiseId($merchandiseId){
        $this->_data['merchandiseid']=$merchandiseId;
        return $this;
    }

    public function setShopPromoId ($shopPromoId){
        $this->_data['shoppromoid']=$shopPromoId;
        return $this;
    }

    public function setElement ($element){
        $this->_data['element']=$element;
        return $this;
    }

    public function setValue($value)
    {
        $this->_data['value']=$value;
        return $this;
    }

    public function setCreateDate($createDate) {
        $this->_data['createdate'] = $createDate;
        return $this;
    }

    public function setLastUpdateTime($lastupdateTime) {
        $this->_data['lastupdatetime'] = $lastupdateTime;
        return $this;
    }

    /* (non-PHPdoc)
     * @see PwBaseDm::_beforeAdd()
     */

    protected function _beforeAdd() {
        // TODO Auto-generated method stub
        //check the fields value before add
        return true;
    }

    /* (non-PHPdoc)
     * @see PwBaseDm::_beforeUpdate()
     */

    protected function _beforeUpdate() {
        // TODO Auto-generated method stub
        //check the fields value before update
        return true;
    }
}
?>
