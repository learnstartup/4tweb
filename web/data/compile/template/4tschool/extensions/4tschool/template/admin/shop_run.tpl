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
		<div class="h_a">提示信息</div>
		<div class="mb10 prompt_text">
			<ol>
				<li>请正确填写手机号码及地址</li>
			</ol>
		</div>
		<div class="mb10"><a class="btn J_dialog" href="<?php echo Wekit::app()->baseUrl,'/','admin.php?app=4tschool&m=app&c=shop&a=add'; ?>" title="添加商家" role="button"><span class="add"></span>添加商家</a>

		<button type="button" class="btn opendaike"/>开启代客下单商家</button>
		<button type="button" class="btn closedaike">关闭代客下单商家</button>
		<?php  if ('' !=$message) { ?>
        	<strong style="color:red"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8');?>！</strong>
		<?php  } ?>
		<div class="h_a">搜索</div>
		<div class="search_type cc mb10">
			<form class="J_ajaxForm" action="<?php echo Wekit::app()->baseUrl,'/','admin.php?app=4tschool&m=app&c=shop'; ?>" method="post">
				<input type="hidden" name="page" value="<?php echo htmlspecialchars($page, ENT_QUOTES, 'UTF-8');?>">
				<input type='hidden' name='type' value="do">
				<input type="hidden" class="pageurl" name="pageurl" value="<?php echo Wekit::app()->baseUrl,'/','admin.php?app=4tschool&m=app&c=shop'; ?>">

				<!-- <label>商家名:</label>
					<select class="choosenShopid" name="choosenShopid">
						<option value="-1">全部商家</option>	
						<?php foreach($allShopList as $item) {?>
						<option value="<?php echo htmlspecialchars($item['id'], ENT_QUOTES, 'UTF-8');?>" <?php if($item['id'] == $searchCondition['choosenShopid']) echo "selected"; ?> ><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8');?></option>
						<?php }?>
					</select> -->
				<label>一级区域选择:</label>
					<select class="chooseschool" style="width:60px" name="choosenschoolid">
						<option value="-1">全部</option>
	                    <?php foreach($allSchool as $item) {?>
	                    <option class="school<?php echo htmlspecialchars($item['schoolid'], ENT_QUOTES, 'UTF-8');?>"
	                    <?php if($item['schoolid'] == $choosenschoolid) echo "selected"; ?>
	                    value="<?php echo htmlspecialchars($item['schoolid'], ENT_QUOTES, 'UTF-8');?>" ><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8');?>
	                	</option>
	                    <?php }?>
                	</select>	
				<label>活动?</label>
					<select name="isactive">
						<option value="-1">全部</option>
						<option value="1" <?php if($isactive == '1') echo "selected"; ?>>是</option>
						<option value="0" <?php if($isactive == '0') echo "selected"; ?>>否</option>
					</select>
				<label>合作商家?</label>
					<select name="ispartner">
						<option value="-1">全部</option>
						<option value="1" <?php if($ispartner == '1') echo "selected"; ?>>是</option>
						<option value="0" <?php if($ispartner == '0') echo "selected"; ?>>否</option>
					</select>
				<label>商家状态?</label>
					<select name="isaudit">
						<option value="-1">全部</option>
						<option value="1" <?php if($isaudit == '1') echo "selected"; ?>>审核通过</option>
						<option value="0" <?php if($isaudit == '0') echo "selected"; ?>>审核中...</option>
					</select>
				<label>返利?</label>
					<select name="ifrebate">
						<option value="-1">全部</option>
						<option value="1" <?php if($ifrebate == '1') echo "selected"; ?>>有</option>
						<option value="0" <?php if($ifrebate == '0') echo "selected"; ?>>无</option>
					</select>
				<label>代客下单?</label>
					<select name="openordertouser">
						<option value="-1">全部</option>
						<option value="1" <?php if($openordertouser == '1') echo "selected"; ?>>是</option>
						<option value="0" <?php if($openordertouser == '0') echo "selected"; ?>>否</option>
					</select>	
				<label>商家名</label>
					<input type="text" value="<?php echo htmlspecialchars($shopname, ENT_QUOTES, 'UTF-8');?>" style="width:100px" name="shopname" />
				<label>商家ID</label>
					<input type="text" value="<?php echo htmlspecialchars($shopid, ENT_QUOTES, 'UTF-8');?>" style="width:100px" name="shopid" />	
				<button type="submit" class="btn btn_submit">搜索</button>
			<input type="hidden" name="csrf_token" value="<?php echo WindSecurity::escapeHTML(Wind::getComponent('windToken')->saveToken('csrf_token')); ?>"/></form>
		</div>
		<div class="table_list">
			<table width="100%">
				<thead>
					<tr>
						<td>ID</td>
						<td>商家名</td>
						<td>地址</td>
                        <td>打包费(元)</td>
                        <td>外卖费(元)</td>
						<td>区域</td>
						<td>手机号码</td>
						<td style="display:none">最后更新时间</td>
						<td>订单总数</td>
						<td>上线?</td>
						<td>商家状态</td>
						<td>合作商家</td>
						<td>功能</td>
					</tr>
				</thead>
				<?php  if ($shopList) { 
 foreach ($shopList as $key => $item) {?>
				<tr>
					<td><?php echo htmlspecialchars($item['id'], ENT_QUOTES, 'UTF-8');?></td>
					<td><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8');?></td>
					<td><?php echo htmlspecialchars($item['address'], ENT_QUOTES, 'UTF-8');?></td>
                    <td><?php echo htmlspecialchars($item['packingprice'], ENT_QUOTES, 'UTF-8');?></td>
                    <td><?php echo htmlspecialchars($item['deliveryprice'], ENT_QUOTES, 'UTF-8');?></td>
					<td><?php echo htmlspecialchars($item['areaname'], ENT_QUOTES, 'UTF-8');?></td>
					<td><?php echo htmlspecialchars($item['phonenumber'], ENT_QUOTES, 'UTF-8');?></td>
					<td style="display:none"><?php echo htmlspecialchars(Pw::time2str($item['lastupdatetime'], 'Y-m-d H:i:s'), ENT_QUOTES, 'UTF-8');?></td>
					<td><?php echo htmlspecialchars($item['ordercount'], ENT_QUOTES, 'UTF-8');?></td>
					<td><?php echo htmlspecialchars($item['isactive']==1?'是':'否', ENT_QUOTES, 'UTF-8');?></td>
					<td><?php echo htmlspecialchars($item['isaudit']==1?'审核通过':'审核中...', ENT_QUOTES, 'UTF-8');?></td>
					<td><?php echo htmlspecialchars($item['ispartner']==1?'是':'否', ENT_QUOTES, 'UTF-8');?></td>
					<td><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?id=', rawurlencode($item['id']),'&app=4tschool&m=app&c=shop&a=edit'; ?>" class="mr10 J_dialog" title="编辑商家">[编辑]</a>
                        <a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?sid=', rawurlencode($item['id']),'&url=', rawurlencode($item['breviaryphoto']),'&app=4tschool&m=app&c=shop&a=imgupload'; ?>" class="mr10 J_dialog" title="上传图片">[上传图片]</a>
                        <label><?php echo htmlspecialchars(Pw::strlen($item['imageurl'])==0?"无图":"有图", ENT_QUOTES, 'UTF-8');?></label>
					</td>
				</tr>
				<?php }
  } else { ?>
				<tbody>
					<tr><td colspan="14" class="tac">啊哦，目前还没有商家哟！</td></tr>
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
	<a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?page=', rawurlencode($_page_i),'&app=4tschool&m=app&c=shop'; 
 echo htmlspecialchars($args ? '&' . http_build_query($args) : '', ENT_QUOTES, 'UTF-8');?>" class="pages_pre J_pages_pre">&laquo;&nbsp;上一页</a>
	<?php  if ($_page_min > 1) { 
		$_page_i = 1;		
	?>
	<a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?page=', rawurlencode($_page_i),'&app=4tschool&m=app&c=shop'; 
 echo htmlspecialchars($args ? '&' . http_build_query($args) : '', ENT_QUOTES, 'UTF-8');?>">1...</a>
	<?php  } 
  for ($_page_i = $_page_min; $_page_i < $__tplPageCurrent; $_page_i++) { 
	?>
	<a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?page=', rawurlencode($_page_i),'&app=4tschool&m=app&c=shop'; 
 echo htmlspecialchars($args ? '&' . http_build_query($args) : '', ENT_QUOTES, 'UTF-8');?>"><?php echo htmlspecialchars($_page_i, ENT_QUOTES, 'UTF-8');?></a>
	<?php  } 
  } ?>
	<strong><?php echo htmlspecialchars($__tplPageCurrent, ENT_QUOTES, 'UTF-8');?></strong>
