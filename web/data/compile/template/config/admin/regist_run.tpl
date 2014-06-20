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
			<li class="current"><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?m=config&c=regist'; ?>">注册设置</a></li>
			<li><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?m=config&c=regist&a=login'; ?>">登录设置</a></li>
			<!--<li><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?m=config&c=regist&a=guide'; ?>">新用户引导设置</a></li>-->
		</ul>
	</div>
	<div class="h_a">注册设置</div>
	<form class="J_ajaxForm" data-role="list" action="<?php echo Wekit::app()->baseUrl,'/','admin.php?m=config&c=regist&a=dorun'; ?>" method="post" >
	<div class="table_full">
		<table width="100%">
			<col class="th" />
			<col width="400" />
			<col />
			<tr>
				<th>允许新用户注册</th>
				<td>
					<ul class="single_list cc J_radio_change" id="J_register_type">
						<li><label><input type="radio" name="type" data-arr="reg2" value="1" <?php echo htmlspecialchars(Pw::ifcheck($config['type'] == 1), ENT_QUOTES, 'UTF-8');?>>开放注册</label></li>
						<li><label><input type="radio" name="type" data-arr="reg1,reg2,J_reg2_intro" value="2" <?php echo htmlspecialchars(Pw::ifcheck($config['type'] == 2), ENT_QUOTES, 'UTF-8');?>>邀请注册</label></li>
						<li><label><input type="radio" name="type" data-arr="reg3,J_reg3_intro" value="0" <?php echo htmlspecialchars(Pw::ifcheck($config['type'] == 0), ENT_QUOTES, 'UTF-8');?>>关闭注册</label></li>
					</ul>
				</td>
				<td>
				<div class="fun_tips">
					<div class="J_radio_change_items" id="J_reg2_intro">选择“邀请注册”，则站点只开放邀请注册</div>
					<div class="J_radio_change_items" id="J_reg3_intro">选择“关闭注册”，将禁止游客注册成为会员，但不影响过去已注册的会员的使用</div>
				</div>
				</td>
			</tr>
		</table>
<!--邀请注册内容-->
		<table width="100%" class="J_radio_change_items" id="reg1" style="margin-bottom:0;">
			<col class="th" />
			<col width="400" />
			<col />
			<tbody>
				<tr>
					<th>有效期限</th>
					<td>
						<input type="number" class="input length_5 mr5" value="<?php echo htmlspecialchars($config['invite.expired'], ENT_QUOTES, 'UTF-8');?>" name="inviteExpired">天
					</td>
					<td><div class="fun_tips">设置邀请码有效期限，如果购买后没有在有效期内使用，则失效。</div></td>
				</tr>
				<tr>
					<th>消费积分类型</th>
					<td>
						<select class="select_2 mr10" name="inviteCreditType">
<?php foreach($credits as $id => $credit): ?>
						<option value="<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8');?>" <?php echo htmlspecialchars(Pw::isSelected($id == $config['invite.credit.type']), ENT_QUOTES, 'UTF-8');?>><?php echo htmlspecialchars($credit, ENT_QUOTES, 'UTF-8');?></option>
<?php endforeach; ?>
						</select>
					</td>
					<td><div class="fun_tips">购买邀请码消耗的积分类型，设置消耗积分数量前往<a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?m=u&c=groups'; ?>">用户 &raquo; 用户组权限 &raquo; 基本设置</a>。</div></td>
				</tr>
				<tr style="display:none">
					<th>在线支付功能</th>
					<td>
						<ul class="switch_list cc">
							<li><label><input type="radio" name="invitePayState" value="1" <?php echo htmlspecialchars(pw::ifcheck($config['invite.pay.open'] == 1), ENT_QUOTES, 'UTF-8');?>><span>开启</span></label></li>
							<li><label><input type="radio" name="invitePayState" value="0" <?php echo htmlspecialchars(Pw::ifcheck($config['invite.pay.open'] == 0), ENT_QUOTES, 'UTF-8');?>><span>关闭</span></label></li>
						</ul>
					</td>
					<td><div class="fun_tips">此功能允许注册者通过网上支付一定费用获得邀请码，开启前请确认：1. 系统已开启<a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?m=config&c=pay'; ?>">网上支付</a>功能，2. 系统已开启<a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?m=config&c=email'; ?>">邮件发送</a>功能。</div></td>
				</tr>
				<tr style="display:none">
					<th>支付金额</th>
					<td>
						<input type="text" class="input length_5 mr5" value="<?php echo htmlspecialchars($config['invite.pay.money'], ENT_QUOTES, 'UTF-8');?>" name="invitePayMoney">元
					</td>
					<td><div class="fun_tips"></div></td>
				</tr>
				<tr>
					<th>邀请成功积分奖励</th>
					<td>
						<input type="text" class="input mr5" style="width:160px;" value="<?php echo htmlspecialchars($config['invite.reward.credit.num'], ENT_QUOTES, 'UTF-8');?>" name="inviteRewardCreditNum">
						<select class="select_2 mr10" name="inviteRewardCredit">
