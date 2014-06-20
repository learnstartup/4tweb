<?php
class MobileqrcodeController extends PwBaseController{

	
	public function run (){
			
    $shopid = $this->getInput('shopid');

		$token = $this->_getOrderStatusNotifyDs()->_GetWeiXinAccessToken();
	
    $postData = array("action_name" =>'QR_LIMIT_SCENE','action_info' => array('scene' => array("scene_id" => $shopid)));
		
    $postUrl = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$token;

    $ch = curl_init($postUrl);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded',
            'charset:utf-8'
        ));

   $result = curl_exec($ch);
   print_r($postData);
   print_r($result);

   if(!empty($result))
   {
      $result = (array)json_decode($result);
      $ticket = $result['ticket'];

      $qrurl = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".urlencode($ticket);
      $this->setOutput($shopid,'shopid');
      $this->setOutput($qrurl,'qrurl');
   }
   else
   {
      echo "无法输出有效的商家二维码";die;
   }

}

/**
     * @return App_OrderStatusNotify
     */
    private function _getOrderStatusNotifyDs()
    {
        return Wekit::load('EXT:4tschool.service.myorder.App_OrderStatusNotify');
    }

	
}
?>