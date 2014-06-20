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
			<li class="current"><a href="<?php echo htmlspecialchars(WindUrlHelper::createUrl('app/qusite/manage/run'), ENT_QUOTES, 'UTF-8');?>">客服设置</a></li>
		</ul>
	</div>
	<div class="h_a">基础设置</div>
	
	<form class="J_ajaxForm" action="<?php echo htmlspecialchars(WindUrlHelper::createUrl('app/qusite/manage/doSet'), ENT_QUOTES, 'UTF-8');?>" method="post">
  	<div class="table_full">
  		<table width="100%">
			<col class="th" />
			<col width="800" />
			<col />
        <tr>
          <td>学校<input type="hidden" value="<?php echo htmlspecialchars($schoolid, ENT_QUOTES, 'UTF-8');?>" name="config[schoolid]" /></td>
          <td>
            <select name="school" id="sc" onChange="schoolchange(this.value)">
                <option value="">点餐哟官方客服</option>
              <?php foreach($allSchool as $item) {?>
                <option class="school<?php echo htmlspecialchars($item['schoolid'], ENT_QUOTES, 'UTF-8');?>"
                <?php if($item['schoolid'] == $schoolid) echo "selected"; ?>
                value="<?php echo htmlspecialchars($item['schoolid'], ENT_QUOTES, 'UTF-8');?>" ><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8');?>
              </option>
            <?php }?>
            </select>
          </td>
        </tr>
    		<tr>
      			<td>状态</td>
      			<td>
      				<ul class="switch_list cc">
            			<li><input type="radio" name="config[isopen]" value="1" <?php echo htmlspecialchars(Pw::ifcheck($config['isopen']), ENT_QUOTES, 'UTF-8');?> />开启</li>
            			<li><input type="radio" name="config[isopen]" value="0" <?php echo htmlspecialchars(Pw::ifcheck(!$config['isopen']), ENT_QUOTES, 'UTF-8');?> />关闭</li>
          			</ul>      			</td>
	  			<td><div class="fun_tips"></div></td>
    		</tr>
		  <tr>
    		  <td>客服QQ</td>
    		  <td><textarea name="config[qq]" class=" length_6"><?php echo htmlspecialchars($config[qq], ENT_QUOTES, 'UTF-8');?></textarea></td>
    		  <td>如：技术部:杨周-89652519,小潘-888888|seo部:小刘-888888,小丹-888888|市场部:陆经理-888888</td>
  		  </tr>
           <tr>
    		  <td>客服电话</td>
    		  <td><textarea name="config[tel]" class=" length_6"><?php echo htmlspecialchars($config[tel], ENT_QUOTES, 'UTF-8');?></textarea></td>
    		  <td>如：018-83600000,010-532525<span class="red">注：用英文符号</span></td>
  		  </tr>
 <script type="text/javascript">
$(function(){
var column='3';
options(column,'style');
});
function stylex(value){
	$("#img").attr("src","/themes/extres/qusite/o/"+value+".png");
}

function schoolchange(value)
{
  window.location.href = "admin.php?app=qusite&m=app&c=manage&schoolid="+value;
}

</script>
            <tr>
    		  <td>样式</td>
    		  <td><select name="config[style]" id="style" onChange="stylex(this.value)">
                    <option value="3">风格3</option>
				</select></td>
    		  <td></td>
  		  </tr>
           <tr>
    		  <td>效果</td>
    		  <td><img src="themes/extres/qusite/o/<?php echo htmlspecialchars($config[style], ENT_QUOTES, 'UTF-8');?>.png" id="img"></td>
    		  <td></td>
  		  </tr><tr>
      			<td>使用方式</td>
      			<td>
      				在后台全局-站点设置-站点信息：填写以下代码<br>
&lt;script src="themes/extres/qusite/qusite.js">&lt;/script>  </td>
	  			<td><div class="fun_tips"></div></td>
    		</tr>
  		</table>
  	</div>
	<div class="">
		<div class="btn_wrap_pd">
			<button class="btn btn_submit J_ajax_submit_btn" type="submit" >提交</button>
		</div>
	</div>
	<input type="hidden" name="csrf_token" value="<?php echo WindSecurity::escapeHTML(Wind::getComponent('windToken')->saveToken('csrf_token')); ?>"/></form>
</div>
<script src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','js'), ENT_QUOTES, 'UTF-8');?>/pages/admin/common/common.js?v<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>"></script>
</body>
</html>