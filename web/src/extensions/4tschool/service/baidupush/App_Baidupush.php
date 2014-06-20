<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_Baidupush - 数据服务接口
 */
class App_Baidupush
{

	//推送android设备, userid 消息
	public function PushMessageToShop ($user_id ='1106553480533677177',$title='点餐哟新订单通知',$content='请您打开终端进行接收, 谢谢')
	{
		require_once (dirname(__FILE__) . DIRECTORY_SEPARATOR."baidusdk/Channel.class.php" ) ;
		
		$baidukey = include Wind::getRealPath('ROOT:conf.baidushopclientkey.php', true);
		$apiKey = $baidukey['appid'];
		$secretKey = $baidukey['appsecret'];

		$env = $baidukey['env'];
		if($env == 'dev')
		{
			//need to set one user id, as in dev, you will not want to send to user...
		}
		
	    $channel = new Channel ( $apiKey, $secretKey ) ;
		//推送消息到某个user，设置push_type = 1; 
		//推送消息到一个tag中的全部user，设置push_type = 2;
		//推送消息到该app中的全部user，设置push_type = 3;
		$push_type = 1; //推送单播消息
		$optional[Channel::USER_ID] = $user_id; //如果推送单播消息，需要指定user
		//optional[Channel::TAG_NAME] = "xxxx";  //如果推送tag消息，需要指定tag_name

		//指定发到android设备
		$optional[Channel::DEVICE_TYPE] = 3;
		//指定消息类型为通知
		$optional[Channel::MESSAGE_TYPE] = 1;
		//通知类型的内容必须按指定内容发送，示例如下：
		$message = '{ 
				"notification_builder_id": 0,
				"custom_content": {"jumpTo":"ConfirmActivity"},
				"pkg_name":"com.fenxiangyo.shopclient",
				"title": "##title##",
				"description": "##content##",
				"notification_basic_style":7,
				"open_type":3
	 		}';

	 	$message = str_replace('##title##',$title,$message);
	 	$message = str_replace('##content##',$content,$message);

		$message_key = "msg_key";

		try
		{
	    	$ret = $channel->pushMessage ( $push_type, $message, $message_key, $optional );
		    if ( false === $ret )
		    {
		    }
		    else
		    {
		       
		    }
	    }
	    catch(Exception $e)
	    {

	    }
	    
	}

	
	//推送android设备, 指定的tag 消息
	public function PushMessageToDaikeTag($tag ='diancanyodaike',$title ="订单处理延迟,请跟进",$content='如题,请及时处理')
	{

		require_once (dirname(__FILE__) . DIRECTORY_SEPARATOR."baidusdk/Channel.class.php" ) ;
		
	    $baidukey = include Wind::getRealPath('ROOT:conf.baidudaikekey.php', true);
	    $apiKey = $baidukey['appid'];
		$secretKey = $baidukey['appsecret'];
		$env = $baidukey['env'];

		$title = $env.$title;

	    $channel = new Channel ( $apiKey, $secretKey ) ;
		//推送消息到某个user，设置push_type = 1; 
		//推送消息到一个tag中的全部user，设置push_type = 2;
		//
		$push_type = 2; 
		//$optional[Channel::USER_ID] = $user_id; //如果推送单播消息，需要指定user
		$optional[Channel::TAG_NAME] = $tag;  //如果推送tag消息，需要指定tag_name

		//指定发到android设备
		$optional[Channel::DEVICE_TYPE] = 3;
		//指定消息类型为通知
		$optional[Channel::MESSAGE_TYPE] = 1;
		//通知类型的内容必须按指定内容发送，示例如下：
		$message = '{ 
				"title": "##title##",
				"description": "##content##",
				"notification_basic_style":7,
				"open_type":1,
				"url":"http://www.baidu.com"
	 		}';

	 	$message = str_replace('##title##',$title,$message);
	 	$message = str_replace('##content##',$content,$message);

	 	
		$message_key = "msg_key";

		try
		{
		    $ret = $channel->pushMessage ( $push_type, $message, $message_key, $optional ) ;
		    
		    if ( false === $ret )
		    {
		    	var_dump($channel);
		    }
		    else
		    {
		       
		    }
	    }
	    catch(Exception $ex)
	    {

	    }
	}

    public function add(App_Baidupush_Dm $dm)
    {
        if (true !== ($r = $dm->beforeAdd())) return $r;
        return $this->loadDao()->add($dm->getData());
    }

    public function loadDao()
    {
        return Wekit::load('EXT:4tschool.service.baidupush.dao.App_Baidupush_Dao');
    }

}

?>