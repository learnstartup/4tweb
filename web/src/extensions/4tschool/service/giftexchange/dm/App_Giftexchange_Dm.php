<?php

defined('WEKIT_VERSION') or exit(403);

class App_Giftexchange_Dm extends PwBaseDm
{
	protected $id;

    public function setUserId($userid)
    {
        $this->_data['userid'] = $userid;
        return $this;
    }

    public function setContact($contact)
    {
        $this->_data['contact'] = $contact;
        return $this;
    }

    public function setPhoneNumber($phonenumber)
    {
        $this->_data['phonenumber'] = $phonenumber;
        return $this;
    }

    public function setqq($qq)
    {
        $this->_data['qq'] = $qq;
        return $this;
    }

    public function setAddress($address)
    {
        $this->_data['address'] = $address;
        return $this;
    }

    public function setProductId($productid)
    {
        $this->_data['productid'] = $productid;
        return $this;
    }

    public function setExchangeSuccess($exchangesuccess)
    {
        $this->_data['exchangesuccess'] = $exchangesuccess;
        return $this;
    }

    public function setCreateTime($createtime)
    {
        $this->_data['createtime'] = $createtime;
        return $this;
    }

    public function setUpdateTime($updatetime)
    {
        $this->_data['updatetime'] = $updatetime;
        return $this;
    }

    public function setExceptionExchange($exceptionexchange)
    {
        $this->_data['exceptionexchange'] = $exceptionexchange;
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

?>