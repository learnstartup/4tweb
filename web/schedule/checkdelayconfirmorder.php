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

date_default_timezone_set('Asia/Shanghai');

Wind::import('LIB:utility.PwMail');
		
$totalCount = Wekit::load('EXT:4tschool.service.myorder.App_MyOrder')->countDelayConfirmOrder();
if($totalCount > 0)
{
	Wekit::load('EXT:4tschool.service.myorder.App_OrderStatusNotify')->PushToDiancanYoDelay();
}


?>