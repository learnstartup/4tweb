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
	<?php  foreach ($navTypeList as  $key=>$value) { 
  if($navType == $key){ ?>
			<li class="current"><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?type=', rawurlencode($key),'&m=nav&c=nav'; ?>"><?php echo htmlspecialchars($value, ENT_QUOTES, 'UTF-8');?></a></li>
		<?php  }else{ ?>
			<li><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?type=', rawurlencode($key),'&m=nav&c=nav'; ?>"><?php echo htmlspecialchars($value, ENT_QUOTES, 'UTF-8');?></a></li>
		<?php  } 
  } ?>
	</ul>
</div>

	<?php  if ($navType == 'main'): ?>
	<div class="h_a">功能说明</div>
	<div class="prompt_text">
		<ul>
			<li>“设为首页” 可以把当前页设为网站默认首页。</li>
		</ul>
	</div>
	<?php  endif; 
  if ($navType == 'my'): ?>
	<div class="h_a">功能说明</div>
	<div class="prompt_text">
		<ul>
			<li>如果应用设置了开关功能，“应用标识” 设置相同的应用标识可以同时开启和关闭。</li>
		</ul>
	</div>
	<?php  endif; ?>

<!--div class="mb10">
	<a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?m=nav&c=nav&a=add'; ?>&type=<?php echo htmlspecialchars($navType, ENT_QUOTES, 'UTF-8');?>" class="btn J_dialog"><span class="add"></span>添加导航</a>
</div-->
<form method="post" class="J_ajaxForm" action="<?php echo Wekit::app()->baseUrl,'/','admin.php?m=nav&c=nav&a=dorun'; ?>" data-role="list">