<?php  if ($__tplPageCurrent < $_page_max) { 
  for ($_page_i = $__tplPageCurrent+1; $_page_i <= $_page_max; $_page_i++) { 
	?>
	<a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?page=', rawurlencode($_page_i),'&app=4tschool&m=app&c=shop'; 
 echo htmlspecialchars($args ? '&' . http_build_query($args) : '', ENT_QUOTES, 'UTF-8');?>"><?php echo htmlspecialchars($_page_i, ENT_QUOTES, 'UTF-8');?></a>
	<?php  } 
  if ($_page_max < $__tplPageTotal) { 
		$_page_i = $__tplPageTotal;
	?>
	<a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?page=', rawurlencode($_page_i),'&app=4tschool&m=app&c=shop'; 
 echo htmlspecialchars($args ? '&' . http_build_query($args) : '', ENT_QUOTES, 'UTF-8');?>">...<?php echo htmlspecialchars($__tplPageTotal, ENT_QUOTES, 'UTF-8');?></a>
	<?php  }
		$_page_i = $__tplPageCurrent+1;
	?>
	<a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?page=', rawurlencode($_page_i),'&app=4tschool&m=app&c=shop'; 
 echo htmlspecialchars($args ? '&' . http_build_query($args) : '', ENT_QUOTES, 'UTF-8');?>" class="pages_next J_pages_next">下一页&nbsp;&raquo;</a>
<?php  } ?>
</div>
<?php } ?>
		</div>

	</div>
<script src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','js'), ENT_QUOTES, 'UTF-8');?>/pages/admin/common/common.js?v<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>"></script>
<script type="text/javascript">
$('.opendaike').click(function(event){
	daike(1);
});
$('.closedaike').click(function(event){
	daike(0);
});

function daike(status)
{
	window.location.href = $(".pageurl").val() + "&status=" + status + "&yes=yes"; 
}

</script>
</body>
</html>