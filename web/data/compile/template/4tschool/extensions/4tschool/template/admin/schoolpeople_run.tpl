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
	<div class="h_a">提示信息</div>
	<div class="mb10 prompt_text">
		<ol>
			<li>以下列表列出了所有开放的高校</li>
			<li>编辑对应的人</li>
		</ol>
	</div>
	<div class="table_list">
		<table width="80%">
			<thead>
				<tr>
					<td>高校</td>
					<td>操作</td>
				</tr>
			</thead>
		<?php  if ($openSchools) { 
 foreach ($openSchools as $key => $item) {?>
			<tr>
				<td><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8');?></td>
				<td>
					<a class="mr10 J_dialog" href="<?php echo Wekit::app()->baseUrl,'/','admin.php?schoolid=', rawurlencode($item['schoolid']),'&app=4tschool&m=app&c=schoolpeople&a=setup'; ?>" class="mr10" title="学校设置">[学校设置]</a>
					&nbsp;
					<a class="mr10 J_dialog" href="<?php echo Wekit::app()->baseUrl,'/','admin.php?schoolid=', rawurlencode($item['schoolid']),'&type=master&app=4tschool&m=app&c=schoolpeople&a=people'; ?>" class="mr10" title="区域总负责人管理">[代理人]</a>
					&nbsp;
				     <a class="mr10 J_dialog" href="<?php echo Wekit::app()->baseUrl,'/','admin.php?schoolid=', rawurlencode($item['schoolid']),'&type=orderdispatch&app=4tschool&m=app&c=schoolpeople&a=people'; ?>" class="mr10" title="订单分配人管理">[订单分配人]</a>
				     &nbsp;
				     <a class="mr10 J_dialog" href="<?php echo Wekit::app()->baseUrl,'/','admin.php?schoolid=', rawurlencode($item['schoolid']),'&type=delivery&app=4tschool&m=app&c=schoolpeople&a=people'; ?>" class="mr10" title="配送人管理">[配送人]</a>
				     <--&nbsp;-->
				      <a class="mr10 J_dialog" href="<?php echo Wekit::app()->baseUrl,'/','admin.php?schoolid=', rawurlencode($item['schoolid']),'&type=delivery&app=4tschool&m=app&c=schoolpeople&a=group'; ?>" class="mr10" title="配送组管理">[配送组]</a>
				      <--&nbsp;-->
				      <a class="mr10" href="<?php echo Wekit::app()->baseUrl,'/','admin.php?schoolid=', rawurlencode($item['schoolid']),'&type=delivery&app=4tschool&m=app&c=schoolpeople&a=peopleingroup'; ?>" class="mr10" title="配送人员组分配">[配送人员组分配]</a>
				     &nbsp;
				     <a class="mr10 J_dialog" href="<?php echo Wekit::app()->baseUrl,'/','admin.php?schoolid=', rawurlencode($item['schoolid']),'&type=areaorderget&app=4tschool&m=app&c=schoolpeople&a=people'; ?>" class="mr10" title="区域下订单人">[区域下订单人]</a>
				     &nbsp;
				     <a class="mr10 J_dialog" href="<?php echo Wekit::app()->baseUrl,'/','admin.php?schoolid=', rawurlencode($item['schoolid']),'&type=shopaccount&app=4tschool&m=app&c=schoolpeople&a=people'; ?>" class="mr10" title="商家帐号列表">[商家帐号列表]</a>
			</tr>
		<?php }
  } else { ?>
			<tbody>
				<tr><td colspan="7" class="tac"> 没有符合条件的结果！</td></tr>
			</tbody>
		<?php  } ?>
		</table>
	</div>
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
	<a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?page=', rawurlencode($_page_i),'&m=u&c=manage'; 
 echo htmlspecialchars($args ? '&' . http_build_query($args) : '', ENT_QUOTES, 'UTF-8');?>" class="pages_pre J_pages_pre">&laquo;&nbsp;上一页</a>
	<?php  if ($_page_min > 1) { 
		$_page_i = 1;		
	?>
	<a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?page=', rawurlencode($_page_i),'&m=u&c=manage'; 
 echo htmlspecialchars($args ? '&' . http_build_query($args) : '', ENT_QUOTES, 'UTF-8');?>">1...</a>
	<?php  } 
  for ($_page_i = $_page_min; $_page_i < $__tplPageCurrent; $_page_i++) { 
	?>
	<a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?page=', rawurlencode($_page_i),'&m=u&c=manage'; 
 echo htmlspecialchars($args ? '&' . http_build_query($args) : '', ENT_QUOTES, 'UTF-8');?>"><?php echo htmlspecialchars($_page_i, ENT_QUOTES, 'UTF-8');?></a>
	<?php  } 
  } ?>
	<strong><?php echo htmlspecialchars($__tplPageCurrent, ENT_QUOTES, 'UTF-8');?></strong>
<?php  if ($__tplPageCurrent < $_page_max) { 
  for ($_page_i = $__tplPageCurrent+1; $_page_i <= $_page_max; $_page_i++) { 
	?>
	<a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?page=', rawurlencode($_page_i),'&m=u&c=manage'; 
 echo htmlspecialchars($args ? '&' . http_build_query($args) : '', ENT_QUOTES, 'UTF-8');?>"><?php echo htmlspecialchars($_page_i, ENT_QUOTES, 'UTF-8');?></a>
	<?php  } 
  if ($_page_max < $__tplPageTotal) { 
		$_page_i = $__tplPageTotal;
	?>
	<a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?page=', rawurlencode($_page_i),'&m=u&c=manage'; 
 echo htmlspecialchars($args ? '&' . http_build_query($args) : '', ENT_QUOTES, 'UTF-8');?>">...<?php echo htmlspecialchars($__tplPageTotal, ENT_QUOTES, 'UTF-8');?></a>
	<?php  }
		$_page_i = $__tplPageCurrent+1;
	?>
	<a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?page=', rawurlencode($_page_i),'&m=u&c=manage'; 
 echo htmlspecialchars($args ? '&' . http_build_query($args) : '', ENT_QUOTES, 'UTF-8');?>" class="pages_next J_pages_next">下一页&nbsp;&raquo;</a>
<?php  } ?>
</div>
<?php } ?>
	
</div>
<script src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','js'), ENT_QUOTES, 'UTF-8');?>/pages/admin/common/common.js?v<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>"></script>
<script>
$(".choosenProvinceid").change(function()
{
	searchchange(true,false);
	
});

$(".choosenSchoolid").change(function()
{
	searchchange(true,true);
	
});

$(".search").click(function(){
	searchchange(true,true);	
});

function searchchange(showP,showS)
{
	var provincepara = '&choosenProvinceid='+$(".choosenProvinceid").val();
	if(!showP)
	{
		provincepara = "";	
	}
	var schoolpara = '&choosenSchoolid='+$(".choosenSchoolid").val(); 
	if(!showS)
	{
		schoolpara = "";		
	}
	window.location.href= $(".pageurl").val()+ provincepara + schoolpara; 
}
</script>
</body>
</html>