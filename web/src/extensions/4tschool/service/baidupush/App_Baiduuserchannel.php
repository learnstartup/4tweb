<?php
defined('WEKIT_VERSION') or exit(403);
Wind::import('EXT:4tschool.service.baidupush.dm.App_Baiduuserchannel_Dm');

/**
 * App_Baiduuserchannel - 数据服务接口
 */
class App_Baiduuserchannel
{

	//推送android设备, userid 消息
	public function run()
	{
	    
	}

	public function getBaiduuserIdByShopId($shopid)
	{
		return $this->loadDao()->getBaiduuserIdByShopId($shopid);
	}

    public function addBaiduuserChannelMsg($baiduUserChannelArr)
    {
    	$dm = new App_Baiduuserchannel_Dm();
    	$dm->setShopId($baiduUserChannelArr['shopid'])
    	   ->setBaiduUserId($baiduUserChannelArr['baiduuserid'])
    	   ->setChannelId($baiduUserChannelArr['channelid']);

        if (true !== ($r = $dm->beforeAdd())) return $r;

        $this->loadDao()->deleteByShopid($baiduUserChannelArr['shopid']); //delete if other already use it
        return $this->loadDao()->add($dm->getData());
    }

    public function baiduchannelifexist($baiduUserChannelArr)
    {
    	return $this->loadDao()->baiduchannelifexist($baiduUserChannelArr);
    }

    /**
     * update record
     *
     * @param App_Baiduuserchannel_Dm $dm
     * @return multitype:|Ambigous <boolean, number, rowCount>
     */
    public function update($id, App_Baiduuserchannel_Dm $dm)
    {
        if (true !== ($r = $dm->beforeUpdate())) return $r;
        return $this->loadDao()->update($id, $dm->getData());
    }

    /**
     * delete a record
     *
     * @param unknown_type $id
     * @return Ambigous <number, boolean, rowCount>
     */
    public function delete($id)
    {
        return $this->loadDao()->delete($id);
    }

    public function get($id){
        return $this->loadDao()->get($id);
    }

    public function loadDao()
    {
        return Wekit::load('EXT:4tschool.service.baidupush.dao.App_Baiduuserchannel_Dao');
    }



}

?>