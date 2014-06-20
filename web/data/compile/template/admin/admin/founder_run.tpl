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

<!--创始人开始-->
<div class="h_a">提示信息</div>
<div class="mb10 prompt_text">
	<ol>
		<li>创始人拥有后台所有权限，若无特殊情况请勿更改</li>
		<li>您可以添加新创始人，或删除其它创始人</li>
		<?php if(!$is_writeable){?>
		<li><span class="red">你的配置文件不可写，无法对创始人进行管理操作</span></li>
		<?php }?>
	</ol>
</div>
<div class="h_a">创始人管理</div>
<div class="table_full">
<form id="J_founder_form" action="<?php echo Wekit::app()->baseUrl,'/','admin.php?c=founder&a=add'; ?>" method="post">
	<table width="100%">
		<col class="th" />
		<col />
<?php foreach($list as $user): ?>
		<tr>
			<th><?php echo htmlspecialchars($user, ENT_QUOTES, 'UTF-8');?></th>
			<td>
			<a class="J_dialog mr5" href="<?php echo Wekit::app()->baseUrl,'/','admin.php?username=', rawurlencode($user),'&c=founder&a=edit'; ?>" title="编辑">[编辑]</a>
			<a class="J_ajax_del" href="<?php echo Wekit::app()->baseUrl,'/','admin.php?username=', rawurlencode($user),'&c=founder&a=del'; ?>">[删除]</a></td>
		</tr>
<?php endforeach;?>

		<tr>
			<th><input name="username" type="text" class="input length_2"></th>
			<td>
				<button type="submit" class="btn" id="J_founder_sub"><span class="add"></span>添加创始人</button>
			</td>
		</tr>
	</table>
<input type="hidden" name="csrf_token" value="<?php echo WindSecurity::escapeHTML(Wind::getComponent('windToken')->saveToken('csrf_token')); ?>"/></form>
</div>
<!--创始人结束-->


</div>
<script src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','js'), ENT_QUOTES, 'UTF-8');?>/pages/admin/common/common.js?v<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>"></script>
<script>
Wind.use('dialog', 'ajaxForm', function(){
	var founder_add_btn = $('#J_founder_sub');

	$('#J_founder_form').ajaxForm({
		dataType : 'json',
		beforeSubmit: function(arr, $form, options) {
			var text = founder_add_btn.text();
			//按钮文案、状态修改
			founder_add_btn.text(text +'中...').prop('disabled',true).addClass('disabled');
		},
		success : function(data, statusText, xhr, $form) {
			var text = founder_add_btn.text();
			//按钮文案、状态修改
			founder_add_btn.removeClass('disabled').prop('disabled', false).text(text.replace('中...', '')).parent().find('span').remove();

			if(data.state == 'success') {
				Wind.dialog.open( data.referer ,{
					onClose : function() {
						$('#J_founder_sub').focus();	//关闭时让触发弹窗的元素获取焦点
					},
					title: '添加创始人'
				});
			}else if(data.state == 'fail'){
				$( '<span class="tips_error">' + data.message + '</span>' ).appendTo(founder_add_btn.parent()).fadeIn( 'fast' );
				founder_add_btn.removeProp('disabled').removeClass('disabled');
			}
			
		}
	});
})
</script>
</body>
</html>