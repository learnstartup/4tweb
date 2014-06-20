<?php

class MobilecontactusController extends PwBaseController
{
    public function run()
    {
        $is_weixin=$this->_getCommonDs()->is_weixin();
        $is_weixin=true;
        if (!$is_weixin) {
            return;
        }        
        $this->setOutput($is_weixin,'is_weixin');        
    	
    }

    private function _getCommonDs ()
    {
        return Wekit::load('EXT:4tmobile.service.common.App_Common');
    }        
}

?>