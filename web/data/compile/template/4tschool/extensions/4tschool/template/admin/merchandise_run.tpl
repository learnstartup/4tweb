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
		<!-- <div class="nav">
	<ul class="cc">
        	<li class="<?php echo htmlspecialchars($navType=='sm'?'current':'', ENT_QUOTES, 'UTF-8');?>"><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?app=4tschool&m=app&c=manage'; ?>">系统管理</a></li>
        	<li class="<?php echo htmlspecialchars($navType=='t'?'current':'', ENT_QUOTES, 'UTF-8');?>"><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?app=4tschool&m=app&c=tag'; ?>">标签管理</a></li>
        	<li class="<?php echo htmlspecialchars($navType=='sa'?'current':'', ENT_QUOTES, 'UTF-8');?>"><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?app=4tschool&m=app&c=schoolarea'; ?>">学校区域管理</a></li>
        	<li class="<?php echo htmlspecialchars($navType=='m'?'current':'', ENT_QUOTES, 'UTF-8');?>"><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?isall=all&app=4tschool&m=app&c=merchandise'; ?>">商品管理</a></li>
                <li class="<?php echo htmlspecialchars($navType=='p'?'current':'', ENT_QUOTES, 'UTF-8');?>"><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?app=4tschool&m=app&c=promo'; ?>">商家活动管理</a></li>
                <li class="<?php echo htmlspecialchars($navType=='mni'?'current':'', ENT_QUOTES, 'UTF-8');?>"><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?app=4tschool&m=app&c=merchandise&a=noitem'; ?>">商品缺货列表</a></li>
                <li class="<?php echo htmlspecialchars($navType=='sp'?'current':'', ENT_QUOTES, 'UTF-8');?>"><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?app=4tschool&m=app&c=schoolpeople'; ?>">学校管理</a></li>
                <li class="<?php echo htmlspecialchars($navType=='st'?'current':'', ENT_QUOTES, 'UTF-8');?>"><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?app=4tschool&m=app&c=systagtree'; ?>">分类结构管理</a></li>
                <li class="<?php echo htmlspecialchars($navType=='b'?'current':'', ENT_QUOTES, 'UTF-8');?>"><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?app=4tschool&m=app&c=boutique'; ?>">精品推荐管理</a></li>
                <li class="<?php echo htmlspecialchars($navType=='a'?'current':'', ENT_QUOTES, 'UTF-8');?>"><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?app=4tschool&m=app&c=announce'; ?>">公告管理</a></li>
                <li class="<?php echo htmlspecialchars($navType=='cateweekreport'?'current':'', ENT_QUOTES, 'UTF-8');?>"><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?app=4tschool&m=app&c=cateweekreport'; ?>">美食周报</a></li>
	</ul>
