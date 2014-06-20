<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_OrderStatusNotify - 数据服务接口
 *
 */
class App_OrderStatusNotify
{

    private $baseUrl = "";
    private $weixinkey = array();

    static $Access_Token = '';
    static $Token_Timeout = '';

    public function __construct() {
        
        $weixinkey = include Wind::getRealPath('ROOT:conf.weixinkey.php', true);
        $this->weixinkey = $weixinkey;
        $this->baseUrl = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$weixinkey['appid']."&secret=".$weixinkey['appsecret'];
    }

    public function SendStatusNotify($status,$orderid)
    {

        //get order detail
        $orderdetail = $this->_getOrderDS()->getOrdertail($orderid);
        $orderdetail= $orderdetail[0];

        if(empty($orderdetail))
            return;

        $userid = $orderdetail['userid'];
        $mobile = $orderdetail['tomobile'];

        $dianbi = $orderdetail['deservedpointcoin'];
        $dianbimessage = empty($dianbi)?"此单不返点币":"此单您可返点币".$dianbi."(1点币=0.1元) 请在外卖抵达后在“我的订单”里确认收货就会返还到您的零钱包里哦";


        //如果是手机用户就发短信
        //check user if from weixin or web
        $userInfo = $this->_getTmpUserDS()->whereUserFrom($userid);
        $from =1; //website
        $key = '';

        if(empty($userInfo))
        {
            $from = 1;
        }
        else
        {
            $from = $userInfo['from'];
            $key = $userInfo['key'];
        }

//test only
        if($this->weixinkey['env'] == 'dev')
        {

            $key = 'oemrGt0boZQoJake_eUlkOxPJYu8'; //always push to one user
            $from = 3;

            $mobile = '15270011972';
        }
//end-test

        try
        {
            switch ($status) {
                case 0: //仅从微信下单才通知
                    $message = "恭喜您下单成功！".$dianbimessage;
                    $this->_PostWeixinMessage($message,$key);
                    break;
                case -1:
                    $message = "缺货, 您的订单商家标记为缺货, 请重新选购, 造成的不便, 我们深表歉意,（如非本人操作，可不予理会）【".Wekit::C('site', 'info.name')."】";
                    if($from == 1) //
                    {
                        //网站,需要发短信
                        $result = Wind::getComponent('mobileplat')->sendMobileMessage($mobile,$message);

                        $hasError = false;
                        if ($result instanceof PwError)
                        {
                            $hasError = true;
                        }
                    }
                    else if($from == 3)
                    {
                        $message = "缺货, 您的订单商家标记为缺货, 请重新选购, 造成的不便, 我们深表歉意【".Wekit::C('site', 'info.name')."】";
                        $this->_PostWeixinMessage($message,$key);
                    }
                    break;
                case 2:
                    if($from == 1) //
                    {
                        $message = "您的订单商家已确认,正在制作中,".$dianbimessage." （如非本人操作，可不予理会）【".Wekit::C('site', 'info.name')."】";
                        //网站,需要发短信
                        $result = Wind::getComponent('mobileplat')->sendMobileMessage($mobile,$message);

                        $hasError = false;
                        if ($result instanceof PwError)
                        {
                            $hasError = true;
                        }
                    } 

                    if($from == 3)
                    {
                        //weixin
                        $message = "您的订单商家已确认,正在制作中,".$dianbimessage."【".Wekit::C('site', 'info.name')."】";
                        $this->_PostWeixinMessage($message,$key);
                        //save log
                    }
                    break;
                case 6:
                $message = "您的订单商家标记为用户拒签,我们将进行核实, 带来的不便, 我们深表歉意【".Wekit::C('site', 'info.name')."】";
                    if($from == 1) //
                    {
                        //网站,需要发短信
                        $result = Wind::getComponent('mobileplat')->sendMobileMessage($mobile,$message);

                        $hasError = false;
                        if ($result instanceof PwError)
                        {
                            $hasError = true;
                        }
                    }
                    else if($from == 3)
                    {
                        $this->_PostWeixinMessage($message,$key);
                    }
                    break;
                default:
                    break;
            }

        }
        catch(Exception $ex)
        {

        }
        
    }

