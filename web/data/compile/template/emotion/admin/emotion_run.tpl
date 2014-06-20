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
	<div class="h_a">表情安装说明</div>
	<div class="prompt_text">
		<ol>
			<li>请将包含表情文件的文件夹通过ftp上传至 <span class="red">www/res/images/emotion</span> 目录下。</li>
			<li>在“未安装表情”列表里安装该分类。</li>
			<li>在“启用”列表里启用该分类。</li>
			<li>“管理”该该分类下的表情，“添加”需要启用的表情。</li>
		</ol>
	</div>
<form class="J_ajaxForm" action="<?php echo Wekit::app()->baseUrl,'/','admin.php?m=emotion&c=emotion&a=dorun'; ?>" method="post">
	<div class="table_list">
		<table width="100%">
			<colgroup>
				<col width="50" />
				<col width="80" />
				<col width="220" />
				<col width="120" />
				<col width="250" />
				<col />
			</colgroup>
			<thead>
				<tr>
					<td>启用</td>
					<td>顺序</td>
					<td>分类名称</td>
					<td>文件夹名</td>
					<td>支持应用</td>
					<td>操作</td>
				</tr>
			</thead>
		<?php  foreach ($catList as $cat):?>
			<tr>
				<td><input type="checkbox" name="isopen[<?php echo htmlspecialchars($cat['category_id'], ENT_QUOTES, 'UTF-8');?>]"  <?php echo htmlspecialchars(Pw::ifcheck($cat['isopen']), ENT_QUOTES, 'UTF-8');?> value="1"/>
					<input type="hidden" name="catid[]" value="<?php echo htmlspecialchars($cat['category_id'], ENT_QUOTES, 'UTF-8');?>"/>
				</td>
				<td><input type="number" class="input length_1" name="category_orderid[<?php echo htmlspecialchars($cat['category_id'], ENT_QUOTES, 'UTF-8');?>]" value="<?php echo htmlspecialchars($cat['orderid'], ENT_QUOTES, 'UTF-8');?>" /></td>
				<td><input type="text" class="input length_3" name="category_name[<?php echo htmlspecialchars($cat['category_id'], ENT_QUOTES, 'UTF-8');?>]" value="<?php echo htmlspecialchars($cat['category_name'], ENT_QUOTES, 'UTF-8');?>"/></td>
				<td><?php echo htmlspecialchars($cat['emotion_folder'], ENT_QUOTES, 'UTF-8');?></td>
				<td>
					<div class="J_toggle_list dn" style="float:left;margin-top:18px;">
						<div class="core_menu" tabindex="0">
							<div class="core_menu_list">
								<ul class="cc">
							<?php  foreach ($appList as $key=>$app):?>
									<li><label><input type="checkbox" name="apps[<?php echo htmlspecialchars($cat['category_id'], ENT_QUOTES, 'UTF-8');?>][]" <?php echo htmlspecialchars(Pw::ifcheck(in_array($key, $cat['apps'])), ENT_QUOTES, 'UTF-8');?> value="<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8');?>"/><?php echo htmlspecialchars($app, ENT_QUOTES, 'UTF-8');?></label></li>
							<?php  endforeach; ?>	

								</ul>
							</div>
						</div>
					</div>
					<a href="" class="cate_link_down J_click_toggle"></a><span class="J_support_list"><?php echo htmlspecialchars($cat['appsname'], ENT_QUOTES, 'UTF-8');?></span>
				</td>
				<td>
					<a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?catid=', rawurlencode($cat['category_id']),'&m=emotion&c=emotion&a=emotion'; ?>" class="mr5">[管理]</a>
					<a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?cateid=', rawurlencode($cat['category_id']),'&m=emotion&c=emotion&a=deletecate'; ?>" class="mr5 J_ajax_del">[删除]</a>
				</td>
			</tr>
		<?php  endforeach; ?>
		</table>
	</div>
	<div class="btn_wrap_pd"><button class="btn btn_submit J_ajax_submit_btn" type="submit">提交</button></div>
	<input type="hidden" name="csrf_token" value="<?php echo WindSecurity::escapeHTML(Wind::getComponent('windToken')->saveToken('csrf_token')); ?>"/></form>
	<div class="table_list mb10">
		<div class="h_a">未安装表情</div>
		<form class="J_ajaxForm" action="<?php echo Wekit::app()->baseUrl,'/','admin.php?m=emotion&c=emotion&a=doadd'; ?>" method="post">
		<table width="100%">
			<tr>
				<td width="80">顺序</td>
				<td width="220">分类名称</td>
				<td width="120">文件夹名</td>
				<td>操作</td>
			</tr>
		<?php  foreach ($folderList as $folder):?>
			<tr>
				<td><input type="number" class="input length_1" name="orderid"/></td>
				<td><input type="text" class="input length_3" name="catname"/></td>
				<td><?php echo htmlspecialchars($folder, ENT_QUOTES, 'UTF-8');?><input type="hidden" name="folder" value="<?php echo htmlspecialchars($folder, ENT_QUOTES, 'UTF-8');?>"/></td>
				<td><button class="btn J_ajax_submit_btn" type="submit">安装</button></td>
			</tr>
		<?php  endforeach; ?>
		</table>
		<input type="hidden" name="csrf_token" value="<?php echo WindSecurity::escapeHTML(Wind::getComponent('windToken')->saveToken('csrf_token')); ?>"/></form>	
	</div>
</div>
<script src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','js'), ENT_QUOTES, 'UTF-8');?>/pages/admin/common/common.js?v<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>"></script>
<script>
$(function(){
	//显示支持应用
	$('a.J_click_toggle').on('click', function(e){
		e.preventDefault();
		$(this).prev('.J_toggle_list').toggleClass('dn');			//不能用toggle()，父标签浮动宽高为0，jquery :hidden为true
	});
	
	var lock = false;
	$('div.J_toggle_list').children().on('mouseenter', function(){
		lock = true;
	}).on('mouseleave', function(){
		$(this).focus();
		lock = false;
	}).on('blur', function(){
		if(!lock) {
			$(this).parent().addClass('dn');
		}
	}).on('click', 'input:checkbox', function(){
		//点击下拉项
		var arr = [],
			list = $(this).parents('.J_toggle_list'),
			checked = list.find('input:checkbox:checked');
		
		//循环写入名称
		$.each(checked, function(i, o){
			arr.push($(this).parent().text());
		});
		list.siblings('.J_support_list').text(arr.join('、'));
		
	});
});
</script>
</body>
</html>