<div class="table_list">
	<table width="100%" id="J_table_list" style="table-layout:fixed;">
		<colgroup>
			<col width="30">
			<col width="380">
			<col width="260">
			<col width="68">
			<col>
		</colgroup>
		<thead>
			<tr>
				<td></td>
				<td>[顺序] 导航名称</td>
				<td>链接地址</td>
				<td>
				<?php  if ($navType == 'main'): ?>
				设为首页
				<?php  endif; 
  if ($navType == 'my'): ?>
				应用标识
				<?php  endif; ?>
				</td>
				<td class="tac">启用</td>
				<td>操作</td>
			</tr>
		</thead>
	<?php 
		foreach ($navList as $value) {
		$count=count($value['child']);
		$icon='zero_icon';
		if($count>0){
			$icon='J_start_icon away_icon';
		}
	?>
		<tbody>
		<tr>
			<td><span class="<?php echo htmlspecialchars($icon, ENT_QUOTES, 'UTF-8');?>" data-id="<?php echo htmlspecialchars($value['navid'], ENT_QUOTES, 'UTF-8');?>"></span></td>
			<td>
				<input name="data[<?php echo htmlspecialchars($value['navid'], ENT_QUOTES, 'UTF-8');?>][navid]" type="hidden" value="<?php echo htmlspecialchars($value['navid'], ENT_QUOTES, 'UTF-8');?>" >
				<input name="data[<?php echo htmlspecialchars($value['navid'], ENT_QUOTES, 'UTF-8');?>][orderid]" type="text" class="input length_0 mr10" value="<?php echo htmlspecialchars($value['orderid'], ENT_QUOTES, 'UTF-8');?>">
				<input name="data[<?php echo htmlspecialchars($value['navid'], ENT_QUOTES, 'UTF-8');?>][name]" type="text" class="input length_3 mr5" value="<?php echo htmlspecialchars($value['name'], ENT_QUOTES, 'UTF-8');?>">
				<?php  if ($navType == 'main'): ?>
				<a style="display:none" href="<?php echo Wekit::app()->baseUrl,'/','admin.php?parentid=', rawurlencode($value['navid']),'&type=', rawurlencode($navType),'&m=nav&c=nav&a=add'; ?>" class="link_add J_addChild add_nav" data-id="<?php echo htmlspecialchars($value['navid'], ENT_QUOTES, 'UTF-8');?>" data-html="tbody" data-type="nav_2">添加二级导航</a>
				<?php  endif; ?>
			</td>
			<td><input name="data[<?php echo htmlspecialchars($value['navid'], ENT_QUOTES, 'UTF-8');?>][link]" type="text" class="input length_4" value="<?php echo htmlspecialchars($value['link'], ENT_QUOTES, 'UTF-8');?>"></td>
			<td>
				<?php  if ($navType == 'main'): ?>
				<input type="radio" name="home"  value="<?php echo htmlspecialchars($value['navid'], ENT_QUOTES, 'UTF-8');?>" <?php echo htmlspecialchars(Pw::ifcheck($homeUrl && $homeUrl == $value['link'] ), ENT_QUOTES, 'UTF-8');?>>
				<?php  endif; 
  if ($navType == 'my'): ?>
				<input type="text" name="data[<?php echo htmlspecialchars($value['navid'], ENT_QUOTES, 'UTF-8');?>][sign]"  value="<?php echo htmlspecialchars($value['sign'], ENT_QUOTES, 'UTF-8');?>" class="input length_2">
				<?php  endif; ?>
			</td>
			<td class="tac"><input name="data[<?php echo htmlspecialchars($value['navid'], ENT_QUOTES, 'UTF-8');?>][isshow]" type="checkbox" value="1" <?php echo htmlspecialchars(Pw::ifcheck($value['isshow']), ENT_QUOTES, 'UTF-8');?>></td>
			<td>
				<a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?navid=', rawurlencode($value['navid']),'&type=', rawurlencode($value['type']),'&m=nav&c=nav&a=edit'; ?>" class="mr10 J_dialog" title="导航编辑">[编辑]</a>
				<a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?navid=', rawurlencode($value['navid']),'&m=nav&c=nav&a=del'; ?>" class="mr10 J_ajax_del">[删除]</a>
			</td>
		</tr>
		</tbody>
		<?php 
			if($count>0){
		?>
			<tbody id="J_table_list_<?php echo htmlspecialchars($value['navid'], ENT_QUOTES, 'UTF-8');?>">
		<?php 
			foreach ($value['child'] as  $childKey=>$childValue) {
			$checked=$childValue['isshow']?'checked':'';
			$endicon=($childKey==$count-1)?'  plus_end_icon':'';
		?>
			<tr>
				<td>&nbsp;</td>
				<td><span class="plus_icon<?php echo htmlspecialchars($endicon, ENT_QUOTES, 'UTF-8');?> mr10"></span><input name="data[<?php echo htmlspecialchars($childValue['navid'], ENT_QUOTES, 'UTF-8');?>][navid]" type="hidden" value="<?php echo htmlspecialchars($childValue['navid'], ENT_QUOTES, 'UTF-8');?>" ><input name="data[<?php echo htmlspecialchars($childValue['navid'], ENT_QUOTES, 'UTF-8');?>][orderid]" type="text" class="input length_0 mr10" value="<?php echo htmlspecialchars($childValue['orderid'], ENT_QUOTES, 'UTF-8');?>" style="width:20px;"><input name="data[<?php echo htmlspecialchars($childValue['navid'], ENT_QUOTES, 'UTF-8');?>][name]" type="text" class="input length_3 mr5" value="<?php echo htmlspecialchars($childValue['name'], ENT_QUOTES, 'UTF-8');?>"><!--<a href="<?php echo htmlspecialchars($addUrl, ENT_QUOTES, 'UTF-8');?>&type=<?php echo htmlspecialchars($navType, ENT_QUOTES, 'UTF-8');?>&parentid=<?php echo htmlspecialchars($value['navid'], ENT_QUOTES, 'UTF-8');?>" style="display:none" class="s2 dialog">+添加导航</a>-->
					</td>
				<td>
					<input name="data[<?php echo htmlspecialchars($childValue['navid'], ENT_QUOTES, 'UTF-8');?>][link]" type="text" class="input length_4" value="<?php echo htmlspecialchars($childValue['link'], ENT_QUOTES, 'UTF-8');?>">
				</td>
				<td></td>
				<td class="tac"><input name="data[<?php echo htmlspecialchars($childValue['navid'], ENT_QUOTES, 'UTF-8');?>][isshow]" type="checkbox" value="1" <?php echo htmlspecialchars($checked, ENT_QUOTES, 'UTF-8');?>></td>
				<td>
					<a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?navid=', rawurlencode($childValue['navid']),'&type=', rawurlencode($childValue['type']),'&m=nav&c=nav&a=edit'; ?>" class="mr10 J_dialog" title="导航编辑">[编辑]</a><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?navid=', rawurlencode($childValue['navid']),'&m=nav&c=nav&a=del'; ?>" class="mr10 J_ajax_del">[删除]</a>
				</td>
			</tr>
		<?php 
			}
		?>
		</tbody>
		<?php 
			}
			}
		?>
	</table>
	<table width="100%">
		<tr class="ct"><td colspan="5" style="padding-left:38px;"><a data-type="nav_1" data-html="tbody" href="" id="J_add_root" class="link_add">添加导航</a></td></tr>
	</table>
