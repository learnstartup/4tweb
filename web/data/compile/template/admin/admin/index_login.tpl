<!doctype html>
<html  style="background-color:#D6E2E6;">
	<head>
		<meta charset="<?php echo htmlspecialchars(Wekit::app()->charset, ENT_QUOTES, 'UTF-8');?>" />
		<title>系统后台 - <?php echo htmlspecialchars(Wekit::C('site', 'info.name'), ENT_QUOTES, 'UTF-8');?></title>
		<meta name="robots" content="noindex,nofollow">
		<link href="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','css'), ENT_QUOTES, 'UTF-8');?>/admin_login.css?v<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>" rel="stylesheet" />
		<script>
			if (window.parent !== window.self) {
					document.write = '';
					window.parent.location.href = window.self.location.href;
					setTimeout(function () {
							document.body.innerHTML = '';
					}, 0);
			}
		</script>
	</head>
<body style="background: url();"> 
	<div class="wrap" style="width: 400px; margin-top:100px">
		<h1><a style="height: 95px;width: 400px;" href="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','base'), ENT_QUOTES, 'UTF-8');?>">点餐哟 - 后台管理中心</a></h1>
		<form method="post" name="login" action="<?php echo Wekit::app()->baseUrl,'/','admin.php?a=login'; ?>" autoComplete="off">
			<div class="login">
				<ul>
					<li>
						<input class="input" id="J_admin_name" required name="username" type="text" placeholder="帐号名" title="帐号名" />
					</li>
					<li>
						<input class="input" id="admin_pwd" type="password" required name="password" placeholder="密码" title="密码" />
					</li>
					<?php if ($showVerify) {?>
					<li>
						<div id="J_verify_code"></div>
					</li>
					<li>
						<input class="input" type="text" name="code" placeholder="请输入验证码" />
					</li>
					<?php }?>
				</ul>
				<button type="submit" name="submit" class="btn">登录</button>
			</div>
		<input type="hidden" name="csrf_token" value="<?php echo WindSecurity::escapeHTML(Wind::getComponent('windToken')->saveToken('csrf_token')); ?>"/></form>
	</div>

<script>
var GV = {
	JS_ROOT : "<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','res'), ENT_QUOTES, 'UTF-8');?>/js/dev/",																									//js目录
	JS_VERSION : "<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>",																										//js版本号
	TOKEN : '<?php echo htmlspecialchars(Wind::getComponent('windToken')->saveToken('csrf_token'), ENT_QUOTES, 'UTF-8');?>'	//token ajax全局
};
</script>
<script src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','js'), ENT_QUOTES, 'UTF-8');?>/wind.js?v<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>"></script>
<script src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','js'), ENT_QUOTES, 'UTF-8');?>/jquery.js?v<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>"></script>
<script src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','js'), ENT_QUOTES, 'UTF-8');?>/pages/admin/common/common.js?v<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>"></script>
<script>
;(function(){
	document.getElementById('J_admin_name').focus();

	getVerifyTemp({wrap : $('#J_verify_code')});

	function getVerifyTemp(options){
		//验证码模板
		var _this = this,
			wrap = options.wrap,				//验证码容器
			afterClick = options.afterClick,	//点击换一个后回调
			clone = options.clone;				//获取失败后恢复内容
		if(!wrap.length) {
			return;
		}

		wrap.html('<span class="tips_loading">验证码loading</span>');
		var url = '<?php echo Wekit::app()->baseUrl,'/','admin.php?a=showVerify'; ?>';
		$.post(url, {
			csrf_token : GV.TOKEN
		}, function(data){
			if(data.state == 'success') {
				wrap.html(data.data);
			}else if(data.state == 'fail') {
				if(clone) {
					//恢复原代码
					wrap.html(clone.html());
				}else{
					//重试
					wrap.html('<a href="#" role="button" id="J_verify_update_a">重新获取</a>');
				}

				alert(data.message);
				/*_this.resultTip({
					error : true,
					elem : $('#J_verify_update_a'),
					follow : true,
					msg : data.message
				});*/
			}

		}, 'json');

		wrap.off('click').on('click', '#J_verify_update_a', function(e){
			//换一个
			e.preventDefault();

			if(wrap.find('.tips_loading').length) {
				//防多次点击
				return false;
			}

			var clone = wrap.clone();
			wrap.html('<span class="tips_loading">验证码loading</span>');
			getVerifyTemp({
				wrap : wrap,
				clone : clone
			});

			if(afterClick) {
				afterClick();
			}
		}).on('click', '#J_verify_update_img', function(e){
			//点击图片
			$('#J_verify_update_a').click();
		});
	}
})();
</script>
</body>
</html>
