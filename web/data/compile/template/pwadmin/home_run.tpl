<!doctype html>
<html>
<head>
<meta charset="<?php echo htmlspecialchars(Wekit::app()->charset, ENT_QUOTES, 'UTF-8');?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<title><?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','c','name'), ENT_QUOTES, 'UTF-8');?></title>
<link href="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','css'), ENT_QUOTES, 'UTF-8');?>/admin_style.css?v<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>" rel="stylesheet" />
<script>
//全局变量，是Global Variables不是Gay Video喔
var GV = {
	JS_ROOT : "<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','res'), ENT_QUOTES, 'UTF-8');?>/js/dev/",																									//js目录
	JS_VERSION : "<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>",																										//js版本号
	TOKEN : '<?php echo htmlspecialchars(Wind::getComponent('windToken')->saveToken('csrf_token'), ENT_QUOTES, 'UTF-8');?>',	//token ajax全局
	REGION_CONFIG : {},
	SCHOOL_CONFIG : {},
	URL : {
		LOGIN : '<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','loginUrl'), ENT_QUOTES, 'UTF-8');?>',																													//后台登录地址
		IMAGE_RES: '<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','images'), ENT_QUOTES, 'UTF-8');?>',																										//图片目录
		REGION : '<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=webData&a=area'; ?>',					//地区
		SCHOOL : '<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=webData&a=school'; ?>'				//学校
	}
};
</script>
<script src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','js'), ENT_QUOTES, 'UTF-8');?>/wind.js?v<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>"></script>
<script src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','js'), ENT_QUOTES, 'UTF-8');?>/jquery.js?v<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>"></script>

</head>
<body>
<?php  
$filePath = Wind::getRealPath('ADMIN:conf.openplatformurl.php', true);
$openPlatformUrl = Wind::getComponent('configParser')->parse($filePath);
?>
<div class="wrap">
	<div id="home_toptip"></div>
	<h2 class="h_a">系统信息</h2>
	<div class="home_info">
		<ul>
			<li>
				<em>软件版本</em>
				<span><?php echo htmlspecialchars($sysinfo['wind_version'], ENT_QUOTES, 'UTF-8');?> <a href="http://www.phpwind.com/index.php?m=downloads&a=downloadsphpwind" target="_blank">查看最新版本</a></span>
			</li>
			<!-- 
			<li>
				<em>操作系统</em>
				<span>WINNT</span>
			</li>
			 -->
			<li>
				<em>PHP版本</em>
				<span><?php echo htmlspecialchars($sysinfo['php_version'], ENT_QUOTES, 'UTF-8');?></span>
			</li>
			<li>
				<em>MYSQL版本</em>
				<span><?php echo htmlspecialchars($sysinfo['mysql_version'], ENT_QUOTES, 'UTF-8');?></span>
			</li>
			<li>
				<em>服务器端信息</em>
				<span><?php echo htmlspecialchars($sysinfo['server_software'], ENT_QUOTES, 'UTF-8');?></span>
			</li>
			<li>
				<em>最大上传限制</em>
				<span><?php echo htmlspecialchars($sysinfo['max_upload'], ENT_QUOTES, 'UTF-8');?></span>
			</li>
			<li>
				<em>最大执行时间</em>
				<span><?php echo htmlspecialchars($sysinfo['max_excute_time'], ENT_QUOTES, 'UTF-8');?></span>
			</li>
			<li>
				<em>邮件支持模式</em>
				<span><?php echo htmlspecialchars($sysinfo['sys_mail'], ENT_QUOTES, 'UTF-8');?></span>
			</li>
		</ul>
	</div>
	<h2 class="h_a">开发团队</h2>
	<div class="home_info" id="home_devteam"></div>
</div>
<!--升级提示-->
<div id="J_system_update" style="display:none" class="system_update">
	您正在使用旧版本的phpwind，为了获得更好的体验，请升级至最新版本。<a href="">立即升级</a>
</div>
<script src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','js'), ENT_QUOTES, 'UTF-8');?>/pages/admin/common/common.js?v<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>"></script>
<script>
$("#btn_submit").click(function(){
	$("#tips_success").fadeTo(500,1);
});
//获取升级信息通知
$.ajax({
    url: "<?php echo Wekit::app()->baseUrl,'/','admin.php?m=pwadmin&c=home&a=notice'; ?>",
    dataType: "json",
    success: function (data) {
    	var r = data.html;
    	if (r.notice) {
    		$('#J_system_update').show();
    		$('#J_system_update').html(r.notice);
    	}
    	var tabframe_trigger = $('a.J_tabframe_trigger');
    	if(tabframe_trigger.length) {
    		try{
    			var _SUBMENU_CONFIG = parent.window.SUBMENU_CONFIG;		//导航数据

    			tabframe_trigger.on('click', function(e){
    				e.preventDefault();
    				var $this = $(this),
    					id = $this.data('id'),						//id
    					par = $this.data('parent'),					//父导航id
    					level = parseInt($this.data('level'));		//二级三级导航标识

    				parent.window.eachSubmenu(_SUBMENU_CONFIG, id, par, level, this.href);
    			});
    		}catch(e){
    			$.error(e);
    		}
    	}
    },
    error: function () {
    }
});

</script>
<?php  
$siteUrl = $_SERVER ['HTTP_HOST'];
$ip = Wind::getApp()->getRequest()->getClientIp();
$ts = PW::getTime();
?>
<script src="<?php echo htmlspecialchars($openPlatformUrl, ENT_QUOTES, 'UTF-8');?>sitepush.php?a=push&siteurl=<?php echo htmlspecialchars($siteUrl, ENT_QUOTES, 'UTF-8');?>&ip=<?php echo htmlspecialchars($ip, ENT_QUOTES, 'UTF-8');?>&ts=<?php echo htmlspecialchars($ts, ENT_QUOTES, 'UTF-8');?>" charset="UTF-8"></script>
</body>
</html>