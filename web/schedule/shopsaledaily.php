<?php
/*
* used to calculate shop sales everyday
*/
error_reporting(E_ERROR | E_PARSE);

$_SERVER['REQUEST_URI'] = 'schedule';
$_SERVER['HTTP_X_REWRITE_URL'] = 'schedule';
$_SERVER['ORIG_PATH_INFO'] = 'schedule';
$_SERVER['HTTP_HOST'] = 'www.diancanyo.com';



define('TT', dirname(__FILE__) . DIRECTORY_SEPARATOR);
include TT . '../src/wekit.php';

Wekit::run('phpwind');

$startDate = '2013-08-01';
$isfirstrun = false;

//if it is first time run, then need to calculate the data from start date
date_default_timezone_set('Asia/Shanghai');

$today = date('Y-m-d H:i:s');
echo "today:".$today;

if($isfirstrun)
{
	while($startDate < $today)
	{
		calDailySale($startDate);

		//prepare next day
		$fromDateArray = getdate(strtotime($startDate));
		$nextday = mktime(0,0,0,$fromDateArray['mon'], $fromDateArray['mday'] + 1, $fromDateArray['year']);
		$startDate = date('Y-m-d',$nextday);

	}
}
else
{
	//if it is not first time run, then just cal previous 
	$fromDateArray = getdate(strtotime($today));
	$nextday = mktime(0,0,0,$fromDateArray['mon'], $fromDateArray['mday'] - 1, $fromDateArray['year']);
	$calDate = date('Y-m-d',$nextday);
	echo $calDate;
	calDailySale($calDate);

	Wind::import('LIB:utility.PwMail');
	$mail = new PwMail();
	$mail->sendMail('81552433@qq.com', $calDate.'商家返利统计计算完毕', '如题,谢谢');

}



function calDailySale($currentday)
{
	$cShopDaily = Wekit::load('EXT:4tschool.service.shopdailysale.App_ShopDailySale');
	$result = $cShopDaily->calDailySale($currentday);
	$cShopDaily->saveDailyCal($result);
}

?>
