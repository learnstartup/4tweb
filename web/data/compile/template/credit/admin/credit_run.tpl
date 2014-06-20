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
	<div class="nav">
	<ul class="cc">
		<li class="<?php echo htmlspecialchars($currentTabs['run'], ENT_QUOTES, 'UTF-8');?>"><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?m=credit&c=credit'; ?>">积分设置</a></li>
		<li class="<?php echo htmlspecialchars($currentTabs['strategy'], ENT_QUOTES, 'UTF-8');?>"><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?m=credit&c=credit&a=strategy'; ?>">积分策略</a></li>
		<li class="<?php echo htmlspecialchars($currentTabs['recharge'], ENT_QUOTES, 'UTF-8');?>"><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?m=credit&c=credit&a=recharge'; ?>">积分充值</a></li>
		<li class="<?php echo htmlspecialchars($currentTabs['exchange'], ENT_QUOTES, 'UTF-8');?>"><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?m=credit&c=credit&a=exchange'; ?>">积分转换</a></li>
		<li class="<?php echo htmlspecialchars($currentTabs['transfer'], ENT_QUOTES, 'UTF-8');?>"><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?m=credit&c=credit&a=transfer'; ?>">积分转账</a></li>
		<li class="<?php echo htmlspecialchars($currentTabs['log'], ENT_QUOTES, 'UTF-8');?>"><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?m=credit&c=credit&a=log'; ?>">积分日志</a></li>
	</ul>
</div>
	<form class="J_ajaxForm" method="post" action="<?php echo Wekit::app()->baseUrl,'/','admin.php?m=credit&c=credit&a=doSetting'; ?>" data-role="list">
	<div class="table_list">
		<table id="J_table_list" width="100%">
			<col width="220">
			<col width="220">
			<col width="40">
			<col width="100">
			<thead>
				<tr>
					<td width="200">积分名称</td>
					<td width="200">积分单位</td>
					<td width="30">启用</td>
					<td>开启积分日志</td>
					<td>操作</td>
				</tr>
			</thead>
			<tbody id="J_credit_tbody">
			<?php  foreach ($credits as $key => $credit) { ?>
			<tr data-key="<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8');?>">
				<td><input name="credits[<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8');?>][name]" type="text" class="input" value="<?php echo htmlspecialchars($credit['name'], ENT_QUOTES, 'UTF-8');?>"></td>
				<td><input name="credits[<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8');?>][unit]" type="text" class="input" value="<?php echo htmlspecialchars($credit['unit'], ENT_QUOTES, 'UTF-8');?>"></td>
				<td><input name="credits[<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8');?>][open]" type="checkbox" value="1"<?php echo htmlspecialchars(Pw::ifcheck($localCredits[$key]['open']), ENT_QUOTES, 'UTF-8');?>></td>
				<td><input name="credits[<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8');?>][log]" type="checkbox" value="1"<?php echo htmlspecialchars(Pw::ifcheck($localCredits[$key]['log']), ENT_QUOTES, 'UTF-8');?>></td>
				<?php  if($key > 4) {?>
				<td><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?creditId=', rawurlencode($key),'&m=credit&c=credit&a=doDelete'; ?>" class="mr10 J_ajax_del">[删除]</a></td>
				<?php } else {?>
				<td>-- --</td>
				<?php }?>
			</tr>
			<?php }?>
			</tbody>
		</table>
		<table width="100%">
			<tr>
				<td colspan="4"><a id="J_add_root" data-type="credit_root" data-html="tbody" href="#" class="link_add mr20">添加新积分</a><span id="J_credit_add_tip"><?php if(count($credits) >= 8) {?>过多的积分组，可能会导致社区金融体系的混乱。<?php }?></span></td>
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
<script>
var last_credit_key = $('#J_credit_tbody > tr:last').data('key'),
	root_tr_html = '<tr class="ct">\
				<td><input type="text" value="" class="input" name="newcredits[credit_key_][name]"></td>\
				<td><input type="text" value="" class="input" name="newcredits[credit_key_][unit]"></td>\
				<td><input type="checkbox" checked="" value="1" name="newcredits[credit_key_][open]"></td>\
				<td><input type="checkbox" value="1" name="newcredits[credit_key_][log]"></td>\
							<td><a href="#" class="mr5 J_newRow_del">[删除]</a></td>\
						</tr>';
Wind.js(GV.JS_ROOT+ 'pages/admin/common/forumTree_table.js?v=' +GV.JS_VERSION);
$(function(){
	var add_tip = $('#J_credit_add_tip');
	
	//添加后判断积分数量，大于等于8个则提示
	$('#J_add_root').click(function(){
		setTimeout(function(){
			if ($('#J_table_list > tbody > tr').length >= 9) {
				add_tip.text('建议不要添加太多积分！');
			}else{
				add_tip.text('');
			}
		}, 0);
	});
	
	//删除后判断积分数量
	$('#J_table_list').on('click', 'a.J_newRow_del', function (e) {
		setTimeout(function(){
			if ($('#J_table_list > tbody > tr').length < 9) {
				add_tip.text('');
			}
		}, 0);
	})
	
});
</script>
</body>
</html>