</div>
<div class="btn_wrap">
	<div class="btn_wrap_pd">
		<button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">提交</button>
		<input name="navtype" type="hidden" value="<?php echo htmlspecialchars($navType, ENT_QUOTES, 'UTF-8');?>" >
	</div>
</div>	
<input type="hidden" name="csrf_token" value="<?php echo WindSecurity::escapeHTML(Wind::getComponent('windToken')->saveToken('csrf_token')); ?>"/></form>
<!-- end -->

</div>
<script src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','js'), ENT_QUOTES, 'UTF-8');?>/pages/admin/common/common.js?v<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>"></script>
<script>
/*
root_tr_html 为“添加导航”html
child_tr_html 为“添加二级导航”html
*/
var root_tr_html = '<tr>\
                            <td><span class="zero_icon mr10"></span></td>\
                                        <td>\
                                            <input name="newdata[root_][orderid]" type="text" value="" class="input length_0 mr10">\
                                            <input name="newdata[root_][name]" type="text" class="input length_3 mr5" value="">\
                                            <?php  if ($navType == 'main'): ?>
											<a style="display: none; " href="#" class="link_add J_addChild add_nav" data-html="tbody" data-id="temp_root_" data-type="nav_2">添加二级导航</a>\
											<?php  endif; ?>
                                            <input type="hidden" name="newdata[root_][tempid]" value="temp_root_"/>\
                                        </td>\
                                        <td>\
                                            <input name="newdata[root_][link]" type="text" class="input length_4" value="">\
                                        </td>\
																				<td>\
                                        <?php  if ($navType == 'main'): ?>
										<input type="radio" name="home" value="home_root_" ></td>\
										<?php  endif; 
  if ($navType == 'my'): ?>
										<input type="text" name="newdata[root_][sign]" class="input length_2" value="" >\
										<?php  endif; ?></td>\
                                        <td class="tac"><input name="newdata[root_][isshow]" type="checkbox" value="1" checked="checked"></td>\
                                        <td>\
                                            <a href="" class="mr5 J_newRow_del">[删除]</a>\
                                        </td>\
                                    </tr>',
	child_tr_html = '<tr>\
						<td></td>\
						<td><span class="plus_icon"></span>\
							<input name="newdata[child_][orderid]" type="text" value="" class="input length_0 mr10">\
                                            <input name="newdata[child_][name]" type="text" class="input length_3 mr5" value="">\
                                        </td>\
                                        <td>\
                                            <input name="newdata[child_][link]" type="text" class="input length_4" value="">\
                                        </td>\
																				<td></td>\
                                        <td class="tac"><input name="newdata[child_][isshow]" type="checkbox" value="1" checked="checked"></td>\
                                        <td>\
                                            <a href="" class="mr5 J_newRow_del">[删除]</a>\
                                            <input type="hidden" name="newdata[child_][parentid]" value="id_"/>\
                                        </td>\
                                    </tr>';

Wind.js(GV.JS_ROOT+ 'pages/admin/common/forumTree_table.js?v=' +GV.JS_VERSION);
</script>
</body>
</html>