<?php
Wind::import('EXT:4tschool.controller.T4BaseNotLoginController');
Wind::import('EXT:4tschool.service.giftexchange.dm.App_Giftexchange_Dm');
/**
 */
class DcyMallController extends T4BaseNotLoginController {

	public function beforeAction($handlerAdapter) {
		parent::beforeAction($handlerAdapter);
	}

	public function run() {
		$userid = $this->loginUser->uid;
		$isLogin=($userid>0)==true;
		$this->setOutput($isLogin,"isLogin");

		if ($isLogin) {
			$msg=$this->getInput('message');
			$this->setOutput($msg,'msg');
			$userMoney=$this->_getMyMoneyDS()->getMyMoney($userid);
			$this->setOutput($userMoney[0],"userMoney");			
		}

		$loginUrl=WindUrlHelper::createUrl('u/login/run', array('schoolid' => $this->getCurrentSchoolId()));
		$this->setOutput($loginUrl,"loginUrl");		

		$this->setOutput($this->_getGiftExchange()->getPrizes(),'prizeList');
	}

	public function doSaveInformationAction (){
		$returnMs;
        $userid = $this->loginUser->uid;
        if (!$userid>0) {
        	$returnMsg="您还没有登录，请登录后在兑换礼品！";
        	$this->redirectAndShowMsg($returnMsg);
        }
        
        $userMoney=$this->_getMyMoneyDS()->getMyMoney($userid);
        $userMoney=$userMoney[0];

        if (empty($userMoney)) {
            $returnMsg="未知的用户！";
            $this->redirectAndShowMsg($returnMsg);
        }

        $pid=$this->getInput('pid');
        $prize=$this->_getGiftExchange()->getPrizeById($pid);
        if (empty($prize)) {
        	$returnMsg="您所选择的商品不存在，请重新兑换。";
        	$this->redirectAndShowMsg($returnMsg);
        }


        if ($prize['dmoney']>$userMoney['money']) {
        	$returnMsg="您的点币不足，点餐返点币，赶快去点餐吧！";
        	$this->redirectAndShowMsg($returnMsg);
        }

        $deductDMoeny=0-$prize['dmoney'];                

        $isDeduct=$this->_getMyMoneyDS()->updateMyMoney($userMoney['userid'],$deductDMoeny,0,$prize['name']);

        if ($isDeduct!=1) {
        	$returnMsg="非常抱歉，您刚才的兑换失败了，请再次尝试。";
        	$this->redirectAndShowMsg($returnMsg);        		
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

        $row=$this->_getGiftExchange()->add($dm);
        if (!$row>0) {
        	$returnMsg="收货信息保存失败，请联系点餐哟客服人工处理，给您带来的不便我们深表歉意！";
        	$this->redirectAndShowMsg($returnMsg);
        }
        if($row){
            $nowtime = date('Y-m-d H:i:s');
            Wind::import('LIB:utility.PwMail');
            $mail = new PwMail();
            $mail->sendMail($receiveQQ.'@qq.com', $nowtime.'点餐哟点币兑换', '您已成功兑换'.$prize['name']);
        }

        $returnMsg="您已成功兑换".$prize['name']."，消耗点币".$prize['dmoney']."个。我们将尽快处理，相关信息将以短信或电话的方式通知您。兑换详情请到零钱包中查看。";
        $this->redirectAndShowMsg($returnMsg);
        die;
	}

	private function redirectAndShowMsg ($message){
		$url=WindUrlHelper::createUrl('app/4tschool/dcymall/run',array('message' => $message));
		$this->forwardRedirect($url);		
	}


    /**
     * @return App_Giftexchange
     */
    private function _getGiftExchange()
    {
        return Wekit::load('EXT:4tschool.service.giftexchange.App_Giftexchange');
    }

    /**
     * @return App_MyOrder
     */
    private function _getMyMoneyDS()
    {
        return Wekit::load('EXT:4tschool.service.mymoney.App_MyMoney');
    }             
}