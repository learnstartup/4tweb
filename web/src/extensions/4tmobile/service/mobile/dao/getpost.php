<?php

/**
 * Description of CallRestfulAPI
 *
 * @author York
 */
class getpost {

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