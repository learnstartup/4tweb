<?php
class MobilewechatController extends PwBaseController{

	private $currentSchool = NULL, $currentUserID = NULL;
	private $_token="very9strongpwd";
	private $Environment="dev";
	private $_wechat_key=3;

	public function run (){
			$this->valid();
			$this->responseMsg();
			die;	
	}

	//有效性验证
	public function valid() {
		$echoStr = $this->getInput('echostr','get');
		if (empty($echoStr)==false) {
			if ($this->checkSignature()) {
				echo $echoStr;
				die;
			}
		}
	}

	//验证是否有效
	private function checkSignature() {
		list($signature,$timestamp,$nonce)=$this->getInput(array('signature','timestamp','nonce'),'get');
		$token = $this->_token;
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

	//接收事件
	private function receiveEvent($object) {
		$contentStr = "";
		$defaultUrl=WindUrlHelper::createUrl('app/4tmobile/mobileschool/run',array('openid'=>$object->FromUserName));
		switch ($object->Event) {
			case "subscribe":
				if(!empty($object->EventKey))
				{
					//是从场景关注过来的
					$key = $object->EventKey;
					//判断是否是首次关注
					if(strpos($key,'qrscene_') >= 0)
					{
						$key = str_replace('qrscene_','',$key);
					}

					//now, the key shall be shopid
					$resultStr = $this->transmitText($object, 'shopid'.$key);
					break;
				}

			    $contentStr="/:rose欢迎关注点餐哟--您口袋里的外卖天堂!"
			    . "\n" . "各大高校在线点餐火热进行中/:,@-D"
			    . "\n" . "现在就开始体验吧~<a href="."'".$defaultUrl."'".">[开始点餐]</a>"
			    . "\n" . "有任何意见和建议，都可以给小点留言哦，小点会亲自查看的/::$";
				$resultStr = $this->transmitText($object, $contentStr);
				break;
			case "unsubscribe":
				$contentStr = "";
				break;
			case "CLICK":
				switch ($object->EventKey) {
					case "CLICK_ONLINE_ORDER":
					$contentStr="<a href="."'".$defaultUrl."'".">[开始点餐]</a>";
					$curSchool=$this->getCurrentSchoolByKey($object->FromUserName);
					if (empty($curSchool)==false) 
					{
						$curSchool['url']=WindUrlHelper::createUrl('app/4tmobile/mobileshop/run',array('openid'=>$object->FromUserName,'schoolid'=>$curSchool['schoolid']));
						$contentStr="/:X-)我们猜您在"
						. "\n" . "<a href="."'".$curSchool['url']."'".">".$curSchool['name']."</a>"
						. "\n" . "/:@x不对?"
						. "\n" . "<a href="."'".$defaultUrl."'".">[查看全部区域]</a>";						
					}
					$resultStr = $this->transmitText($object, $contentStr);
						break;
					case "CLICK_MY_ORDER":
					// $schoolid, $days, $myid, $offset, $limit
					$contentStr="您还没有在点餐哟下过订单哦,赶紧来试一试吧!"
					. "\n" . "马上<a href="."'".$defaultUrl."'".">[开始点餐]</a>";
					$user=$this->getCurrentUserByKey($object->FromUserName);
					if (empty($user)==false) {
						$curSchool=$this->getCurrentSchoolByKey($object->FromUserName);
						$myOrderUrl=WindUrlHelper::createUrl('app/4tmobile/mobileorder/run',array('schoolid'=>$curSchool['schoolid'],'days'=>30,'userid'=>$user['userid'],'openid'=>$object->FromUserName));
						$contentStr="<a href="."'".$myOrderUrl."'".">/:heart亲，查看订单点这里~</a>";
					}
					$resultStr = $this->transmitText($object, $contentStr);
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

	private function getCurrentUserByKey ($key){
		return $this->_getTmpUserDS()->getbyKey($this->_wechat_key,$key);
	}

	private function getCurrentSchoolByKey ($key)
	{
		$curSchool;
		$user=$this->getCurrentUserByKey($key);
		$theLastOrder=$this->_getMyOrderDS()->getLastOrderByUserId($user['userid']);
		if (empty($theLastOrder)==false) 
		{
			$schoolList = $this->_getSchoolOpenDS()->getOpenedSchools();
			foreach ($schoolList as $item) {
				if ($theLastOrder['schoolid']==$item['schoolid']) {
					$curSchool=$item;
					break;
				}
			}
		}			
		return $curSchool;
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
		$arraySchools = $common->getSchoolsByLocation($this->Environment, $object->Location_Y, $object->Location_X);
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
		$arrayOpenShopList = $common->getOpenShopList($this->Environment, $schoolId, 0, 5);
		$textTpl = "<item>
                            <Title><![CDATA[%s\n￥%.1f起送]]></Title>
                            <Description><![CDATA[]]></Description>
                            <PicUrl><![CDATA[%s]]></PicUrl>
                            <Url><![CDATA[%s]]></Url>
                            </item>";
		$items_str = "";
		foreach ($arrayOpenShopList as $OpenShop) 
                {
			$items_str.=sprintf($textTpl, $OpenShop['name'], $OpenShop['startingprice'], $OpenShop['imageurl'], $common->getShopURL($this->Environment, $OpenShop['id']));
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
                             <PicUrl><![CDATA[http://" . $this->Environment . ".diancanyo.com/webchat/images/diancanyo.png]]></PicUrl>
                             <Url><![CDATA[http://" . $this->Environment . ".diancanyo.com]]></Url>
                             </item>$items_str<item>
                             <Title><![CDATA[查看更多 >>]]></Title>
                             <Url><![CDATA[http://". $this->Environment .".diancanyo.com/index.php?m=app&c=mobileshop&app=4tmobile&schoolId=%s]]></Url>
                             </item>
                             </Articles>
                             </xml>";
		$openShopCount = $common->getOpenShopCountBySchoolId($this->Environment, $schoolId);
		$this->currentSchool = $common->getSchoolByID($this->Environment, $schoolId);
		$this->saveSessionData("CurrentSchool", $this->currentSchool);
		$resultStr = sprintf($shopsTpl, 
                                     $object->FromUserName, 
                                     $object->ToUserName, 
                                     time(), 
                                     $openShopCount > 5 ? 7 : $openShopCount + 1, 
                                     $this->currentSchool['name'], 
                                     $openShopCount,
                                     $schoolId);
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

    private function encrypt($str, $key, $toBase64=true)
    {
    	if ($str == "") {
    		return "";
    	}
    	if ($toBase64) {
    		return base64_encode(self::_des($key,$str,1));
    	} 
    	return self::_des($key,$str,1);
    }	
    /**
     * @return App_TmpUser
     */
    private function _getTmpUserDS()
    {
        return Wekit::load('EXT:4tschool.service.tmpuser.App_Tmpuser');
    }  

    /**
     * @return App_MyOrder
     */
    private function _getMyOrderDS()
    {
        return Wekit::load('EXT:4tschool.service.myorder.App_MyOrder');
    }    

    /**
     * @return App_School
     */
    private function _getSchoolOpenDS()
    {
        return Wekit::load('EXT:4tschool.service.school.App_School');
    }    
}
?>