</div> -->
		<!--
		<div class="h_a">提示信息</div>
		<div class="mb10 prompt_text">
			<ol>
				<li></li>
				<li></li>
			</ol>
		</div>
		-->
		<div class="mb10"><a class="btn J_dialog" href="<?php echo Wekit::app()->baseUrl,'/','admin.php?shopid=', rawurlencode($choosenShopid),'&app=4tschool&m=app&c=merchandise&a=add'; ?>" title="添加菜品" role="button"><span class="add"></span>添加菜品</a></div>
		<div class="h_a">搜索</div>
		<div class="search_type cc mb10">
			<form class="" action="<?php echo Wekit::app()->baseUrl,'/','admin.php?id=', rawurlencode($choosenShopid),'&app=4tschool&m=app&c=merchandise'; ?>" method="post">
				<input type="hidden" name="type" value="search">
				<input type="hidden" name="page" value="<?php echo htmlspecialchars($page, ENT_QUOTES, 'UTF-8');?>">
				<input type="hidden" class="pageurl" name="pageurl" value="<?php echo Wekit::app()->baseUrl,'/','admin.php?app=4tschool&m=app&c=merchandise'; ?>">
				<label>商家:</label>
				<select class="choosenShopid" name="choosenShopid">
					<?php foreach($shopList as $item) {?>
					<option <?php if($item['id'] == $choosenShopid) echo "selected"; ?> value="<?php echo htmlspecialchars($item['id'], ENT_QUOTES, 'UTF-8');?>" ><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8');?></option>
					<?php }?>
				</select>
				<label>SID：</label><input name="searchShopid" type="text" class="input length_2 mr10" value=<?php echo htmlspecialchars($choosenShopid, ENT_QUOTES, 'UTF-8');?>>
				<button type="submit" class="btn btn_submit J_ajax_submit_btn">搜索</button>
				<select class="selectedFilter" name="selectedFilter">
					<?php foreach($specialList as $key => $item) {?>
					<option <?php if ($key.'_'.$item['value']==$args['selectedFilter']) echo "selected"?> value="<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8');?>_<?php echo htmlspecialchars($item['value'], ENT_QUOTES, 'UTF-8');?>" ><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8');?></option>
					<?php }?>
				</select>				
			<input type="hidden" name="csrf_token" value="<?php echo WindSecurity::escapeHTML(Wind::getComponent('windToken')->saveToken('csrf_token')); ?>"/></form>			
		</div>
		<div class="table_list">
			<table width="100%">
				<thead>
					<tr>
						<td>ID</td>
						<td>菜名</td>
						<td>需要打包费用</td>
						<td>价格</td>
						<td>单位</td>
						<td>剩余数量</td>
						<td>已卖出数量</td>
						<td>推荐?</td>
						<td>上架?</td>
						<td>精品?</td>
						<td>标签</td>
						<td>功能</td>
					</tr>
				</thead>
				<?php  if ($merchandiseList) { 
 foreach ($merchandiseList as $key => $item) {?>
				<tr>
					<td><?php echo htmlspecialchars($item['id'], ENT_QUOTES, 'UTF-8');?></td>
					<td><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8');?></td>
					<td><?php echo htmlspecialchars($item['needPackingPrice']==1?"是":"否", ENT_QUOTES, 'UTF-8');?></td>
					<td><?php echo htmlspecialchars($item['price'], ENT_QUOTES, 'UTF-8');?></td>
					<td><?php echo htmlspecialchars($item['unit'], ENT_QUOTES, 'UTF-8');?></td>
					<td><?php echo htmlspecialchars($item['remainder'], ENT_QUOTES, 'UTF-8');?></td>
					<td><?php echo htmlspecialchars($item['ordercount'], ENT_QUOTES, 'UTF-8');?></td>
					<td><?php echo htmlspecialchars($item['recommend']==1?"是":"否", ENT_QUOTES, 'UTF-8');?></td>
					<td><?php echo htmlspecialchars($item['active']==1?"是":"否", ENT_QUOTES, 'UTF-8');?></td>
					<td><?php echo htmlspecialchars($item['isstar']==1?"是":"否", ENT_QUOTES, 'UTF-8');?></td>
					<td><?php echo htmlspecialchars($item['tagid'], ENT_QUOTES, 'UTF-8');?></td>
					<td><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?id=', rawurlencode($item['id']),'&app=4tschool&m=app&c=merchandise&a=edit'; ?>" class="mr10 J_dialog" title="编辑菜品">[编辑]</a>
						<a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?sid=', rawurlencode($choosenShopid),'&mid=', rawurlencode($item['id']),'&url=', rawurlencode($item['imageurl']),'&app=4tschool&m=app&c=merchandise&a=imgupload'; ?>" class="mr10 J_dialog" title="上传图片">[上传图片]</a>
						<label><?php echo htmlspecialchars(Pw::strlen($item['imageurl'])==0?"无图":"有图", ENT_QUOTES, 'UTF-8');?></label>
					</td>
				</tr>
				<?php }
  } else { ?>
				<tbody>
					<tr><td colspan="14" class="tac">啊哦，目前该商家还没有菜单哟！</td></tr>
				</tbody>
				<?php  } ?>
			</table>
		</div>
		<div class="p10">
				<?php $__tplPageCount=(int)$count;
