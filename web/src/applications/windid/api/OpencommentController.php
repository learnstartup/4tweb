<?php
Wind::import('APPS:windid.api.OpenBaseController');
/**
 * the last known user to change this file in the repository  <$LastChangedBy: Peter.yan $>
 * @author $Author: Peter.yan $ 215169718@qq.com
 * @copyright ?2003-2103 fenxiangyo.com
 * @license http://www.fenxiangyo.com
 * @package
 */
class OpencommentController extends OpenBaseController
{
	public function getMCommentAction()
    {
    	list($mid, 
    		 $limit, 
    		 $offset) = $this->getInput(array('mid', 'limit', 'offset'), 'get');
    	$messageList = $this->_getMerCommentDS()->getMcomment($mid, $limit, $offset);
        foreach ($messageList as $key => $value) 
        {
            $messageList[$key]['username'] = $this->formatUserName($value['username']);
        }
        $this->output($messageList);
    }

    public function formatUserName($username)
    {
        $newname = '';
        $count = floor(strlen($username)/2);
        for ($i=0; $i < strlen($username); $i++) {
            if($i < $count && $i >= $count - 2)
            {
                $newname .= '*';
            }
            else
            {
                $newname .= $username[$i];
            } 
        }

        return $newname;
    }

    public function AddCommentAction()
    {
        list($schoolid, 
             $mid, 
             $userid,
             $orderid, 
             $comment, 
             $tastescore,
             $servicescore) = $this->getInput(array('schoolid', 
                                                    'mid', 
                                                    'userid',
                                                    'orderid', 
                                                    'comment',
                                                    'tastescore',
                                                    'servicescore'), 'get');
        $orderid = empty($orderid)?0:$orderid;
        $exists = $this->_getShopCommentDS()->checkIfExists($userid, $orderid, $mid);

        if($exists || empty($userid))
        {
            $this->output(0);
        }
        else
        {
            $id = $this->_getShopCommentDS()->addMyComment($userid, 
                                                           $mid, 
                                                           0, 
                                                           $comment, 
                                                           0, 
                                                           $servicescore, 
                                                           $tastescore);
        }
        
        if($id > 0)
        {
            $this->_getMyMoneyDS()->updateMyCredit($userid, 1 ,"对菜品评论后转入积分");
            $this->_getMyOrderDS()->updateItemasCommented($orderid, $mid);
            $this->output(1);
        }
        else
        {
            $this->output(0);
        }
        
    }

    public function getMcommentMessageAction()
    {
        list($mid) = $this->getInput(array('mid'), 'get');

        $McommentMessage = $this->_getMerCommentDS()->getMcommentMessage($mid);
        
        $countComment = count($McommentMessage);
        $tastescore = 0;
        $servicescore = 0;
        $resulCommentList = array();
        foreach ($McommentMessage as $key => $value) 
        {
            $servicescore += $value['servicescore'];
            $tastescore += $value['tastescore'];
        }

        $servicescore = floor($servicescore/$countComment);
        $tastescore = floor($tastescore/$countComment);

        $resulCommentList = array('commentotal' => $countComment,
                                  'servicescore' => $servicescore,
                                  'tastescore' => $tastescore);
        $this->output($resulCommentList);
    }

    public function getMyMoneyAction()
    {
        list($userid) = $this->getInput(array('userid'), 'get');

        $myCredit = $this->_getMyMoneyDS()->getMyMoney($userid);
        $this->output($myCredit[0]);
    }

    /**
     * @return App_MerComment
     */
    private function _getMerCommentDS()
    {
        return Wekit::load('EXT:4tschool.service.mercomment.App_MerComment');
    }

    private function _getShopCommentDS()
    {
        return Wekit::load('EXT:4tschool.service.mercomment.App_MerComment');
    }

    private function _getMyMoneyDS()
    {
        return Wekit::load('EXT:4tschool.service.mymoney.App_MyMoney');
    }

    private function _getMyOrderDS()
    {
        return Wekit::load('EXT:4tschool.service.myorder.App_MyOrder');
    }

}


?>