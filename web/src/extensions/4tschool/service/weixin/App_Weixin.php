<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_TmpUser - 数据服务接口
 * 1: website
 * 2: app
 * 3: weixin
 */
class App_Weixin
{

    public function getValidToken($currenttime)
    {
        return $this->loadDao()->getToken($currenttime);
    }

    public function AddNewToken($token,$expireat)
    {
        $data['token'] = $token;
        $data['expireat'] = $expireat;

        $this->loadDao()->add($data);
    }
	
    /**
     * @return App_TmpUser_Dao
     */
    private function loadDao()
    {
        return Wekit::loadDao('EXT:4tschool.service.weixin.dao.App_WeixinToken_Dao');
    }

}

?>