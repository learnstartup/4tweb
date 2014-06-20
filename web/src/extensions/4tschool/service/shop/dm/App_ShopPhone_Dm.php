<?php

defined('WEKIT_VERSION') or exit(403);

class App_ShopPhone_Dm extends PwBaseDm
{

    protected $id;

    
    public function setShopId($sid)
    {
        $this->_data['shopid'] = $sid;
        return $this;
    }

    public function setUID ($uid){
        $this->_data['uid']=$uid;
        return $this;
    }

    public function setClientIP ($clientIP){
        $this->_data['clientip']=$clientIP;
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
