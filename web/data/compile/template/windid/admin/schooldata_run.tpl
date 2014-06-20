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
			<li class="<?php echo htmlspecialchars(Pw::isCurrent($type == 3), ENT_QUOTES, 'UTF-8');?>"><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?type=3&m=windid&c=schooldata'; ?>">大学管理</a></li>
			<li class="<?php echo htmlspecialchars(Pw::isCurrent($type == 2), ENT_QUOTES, 'UTF-8');?>"><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?type=2&m=windid&c=schooldata'; ?>">中学管理</a></li>
			<li class="<?php echo htmlspecialchars(Pw::isCurrent($type == 1), ENT_QUOTES, 'UTF-8');?>"><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?type=1&m=windid&c=schooldata'; ?>">小学管理</a></li>
		</ul>
	</div>
	<div class="h_a">功能说明</div>
	<div class="prompt_text">
		<ul>
			<li>此功能允许管理员手动维护学校的联动关系及新增学校。</li>
			<li>此功能的维护涉及全站所有的学校联动调用，请管理员根据实际的行政地域调整变化修改。</li>
		</ul>
	</div>
	<div class="h_a"><?php echo htmlspecialchars($schools[$type], ENT_QUOTES, 'UTF-8');?>管理</div>
<?php 
$_var = $type == 3 ? 'province' : 'other';
	?>
	<div class="table_full">
	
		<table width="100%">
			<col class="th" />
			<col width="600" />
			<col />
			<tr>
				<th>选择地区</th>
				<td>
					<div class="yarnball mr20">
						<ul class="cc" id="J_yarnball_list">
							<!-- <li id="J_yarnball_country" class="li_disabled"><a class="J_yarnball" href="javascript:;" data-type="all">中国</a><em></em></li> -->
							<li id="J_yarnball_province" class="li_disabled" style="<?php echo htmlspecialchars($route['province']['display'], ENT_QUOTES, 'UTF-8');?>"><a class="J_yarnball" href="javascript:;" data-type="province" data-id="<?php echo htmlspecialchars($route['province']['areaid'], ENT_QUOTES, 'UTF-8');?>"><?php echo htmlspecialchars($route['province']['name'], ENT_QUOTES, 'UTF-8');?></a><em></em></li>
							<li id="J_yarnball_city" class="li_disabled" style="<?php echo htmlspecialchars($route['city']['display'], ENT_QUOTES, 'UTF-8');?>"><a class="J_yarnball" href="javascript:;" data-id="<?php echo htmlspecialchars($route['city']['areaid'], ENT_QUOTES, 'UTF-8');?>"><?php echo htmlspecialchars($route['city']['name'], ENT_QUOTES, 'UTF-8');?></a><em></em></li>
							<li id="J_yarnball_district" class="li_disabled" style="<?php echo htmlspecialchars($route['area']['display'], ENT_QUOTES, 'UTF-8');?>"><a class="J_yarnball" href="javascript:;" data-id="<?php echo htmlspecialchars($route['area']['areaid'], ENT_QUOTES, 'UTF-8');?>"><?php echo htmlspecialchars($route['area']['name'], ENT_QUOTES, 'UTF-8');?></a><em></em></li>
						</ul>
					</div>
					<a href="" id="J_school_filter" data-rank="<?php echo htmlspecialchars($_var, ENT_QUOTES, 'UTF-8');?>" data-pid="<?php echo htmlspecialchars($route['province']['areaid'], ENT_QUOTES, 'UTF-8');?>" data-cid="<?php echo htmlspecialchars($route['city']['areaid'], ENT_QUOTES, 'UTF-8');?>" data-did="<?php echo htmlspecialchars($route['area']['areaid'], ENT_QUOTES, 'UTF-8');?>">请选择&gt;&gt;</a>
					<!-- <a href="#" style="display:none;" id="J_region_change">更换省市&gt;&gt;</a> -->
					<input type="hidden" value="<?php echo htmlspecialchars($data['areaid'], ENT_QUOTES, 'UTF-8');?>" name='areaid'>
				</td>
				<td><div class="fun_tips"></div></td>
			</tr>
			
			<tr>
				<th>搜索<?php echo htmlspecialchars($schools[$data['typeid']], ENT_QUOTES, 'UTF-8');?></th>
				<td>
					<form action="#" id="J_shcool_search">
						<input type="text" class="input length_3 mr10" name="name" value="<?php echo htmlspecialchars($data['name'], ENT_QUOTES, 'UTF-8');?>"><button type="submit" class="btn">搜索</button>
					<input type="hidden" name="csrf_token" value="<?php echo WindSecurity::escapeHTML(Wind::getComponent('windToken')->saveToken('csrf_token')); ?>"/></form>
				</td>
				<td><div class="fun_tips"></div></td>
			</tr>
		</table>
	
	</div>
	
	<form class="J_ajaxForm" action="<?php echo Wekit::app()->baseUrl,'/','admin.php?m=windid&c=schooldata&a=update'; ?>" method="post">
	<div class="table_full">
		<table width="100%" id="J_table_list">
		<col width="160">
		<thead>
			<tr class="h_a">
				<th>双击名称进行编辑</th>
				<td>操作</td>
			</tr>
		</thead>
		 <tbody id="J_school_list">
<?php foreach ($list as $_i) {?>
			<tr>
				<th><div data-id="<?php echo htmlspecialchars($_i['schoolid'], ENT_QUOTES, 'UTF-8');?>" class="J_school_item"><?php echo htmlspecialchars($_i['name'], ENT_QUOTES, 'UTF-8');?></div></th>
				<td><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?schoolid=', rawurlencode($_i['schoolid']),'&m=windid&c=schooldata&a=delete'; ?>" class="J_school_del">[删除]</a></td>
			</tr>
<?php }?>
		</tbody>
		</table>
		<div class="p10" id="J_school_add"><a href="" class="link_add" id="J_add_root" data-html="tbody">添加</a></div>
	</div>
	<div class="btn_wrap">
		<div class="btn_wrap_pd"><input style="display:none;" id="J_input_areaid" value="<?php echo htmlspecialchars($data['areaid'], ENT_QUOTES, 'UTF-8');?>" name="areaid" /><input style="display:none;" id="J_input_typeid" value="<?php echo htmlspecialchars($data['typeid'], ENT_QUOTES, 'UTF-8');?>" name="typeid" /><button class="btn btn_submit J_ajax_submit_btn" type="submit">提交</button></div>
	</div>
	<input type="hidden" name="csrf_token" value="<?php echo WindSecurity::escapeHTML(Wind::getComponent('windToken')->saveToken('csrf_token')); ?>"/></form>
<script src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','js'), ENT_QUOTES, 'UTF-8');?>/pages/admin/common/common.js?v<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>"></script>
</div>
<script>
var SCHOOL_DEL = "<?php echo Wekit::app()->baseUrl,'/','admin.php?m=windid&c=schooldata&a=delete'; ?>"; //schoolid
Wind.js(GV.JS_ROOT +'pages/config/admin/schoolData.js?v='+ GV.JS_VERSION, GV.JS_ROOT+ 'pages/admin/common/forumTree_table.js?v=' +GV.JS_VERSION);

//添加 模板 forumTree_table.js
var root_tr_html = '<tr><th><input type="text" class="input length_2" value="" name="add[]"></th><td><a href="#" class="J_newRow_del">[删除]</a></td></tr>'
</script>
</body>
</html>