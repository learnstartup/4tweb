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
		<li class="current"><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?m=config&c=config'; ?>">站点信息</a></li>
		<li><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?m=config&c=config&a=site'; ?>">全局参数</a></li>
	</ul>
</div>
<form method="post" class="J_ajaxForm" action="<?php echo Wekit::app()->baseUrl,'/','admin.php?m=config&c=config&a=dorun'; ?>">
<div class="h_a">站点信息设置</div>
<div class="table_full">
	<table width="100%">
		<col class="th" />
		<col width="400" />
		<col />
		<tr>
			<th>站点名称</th>
			<td>
				<input name="infoName" type="text" class="input length_5" value="<?php echo htmlspecialchars($config['info.name'], ENT_QUOTES, 'UTF-8');?>">
			</td>
			<td><div class="fun_tips">默认站点名称，如果各个应用没有填写站点名称，则显示这个名称</div></td>
		</tr>
		<tr>
			<th>站点地址</th>
			<td>
				<input name="infoUrl" type="text" class="input length_5" value="<?php echo htmlspecialchars($config['info.url'], ENT_QUOTES, 'UTF-8');?>">
			</td>
			<td><div class="fun_tips">填写您站点的完整域名。例如: http://www.phpwind.net，不要以斜杠 (“/”) 结尾</div></td>
		</tr>
		<tr>
			<th>管理员电子邮箱</th>
			<td>
				<input name="infoMail" type="text" class="input length_5" value="<?php echo htmlspecialchars($config['info.mail'], ENT_QUOTES, 'UTF-8');?>">
			</td>
			<td><div class="fun_tips">填写站点管理员的邮箱地址</div></td>
		</tr>
		<tr>
			<th>ICP 备案信息</th>
			<td>
				<input name="infoIcp" type="text" class="input length_5" value="<?php echo htmlspecialchars($config['info.icp'], ENT_QUOTES, 'UTF-8');?>">
			</td>
			<td><div class="fun_tips">填写 ICP 备案的信息，例如: 浙ICP备xxxxxxxx号</div></td>
		</tr>
		<tr>
			<th>第三方统计代码</th>
			<td>
				<textarea class="length_5" name="statisticscode"><?php echo htmlspecialchars($config['statisticscode'], ENT_QUOTES, 'UTF-8');?></textarea>
			</td>
			<td><div class="fun_tips">在第三方网站上注册并获得统计代码，并将统计代码粘帖在下面文本框中即可。</div></td>
		</tr>
	</table>
</div>
<div class="h_a">站点状态设置</div>		
<div class="table_full">
<table width="100%">
	<col class="th" />
	<col width="400" />
	<col />
	<tr>
		<th>站点状态</th>
		<td>
			<ul id="J_status_type" class="single_list cc">
				<li><label><input data-title="s1" data-type="" name="visitState" type="radio" value="0"<?php echo htmlspecialchars(Pw::ifcheck(!$config['visit.state']), ENT_QUOTES, 'UTF-8');?>>完全开放</label></li>
				<li><label><input data-title="s2" data-type="J_status_s1,J_status_s2" name="visitState" type="radio" value="1"<?php echo htmlspecialchars(Pw::ifcheck($config['visit.state']==1), ENT_QUOTES, 'UTF-8');?>>内部开放</label></li>
				<li><label><input data-title="s3" data-type="J_status_s2" name="visitState" type="radio" value="2"<?php echo htmlspecialchars(Pw::ifcheck($config['visit.state']==2), ENT_QUOTES, 'UTF-8');?>>完全关闭</label></li>
			</ul>
		</td>
		<td><div id="J_status_tip" class="fun_tips">完全关闭:除站点创始人，其他人都不允许访问站点，一般用于站点关闭、系统维护等情况</div></td>
	</tr>