<?php foreach($credits as $id => $credit): ?>
						<option value="<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8');?>" <?php echo htmlspecialchars(Pw::isSelected($id == $config['invite.reward.credit.type']), ENT_QUOTES, 'UTF-8');?>><?php echo htmlspecialchars($credit, ENT_QUOTES, 'UTF-8');?></option>
<?php endforeach; ?>
						</select>
					</td>
					<td><div class="fun_tips">设置邀请成功后邀请人获得的积分奖励数值以及积分类型。</div></td>
				</tr>
			</tbody>
		</table>
<!--结束-->
	</div>
	<div class="h_a">基本设置</div>
	<div class="table_full">
		<table width="100%" class="J_radio_change_items" id="reg2" style="margin-bottom:0;">
			<col class="th" />
			<col width="400" />
			<col />
			<tbody>
				<tr>
					<th>注册协议内容</th>
					<td>
						<textarea class="length_5" name="protocol"><?php echo htmlspecialchars($config['protocol'], ENT_QUOTES, 'UTF-8');?></textarea>
					</td>
					<td><div class="fun_tips">注册许可协议的内容。支持html代码。</div></td>
				</tr>
				<tr>
					<th>同一IP重复注册[小时]</th>
					<td>
						<input type="number" class="input length_5 mr5" name="securityIp" value="<?php echo htmlspecialchars($config['security.ip'], ENT_QUOTES, 'UTF-8');?>">小时
					</td>
					<td><div class="fun_tips">规定时间内，同一IP将无法进行多次注册。0或留空表示不限制。</div></td>
				</tr>
				<tr>
					<th>注册验证手机</th>
					<td>
						<ul class="switch_list cc">
							<li><label><input type="radio" name="activePhone" value="1" <?php echo htmlspecialchars(Pw::ifcheck($config['active.phone'] == 1), ENT_QUOTES, 'UTF-8');?>><span>开启</span></label></li>
							<li><label><input type="radio" name="activePhone" value="0" <?php echo htmlspecialchars(Pw::ifcheck($config['active.phone'] == 0), ENT_QUOTES, 'UTF-8');?>><span>关闭</span></label></li>
						</ul>
					</td>
					<td><div class="fun_tips">选择“开启”，则用户在注册时需要验证手机。请确保已开启<a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?m=config&c=mobile'; ?>">手机服务</a>。</div></td>
				</tr>
				<tr>
					<th>新用户注册审核</th>
					<td>
						<ul class="switch_list cc">
							<li><label><input type="radio" name="activeCheck" value="1" <?php echo htmlspecialchars(Pw::ifcheck($config['active.check'] == 1), ENT_QUOTES, 'UTF-8');?>><span>开启</span></label></li>
							<li><label><input type="radio" name="activeCheck" value="0" <?php echo htmlspecialchars(Pw::ifcheck($config['active.check'] == 0), ENT_QUOTES, 'UTF-8');?>><span>关闭</span></label></li>
						</ul>
					</td>
					<td><div class="fun_tips">开启后,新用户只有通过管理员审核才能发帖。</div></td>
				</tr>
				<tr>
					<th>新用户邮件激活</th>
					<td>
						<ul class="switch_list cc">
							<li><label><input type="radio" name="activeMail" value="1" <?php echo htmlspecialchars(Pw::ifcheck($config['active.mail'] == 1), ENT_QUOTES, 'UTF-8');?>><span>开启</span></label></li>
							<li><label><input type="radio" name="activeMail" value="0" <?php echo htmlspecialchars(Pw::ifcheck($config['active.mail'] == 0), ENT_QUOTES, 'UTF-8');?>><span>关闭</span></label></li>
						</ul>
					</td>
					<td><div class="fun_tips">必须先在<a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?m=config&c=email'; ?>">邮件设置</a>中配置邮件服务并测试成功。开启后，系统将向注册 电子邮箱 发送一封验证电子邮件以确认电子邮箱的有效性。用户收到电子邮件并激活帐号后才能拥有正常的权限。</div></td>
				</tr>
				<tr>
					<th>激活邮件标题</th>
					<td>
						<input type="text" class="input length_5 mr5" name="activeTitle" value="<?php echo htmlspecialchars($config['active.mail.title'], ENT_QUOTES, 'UTF-8');?>">
					</td>
					<td><div class="fun_tips">支持参数，如下：<br>{sitename}：站点名称<br>{username}：用户名</div></td>
				</tr>
				<tr>
					<th>激活邮件内容</th>
					<td>
						<textarea class="length_5" name="activeContent"><?php echo htmlspecialchars($config['active.mail.content'], ENT_QUOTES, 'UTF-8');?></textarea>
					</td>
					<td><div class="fun_tips">支持html代码，支持参数：<br>{username}：用户名<br>{sitename}：站点名称<br>{url}：激活地址<br>{time}：发送时间。</div></td>
				</tr>
				<tr>
					<th>发送欢迎信息</th>
					<td>
						<ul class="single_list cc">
							<li><label><input type="checkbox" name="welcomeType[]" value="1" <?php echo htmlspecialchars(Pw::ifcheck(in_array(1, $config['welcome.type'])), ENT_QUOTES, 'UTF-8');?>>站内短信</label></li>
							<li><label><input type="checkbox" name="welcomeType[]" value="2" <?php echo htmlspecialchars(Pw::ifcheck(in_array(2, $config['welcome.type'])), ENT_QUOTES, 'UTF-8');?>>电子邮件</label></li>
						</ul>
					</td>
					<td><div class="fun_tips">新用户注册后系统自动发送表示欢迎的站内短信或电子邮件。<br/>如果开启了邮件激活,则只发送激活邮件,不发送欢迎邮件,必须先在<a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?m=config&c=email'; ?>">邮件设置</a>中配置邮件服务并测试成功。</div></td>
				</tr>
				<tr>
					<th>欢迎信息标题</th>
					<td>
						<input type="text" class="input length_5 mr5" name="welcomeTitle" value="<?php echo htmlspecialchars($config['welcome.title'], ENT_QUOTES, 'UTF-8');?>">
					</td>
					<td><div class="fun_tips">支持参数，如下：<br>{username}：用户名<br>{sitename}：站点名称</div></td>
				</tr>
				<tr>
					<th>欢迎信息内容</th>
					<td>
						<textarea class="length_5" name="welcomeContent"><?php echo htmlspecialchars($config['welcome.content'], ENT_QUOTES, 'UTF-8');?></textarea>
					</td>
					<td><div class="fun_tips">支持html代码，支持参数：<br>{username}：用户名<br>{sitename}：站点名称<br>{time}：发送时间。</div></td>
				</tr>
				<tr>
					<th>禁用用户名</th>
					<td>
						<textarea class="length_5" name="securityBanUsername"><?php echo htmlspecialchars($config['security.ban.username'], ENT_QUOTES, 'UTF-8');?></textarea>
					</td>
					<td><div class="fun_tips">包含设定词汇的所有用户名将无法成功注册。如你禁用了"版主"，那么所有含有"版主"(如:我是版主)的用户名将被禁止使用。多个词之间用英文半角逗号","分隔。</div></td>
				</tr>
				<tr>
					<th>用户名长度控制</th>
					<td>
						<input type="number" class="input select_2 mr15" value="<?php echo htmlspecialchars($config['security.username.min'], ENT_QUOTES, 'UTF-8');?>" name="securityUsernameMin"><span class="mr15">到</span>
						<input type="number" class="input select_2" value="<?php echo htmlspecialchars($config['security.username.max'], ENT_QUOTES, 'UTF-8');?>" name="securityUsernameMax">
					</td>
					<td><div class="fun_tips">用户名字符的最小和最大长度，最小值不能小于1，最大值不能大于15。</div></td>
				</tr>
				<tr>
					<th>密码长度控制</th>
					<td>
						<input type="number" class="input select_2 mr15" value="<?php echo htmlspecialchars($config['security.password.min'], ENT_QUOTES, 'UTF-8');?>" name="securityPasswordMin"><span class="mr15">到</span>
						<input type="number" class="input select_2" value="<?php echo htmlspecialchars($config['security.password.max'], ENT_QUOTES, 'UTF-8');?>" name="securityPasswordMax">
					</td>
					<td><div class="fun_tips">最小值不能小于1，无最大值限制，留空表示不限制。</div></td>
				</tr>
				<tr>
					<th>强制密码复杂度</th>
					<td>
						<ul class="three_list cc">
							<li><label><input type="checkbox" value="1" name="securityPassword[]" <?php echo htmlspecialchars(Pw::ifcheck(in_array(1, $config['security.password'])), ENT_QUOTES, 'UTF-8');?>>小写字母</label></li>
							<li><label><input type="checkbox" value="2" name="securityPassword[]" <?php echo htmlspecialchars(Pw::ifcheck(in_array(2, $config['security.password'])), ENT_QUOTES, 'UTF-8');?>>大写字母</label></li>
							<li><label><input type="checkbox" value="4" name="securityPassword[]" <?php echo htmlspecialchars(Pw::ifcheck(in_array(4, $config['security.password'])), ENT_QUOTES, 'UTF-8');?>>数字</label></li>
							<li><label><input type="checkbox" value="8" name="securityPassword[]" <?php echo htmlspecialchars(Pw::ifcheck(in_array(8, $config['security.password'])), ENT_QUOTES, 'UTF-8');?>>符号</label></li>
							<li style="width:66%;"><label><input type="checkbox" value="9" name="securityPassword[]" <?php echo htmlspecialchars(Pw::ifcheck(in_array(9, $config['security.password'])), ENT_QUOTES, 'UTF-8');?>>密码不能与用户名相同</label></li>
						</ul>
					</td>
					<td><div class="fun_tips">密码中必须符合所选条件限制。</div></td>
				</tr>
				<tr>
					<th>注册界面显示用户字段</th>
					<td>
						<ul class="three_list cc">
							<li><label><input type="checkbox" value="location" name="activeField[]" <?php echo htmlspecialchars(Pw::ifcheck(in_array('location', $config['active.field'])), ENT_QUOTES, 'UTF-8');?>>现居住地</label></li>
							<li><label><input type="checkbox" value="hometown" name="activeField[]" <?php echo htmlspecialchars(Pw::ifcheck(in_array('hometown', $config['active.field'])), ENT_QUOTES, 'UTF-8');?>>家乡</label></li>
							<li><label><input type="checkbox" value="qq" name="activeField[]" <?php echo htmlspecialchars(Pw::ifcheck(in_array('qq', $config['active.field'])), ENT_QUOTES, 'UTF-8');?>>QQ</label></li>
							<li><label><input type="checkbox" value="msn" name="activeField[]" <?php echo htmlspecialchars(Pw::ifcheck(in_array('msn', $config['active.field'])), ENT_QUOTES, 'UTF-8');?>>MSN</label></li>
							<li><label><input type="checkbox" value="aliww" name="activeField[]" <?php echo htmlspecialchars(Pw::ifcheck(in_array('aliww', $config['active.field'])), ENT_QUOTES, 'UTF-8');?>>阿里旺旺</label></li>
						</ul>
					</td>
					<td><div class="fun_tips">选择需要显示在注册界面的用户字段，勾选表示显示并限制必填。</div></td>
				</tr>
			</tbody>
		</table>
		<table width="100%" class="J_radio_change_items" id="reg3" style="margin-bottom:0;">
			<col class="th" />
			<col width="400" />
			<col />
