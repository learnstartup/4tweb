<?php

defined('WEKIT_VERSION') or exit(403);

class App_Baiduuserchannel_Dm extends PwBaseDm
{
	protected $id;

	public function setShopId($shopid)
    {
        $this->_data['shopid'] = $shopid;
        return $this;
    }

    public function setBaiduUserId($baiduuserid)
    {
        $this->_data['baiduuserid'] = $baiduuserid;
        return $this;
    }

    public function setChannelId($channelid)
    {
        $this->_data['channelid'] = $channelid;
        return $this;
    }

    protected function _beforeAdd()
    {
        // TODO Auto-generated method stub
        //check the fields value before add
        return true;
    }

    protected function _beforeUpdate()
    {
        // TODO Auto-generated method stub
        //check the fields value before update
        return true;
    }

}

?>