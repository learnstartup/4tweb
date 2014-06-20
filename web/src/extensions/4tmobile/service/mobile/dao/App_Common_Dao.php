<?php

/**
 * @author York
 */

class App_Common_Dao {
    
    //微信登录
	public function weiXinLogin($environment, $username, $password) 
	{
		$url = sprintf("%s/windid/index.php?m=api&clientid=1&c=User&a=weiXinLogin&username=%s&password=%s", $environment, $username, $password);
		$result = $this->GetData($url);
		$arrayResult = json_decode($result, true);
		return $arrayResult;
	}

	//商家列表
	public function getOpenShopList($environment, $schoolId, $offset, $limit) 
	{
		$url = sprintf("%s/windid/index.php?m=api&clientid=1&c=Openshop&a=getBySchoolId&sort=desc&orderBy=ordercount&schoolId=%s&offset=%s&limit=%s"
			, $environment, $schoolId, $offset, $limit);
		$result = $this->GetData($url);
		$arrayResult = json_decode($result, true);
		return $arrayResult;
	}

	//商店的菜品列表
	public function getMerchandiseList($environment, $shopId) 
	{
		$url = sprintf("%s/windid/index.php?m=api&clientid=1&c=Openmerchandise&a=weixinMerchandiseByShopId&shopId=%s"
			, $environment, $shopId);
		//echo $url;exit;
		$result = $this->GetData($url);
		$arrayResult = json_decode($result, true);
		return $arrayResult;
	}

	//微信注册
	public function weixinRegisterUser($environment, $mobile, $password, $username)
	{
		$url = sprintf("%s/windid/index.php?m=api&clientid=1&c=User&a=weixinRegisterUser&mobile=%s&password=%s&username=%s"
			, $environment, $mobile, $password, $username);
		$result = $this->GetData($url);
		$arrayResult = json_decode($result, true);
		return $arrayResult;
	}

	//获取商家URL地址
	public function getShopURL($environment, $schoolId, $shopId) 
	{
		$url = sprintf("%s/mobile/webapp/php/shop.php?schoolId=%s&shopId=%s", $environment, $schoolId, $shopId);
		return $url;
	}

	//获取外卖商家总数
	public function getOpenShopCountBySchoolId($environment, $schoolId) 
	{
		$url = sprintf("%s/windid/index.php?m=api&clientid=1&c=Openshop&a=countDeliverShop&schoolId=%s", $environment, $schoolId);
		$result = $this->GetData($url);
		$arrayResult = json_decode($result, true);
		return $arrayResult["sum"];
	}

	//获取我的订单
	public function getOpenMyOrder($environment, $schoolid, $days, $myid, $offset, $limit) 
	{
		$url = sprintf("%s/windid/index.php?m=api&clientid=1&c=OpenOrder&a=getMyOrder&schoolid=%s&days=%s&myid=%s&offset=%s&limit=%s", 
			$environment, $schoolid, $days, $myid, $offset, $limit);
		return $url;
		$result = $this->GetData($url);
		$arrayResult = json_decode($result, true);
		return $arrayResult;
	}

	//根据经纬度获取学校
	public function getSchoolsByLocation($environment, $location_lng, $location_lat) {
		$results = $this->getAllSchools($environment);
		$arraySchools = array();
		foreach ($results as $school) {
//			switch ($school['name']) {
//				case "江西师范大学科学技术学院":
//					$school['schlongitude'] = 115.922884;
//					$school['schlatitude'] = 28.677269;
//					break;
//				case "江西省南昌大学[南院]":
//					$school['schlongitude'] = 115.937486;
//					$school['schlatitude'] = 28.682973;
//					break;
//			}
			if ($school['schlongitude'] != 0 && $school['schlatitude'] != 0) {
				if ($this->getdistance($school['schlongitude'], $school['schlatitude'], doubleval($location_lng), doubleval($location_lat)) < 1000) {
					array_push($arraySchools, $school);
				}
			}
		}
		return $arraySchools;
	}

	//获取所有学校的列表
	public function getAllSchools($environment) {
		$url = sprintf("%s/windid/index.php?m=api&clientid=1&c=School&a=getOpenSchools", $environment);
		$result = $this->GetData($url);
		$arrayResult = json_decode($result, true);
		return $arrayResult;
	}

	//根据学校ID获取学校数据
	public function getSchoolByID($environment, $school_Id) {
		$arraySchools = $this->getAllSchools($environment);
		$result = NULL;
		foreach ($arraySchools as $school) {
			if (intval($school['schoolid']) == intval($school_Id)) {
				$result = $school;
				break;
			}
		}
		return $result;
	}

	/**
	 * 求两个已知经纬度之间的距离,单位为米
	 * @param lng1,lng2 经度
	 * @param lat1,lat2 纬度
	 * @return float 距离，单位米
	 * */
	public function getdistance($lng1, $lat1, $lng2, $lat2) {
		//将角度转为狐度
		$radLat1 = deg2rad($lat1); //deg2rad()函数将角度转换为弧度
		$radLat2 = deg2rad($lat2);
		$radLng1 = deg2rad($lng1);
		$radLng2 = deg2rad($lng2);
		$a = $radLat1 - $radLat2;
		$b = $radLng1 - $radLng2;
		$s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2))) * 6378.137 * 1000;
		return $s;
	}


	public function GetData($url) {
		$url = $this->AddWindidKeyAndTime($url);
		$output = $url;
		$ch = curl_init();
		//设置选项，包括URL
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		//执行并获取HTML文档内容
		$output = curl_exec($ch);
		//释放curl句柄
		curl_close($ch);
		return $output;
	}

	public function PostData($url) {
		$url = $this->AddWindidKeyAndTime($url);
		$post_data = array(
		    "nameuser" => "syxrrrr",
		    "pw" => "123456"
		);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		$output = curl_exec($ch);
		curl_close($ch);
		echo $output;
	}

	public function AddWindidKeyAndTime($url) {
		$time = strval(time());
		$url = $url . "&windidkey=" . md5(md5('1' . '||' . 'b6a76c3e4aa21dbf9aeee10bfaba1f2a') . $time) . "&time=" . $time;
		return $url;
	}

}

?>
