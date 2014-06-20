<?php

defined('WEKIT_VERSION') or exit(403);

class App_Shop_DeliveryTime_Dm extends PwBaseDm
{

    protected $id;

    
    public function setShopId($sid)
    {
        $this->_data['shopid'] = $sid;
        return $this;
    }

    public function setBeginTime ($begintime){
        $this->_data['begintime']=$begintime;
        return $this;
    }

    public function setEndTime ($endtime){
        $this->_data['endtime']=$endtime;
        return $this;
    }

    public function setWeights ($weights){
        $this->_data['weights']=$weights;
        return $this;
    }

    public function setIsActive ($isactive){
        $this->_data['isactive']=$isactive;
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
