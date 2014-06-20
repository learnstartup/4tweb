<?php

Wind::import('EXT:4tschool.controller.T4BaseNotLoginController');
Wind::import('EXT:4tschool.service.giftexchange.dm.App_Giftexchange_Dm');

class MobilereceiveinformationController extends T4BaseNotLoginController
{
    public function run()
    {        
        $is_weixin=$this->_getCommonDs()->is_weixin();
        
        if (!$is_weixin) {
            return;
        }        
        $this->setOutput($is_weixin,'is_weixin');        

        list($openid,$id,$key)=$this->getInput(array('openid','id','key'));

        //user validation
        $userMoney=$this->getUserMoneyByOpenId($openid);
        $this->setOutput($userMoney,'userMoney');

        if (empty($userMoney)==false) {
            $prize=$this->_getCommonDs()->getPrizeById($id);
            //check user money
            if (empty($prize)==false) {
                $this->setOutput($prize['dmoney']<=$userMoney['money'],'isenough');
                $this->setOutput($prize,'prize');
            }            
        }

        $this->setOutput($key,'key');
        $this->setOutput($openid,'openId');        
   
        
        //get and save receive information
        //prompt success or fail      
    }

    public function doSaveInformationAction (){
        list($openid,$id,$key)=$this->getInput(array('openid','pid','key'));
        $this->setOutput($openid,'openId');          

        if (!isset($_SESSION)) {
            @session_start();
        }

        $_SESSION['exchangekey']=$key;

        //user validation
        $userMoney=$this->getUserMoneyByOpenId($openid);

        if (empty($userMoney)==false&&isset($_SESSION['exchangekey'])) {
            $prize=$this->_getCommonDs()->getPrizeById($id);
            //check user money
            if (empty($prize)==false&&$prize['dmoney']<=$userMoney['money']) {

                $deductDMoeny=0-$prize['dmoney'];                

                $isDeduct=$this->_getMyMoneyDS()->updateMyMoney($userMoney['userid'],$deductDMoeny,0,$prize['name']);

                if ($isDeduct>0) {
                    unset($_SESSION['exchangekey']);
                    $this->setOutput($isDeduct,"isDeduct");
                }

                $myMoney=$this->_getMyMoneyDS()->getMyMoney($userMoney['userid']);
                $this->setOutput($myMoney[0],'myMoney');                
                $this->setOutput($prize,"prize");

                list($pid,$receiveContactor,$receivePhone,$receiveQQ,$receiveAddress)=$this->getInput(array('pid','receiveContactor','receivePhone','receiveQQ','receiveAddress'));
                $dm=new App_Giftexchange_Dm();
                $dm->setUserId($userMoney['userid'])
                ->setContact($receiveContactor)
                ->setPhoneNumber($receivePhone)
                ->setqq($receiveQQ)
                ->setAddress($receiveAddress)
                ->setProductId($prize['id'])
                ->setCreateTime(Pw::getTime());

                $saveInfo=$this->_getGiftexchangeDS()->add($dm);
                $this->setOutput($saveInfo,'saveInfo');
            }            
        }
        else
        {
            $url=WindUrlHelper::createUrl('app/4tmobile/mobilemymoney/run',array('openid'=>$openid));
            $this->forwardRedirect($url);
        }    
    }

    private function getUserMoneyByOpenId ($openid){

        $user=$this->_getTmpUserDS()->getbyKey($this->_getCommonDs()->getWechatKey(),$openid);

        if (empty($user)) {
            return null;
        }

        $userid=$user['userid'];

        $myMoney=$this->_getMyMoneyDS()->getMyMoney($userid);

        return $myMoney[0];
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
     * @return App_TmpUser
     */
    private function _getGiftexchangeDS()
    {
        return Wekit::load('EXT:4tschool.service.giftexchange.App_Giftexchange');
    }            
}

?>