    private function _PostWeixinMessage($content,$userkey)
    {
        $message['touser'] = $userkey;
        $message["text"]['content'] = $content;//'你妹Hello World';
        $message["msgtype"] = 'text';

        $token = $this->_GetWeiXinAccessToken();
        if(empty($token))
        {
            return;
        }

        $postUrl = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$token;

        //send message
        $data_string = mb_convert_encoding($this->my_json_encode($message),'utf-8'); //json_encode($message); //5.4以下没有参数，所以必须用以下办法
        
        $ch = curl_init($postUrl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded',
            'charset:utf-8',
            'Content-Length: ' . strlen($data_string)
        ));

        $result = curl_exec($ch);

        //need to add log
        file_put_contents('/tmp/test.txt',$data_string.$result,FILE_APPEND);
         
        
    }

    public function _GetWeiXinAccessToken()
    {
        $now = time();

        $tokenData = $this->_getWeixinTokenDS()->getValidToken($now);
        
        if(empty($tokenData))
        {
            //re-create token
            // 创建一个cURL句柄
            $ch = curl_init($this->baseUrl);

            $ret = curl_setopt($ch, CURLOPT_TIMEOUT,30);
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

            // 执行
            $file_contents = curl_exec($ch);

            // 检查是否有错误发生
            if(!curl_errno($ch))
            {
                $file_contents = json_decode($file_contents);
                $file_contents = (array)$file_contents;
                $token = $file_contents['access_token'];
                $expireat = $now + $file_contents['expires_in'] - 200;

                $this->_getWeixinTokenDS()->AddNewToken($token,$expireat);
            }
            else
            {
                //has issue happens
                //log error message
                
            }

            curl_close($ch);

            return $token;
        }
        else
        {
            return $tokenData['token'];
        }
          
    }

    public function PushToShopClient($shopid,$openordertouser,$notifytitle,$notifycontent)
    {
         //get shopid by userid/channel id
        $baiduuserid = $this->_getBaiduuserchannelDs()->getBaiduuserIdByShopId($shopid);
        if(empty($baiduuserid))
            $baiduuserid = '1106553480533677177'; //yang baidu kehuduan id
        $this->_getBaiduPushDS()->PushMessageToShop($baiduuserid,$notifytitle,$notifycontent);

        if($openordertouser == 1)
        {
            //push to diancanyodaike tag
            $this->_getBaiduPushDS()->PushMessageToDaikeTag('diancanyodaike','代客下单'.$notifytitle,$notifycontent);
        }
   

    }

    public function PushToDiancanYoDelay()
    {
        $this->_getBaiduPushDS()->PushMessageToDaikeTag();
    }

    private function my_json_encode($arr)
    {
            //convmap since 0x80 char codes so it takes all multibyte codes (above ASCII 127). So such characters are being "hidden" from normal json_encoding
            array_walk_recursive($arr, function (&$item, $key) { if (is_string($item)) $item = mb_encode_numericentity($item, array (0x80, 0xffff, 0, 0xffff), 'UTF-8'); });
            return mb_decode_numericentity(json_encode($arr), array (0x80, 0xffff, 0, 0xffff), 'UTF-8');

    }


    private function _getTmpUserDS()
    {
        return Wekit::load('EXT:4tschool.service.tmpuser.App_Tmpuser');
    }

    private function _getOrderDS()
    {
        return Wekit::load('EXT:4tschool.service.myorder.App_MyOrder');
    }

    private function _getWeixinTokenDS()
    {
        return Wekit::load('EXT:4tschool.service.weixin.App_Weixin');
    }

    private function _getBaiduPushDS()
    {
        return Wekit::load('EXT:4tschool.service.baidupush.App_Baidupush');
    }

        /**
     * @return App_Baiduuserchannel
     */
    private function _getBaiduuserchannelDs()
    {
        return Wekit::load('EXT:4tschool.service.baidupush.App_Baiduuserchannel');
    }
    
}

?>
