<?php

define("TOKEN", "very9strongpwd");
define("Environment", "dev");

//$wechatObj = new DianCanYoWechatCallbackAPI();
//if (isset($_GET['echostr'])) {
//	$wechatObj->valid();
//} else {
//	$wechatObj->responseMsg();
//}

class Weixin_Controller_Dao {

	private $currentSchool = NULL, $currentUserID = NULL;

	//有效性验证
	public function valid() {
		$echoStr = $_GET["echostr"];
		if ($this->checkSignature()) {
			echo $echoStr;
			exit;
		}
	}

	//验证是否有效
	private function checkSignature() {
		$signature = $_GET["signature"];
		$timestamp = $_GET["timestamp"];
		$nonce = $_GET["nonce"];

		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr);
		$tmpStr = implode($tmpArr);
		$tmpStr = sha1($tmpStr);

		if ($tmpStr == $signature) {
			return true;
		} else {
			return false;
		}
	}
// <xml>
// <ToUserName><![CDATA[toUser]]></ToUserName>
// <FromUserName><![CDATA[FromUser]]></FromUserName>
// <CreateTime>123456789</CreateTime>
// <MsgType><![CDATA[event]]></MsgType>
// <Event><![CDATA[CLICK]]></Event>
// <EventKey><![CDATA[EVENTKEY]]></EventKey>
// </xml>
	//接收事件
	private function receiveEvent($object) {
		$contentStr = "";
		switch ($object->Event) {
			case "subscribe":
				$contentStr = "欢迎关注点餐哟！"
					. "\n" . "发送您的位置即可查看所在学校周边的外卖并进行订餐。"
					. "\n" . "也可以回复相应的数字，选择您所在的学校："
					. "\n" . "【1】江西师范大学科学技术学院(老校区)"
					. "\n" . "【2】江西省南昌大学南院校区"
					. "\n" . "赶紧试下撒～";
				$resultStr = $this->transmitText($object, $contentStr);
				break;
			case "unsubscribe":
				$contentStr = "";
				break;
			case "CLICK":
				switch ($object->EventKey) {
					case "CLICK_ONLINE_ORDER":
						// $contentStr = "请回复相应的数字，选择您所在的学校："
						// 	. "\n" . "【1】江西师范大学科学技术学院(老校区)"
						// 	. "\n" . "【2】江西省南昌大学南院校区";
					    $contentStr="<a href="."http://dev.diancanyo.com/index.php?m=app&c=mobileschool&app=4tmobile".">[点我开始点餐]</a>";
						$resultStr = $this->transmitText($object, $contentStr);
						break;
					case "CLICK_OPEN_SHOP":
						$this->currentSchool = $this->getSessionData("CurrentSchool");
						//						$this->currentSchool = unserialize($this->getSessionData("CurrentSchool"));
						if ($this->currentSchool != NULL) {
							$resultStr = $this->transmitOpenShopList($object, $this->currentSchool['schoolid']);
						} else {
							$contentStr = "没有找到您所在的学校，请重新定位您的位置。"
								. "\n" . "您也可以回复相应的数字，选择您所在的学校："
								. "\n" . "【1】江西师范大学科学技术学院(老校区)"
								. "\n" . "【2】江西省南昌大学南院校区";
							$resultStr = $this->transmitText($object, $contentStr);
						}
						break;
					default:
						$contentStr = "你点击了菜单: " . $object->EventKey;
						$resultStr = $this->transmitText($object, $contentStr);
						break;
				}
				break;
			default:
				$contentStr = "receive a new event: " . $object->Event;
				break;
		}
		return $resultStr;
	}

	//按消息类型分发事件
	public function responseMsg() {
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		if (!empty($postStr)) {
			$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			$RX_TYPE = trim($postObj->MsgType);
			session_id($postObj->FromUserName); //设置session_id 为 FromUserName
			session_start();
			switch ($RX_TYPE) {
				case "text":
					$resultStr = $this->receiveText($postObj);
					break;
				case "image":
					$resultStr = $this->receiveImage($postObj);
					break;
				case "location":
					$resultStr = $this->receiveLocation($postObj);
					break;
				case "voice":
					$resultStr = $this->receiveVoice($postObj);
					break;
				case "video":
					$resultStr = $this->receiveVideo($postObj);
					break;
				case "link":
					$resultStr = $this->receiveLink($postObj);
					break;
				case "event":
					$resultStr = $this->receiveEvent($postObj);
					break;
				default:
					$resultStr = "unknow msg type: " . $RX_TYPE;
					break;
			}
			echo $resultStr;
		} else {
			echo "";
			exit;
		}
	}

	//接收文字
	private function receiveText($object) {
		$funcFlag = 0;
		switch ($object->Content) {
			case "1":
				$school_id = 11045;
				$resultStr = $this->transmitOpenShopList($object, $school_id);
				break;
			case "2":
				$school_id = 1001292;
				$resultStr = $this->transmitOpenShopList($object, $school_id);
				break;
			default :
				$contentStr = "你发送的是文本，内容为：" . $object->Content;
				$resultStr = $this->transmitText($object, $contentStr, $funcFlag);
				break;
		}
		return $resultStr;
	}

	//接收位置
	private function receiveLocation($object) {
		$funcFlag = 0;
		$common = new common();
		$arraySchools = $common->getSchoolsByLocation(Environment, $object->Location_Y, $object->Location_X);
		if (count($arraySchools) == 0) {
			//			$contentStr = "你发送的是位置，纬度为：" . $object->Location_X . "；经度为：" . $object->Location_Y . "；缩放级别为：" . $object->Scale . "；位置为：" . $object->Label;
			$contentStr = "没有找到您所在的学校，请重新定位您的位置。"
				. "\n" . "您还也可以回复相应的数字，选择您所在的学校："
				. "\n" . "【1】江西师范大学科学技术学院(老校区)"
				. "\n" . "【2】江西省南昌大学南院校区";
			$resultStr = $this->transmitText($object, $contentStr, $funcFlag);
		}
		if (count($arraySchools) == 1) {
			$this->currentSchool = $arraySchools[0];
			$this->saveSessionData("CurrentSchool", $this->currentSchool);
			//			$this->saveSessionData("CurrentSchool", serialize($this->currentSchool));
			$resultStr = $this->transmitOpenShopList($object, $this->currentSchool['schoolid']);
		}
		if (count($arraySchools) > 1) {
			//TODO::如果多个学校符合条件则提示用户通过回复数字进行选择
		}
		return $resultStr;
	}

	//接收图片
	private function receiveImage($object) {
		$funcFlag = 0;
		$contentStr = "你发送的是图片，地址为：" . $object->PicUrl;
		$resultStr = $this->transmitText($object, $contentStr, $funcFlag);
		return $resultStr;
	}

	//接收语音
	private function receiveVoice($object) {
		$funcFlag = 0;
		$contentStr = "你发送的是语音，媒体ID为：" . $object->MediaId;
		$resultStr = $this->transmitText($object, $contentStr, $funcFlag);
		return $resultStr;
	}

	//接收视频
	private function receiveVideo($object) {
		$funcFlag = 0;
		$contentStr = "你发送的是视频，媒体ID为：" . $object->MediaId;
		$resultStr = $this->transmitText($object, $contentStr, $funcFlag);
		return $resultStr;
	}

	//接收连接
	private function receiveLink($object) {
		$funcFlag = 0;
		$contentStr = "你发送的是链接，标题为：" . $object->Title . "；内容为：" . $object->Description . "；链接地址为：" . $object->Url;
		$resultStr = $this->transmitText($object, $contentStr, $funcFlag);
		return $resultStr;
	}

	//返回文字格式
	private function transmitText($object, $content, $flag = 0) {
		$textTpl = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[text]]></MsgType>
                            <Content><![CDATA[%s]]></Content>
                            <FuncFlag>%d</FuncFlag>
                            </xml>";
		$resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content, $flag);
		return $resultStr;
	}

	//返回新闻格式
	private function transmitNews($object, $arr_item, $flag = 0) {
		if (!is_array($arr_item))
			return;

		$itemTpl = "    <item>
                            <Title><![CDATA[%s]]></Title>
                            <Description><![CDATA[%s]]></Description>
                            <PicUrl><![CDATA[%s]]></PicUrl>
                            <Url><![CDATA[%s]]></Url>
                            </item>
                            ";
		$item_str = "";
		foreach ($arr_item as $item)
			$item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['Picurl'], $item['Url']);

		$newsTpl = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[news]]></MsgType>
                            <Content><![CDATA[]]></Content>
                            <ArticleCount>%s</ArticleCount>
                            <Articles>
                            $item_str</Articles>
                            <FuncFlag>%s</FuncFlag>
                            </xml>";

		$resultStr = sprintf($newsTpl, $object->FromUserName, $object->ToUserName, time(), count($arr_item), $flag);
		return $resultStr;
	}

	//返回音频格式
	private function transmitMusic($object, $musicArray, $flag = 0) {
		$itemTpl = "<Music>
                            <Title><![CDATA[%s]]></Title>
                            <Description><![CDATA[%s]]></Description>
                            <MusicUrl><![CDATA[%s]]></MusicUrl>
                            <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
                            </Music>";

		$item_str = sprintf($itemTpl, $musicArray['Title'], $musicArray['Description'], $musicArray['MusicUrl'], $musicArray['HQMusicUrl']);

		$textTpl = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[music]]></MsgType>
                            $item_str
                            <FuncFlag>%d</FuncFlag>
                            </xml>";

		$resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $flag);
		return $resultStr;
	}

	//返回外卖商家列表
	private function transmitOpenShopList($object, $schoolId) {
		$common = new common();
		$arrayOpenShopList = $common->getOpenShopList(Environment, $schoolId, 0, 5);
		$textTpl = "<item>
                            <Title><![CDATA[%s\n￥%.1f起送]]></Title>
                            <Description><![CDATA[]]></Description>
                            <PicUrl><![CDATA[%s]]></PicUrl>
                            <Url><![CDATA[%s]]></Url>
                            </item>";
		$items_str = "";
		foreach ($arrayOpenShopList as $OpenShop) 
                {
			$items_str.=sprintf($textTpl, $OpenShop['name'], $OpenShop['startingprice'], $OpenShop['imageurl'], $common->getShopURL(Environment, $schoolId, $OpenShop['id']));
		}
		$shopsTpl = "<xml>
                             <ToUserName><![CDATA[%s]]></ToUserName>
                             <FromUserName><![CDATA[%s]]></FromUserName>
                             <CreateTime>%s</CreateTime>
                             <MsgType><![CDATA[news]]></MsgType>
                             <Content><![CDATA[]]></Content>
                             <ArticleCount>%s</ArticleCount>
                             <Articles>
                             <item>
                             <Title><![CDATA[%s(共%s个外卖商家)]]></Title>
                             <Description><![CDATA[]]></Description>
                             <PicUrl><![CDATA[http://" . Environment . ".diancanyo.com/webchat/images/diancanyo.png]]></PicUrl>
                             <Url><![CDATA[http://" . Environment . ".diancanyo.com]]></Url>
                             </item>$items_str<item>
                             <Title><![CDATA[查看更多 >>]]></Title>
                             <Url><![CDATA[http://" . Environment . ".diancanyo.com]]></Url>
                             </item>
                             </Articles>
                             </xml>";
		$openShopCount = $common->getOpenShopCountBySchoolId(Environment, $schoolId);
		$this->currentSchool = $common->getSchoolByID(Environment, $schoolId);
		$this->saveSessionData("CurrentSchool", $this->currentSchool);
		$resultStr = sprintf($shopsTpl, 
                                     $object->FromUserName, 
                                     $object->ToUserName, 
                                     time(), 
                                     $openShopCount > 5 ? 7 : $openShopCount + 1, 
                                     $this->currentSchool['name'], 
                                     $openShopCount);
		return $resultStr;
	}

	public function saveSessionData($name, $value) {
		// store session data
		$_SESSION[$name] = $value;
	}

	public function getSessionData($name) {
		//retrieve session data
		if (isset($_SESSION[$name])) {
			return $_SESSION[$name];
		} else {
			return NULL;
		}
	}

}
?>