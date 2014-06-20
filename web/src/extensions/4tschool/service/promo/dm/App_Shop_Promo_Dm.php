<?php
defined('WEKIT_VERSION') or exit(403);

/**
 *
 */
class App_Shop_Promo_Dm extends PwBaseDm
{
    protected $id;

    public function setShopId($shopId){
        $this->_data['shopid']=$shopId;
        return $this;
    }

    public function setTemplateId ($templateId){
        $this->_data['templateid']=$templateId;
        return $this;
    }

    public function setIsActive ($isActive){
        $this->_data['isactive']=$isActive;
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

    public function setDescription($description) {
        $this->_data['description'] = $description;
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