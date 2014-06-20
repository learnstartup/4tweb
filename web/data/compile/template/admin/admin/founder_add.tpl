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
<body class="body_none" style="width:400px;">
<form class="J_ajaxForm" action="<?php echo Wekit::app()->baseUrl,'/','admin.php?c=founder&a=doAdd'; ?>" method="post">
<div class="pop_cont pop_table" style="height:auto;">
	<table width="100%">
			<tbody>
			<tr>
				<th width="80">用户名</th>
				<?php  if($uid) { ?>
				<td><input type="text" class="input length_5" name="username" value="<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8');?>" readonly="readonly"></td>
				<?php  }else{ ?>
				<td><input type="text" class="input length_5" name="username" value="<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8');?>"></td>
				<?php  } ?>
			</tr>
			<tr>
				<th>密码</th>
				<td><input type="text" class="input length_5" name="password"></td>
			</tr>
			<tr>
				<th>电子邮箱</th>
				<td>
					<input name="email" type="email" class="input length_5" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8');?>">
				</td>
			</tr>
			</tbody>
	</table>
</div>
<div class="pop_bottom">
	<button type="button" class="btn fr" id="J_dialog_close">取消</button>
	<button type="submit" class="btn btn_submit J_ajax_submit_btn fr mr10">提交</button>
</div>
<input type="hidden" name="csrf_token" value="<?php echo WindSecurity::escapeHTML(Wind::getComponent('windToken')->saveToken('csrf_token')); ?>"/></form>

<script src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','js'), ENT_QUOTES, 'UTF-8');?>/pages/admin/common/common.js?v<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>"></script>
</body>
</html>