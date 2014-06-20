<?php

class MobileschoolController extends PwBaseController
{
    public function run()
    {
        $is_weixin=$this->_getCommonDs()->is_weixin();
        if (!$is_weixin) {
            return;
        }        
        $this->setOutput($is_weixin,'is_weixin');

        $wechatOpenId=$this->getInput('openid','get');
    	$this->setOutput($wechatOpenId,'openId');
        $schoolList = $this->_getSchoolOpenDS()->getOpenedSchools();
        $this->setOutput($schoolList, 'schoolList');
    }

    private function _getSchoolOpenDS()
    {
        return Wekit::load('EXT:4tschool.service.school.App_School');
    }

    private function _getCommonDs ()
    {
        return Wekit::load('EXT:4tmobile.service.common.App_Common');
    }        
}

?>