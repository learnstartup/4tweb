<?php
defined('WEKIT_VERSION') or exit(403);
Wind::import('EXT:4tschool.service.tmpuser.dm.App_Tmpuser_Dm');

/**
 * App_TmpUser - 数据服务接口
 * 1: website
 * 2: app
 * 3: weixin
 */
class App_Tmpuser
{
	/**
     * add record
     *
     * @param App_Tmpuser_Dm $dm
     * @return multitype:|Ambigous <boolean, number, string, rowCount>
     */
    public function add(App_Tmpuser_Dm $dm)
    {

        if (true !== ($r = $dm->beforeAdd())) return $r;
        return $this->loadDao()->add($dm->getData());
    }

    
    /**
     * get by key
     *
     * @param $from: say weixin, website, app
     * @param $key: say ******************
     */
    public function getbyKey($from,$key)
    {
        return $this->loadDao()->getbyKey($from,$key);
    }

    public function whereUserFrom($userid)
    {
        return $this->loadDao()->whereUserFrom($userid);
    }


    public function registerTmpUser($from=1,$key='')
    {
        //need to check if registered user exists or not
        if(empty($key) == false)
        {
            //if has key, then check if this key has user or not
            $tmpFound = $this->getbyKey($from,$key);
            if(empty($tmpFound) == false)
            {
                //if has user info, then return user's information
                $userid = $tmpFound['userid'];

                return Windid::load('user.WindidUser')->getUserByUid($userid, WindidUser::FETCH_MAIN);
            }

        }


        Wind::import('SRC:service.user.dm.PwUserInfoDm');
        $userDm = new PwUserInfoDm();
        $password = substr(md5(rand().'123456'),0,15);

        //order number: 13 number and 3 random number
        $currentTimeStamp = strtotime("+0 day");
        $prefix = 'tmp';
        if($from == 1)
        {
        	$prefix = 'web';
        }
        else if($from == 2)
        {
        	$prefix = 'app';
        }
        else if($from == 3)
        	$prefix ='wx';
        $username = $prefix.rand(10, 99) . $currentTimeStamp;

        $userDm->setUsername($username);
        $userDm->setPassword($password);
        $userDm->setRegdate(Pw::getTime());
        $userDm->setLastvisit(Pw::getTime());
        $userDm->setRegip(Wekit::app()->clientIp);

        Wind::import('SRV:user.srv.PwRegisterService');
        Wind::import('APPS:u.service.helper.PwUserHelper');
        Wind::import('SRV:user.validator.PwUserValidator');
        Wind::import('Wind:utility.WindValidator');
        Wind::import('SRV:user.srv.PwLoginService');
        
        $registerService = new PwRegisterService();
        $registerService->setUserDm($userDm);
        $info = $registerService->register();

        $userService = Wekit::load('user.srv.PwUserService');
        $userService->updateLastLoginData($info['uid'], Wekit::app()->clientIp);
        $userService->createIdentity($info['uid'], $password);

        $dm = new App_Tmpuser_Dm();
        $dm->setUserId($info['uid']);
        $dm->setFrom($from);
        $dm->setKey($key);
        $this->add($dm);

        return $info;
    }

    /**
     * @return App_TmpUser_Dao
     */
    private function loadDao()
    {
        return Wekit::loadDao('EXT:4tschool.service.tmpuser.dao.App_Tmpuser_Dao');
    }

}

?>