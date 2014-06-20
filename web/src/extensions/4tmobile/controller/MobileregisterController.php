<?php

Wind::import('EXT:4tschool.controller.T4BaseNotLoginController');
Wind::import('SRV:user.srv.PwLoginService');

class MobileregisterController extends T4BaseNotLoginController
{
    
    public function run()
    {
    	if(isset($_POST['submit']))
    	{
            list($mobile, 
                 $password, 
                 $username) = $this->getInput(array('mobile', 
                                                    'password', 
                                                    'username'), 'post');
            $registeresult = $this->_getCommonDs()->weixinRegisterUser(Wekit::C('site', 'info.url'), $mobile, $password, $username);
    	}
        
    } 

    /**
     * @return App_Mobilelogin
     */
    private function _getMobileloginDs()
    {
        return Wekit::load('EXT:4tmobile.service.mobile.App_Weixin');
    }

    /**
     * @return App_Common
     */
    private function _getCommonDs()
    {
        return Wekit::load('EXT:4tmobile.service.mobile.App_Common');
    }

}

?>