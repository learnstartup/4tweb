<?php

Wind::import('EXT:4tschool.controller.T4BaseNotLoginController');
Wind::import('SRV:user.srv.PwLoginService');

class MobileloginController extends T4BaseNotLoginController
{
    
    public function run()
    {
    	if(isset($_POST['submit']))
    	{
		    $username = $_POST['username']; 
		    $password = $_POST['password'];
		    $loginstatusmsg = $this->_getCommonDs()->weiXinLogin(Wekit::C('site', 'info.url'), $username, $password);

            if($loginstatusmsg['Success'] == 1)
            {
                session_start();
                $_SESSION["uname"] = $username;
                $_SESSION["pwd"] = $password;
                header('Location:'.Wekit::C('site', 'info.url').'/index.php?m=app&c=mobilelogin&app=4tmobile&a=school');
            }

    	}
        
        if(!empty($_SESSION["uname"]) && !empty($_SESSION["pwd"])){
            header('Location:'.Wekit::C('site', 'info.url').'/index.php?m=app&c=mobilelogin&app=4tmobile&a=school');
        }

    }

    public function schoolAction()
    {
        $schoolList = $this->_getSchoolOpenDS()->getOpenedSchools();
        
        $this->setOutput($schoolList, 'schoolList');
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

    private function _getSchoolOpenDS()
    {
        return Wekit::load('EXT:4tschool.service.school.App_School');
    }

}

?>