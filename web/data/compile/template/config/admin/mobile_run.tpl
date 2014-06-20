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
<div class="wrap">
<!-- start -->
<div class="nav">
	<ul class="cc">
		<li class="current"><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?m=config&c=mobile'; ?>">短信平台</a></li>
		<li><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?m=config&c=mobile&a=set'; ?>">功能设置</a></li>
	</ul>
</div>

<div class="h_a">功能说明</div>
<div class="prompt_text">
	<ul>
		<li>默认使用阿里云短信平台,支持第三方平台扩展，可以到<a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?m=appcenter&c=app'; ?>">应用中心</a>下载更多的可用方案。</li>
		<li>请先选择短信平台，然后再到<a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?m=config&c=mobile&a=set'; ?>">功能设置</a>中设置相关内容</li>
		
	</ul>
</div>

<form method="post" class="J_ajaxForm" action="<?php echo Wekit::app()->baseUrl,'/','admin.php?m=config&c=mobile&a=dorun'; ?>" data-role="list">
	<div class="h_a">短信平台设置</div>
	<div class="table_full">
		<table width="100%">
			<col class="th" />
			<col width="400" />
			<col />
			<tr>
				<th>平台选择</th>
				<td>
					<ul class="single_list cc">
<?php  
$msg = '';
foreach ($plats as $var => $value) {
	$storageType == $var && $msg = $value['description'];
?>
						<li><span class="mr20"><label><input name="mobile_plat" data-msg="<?php echo htmlspecialchars($value['description'], ENT_QUOTES, 'UTF-8');?>" value="<?php echo htmlspecialchars($var, ENT_QUOTES, 'UTF-8');?>" type="radio" <?php echo Pw::ifcheck($paltType==$var);?>><?php echo htmlspecialchars($value['name'], ENT_QUOTES, 'UTF-8');?></label></span> 
	<?php  if($value['managelink']) { ?>
							<a href="<?php echo WindUrlHelper::createUrl($value['managelink']);?>">[设置]</a>
	<?php  } ?>
						</li>
<?php  } ?>
					</ul>
				</td>
				<td><div class="fun_tips"><?php echo htmlspecialchars($msg, ENT_QUOTES, 'UTF-8');?></div></td>
			</tr>
		</table>
		</div>
		<div class="btn_wrap">
			<div class="btn_wrap_pd">
				<button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">提交</button>
			</div>
		</div>
<input type="hidden" name="csrf_token" value="<?php echo WindSecurity::escapeHTML(Wind::getComponent('windToken')->saveToken('csrf_token')); ?>"/></form>

</div>
<script src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','js'), ENT_QUOTES, 'UTF-8');?>/pages/admin/common/common.js?v<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>"></script>
</body>
</html>