</table>
</div>
<div class="table_full">
<table width="100%" id="J_status_s1" class="J_status_tbody">
	<col class="th" />
	<col width="400" />
	<col />
		<tr>
			<th>允许访问的用户组</th>
			<td>
				<div class="user_group J_check_wrap">
		<?php foreach($groupTypes as $type => $typeName): 
			$checked = in_array($type,$config['visit.group']);?>
					<dl>
						<dt><label><input data-direction="y" data-checklist="J_check_<?php echo htmlspecialchars($type, ENT_QUOTES, 'UTF-8');?>" type="checkbox" class="checkbox J_check_all" name="visitGroup[]" value="<?php echo htmlspecialchars($type, ENT_QUOTES, 'UTF-8');?>"<?php echo htmlspecialchars(Pw::ifcheck($checked), ENT_QUOTES, 'UTF-8');?>><?php echo htmlspecialchars($typeName, ENT_QUOTES, 'UTF-8');?></label></dt>
						<dd>
			<?php foreach($groups as $group): 
		if($group['type'] == $type):
		$checked = in_array($group['gid'],$config['visit.gid']);?>
							<label><input class="J_check" data-yid="J_check_<?php echo htmlspecialchars($type, ENT_QUOTES, 'UTF-8');?>" type="checkbox" name="visitGid[]" value="<?php echo htmlspecialchars($group['gid'], ENT_QUOTES, 'UTF-8');?>"<?php echo htmlspecialchars(Pw::ifcheck($checked), ENT_QUOTES, 'UTF-8');?>><span><?php echo htmlspecialchars($group['name'], ENT_QUOTES, 'UTF-8');?></span></label>
			<?php endif;endforeach; ?>
						</dd>
					</dl>
		<?php endforeach; ?>
				</div>
			</td>
			<td><div class="fun_tips">站点内部开放状态下，允许访问站点的特定用户组。<br>留空表示不使用此功能</div></td>
		</tr>
	<tr>
		<th>允许访问的IP段</th>
		<td>
			<textarea class="length_5" name="visitIp"><?php echo htmlspecialchars($config['visit.ip'], ENT_QUOTES, 'UTF-8');?></textarea>
		</td>
		<td><div class="fun_tips">站点内部开放状态下，允许访问站点的特定IP段用户。<br>如：192.168.1.*，表示192.168.1下的所有IP都允许访问站点。<br>多个IP段之间请用英文半角逗号“,”分隔。留空则表示不使用此功能。<br>您当前登录IP：127.0.0.1</div></td>
	</tr>
	<tr>
		<th>允许访问的会员</th>
		<td>
			<textarea class="length_5" name="visitMember"><?php echo htmlspecialchars($config['visit.member'], ENT_QUOTES, 'UTF-8');?></textarea>
		</td>
		<td><div class="fun_tips">站点内部开放状态下，允许访问站点的特定会员。<br>多个会员用户名请用英文半角逗号“,”分隔。<br>留空则表示不使用此功能</div></td>
	</tr>
</table>
<table width="100%" id="J_status_s2" class="J_status_tbody">
	<col class="th" />
	<col width="400" />
	<col />
	<tr>
		<th>限制访问提示信息</th>
		<td>
			<textarea class="length_5"  name="visitMessage"><?php echo htmlspecialchars($config['visit.message'], ENT_QUOTES, 'UTF-8');?></textarea>
		</td>
		<td><div class="fun_tips">当站点处于内部开放状态时，登录界面显示的提示信息</div></td>
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

$(function(){
	//站点状态
	var status_title = {
		s1 : '允许任何人访问站点',
		s2 : '特定会员才能访问站点，通常用于站点内部测试、调试',
		s3 : '除创始人，其他用户不允许访问站点，一般用于站点关闭、系统维护等情况'
	};
	
	var checked = $('#J_status_type input:checked');
	
	statusAreaShow(checked.data('type'));
	statusTitle(checked.data('title'));

	$('#J_status_type input:radio').on('change', function(){
			statusAreaShow($(this).data('type'));
			statusTitle($(this).data('title'));
	});

	//切换显示版块
	function statusAreaShow(type) {
		var status_arr= new Array();
		
		status_arr = type.split(",");
		$('table.J_status_tbody').hide();
		
		$.each(status_arr, function(i, o){
			$('#'+ o).show();
		});
	}
	
	//切换提示文案
	function statusTitle(title){
		$('#J_status_tip').text(status_title[title]);
	}
});
</script>
</body>
</html>