<!--关闭注册内容-->
			<tbody>
				<tr>
					<th>关闭注册原因</th>
					<td>
						<textarea class="length_5" name="closeMsg"><?php echo htmlspecialchars($config['close.msg'], ENT_QUOTES, 'UTF-8');?></textarea>
					</td>
					<td><div class="fun_tips">当站点关闭注册时，对外的提示信息。<br>支持html代码。</div></td>
				</tr>
			</tbody>
<!--结束-->
		</table>
	</div>
	<div class="btn_wrap">
		<div class="btn_wrap_pd">
			<button class="btn btn_submit J_ajax_submit_btn" type="submit">提交</button>
		</div>
	</div>
	<input type="hidden" name="csrf_token" value="<?php echo WindSecurity::escapeHTML(Wind::getComponent('windToken')->saveToken('csrf_token')); ?>"/></form>
</div>
<script src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','js'), ENT_QUOTES, 'UTF-8');?>/pages/admin/common/common.js?v<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>"></script>
<script>

$(function(){
	//是否允许新用户注册
	/*registAreaShow($('#J_register_type input:checked').data('type'));

	$('#J_register_type input:radio').on('change', function(){
			registAreaShow($(this).data('type'));
	});

	function registAreaShow(type) {
		var reg_arr= new Array();
		reg_arr = type.split(",");
		$('.J_reg_tbody').hide();
		$.each(reg_arr, function(i, o){
			$('#'+ o).show();
		});
	}*/
});
</script>
</body>
</html>