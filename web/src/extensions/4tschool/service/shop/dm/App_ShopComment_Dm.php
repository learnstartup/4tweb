<?php

defined('WEKIT_VERSION') or exit(403);

class App_ShopComment_Dm extends PwBaseDm
{

    protected $id;

    
    public function setShopId($shopid)
    {
        $this->_data['shopid'] = $shopid;
        return $this;
    }

    public function setUserId($userid){
        $this->_data['userid']=$userid;
        return $this;
    }

    public function setOrderId($orderid){
        $this->_data['orderid']=$orderid;
        return $this;
    }

    public function setSpeed($speed)
    {
    	$this->_data['speed']=$speed;
        return $this;
    }

    public function setComment($comment)
    {
    	$this->_data['comment']=$comment;
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
