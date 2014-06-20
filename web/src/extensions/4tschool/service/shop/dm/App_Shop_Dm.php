<?php

defined('WEKIT_VERSION') or exit(403);

class App_Shop_Dm extends PwBaseDm
{

    protected $id;

    public function setShop($shop)
    {

    }

    public function setUserId($uid)
    {
        $this->_data['userid'] = $uid;
        return $this;
    }

    public function setMasterId($masterId)
    {
        $this->_data['masterid'] = $masterId;
        return $this;
    }

    public function setShopName($shopName)
    {
        $this->_data['name'] = $shopName;
        return $this;
    }

    public function setAddress($address)
    {
        $this->_data['address'] = $address;
        return $this;
    }

    public function setLatitude ($latitude){
        $this->_data['latitude']=$latitude;
        return $this;
    }

    public function setLongitude ($longitude){
        $this->_data['longitude']=$longitude;
        return $this;
    }

    public function setPackingPrice($packingPrice)
    {
        $this->_data['packingprice'] = $packingPrice;
        return $this;
    }

    public function setDeliveryprice($deliveryprice)
    {
        $this->_data['deliveryprice'] = $deliveryprice;
        return $this;
    }

    public function setStartingPrice ($startingprice){
        $this->_data['startingprice']=$startingprice;
        return $this;  
    }

    public function setArea($areaid)
    {
        $this->_data['areaid'] = $areaid;
        return $this;
    }

    public function setPhoneNumber($phoneNumber)
    {
        $this->_data['phonenumber'] = $phoneNumber;
        return $this;
    }

    public function setContactNumber($contactNumber)
    {
        $this->_data['contactnumber'] = $contactNumber;
        return $this;
    }

    public function setOpenOrder($openOrder)
    {
        $this->_data['openorder'] = $openOrder;
        return $this;
    }

    public function setOrderBegin($orderBegin)
    {
        $this->_data['orderbegin'] = $orderBegin;
        return $this;
    }

    public function setOrderEnd($orderEnd)
    {
        $this->_data['orderend'] = $orderEnd;
        return $this;
    }

    public function setCreateDate($createDate)
    {
        $this->_data['createdate'] = $createDate;
        return $this;
    }

    public function setLastUpdateTime($lastupdateTime)
    {
        $this->_data['lastupdatetime'] = $lastupdateTime;
        return $this;
    }

    public function setDescription($description)
    {
        $this->_data['description'] = $description;
        return $this;
    }

    public function setOrderCount($orderCount)
    {
        $this->_data['ordercount'] = $orderCount;
        return $this;
    }

    public function setImageUrl($url)
    {
        $this->_data['imageurl'] = $url;
        return $this;
    }

    public function setIsActive($isActive)
    {
        $this->_data['isactive'] = $isActive;
        return $this;
    }

    public function setIsAudit($isAudit)
    {
        $this->_data['isaudit'] = $isAudit;
        return $this;
    }

    public function setIsPartner($isPartner)
    {
        $this->_data['ispartner'] = $isPartner;
        return $this;
    }

    public function setHasTerminal($hasTerminal)
    {
        $this->_data['hasterminal']=$hasTerminal;
        return $this;
    }

    public function setHasPrint($hasPrint)
    {
        $this->_data['hasprint']=$hasPrint;
        return $this;
    }

    public function setIsShopOpen($isShopOpen)
    {
        $this->_data['isshopopen']=$isShopOpen;
        return $this;
    }

    public function setIfRebate($ifRebate)
    {
        $this->_data['ifrebate']=$ifRebate;
        return $this;
    }

    public function setRebateFromShop($rebateFromShop)
    {
        $this->_data['rebatefromshop']=$rebateFromShop;
        return $this;
    }

    public function setIsOpenOrderToUser($openOrderToUser)
    {
        $this->_data['openordertouser']=$openOrderToUser;
        return $this;
    }

    public function setAveragemakeorder($averagemakeorder)
    {
        $this->_data['averagemakeorder'] = $averagemakeorder;
        return $this;
    }

    public function setAveragebakeout($averagebakeout)
    {
        $this->_data['averagebakeout'] = $averagebakeout;
        return $this;
    }

    public function setAveragetocenter($averagetocenter)
    {
        $this->_data['averagetocenter'] = $averagetocenter;
        return $this;
    }

    public function setAveragedelivery($averagedelivery)
    {
        $this->_data['averagedelivery'] = $averagedelivery;
        return $this;
    }

    public function setActualmakeorder($actualmakeorder)
    {
        $this->_data['actualmakeorder'] = $actualmakeorder;
        return $this;
    }

    public function setActualbakeout($actualbakeout)
    {
        $this->_data['actualbakeout'] = $actualbakeout;
        return $this;
    }

    public function setActualtocenter($actualtocenter)
    {
        $this->_data['actualtocenter'] = $actualtocenter;
        return $this;
    }

    public function setActualdelivery($actualdelivery)
    {
        $this->_data['actualdelivery'] = $actualdelivery;
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
