<?php

defined('WEKIT_VERSION') or exit(403);

class App_Shopstatusrecord_Dm extends PwBaseDm
{

    protected $id;

    public function setShopId($shopId)
    {
        $this->_data['shopId'] = $shopId;
        return $this;
    }

    public function setUserId($userId)
    {
        $this->_data['userId'] = $userId;
        return $this;
    }

    public function setActionTime($currentime)
    {
        $this->_data['actiontime'] = $currentime;
        return $this;
    }

    public function setActionStatus($status)
    {
        $this->_data['actionstatus'] = $status;
        return $this;
    }

     /* (non-PHPdoc)
     * @see PwBaseDm::_beforeAdd()
     */

    protected function _beforeAdd()
    {
        // TODO Auto-generated method stub
        //check the fields value before add
        return true;
    }

    /* (non-PHPdoc)
     * @see PwBaseDm::_beforeUpdate()
     */

    protected function _beforeUpdate()
    {
        // TODO Auto-generated method stub
        //check the fields value before update
        return true;
    }

}

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>