<?php

Wind::import('EXT:4tschool.controller.T4BaseNotLoginController');

class MobilemymoneyController extends T4BaseNotLoginController
{    
    public function run()
    {     
        $is_weixin=$this->_getCommonDs()->is_weixin();

        if (!$is_weixin) {
            return;
        }        
        $this->setOutput($is_weixin,'is_weixin');

        $this->setOutput($this->_getGiftExchange()->getPrizes(),'prizeList');

        $schoolid = $this->getCurrentSchoolId();
        $this->setOutput($schoolid,'schoolId');        

        $openid=$this->getInput('openid');
        $this->setOutput($openid,'openId');        

        $user=$this->_getTmpUserDS()->getbyKey($this->_getCommonDs()->getWechatKey(),$openid);

        if (empty($user)==false) {
            $userid=$user['userid'];
        }

        $myMoney=$this->_getMyMoneyDS()->getMyMoney($userid);

        $myMoney=$myMoney[0];

        $this->setOutput($myMoney,'myMoney');
    }

    private function _getCommonDs ()
    {
        return Wekit::load('EXT:4tmobile.service.common.App_Common');
    }       

    /**
     * @return App_MyOrder
     */
    private function _getMyMoneyDS()
    {
        return Wekit::load('EXT:4tschool.service.mymoney.App_MyMoney');
    }     

    /**
     * @return App_TmpUser
     */
    private function _getTmpUserDS()
    {
        return Wekit::load('EXT:4tschool.service.tmpuser.App_Tmpuser');
    }      

    /**
     * @return App_Giftexchange
     */
    private function _getGiftExchange()
    {
        return Wekit::load('EXT:4tschool.service.giftexchange.App_Giftexchange');
    }

}

?>