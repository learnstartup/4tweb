<?php

defined('WEKIT_VERSION') or exit(403);

class App_Shoparea_Dm extends PwBaseDm
{

    protected $id;

    public function setShopId($shopId)
    {
        $this->_data['shopId'] = $shopId;
        return $this;
    }

    public function setSchoolId($schoolId)
    {
        $this->_data['schoolId'] = $schoolId;
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