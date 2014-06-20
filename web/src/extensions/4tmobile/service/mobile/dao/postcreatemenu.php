<?php
header("Content-type: text/html; charset=utf-8");

$access_token="V-Ylr_HoPLIIDLVkHvRMQB8XGqCjSvU4hZ0qABNPnoN3PKa1CHGHX4D0muNAF3LgKGC82T_78kNX0orcvazgmzM-_ZLgrYtuDE-Px_tT3dRmckJ23VKB_UU2TZjlVSiEwgC5ceH3Zqt6pXLTtdg6Aw";

$data='{
     "button":[
      { 
          "type":"click",
          "name":"在线点餐",
          "key":"CLICK_ONLINE_ORDER"
      },
      {
           "type":"click",
           "name":"我的订单",
           "key":"CLICK_MY_ORDER"
      },
      {
           "type":"view",
           "name":"区域加盟",
           "url":"#"
      }]
 }';

$ch = curl_init();  
curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token);  
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");  
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);  
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);  
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');  
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
curl_setopt($ch, CURLOPT_AUTOREFERER, 1);  
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
$tmpInfo = curl_exec($ch);  
if (curl_errno($ch)) {  
echo curl_error($ch);  
}            
curl_close($ch);              
echo $tmpInfo; 
?>