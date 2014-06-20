<?php

defined('WEKIT_VERSION') or exit(403);

class App_ShopDailySale_Dm extends PwBaseDm
{

    protected $id;

    public function setShopId($shopid)
    {
        $this->_data['shopid'] = $shopid;
        return $this;
    }

    public function setDateFor($datefor)
    {
        $this->_data['datefor'] = $datefor;
        return $this;
    }

    public function setTotalOrders($totalorders)
    {
        $this->_data['totalorders'] = $totalorders;
        return $this;
    }

    public function setValidOrders ($validorders){
        $this->_data['validorders']=$validorders;
        return $this;
    }

    public function setTotalMoney ($totalmoney){
        $this->_data['totalmoney']=$totalmoney;
        return $this;
    }

    public function setValidMoney($validmoney)
    {
        $this->_data['validmoney'] = $validmoney;
        return $this;
    }

    public function setTotalShopReturn ($totalshopreturn){
        $this->_data['totalshopreturn']=$totalshopreturn;
        return $this;
    }

    public function setValidShopReturn($validshopreturn)
    {
        $this->_data['validshopreturn'] = $validshopreturn;
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
