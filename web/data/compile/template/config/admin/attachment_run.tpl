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
		<li class="current"><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?m=config&c=attachment'; ?>">附件设置</a></li>
		<li><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?m=config&c=attachment&a=storage'; ?>">附件存储</a></li>
		<li><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?m=config&c=attachment&a=thumb'; ?>">附件缩略</a></li>
		<li><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?m=config&c=storage'; ?>">头像存储</a></li>
	</ul>
</div>

<form method="post" class="J_ajaxForm" action="<?php echo Wekit::app()->baseUrl,'/','admin.php?m=config&c=attachment&a=dorun'; ?>" data-role="list">
	<div class="h_a">基本设置</div>
	<div class="table_full">
		<table width="100%">
			<col class="th" />
			<col width="400" />
			<col />
			<tr>
				<th>附件路径控制</th>
				<td><input name="pathsize" type="text" class="input length_5 mr5" value="<?php echo htmlspecialchars($config['pathsize'], ENT_QUOTES, 'UTF-8');?>">KB</td>
				<td><div class="fun_tips">当附件超过设定值时，系统将直接读取附件真实路径。此功能可帮助减少系统php进程消耗，亦可帮助转移附件流量并减轻附件服务器负担。请根据站点附件实际情况进行设置。0或留空表示不限制。 </div></td>
			</tr>
			<tr>
				<th>单次附件上传个数限制</th>
				<td><input name="attachnum" type="text" class="input length_5 mr5" value="<?php echo htmlspecialchars($config['attachnum'], ENT_QUOTES, 'UTF-8');?>"></td>
				<td><div class="fun_tips"></div></td>
			</tr>
			<tr>
				<th>附件类型和尺寸控制</th>
				<td>
					<div class="cross">
						<ul id="J_ul_list_attachment" class="J_ul_list_public">
							<li>
								<span class="span_3">后缀名(小写)</span>
								<span class="span_3">最大值(KB)</span>
							</li>
							<?php  foreach($config['extsize'] as $key => $value): ?>
							<li>
								<span class="span_3"><input name="extsize[<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8');?>][ext]" type="text" class="input length_2" value="<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8');?>"></span>
								<span class="span_4"><input name="extsize[<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8');?>][size]" type="text" class="input mr15 length_2"  value="<?php echo htmlspecialchars($value, ENT_QUOTES, 'UTF-8');?>"><a href="#" class="J_ul_list_remove">[删除]</a></span>
							</li>
							<?php  endforeach; ?>
						</ul>
					</div>
					<a href="" class="link_add J_ul_list_add" data-related="attachment">添加附件类型</a>
				</td>
				<td><div class="fun_tips">系统限制上传单个附件的最大值：<span class="red"><?php echo htmlspecialchars($maxSize, ENT_QUOTES, 'UTF-8');?></span></div></td>
			</tr>
		</table>
	</div>
	<div class="btn_wrap">
		<div class="btn_wrap_pd">
			<button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">提交</button>
		</div>
	</div>
<input type="hidden" name="csrf_token" value="<?php echo WindSecurity::escapeHTML(Wind::getComponent('windToken')->saveToken('csrf_token')); ?>"/></form>
<!-- end -->

</div>
<script src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','js'), ENT_QUOTES, 'UTF-8');?>/pages/admin/common/common.js?v<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>"></script>
<script>
//添加附件类型html
var _li_html = '<li>\
					<span class="span_3"><input type="text" value="" class="input length_2" name="extsize[new_][ext]"></span>\
					<span class="span_4">\
						<input type="text" value="" class="input length_2 mr15" name="extsize[new_][size]"><a class="J_ul_list_remove" href="#">[删除]</a>\
					</span>\
				</li>';
</script>
</body>
</html>