$__tplPagePer=(int)$perPage;
$__tplPageTotal=(int)0;
$__tplPageCurrent=(int)$page;
if($__tplPageCount > 0 && $__tplPagePer > 0){
$__tmp = ceil($__tplPageCount / $__tplPagePer);
($__tplPageTotal !== 0 &&  $__tplPageTotal < $__tmp) || $__tplPageTotal = $__tmp;}
$__tplPageCurrent > $__tplPageTotal && $__tplPageCurrent = $__tplPageTotal;
if ($__tplPageTotal > 1) {
 
$_page_min = max(1, $__tplPageCurrent-3);
$_page_max = min($__tplPageTotal, $__tplPageCurrent+3);
?>
<div class="pages">
<?php  if ($__tplPageCurrent > $_page_min) { 
	$_page_i = $__tplPageCurrent-1;
?>
	<a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?page=', rawurlencode($_page_i),'&app=4tschool&m=app&c=merchandise'; 
 echo htmlspecialchars($args ? '&' . http_build_query($args) : '', ENT_QUOTES, 'UTF-8');?>" class="pages_pre J_pages_pre">&laquo;&nbsp;上一页</a>
	<?php  if ($_page_min > 1) { 
		$_page_i = 1;		
	?>
	<a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?page=', rawurlencode($_page_i),'&app=4tschool&m=app&c=merchandise'; 
 echo htmlspecialchars($args ? '&' . http_build_query($args) : '', ENT_QUOTES, 'UTF-8');?>">1...</a>
	<?php  } 
  for ($_page_i = $_page_min; $_page_i < $__tplPageCurrent; $_page_i++) { 
	?>
	<a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?page=', rawurlencode($_page_i),'&app=4tschool&m=app&c=merchandise'; 
 echo htmlspecialchars($args ? '&' . http_build_query($args) : '', ENT_QUOTES, 'UTF-8');?>"><?php echo htmlspecialchars($_page_i, ENT_QUOTES, 'UTF-8');?></a>
	<?php  } 
  } ?>
	<strong><?php echo htmlspecialchars($__tplPageCurrent, ENT_QUOTES, 'UTF-8');?></strong>
<?php  if ($__tplPageCurrent < $_page_max) { 
  for ($_page_i = $__tplPageCurrent+1; $_page_i <= $_page_max; $_page_i++) { 
	?>
	<a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?page=', rawurlencode($_page_i),'&app=4tschool&m=app&c=merchandise'; 
 echo htmlspecialchars($args ? '&' . http_build_query($args) : '', ENT_QUOTES, 'UTF-8');?>"><?php echo htmlspecialchars($_page_i, ENT_QUOTES, 'UTF-8');?></a>
	<?php  } 
  if ($_page_max < $__tplPageTotal) { 
		$_page_i = $__tplPageTotal;
	?>
	<a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?page=', rawurlencode($_page_i),'&app=4tschool&m=app&c=merchandise'; 
 echo htmlspecialchars($args ? '&' . http_build_query($args) : '', ENT_QUOTES, 'UTF-8');?>">...<?php echo htmlspecialchars($__tplPageTotal, ENT_QUOTES, 'UTF-8');?></a>
	<?php  }
		$_page_i = $__tplPageCurrent+1;
	?>
	<a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?page=', rawurlencode($_page_i),'&app=4tschool&m=app&c=merchandise'; 
 echo htmlspecialchars($args ? '&' . http_build_query($args) : '', ENT_QUOTES, 'UTF-8');?>" class="pages_next J_pages_next">下一页&nbsp;&raquo;</a>
<?php  } ?>
</div>
<?php } ?>
		</div>

	</div>
<script src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','js'), ENT_QUOTES, 'UTF-8');?>/pages/admin/common/common.js?v<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>"></script>
<script>
	$(".choosenShopid").change(function()
	{
		searchchange(true,false);
	
	});
	$(".search").click(function(){
		searchchange(true);	
	});
	function searchchange(showP)
	{
		var shoppara = '&choosenShopid='+$(".choosenShopid").val();
		if(!showP)
		{
			provincepara = "";	
		}
		window.location.href= $(".pageurl").val()+shoppara+'&isall=all'; 
	}
	$(".selectedFilter").change(function(){
	    window.location.href= $(".pageurl").val()+'&selectedFilter='+$(".selectedFilter").val()+'&choosenShopid='+$(".choosenShopid").val();	
	});
</script>
</body>
</html>