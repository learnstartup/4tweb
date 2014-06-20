<!doctype html>
<html>
<head>
	<meta charset="<?php echo htmlspecialchars(Wekit::app()->charset, ENT_QUOTES, 'UTF-8');?>" />
<title><?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','seo','title'), ENT_QUOTES, 'UTF-8');?></title>
<meta http-equiv="X-UA-Compatible" content="chrome=1">
<meta name="generator" content="phpwind v<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','version'), ENT_QUOTES, 'UTF-8');?>" />
<meta name="description" content="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','seo','description'), ENT_QUOTES, 'UTF-8');?>" />
<meta name="keywords" content="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','seo','keywords'), ENT_QUOTES, 'UTF-8');?>" />
<link rel="stylesheet" href="<?php echo Wekit::app()->themes.'/site/'.Wekit::C('site', 'theme.site.default').'/css'.Wekit::getGlobal('theme','debug'); ?>/core.css?v=<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>" />
<link rel="stylesheet" href="<?php echo Wekit::app()->themes.'/site/'.Wekit::C('site', 'theme.site.default').'/css'.Wekit::getGlobal('theme','debug'); ?>/style.css?v=<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>" />
<!-- <base id="headbase" href="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','base'), ENT_QUOTES, 'UTF-8');?>/" /> -->
<?php echo Wekit::C('site', 'css.tag');?>
<script>
//全局变量 Global Variables
var GV = {
	JS_ROOT : '<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','res'), ENT_QUOTES, 'UTF-8');?>/js/dev/',										//js目录
	JS_VERSION : '<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>',											//js版本号(不能带空格)
	JS_EXTRES : '<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>',
	TOKEN : '<?php echo htmlspecialchars(Wind::getComponent('windToken')->saveToken('csrf_token'), ENT_QUOTES, 'UTF-8');?>',	//token $.ajaxSetup data
	U_CENTER : '<?php echo Wekit::app()->baseUrl,'/','index.php?m=space'; ?>',		//用户空间(参数 : uid)
<?php 
$loginUser = Wekit::getLoginUser();
if ($loginUser->isExists()) {
?>
	//登录后
	U_NAME : '<?php echo htmlspecialchars($loginUser->username, ENT_QUOTES, 'UTF-8');?>',										//登录用户名
	U_AVATAR : '<?php echo htmlspecialchars(Pw::getAvatar($loginUser->uid), ENT_QUOTES, 'UTF-8');?>',							//登录用户头像
<?php 
}
?>
	U_AVATAR_DEF : '<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','images'), ENT_QUOTES, 'UTF-8');?>/face/face_small.jpg',					//默认小头像
	U_ID : parseInt('<?php echo htmlspecialchars($loginUser->uid, ENT_QUOTES, 'UTF-8');?>'),									//uid
	REGION_CONFIG : '',														//地区数据
	CREDIT_REWARD_JUDGE : '<?php echo $loginUser->showCreditNotice();?>',			//是否积分奖励，空值:false, 1:true
	URL : {
		LOGIN : '<?php echo Wekit::app()->baseUrl,'/','index.php?m=u&c=login'; ?>',										//登录地址
		QUICK_LOGIN : '<?php echo Wekit::app()->baseUrl,'/','index.php?m=u&c=login&a=fast'; ?>',								//快速登录
		IMAGE_RES: '<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','images'), ENT_QUOTES, 'UTF-8');?>',										//图片目录
		CHECK_IMG : '<?php echo Wekit::app()->baseUrl,'/','index.php?m=u&c=login&a=showverify'; ?>',							//验证码图片url，global.js引用
		VARIFY : '<?php echo Wekit::app()->baseUrl,'/','index.php?m=verify&a=get'; ?>',									//验证码html
		VARIFY_CHECK : '<?php echo Wekit::app()->baseUrl,'/','index.php?m=verify&a=check'; ?>',							//验证码html
		HEAD_MSG : {
			LIST : '<?php echo Wekit::app()->baseUrl,'/','index.php?m=message&c=notice&a=minilist'; ?>'							//头部消息_列表
		},
		USER_CARD : '<?php echo Wekit::app()->baseUrl,'/','index.php?m=space&c=card'; ?>',								//小名片(参数 : uid)
		LIKE_FORWARDING : '<?php echo Wekit::app()->baseUrl,'/','index.php?c=post&a=doreply'; ?>',							//喜欢转发(参数 : fid)
		REGION : '<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=webData&a=area'; ?>',									//地区数据
		SCHOOL : '<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=webData&a=school'; ?>',								//学校数据
		EMOTIONS : "<?php echo Wekit::app()->baseUrl,'/','index.php?m=emotion&type=bbs'; ?>",					//表情数据
		CRON_AJAX : '<?php echo htmlspecialchars($runCron, ENT_QUOTES, 'UTF-8');?>',											//计划任务 后端输出执行
		FORUM_LIST : '<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=forum&a=list'; ?>',								//版块列表数据
		CREDIT_REWARD_DATA : '<?php echo Wekit::app()->baseUrl,'/','index.php?m=u&a=showcredit'; ?>',					//积分奖励 数据
		AT_URL: '<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=remind'; ?>',									//@好友列表接口
		TOPIC_TYPIC: '<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=forum&a=topictype'; ?>'							//主题分类
	}
};
</script>
<script src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','js'), ENT_QUOTES, 'UTF-8');?>/wind.js?v=<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>"></script>

	<link href="<?php echo Wekit::app()->themes.'/site/default/css'.Wekit::getGlobal('theme','debug'); ?>/forum.css?v=<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>" rel="stylesheet" />
	<link href="<?php echo Wekit::app()->themes.'/site/default/css'.Wekit::getGlobal('theme','debug'); ?>/editor_content.css?v=<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>" rel="stylesheet" />
<?php  $designPermission = $loginUser->getPermission('design_allow_manage.push'); 
  if ($operateThread || $designPermission > 0) { ?>
	<link href="<?php echo Wekit::app()->themes.'/site/default/css'.Wekit::getGlobal('theme','debug'); ?>/management.css?v=<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>" rel="stylesheet" />
<?php  } ?>
<style>
.aPre{
	cursor:url(<?php echo Wekit::app()->themes.'/site/default/images'; ?>/common/pre.cur),auto;
}
.aNext{
	cursor:url(<?php echo Wekit::app()->themes.'/site/default/images'; ?>/common/next.cur),auto;right:0;
}
</style>
</head>
<body>
<style type="text/css">
</style><?php  
    			$__design_pageid = 5;
    			Wind::import("SRV:design.bo.PwDesignPageBo");
    			$__design = new PwDesignPageBo();
    			$__design_data = $__design->getDataByModules(array());
    			
  
			$loginUser = Wekit::getLoginUser();
	   	 	$designPermission = $loginUser->getPermission('design_allow_manage.push');
	    	if ($designPermission > 0){?><form method="post" action=""><button class="design_mode_edit" type="submit">模块管理</button><input type="hidden" name="design" value="1"><input type="hidden" name="csrf_token" value="<?php echo WindSecurity::escapeHTML(Wind::getComponent('windToken')->saveToken('csrf_token')); ?>"/></form><?php  } ?>
<div class="wrap">
	<?php if ($site_info_notice = Wekit::C('site','info.notice')) {?>
<style>.header_wrap{top:29px;}body{padding-top:75px;}</style><div id="notice"><?php echo htmlspecialchars($site_info_notice, ENT_QUOTES, 'UTF-8');?></div>
<?php }?>
<header class="header_wrap">
	<div id="J_header" class="header cc">
		<div class="logo">
			<a href="<?php echo Wekit::app()->baseUrl,'/',''; ?>">
				<?php  if($__css = Wekit::C('site', 'css.logo')) { ?>
				<!--后台logo上传-->
				<img src="<?php echo htmlspecialchars(Pw::getPath($__css), ENT_QUOTES, 'UTF-8');?>" alt="<?php echo htmlspecialchars(Wekit::C('site','info.name'), ENT_QUOTES, 'UTF-8');?>">
				<?php  } else { ?>
				<img style="height:45px" src="<?php echo Wekit::app()->themes.'/site/'.Wekit::C('site', 'theme.site.default').'/images'; ?>/logo.png" alt="<?php echo htmlspecialchars(Wekit::C('site','info.name'), ENT_QUOTES, 'UTF-8');?>">
				<?php  } ?>
			</a>
		</div>
		<nav class="nav_wrap">
			<div class="nav">
				<ul>
	<?php  $nav = Wekit::load('SRV:nav.bo.PwNavBo');
		  $nav->setRouter();
		  $currentId =  '';
		   $main = $child = array();
		  if ($nav->isForum()) $nav->setForum($pwforum->foruminfo['parentid'], $fid, $tid);
		  $main = $nav->getNavFromConfig('main', true);
		  foreach($main as $key=>$value):
			if ($value['current']) {
				$current = 'current';
				$currentId = $key;
			} else {
				$current = '';
			}
			$value['child'] && $child[$key] = $value['child'];
		  ?>
					<li class="<?php echo htmlspecialchars($current, ENT_QUOTES, 'UTF-8');?>"><?php echo $value['name'];?></li>
	<?php  endforeach; ?>
				</ul>
			</div>
		</nav>
		<div class="header_search" role="search">
			<form action="<?php echo Wekit::app()->baseUrl,'/','index.php?m=search&c=s'; ?>" method="post">
				<input type="text" id="s" aria-label="搜索关键词" accesskey="s" placeholder="搜索其实很简单" x-webkit-speech speech name="keyword"/>
				<button type="submit" aria-label="搜索"><img src="<?php echo Wekit::app()->themes.'/site/'.Wekit::C('site', 'theme.site.default').'/images'; ?>/common/search.png" alt="search" /></button>
			<input type="hidden" name="csrf_token" value="<?php echo WindSecurity::escapeHTML(Wind::getComponent('windToken')->saveToken('csrf_token')); ?>"/></form>
		</div>
		<?php
PwHook::display(array(PwSimpleHook::getInstance("header_nav"), "runDo"), array(), "", $__viewer);

  if (!$loginUser->isExists()) { ?>
<div class="header_login">
	<a rel="nofollow" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=u&c=login'; ?>">登录</a><a rel="nofollow" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=u&c=register'; ?>">注册</a>
</div>
<?php  } else {
	if ($pwforum && $pwforum->isForum()) {
		$ifJsFastPost = '';
		$_tmpfid = $pwforum->fid;
	} else {
		$ifJsFastPost = "J_head_forum_post";
		$_tmpfid = 0;
	}

  } ?>
	</div>
</header>
<?php 
if ($child) {
foreach ($child as $ck => $cv) {
	 if ($currentId == $ck):
?>
	<div class="nav_weak" id="<?php echo htmlspecialchars($ck, ENT_QUOTES, 'UTF-8');?>">
<?php  else: ?>
	<div class="nav_weak" id="<?php echo htmlspecialchars($ck, ENT_QUOTES, 'UTF-8');?>" style="display:none">
<?php  endif; ?>
		<ul class="cc">
			<?php  foreach($cv as $_v):
				$current = $_v['current'] ? 'current' : '';
			?>
			<li class="<?php echo htmlspecialchars($current, ENT_QUOTES, 'UTF-8');?>"><?php echo $_v['name'];?></li>
			<?php  endforeach; ?>
		</ul>
	</div>
<?php }} ?>
<div class="tac"> </div>
	<div class="main_wrap">
		<pw-tpl id="main_segment"/>
		<div class="bread_crumb">
			<?php $__tplPageCount=(int)$count;
$__tplPagePer=(int)$perpage;
$__tplPageTotal=(int)$totalpage;
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
	<a href="<?php echo Wekit::app()->baseUrl,'/','read.php?tid=', rawurlencode($tid),'&fid=', rawurlencode($fid),'&page=', rawurlencode($_page_i); 
 echo htmlspecialchars($urlargs ? '&' . http_build_query($urlargs) : '', ENT_QUOTES, 'UTF-8');?>" class="pages_pre J_pages_pre">&laquo;&nbsp;上一页</a>
	<?php  if ($_page_min > 1) { 
		$_page_i = 1;		
	?>
	<a href="<?php echo Wekit::app()->baseUrl,'/','read.php?tid=', rawurlencode($tid),'&fid=', rawurlencode($fid),'&page=', rawurlencode($_page_i); 
 echo htmlspecialchars($urlargs ? '&' . http_build_query($urlargs) : '', ENT_QUOTES, 'UTF-8');?>">1...</a>
	<?php  } 
  for ($_page_i = $_page_min; $_page_i < $__tplPageCurrent; $_page_i++) { 
	?>
	<a href="<?php echo Wekit::app()->baseUrl,'/','read.php?tid=', rawurlencode($tid),'&fid=', rawurlencode($fid),'&page=', rawurlencode($_page_i); 
 echo htmlspecialchars($urlargs ? '&' . http_build_query($urlargs) : '', ENT_QUOTES, 'UTF-8');?>"><?php echo htmlspecialchars($_page_i, ENT_QUOTES, 'UTF-8');?></a>
	<?php  } 
  } ?>
	<strong><?php echo htmlspecialchars($__tplPageCurrent, ENT_QUOTES, 'UTF-8');?></strong>
<?php  if ($__tplPageCurrent < $_page_max) { 
  for ($_page_i = $__tplPageCurrent+1; $_page_i <= $_page_max; $_page_i++) { 
	?>
	<a href="<?php echo Wekit::app()->baseUrl,'/','read.php?tid=', rawurlencode($tid),'&fid=', rawurlencode($fid),'&page=', rawurlencode($_page_i); 
 echo htmlspecialchars($urlargs ? '&' . http_build_query($urlargs) : '', ENT_QUOTES, 'UTF-8');?>"><?php echo htmlspecialchars($_page_i, ENT_QUOTES, 'UTF-8');?></a>
	<?php  } 
  if ($_page_max < $__tplPageTotal) { 
		$_page_i = $__tplPageTotal;
	?>
	<a href="<?php echo Wekit::app()->baseUrl,'/','read.php?tid=', rawurlencode($tid),'&fid=', rawurlencode($fid),'&page=', rawurlencode($_page_i); 
 echo htmlspecialchars($urlargs ? '&' . http_build_query($urlargs) : '', ENT_QUOTES, 'UTF-8');?>">...<?php echo htmlspecialchars($__tplPageTotal, ENT_QUOTES, 'UTF-8');?></a>
	<?php  }
		$_page_i = $__tplPageCurrent+1;
	?>
	<a href="<?php echo Wekit::app()->baseUrl,'/','read.php?tid=', rawurlencode($tid),'&fid=', rawurlencode($fid),'&page=', rawurlencode($_page_i); 
 echo htmlspecialchars($urlargs ? '&' . http_build_query($urlargs) : '', ENT_QUOTES, 'UTF-8');?>" class="pages_next J_pages_next">下一页&nbsp;&raquo;</a>
<?php  } ?>
</div>
<?php } ?>
			<div class="pages" style="margin-right:3px;"><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=thread&fid=', rawurlencode($pwforum->fid),'&page=', rawurlencode($fpage); ?>" class="pages_pre" rel="nofollow">&laquo; 返回列表</a></div>
			<?php echo $headguide;?>
		</div>
		<div class="main cc"><input type="hidden" id="js-tid" value="$tid" />
			<div class="read_page" id="J_posts_list">
				<pw-tpl id="first_segment"/>
				<div id="app_test"></div>
				<div id="cloudwind_read_top"></div>
				<?php  if ($operateThread || $designPermission > 0) { ?>
				<div class="read_management cc J_post_manage_col" data-role="readbar">
					<?php 
						$hasFirstPart = $operateThread['topped'] || $operateThread['digest'] || $operateThread['highlight'] || $operateThread['up'];
						$hasSecondPart = $operateThread['type'] || $operateThread['print'] || $operateThread['move'] || $operateThread['copy'] || $operateThread['unite'];
						$hasThirdPart = $operateThread['lock'] || $operateThread['down'] || $operateThread['delete'];
					
  if ($operateThread['topped']){ ?><a data-type="norefresh" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=manage&a=topped'; ?>" class="">置顶</a><?php  } 
  if ($operateThread['digest']){ ?><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=manage&a=digest'; ?>" class="">精华</a><?php  } 
  if ($operateThread['highlight']){ ?><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=manage&a=highlight'; ?>" class="">加亮</a><?php  } 
  if ($operateThread['up']){ ?><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=manage&a=up'; ?>" class="">提前</a><?php  } 
  if ($hasFirstPart && $hasSecondPart){ ?><i>|</i><?php  } 
  if ($operateThread['type']){ ?><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=manage&a=type'; ?>" class="">分类</a><?php  } 
  if ($operateThread['print']){ ?><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=manage&a=unite'; ?>" class="">印戳</a><?php  } 
  if ($operateThread['move']){ ?><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=manage&a=move'; ?>" class="">移动</a><?php  } 
  if ($operateThread['copy']){ ?><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=manage&a=copy'; ?>" class="">复制</a><?php  } 
  if ($operateThread['unite']){ ?><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=manage&a=unite'; ?>" class="">合并</a><?php  } 
  if ($hasThirdPart && ($hasFirstPart ^ $hasSecondPart || $hasFirstPart && $hasSecondPart)){ ?><i>|</i><?php  } 
  if ($operateThread['lock']){ ?><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=manage&a=lock'; ?>" class="">锁定</a><?php  } 
  if ($operateThread['down']){ ?><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=manage&a=down'; ?>" class="">压帖</a><?php  } 
  if ($operateThread['delete']){ ?><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=masingle&a=delete'; ?>">删除</a><?php  } 
  if ($designPermission > 0) { 
  if ($hasFirstPart || $hasSecondPart || $hasThirdPart){ ?><i>|</i><?php  } ?>
					<a data-type="norefresh" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=design&c=push&a=add&fromtype=thread&fromid=', rawurlencode($tid); ?>" class="" title="推送">推送</a><!--这玩意交互改下class="mr10 J_manage_single" id="J_push_trigger"  以前的推送class="J_read_push" -->
					<?php  } ?>
				</div>
				<?php  } 
  foreach ($readdb as $key => $read) { ?>
				<a name="<?php echo htmlspecialchars($read['pid'], ENT_QUOTES, 'UTF-8');?>"></a><?php  if ($read['lou'] == $count-1) { ?><a name="a"></a><?php  } ?>
				<div id="cloudwind_read_readfloor_<?php echo htmlspecialchars($read['pid'], ENT_QUOTES, 'UTF-8');?>"></div>
<div class="floor cc J_read_floor" id="read_<?php echo htmlspecialchars($read['pid'], ENT_QUOTES, 'UTF-8');?>">
<table width="100%" style="table-layout:fixed;" class="floor_table">
	<tr>
		<td rowspan="2" class="floor_left">
			<div class="floor_info">
				<!--头像-->
				<div class="face">
					<a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=space&uid=', rawurlencode($read['created_userid']); ?>" class="J_user_card_show" data-uid="<?php echo htmlspecialchars($read['created_userid'], ENT_QUOTES, 'UTF-8');?>" target="_blank"><img src="<?php echo htmlspecialchars(Pw::getAvatar($read['created_userid']), ENT_QUOTES, 'UTF-8');?>" class="J_avatar" data-type="middle" width="100" height="100" alt="<?php echo htmlspecialchars($read['created_username'], ENT_QUOTES, 'UTF-8');?>"></a>
				</div>
				<!--用户名-->
				<div class="name">
					<span class="<?php echo htmlspecialchars($users[$read['created_userid']]['gender']==1 ? 'women' : 'man', ENT_QUOTES, 'UTF-8');?>_<?php echo htmlspecialchars(($_isol = Pw::checkOnline($users[$read['created_userid']]['lastvisit'])) ? 'ol' : 'unol', ENT_QUOTES, 'UTF-8');?>" title="<?php echo htmlspecialchars($_isol ? '在线' : '离线', ENT_QUOTES, 'UTF-8');?>"></span><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=space&uid=', rawurlencode($read['created_userid']); ?>" class="J_user_card_show mr5" data-uid="<?php echo htmlspecialchars($read['created_userid'], ENT_QUOTES, 'UTF-8');?>"><?php echo htmlspecialchars($read['created_username'], ENT_QUOTES, 'UTF-8');?></a>
					<?php if ($operateReply['ban']) {?>
					<span class="J_post_manage_col" data-role="readbar"><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=manage&a=ban&tid=', rawurlencode($tid),'&uid=', rawurlencode($read['created_userid']); ?>" data-uid="<?php echo htmlspecialchars($read['created_userid'], ENT_QUOTES, 'UTF-8');?>" class="J_dialog_post fn org">[禁止]</a></span>
					<?php }?>
				</div>
				<!--等级-->
				<div class="level">
					<div><?php echo htmlspecialchars($ltitle[$users[$read['created_userid']]['groupid']], ENT_QUOTES, 'UTF-8');?></div>
					<img src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','images'), ENT_QUOTES, 'UTF-8');?>/level/<?php echo htmlspecialchars($lpic[$users[$read['created_userid']]['groupid']], ENT_QUOTES, 'UTF-8');?>" alt="<?php echo htmlspecialchars($ltitle[$users[$read['created_userid']]['groupid']], ENT_QUOTES, 'UTF-8');?>">
				</div>
				<!--相关数据-->
				<ul class="cc integral">
				<?php  if ($displayMemberInfo && $read['created_userid']) { 
  foreach ($displayInfo as $key => $value) { 
  if ($key == 'uid') { ?>
					<li><em>UID</em><span><?php echo htmlspecialchars($read['created_userid'], ENT_QUOTES, 'UTF-8');?></span></li>
					<?php  } elseif ($key == 'regdate') { ?>
					<li><em>注册日期</em><span><?php echo htmlspecialchars(Pw::time2str($users[$read['created_userid']]['regdate'], 'Y-m-d'), ENT_QUOTES, 'UTF-8');?></span></li>
					<?php  } elseif ($key == 'lastvisit') { ?>
					<li><em>最后登录</em><span><?php echo htmlspecialchars(Pw::time2str($users[$read['created_userid']]['lastvisit'], 'Y-m-d'), ENT_QUOTES, 'UTF-8');?></span></li>
					<?php  } elseif ($key == 'fans') { ?>
					<li><em>粉丝</em><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=space&c=fans&uid=', rawurlencode($read['created_userid']); ?>" target="_blank"><?php echo htmlspecialchars($users[$read['created_userid']]['fans'], ENT_QUOTES, 'UTF-8');?></a></li>
					<?php  } elseif ($key == 'follows') { ?>
					<li><em>关注</em><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=space&c=follows&uid=', rawurlencode($read['created_userid']); ?>" target="_blank"><?php echo htmlspecialchars($users[$read['created_userid']]['follows'], ENT_QUOTES, 'UTF-8');?></a></li>
					<?php  } elseif ($key == 'posts') { ?>
					<li><em>发帖数</em><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=space&c=thread&uid=', rawurlencode($read['created_userid']); ?>" target="_blank"><?php echo htmlspecialchars($users[$read['created_userid']]['postnum'], ENT_QUOTES, 'UTF-8');?></a></li>
					<?php  } elseif ($key == 'homepage') { ?>
					<li><em>个人主页</em><span title="<?php echo htmlspecialchars($users[$read['created_userid']]['homepage'], ENT_QUOTES, 'UTF-8');?>"><?php echo htmlspecialchars($users[$read['created_userid']]['homepage'], ENT_QUOTES, 'UTF-8');?></span></li>
					<?php  } elseif ($key == 'location') { ?>
					<li><em>来自</em><span title="<?php echo htmlspecialchars($users[$read['created_userid']]['location_text'], ENT_QUOTES, 'UTF-8');?>"><?php echo htmlspecialchars($users[$read['created_userid']]['location_text'], ENT_QUOTES, 'UTF-8');?></span></li>
					<?php  } elseif ($key == 'qq') { ?>
					<li><em>QQ</em><span><?php echo htmlspecialchars($users[$read['created_userid']]['qq'], ENT_QUOTES, 'UTF-8');?></span></li>
					<?php  } elseif ($key == 'aliww') { ?>
					<li><em>阿里旺旺</em><span><?php echo htmlspecialchars($users[$read['created_userid']]['aliww'], ENT_QUOTES, 'UTF-8');?></span></li>
					<?php  } elseif ($key == 'birthday') { ?>
					<li><em>生日</em><span><?php echo htmlspecialchars($users[$read['created_userid']]['byear'], ENT_QUOTES, 'UTF-8');?>-<?php echo htmlspecialchars($users[$read['created_userid']]['bmonth'], ENT_QUOTES, 'UTF-8');?>-<?php echo htmlspecialchars($users[$read['created_userid']]['bday'], ENT_QUOTES, 'UTF-8');?></span></li>
					<?php  } elseif ($key == 'hometown') { ?>
					<li><em>家乡</em><span title="<?php echo htmlspecialchars($users[$read['created_userid']]['hometown_text'], ENT_QUOTES, 'UTF-8');?>"><?php echo htmlspecialchars($users[$read['created_userid']]['hometown_text'], ENT_QUOTES, 'UTF-8');?></span></li>
					<?php  } elseif (isset($creditBo->cType[$key])) { ?>
					<li><em><?php echo htmlspecialchars($creditBo->cType[$key], ENT_QUOTES, 'UTF-8');?></em><span title="<?php echo htmlspecialchars($users[$read['created_userid']]['credit'.$key], ENT_QUOTES, 'UTF-8');
 echo htmlspecialchars($creditBo->cUnit[$key], ENT_QUOTES, 'UTF-8');?>"><?php echo htmlspecialchars($users[$read['created_userid']]['credit'.$key], ENT_QUOTES, 'UTF-8');
 echo htmlspecialchars($creditBo->cUnit[$key], ENT_QUOTES, 'UTF-8');?></span></li>
					<?php  } 
  } 
  } ?>
				</ul>
				<?php  if ($read['created_userid']) { ?>
				<!--发私信加关注-->
				<div class="operate cc">
					<a rel="nofollow" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=my&c=follow&a=add&uid=', rawurlencode($read['created_userid']); ?>" data-uid="<?php echo htmlspecialchars($read['created_userid'], ENT_QUOTES, 'UTF-8');?>" class="follow J_read_follow J_qlogin_trigger">加关注</a>
					<a rel="nofollow" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=message&c=message&a=pop&username=', rawurlencode($read['created_username']); ?>" class="message J_send_msg_pop J_qlogin_trigger" data-name="<?php echo htmlspecialchars($read['created_username'], ENT_QUOTES, 'UTF-8');?>">写私信</a>
					<?php
PwHook::display(array($threadDisplay, "runDo"), array('createHtmlForUserButton',$users[$read['created_userid']], $read), "", $__viewer);
?>
				</div>
				<?php  } 

PwHook::display(array($threadDisplay, "runDo"), array('createHtmlAfterUserInfo',$users[$read['created_userid']], $read), "", $__viewer);

  if ($read['lou'] == 0) { 
  } ?>
				<!--广告位-->
				 
				<!--信息栏结束-->
			</div>
		</td>
		<td class="box_wrap floor_right">
			<div class="fl"><div class="floor_arrow"><em></em><span></span></div></div>
			<?php  if ($read['lou'] == 0) { ?>
			<div class="floor_title cc">
				<div class="post_num">
					<ul class="cc">
						<li>阅读：<em><?php echo htmlspecialchars($threadInfo['hits'], ENT_QUOTES, 'UTF-8');?></em></li>
						<li>回复：<em id="topicRepliesNum"><?php echo htmlspecialchars($threadInfo['replies'], ENT_QUOTES, 'UTF-8');?></em></li>
					</ul>
				</div>
				<h1 id="J_post_title"><?php  if ($threadInfo['topic_type'] && ($topicTypename = $threadDisplay->getTopicTypeName($threadInfo['topic_type']))) { ?><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=thread&fid=', rawurlencode($pwforum->fid),'&type=', rawurlencode($threadInfo['topic_type']); ?>">[<?php echo $topicTypename;?>]</a><?php  } 
 echo htmlspecialchars($threadInfo['subject'], ENT_QUOTES, 'UTF-8');?></h1>
				<span class="floor_honor posts_icon">
					<?php if ($threadInfo['topped']) {?><i class="icon_headtopic_1" title="置顶"></i><?php }
 if ($threadInfo['digest']) {?><i class="icon_digest" title="精华"></i><?php }
 if ($threadInfo['replies'] > $hotIcon) {?><i class="icon_topichot" title="热门"></i><?php }
 if ($threadInfo['highlight']) {?><i class="icon_highlight" title="加亮"></i><?php }?>
				</span>
			</div>
			<?php  } ?>
			<div class="c"></div>
			<div class="floor_top_tips cc">
				<div style="position:relative;"><span class="lou J_floor_copy" title="复制此楼地址" <?php  if($read['lou'] == 0) {?> data-type="main"<?php  } ?> data-hash="read_<?php echo htmlspecialchars($read['pid'], ENT_QUOTES, 'UTF-8');?>"><?php echo htmlspecialchars($threadDisplay->getFloorName($read['lou']), ENT_QUOTES, 'UTF-8');?><sup>#</sup></span></div>
				<?php  if (!empty($read['istopped'])) { ?>
				<div class="inside_digs_icon" title="帖内置顶"></div>
				<?php  } 
  if ($read['lou'] == 0) { 
					$_urlDescArgs = $urlDescArgs ? '&' . http_build_query($urlDescArgs) : '';
				?>
				<a href="javascript:;" class="more_down" id="J_read_moredown">更多</a>
				<div id="J_read_moredown_list" class="core_menu" style="display:none;">
					<ul class="core_menu_list">
						<li><a rel="nofollow" href="<?php echo Wekit::app()->baseUrl,'/','read.php?tid=', rawurlencode($read['tid']),'&fid=', rawurlencode($read['fid']),'&uid=', rawurlencode($read['created_userid']); ?>">只看楼主</a></li>
						<li><a rel="nofollow" href="<?php echo Wekit::app()->baseUrl,'/','read.php?tid=', rawurlencode($read['tid']),'&fid=', rawurlencode($read['fid']),'&desc=1'; 
 echo htmlspecialchars($_urlDescArgs, ENT_QUOTES, 'UTF-8');?>">倒序阅读</a></li>
					</ul>
				</div>
				<?php  } ?>
				<span class="fl">发布于：<?php echo htmlspecialchars(Pw::time2str($read['created_time']), ENT_QUOTES, 'UTF-8');
  if ($loginUser->getPermission('view_ip_address')) { ?>，<span title="IP: <?php echo htmlspecialchars($read['created_ip'], ENT_QUOTES, 'UTF-8');?>">来自：<?php echo htmlspecialchars($read['ipfrom'], ENT_QUOTES, 'UTF-8');?></span> <?php }
  if ($loginUser->uid && ($read['created_userid'] == $loginUser->uid || $threadPermission['edit'])) { ?>
				 <a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=post&a=modify&tid=', rawurlencode($tid),'&pid=', rawurlencode($read['pid']); ?>">[编辑]</a>
				<?php  } ?>
				</span>
			</div>
			<?php  if ($read['disabled'] == 1) { ?>
				<div class="inside_logs"><span class="red">该帖需要审核通过后才能显示</span></div>
			<?php  } 
  if (!empty($read['istopped'])) { ?>
			<div class="inside_logs"><span class="org">帖内置顶</span>&nbsp;&nbsp;&ndash;&nbsp;&nbsp;<?php echo htmlspecialchars($users[$read['topped_userid']]['username'], ENT_QUOTES, 'UTF-8');?>&nbsp;&nbsp;&ndash;&nbsp;&nbsp;<?php echo htmlspecialchars(Pw::time2str($read['topped_time']), ENT_QUOTES, 'UTF-8');?></div>
			<?php  } ?>
			<div id="J_read_main">
				 
				<?php  if ($read['lou'] == 0) { 
					$read['tags'] && $reaTags = explode(',', $read['tags']);
				?>
				<div id="J_read_tag_wrap" class="read_tag_list">
					<?php  foreach ((array)$reaTags as $tag) { ?>
					<a data-url="<?php echo Wekit::app()->baseUrl,'/','index.php?m=tag&a=card&name=', rawurlencode($tag); ?>" class="J_read_tag_item tag_item" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=tag&a=view&name=', rawurlencode($tag); ?>"><?php echo htmlspecialchars($tag, ENT_QUOTES, 'UTF-8');?></a>
					<div class="tag_card J_tag_card" style="display:none;"><div class="pop_loading"></div></div>
					<?php  } 
  if (($read['created_userid'] === $loginUser->uid && $loginUser->getPermission('tag_allow_add')) || $loginUser->getPermission('tag_allow_edit')) { ?>
					<a id="J_read_tag_edit_btn" href="javascript:;" class="edit">[编辑话题]</a>
					<?php  } ?>
				</div>
				<!--=========话题编辑=========-->
				<div id="J_read_tag_edit" class="mb10 cc" style="display:none;">
					<form id="J_read_tag_form" action="<?php echo Wekit::app()->baseUrl,'/','index.php?m=tag&a=editReadTag&tid=', rawurlencode($tid); ?>" method="post">
						<div class="user_select_input J_user_tag_wrap fl mr10">
							<ul class="fl J_user_tag_ul"></ul>
							<input class="J_user_tag_input" data-name="tagnames[]" type="text" />
						</div>
						<button id="J_read_tag_sub" class="btn btn_submit">保存</button>
					<input type="hidden" name="csrf_token" value="<?php echo WindSecurity::escapeHTML(Wind::getComponent('windToken')->saveToken('csrf_token')); ?>"/></form>
				</div>
				<?php  } 
  if ($read['lou'] == 0) { 
  } 

PwHook::display(array($threadDisplay, "runDo"), array('createHtmlBeforeContent',$read), "", $__viewer);
?>
				<div class="fr">
				<!--开始右侧广告位-->
					 
				<!--结束右侧广告位-->
				</div>
				<div class="editor_content">
					<?php  if ($read['lou'] != 0 && $read['subject']) { ?>
					<div class="inside_title"><?php echo htmlspecialchars($read['subject'], ENT_QUOTES, 'UTF-8');?></div>
					<?php  } 
 echo $read['content'];?>
				</div>
				<?php  if ($read['modified_time']) { ?>
				<div class="edit_log">[<?php echo htmlspecialchars($read['modified_username'], ENT_QUOTES, 'UTF-8');?>于<?php echo htmlspecialchars(Pw::time2str($read['modified_time']), ENT_QUOTES, 'UTF-8');?>编辑了帖子]</div>
				<?php  } 

PwHook::display(array($threadDisplay, "runDo"), array('createHtmlAfterContent',$read), "", $__viewer);
?>
			</div>
		</td>
	</tr>
	<tr>
		<td class="box_wrap floor_bottom" valign="bottom">
		<?php  if ($threadDisplay->attach && $attach = $threadDisplay->attach->getList($read['pid'])) { 
  if ($attach['pic']) { 
  $_isShowSmall = (count($attach['pic']) >= 5); ?>
			<div class="read_attach_pic">
				<?php  if ($_isShowSmall) { ?>
				<div class="hd">
					<div class="fr"><a href="javascript:;" class="current J_big_images">大图</a><span>|</span><a href="javascript:;" class="J_small_images">小图</a></div>
					<h2>图片</h2>
				</div>
				<?php  } ?>
				<div class="ct">
					<ul class="cc big_img" style="display:<?php echo htmlspecialchars($_isShowSmall ? 'none' : '', ENT_QUOTES, 'UTF-8');?>">
						<?php  foreach ($attach['pic'] as $key => $value) { ?>
						<li><span class="J_attach_img_wrap"><div class="img_info J_img_info"><?php  if ($value['descrip']) { ?><p>描述：<?php echo htmlspecialchars($value['descrip'], ENT_QUOTES, 'UTF-8');?></p><?php  } ?><p>图片：<?php echo htmlspecialchars($value['name'], ENT_QUOTES, 'UTF-8');
  if ($threadPermission['deleteatt']) { ?><a class="J_read_img_del" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=attach&a=delete&aid=', rawurlencode($value['aid']); ?>">[删除]</a><?php  } ?></p></div><?php echo $value['img'];?></span></li>
						<?php  } ?>
					</ul>
					<?php  if ($_isShowSmall) { ?>
					<ul class="cc small_img J_gallery_list">
						<?php  foreach ($attach['pic'] as $key => $value) { ?>
						<li class="J_gallery_items"><a data-big="<?php echo htmlspecialchars($value['url'], ENT_QUOTES, 'UTF-8');?>" href="<?php echo htmlspecialchars($value['url'], ENT_QUOTES, 'UTF-8');?>" target="_blank"><img onerror="this.onerror=null;this.className='J_error';" src="<?php echo htmlspecialchars($value['miniUrl'], ENT_QUOTES, 'UTF-8');?>" width="125" height="125" alt=""></a></li>
						<?php  } ?>
					</ul>
					<?php  } ?>
				</div>
			</div>
			<?php  } 
  if ($attach['downattach']) { ?>
			<div class="read_attach_downattach">
				<dl>
					<dt class="cc">
						<span class="name">附件名称/大小</span>
						<span class="cost">下载次数</span>
						<span class="time">最后更新</span>
						<span class="operate"></span>
					</dt>
					<?php  foreach ($attach['downattach'] as $key => $value) { ?>
					<dd class="cc" id="J_att_<?php echo htmlspecialchars($value['aid'], ENT_QUOTES, 'UTF-8');?>">
						<span class="name" title="<?php echo htmlspecialchars($value['descrip'], ENT_QUOTES, 'UTF-8');?>"><span class="file_list_wrap"><span class="file_icon_<?php echo htmlspecialchars($value['ext'], ENT_QUOTES, 'UTF-8');?>"></span></span><a class="J_attach_post_buy" data-cost="<?php  if ($value['cost']) { ?>true<?php  } ?>" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=attach&a=download&aid=', rawurlencode($value['aid']); ?>" data-credit="<?php echo htmlspecialchars($loginUser->getCredit($value['ctype']), ENT_QUOTES, 'UTF-8');?>" data-countrel="#J_attach_count_<?php echo htmlspecialchars($value['aid'], ENT_QUOTES, 'UTF-8');?>"><?php echo htmlspecialchars($value['name'], ENT_QUOTES, 'UTF-8');?></a>&nbsp;(<?php echo htmlspecialchars($value['size'], ENT_QUOTES, 'UTF-8');?>KB)&nbsp;</span>
						<span class="cost"><span class="" id="J_attach_count_<?php echo htmlspecialchars($value['aid'], ENT_QUOTES, 'UTF-8');?>"><?php echo htmlspecialchars($value['hits'], ENT_QUOTES, 'UTF-8');?></span></span>
						<span class="time"><?php echo htmlspecialchars(Pw::time2str($value['created_time'], 'auto'), ENT_QUOTES, 'UTF-8');?></span>
						<span class="operate">
							<?php  if ($value['cost']) { ?>
							售价<span class="org mr10"><?php echo htmlspecialchars($value['cost'], ENT_QUOTES, 'UTF-8');
 echo htmlspecialchars($creditBo->cType[$value['ctype']], ENT_QUOTES, 'UTF-8');?></span><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=attach&a=record&aid=', rawurlencode($value['aid']); ?>" title="查看记录" class="mr10 fn J_buy_record" data-aid="<?php echo htmlspecialchars($value['aid'], ENT_QUOTES, 'UTF-8');?>">[记录]</a>
							<?php  } 
  if ($threadPermission['deleteatt']) { ?><a class="J_attach_post_del" data-rel="#J_att_<?php echo htmlspecialchars($value['aid'], ENT_QUOTES, 'UTF-8');?>" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=attach&a=delete&aid=', rawurlencode($value['aid']); ?>">[删除]</a><?php  } ?>
						</span>
					</dd>
					<?php  } ?>
				</dl>
			</div>
			<?php  } 
  } 
  if (!$read['pid']) { ?>
			<a role="button" rel="nofollow" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=like&c=mylike&a=doLike&typeid=1&fromid=', rawurlencode($read['tid']); ?>" data-tid="<?php echo htmlspecialchars($tid, ENT_QUOTES, 'UTF-8');?>" data-pid="<?php echo htmlspecialchars($read['pid'], ENT_QUOTES, 'UTF-8');?>" data-fid="<?php echo htmlspecialchars($fid, ENT_QUOTES, 'UTF-8');?>" class="icon_read_like J_like_btn J_qlogin_trigger" data-role="main">
				<span>喜欢</span><em class="J_like_count"><?php echo htmlspecialchars($read['like_count'], ENT_QUOTES, 'UTF-8');?></em>
			</a>
			<?php  } 
  if (!$read['pid']) { ?>
			<div style="<?php echo htmlspecialchars(empty($read['lastLikeUsers']) ? 'display:none' : '', ENT_QUOTES, 'UTF-8');?>" id="J_read_like_list" class="read_like_list cc">
				<h4 class="J_read_like_tit">最新喜欢：</h4>
				<?php  if ($read['lastLikeUsers']) { 
  foreach ($read['lastLikeUsers'] as $likeuser) { ?>
				<a class="J_user_card_show" data-uid="<?php echo htmlspecialchars($likeuser['uid'], ENT_QUOTES, 'UTF-8');?>" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=space&uid=', rawurlencode($likeuser['uid']); ?>"><img  class="J_avatar" src="<?php echo htmlspecialchars(Pw::getAvatar($likeuser['uid']), ENT_QUOTES, 'UTF-8');?>" data-type="small" width="50" height="50" alt="<?php echo htmlspecialchars($likeuser['username'], ENT_QUOTES, 'UTF-8');?>" /><span title="<?php echo htmlspecialchars($likeuser['username'], ENT_QUOTES, 'UTF-8');?>"><?php echo htmlspecialchars(Pw::substrs($likeuser['username'],6), ENT_QUOTES, 'UTF-8');?></span></a>
					<?php  } 
  } ?>
			</div>
			<?php  } ?>
			<div id="app_read_floor_<?php echo htmlspecialchars($read['lou'], ENT_QUOTES, 'UTF-8');?>"></div>
			<?php  if ($read['lou'] == 0) { ?>
			<div id="cloudwind_read_content"></div>
			<?php  } 

PwHook::display(array($threadDisplay, "runDo"), array('createHtmlContentBottom',$read), "", $__viewer);

  if ($users[$read['created_userid']]['bbs_sign']) { 
 
				$_signheight = (isset($groupRight[$users[$read['created_userid']]['groupid']]['sign_max_height']) && $groupRight[$users[$read['created_userid']]['groupid']]['sign_max_height']) ? $groupRight[$users[$read['created_userid']]['groupid']]['sign_max_height'] : 200;
				?>
			<div class="signature" style="max-height:<?php echo htmlspecialchars($_signheight, ENT_QUOTES, 'UTF-8');?>px;maxHeight:<?php echo htmlspecialchars($_signheight, ENT_QUOTES, 'UTF-8');?>px;"><table width="100%"><tr><td><?php echo $users[$read['created_userid']]['bbs_sign'];?></td></tr></table></div>
			<?php  } 
  if ($read['lou'] == 0) { 
  } 
  if ($read['lou'] == 0 && $showReply) { ?>
			<!--快速回复-->
			<div class="reply_quick cc">
				<dl class="ct cc">
					<dt><img class="J_avatar" data-type="small" src="<?php echo htmlspecialchars(Pw::getAvatar($loginUser->uid,'small'), ENT_QUOTES, 'UTF-8');?>" width="50" height="50" alt="<?php echo htmlspecialchars($loginUser->username, ENT_QUOTES, 'UTF-8');?>" /></dt>
					<dd>
						<div class="arrow"><em></em><span></span></div>
						<textarea name="atc_content" aria-label="快速回复" id="J_reply_quick_ta" class="J_at_user_textarea" placeholder="我也说两句"></textarea>
					</dd>
				</dl>
				<div class="ft cc" id="J_reply_ft" style="display:none;">
					<div class="operate">
						<a href="" tabindex="-1" rel="nofollow" class="a_face J_insert_emotions" data-emotiontarget="#J_reply_quick_ta">表情</a>
					</div>
					<button type="submit" data-tid="<?php echo htmlspecialchars($tid, ENT_QUOTES, 'UTF-8');?>" data-action="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=post&a=doreply&_getHtml=1'; ?>" class="btn btn_submit disabled" disabled="disabled" id="J_reply_quick_btn">回复</button>
					<a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=post&a=reply&tid=', rawurlencode($tid); ?>">进入高级模式&gt;&gt;</a>
				</div>
			</div>
			<!--快速回复结束-->
			<?php  } ?>
			
			<div class="floor_bottom_tips cc">
				<?php  $type =  !$read['pid'] ? 'thread' : 'post'; $type_id = !$read['pid'] ? $read['tid'] : $read['pid']; ?>
				<span class="fr">
					<?php if ($read['lou'] == 0 && $canLook && Pw::getstatus($read['tpcstatus'], PwThread::STATUS_OPERATORLOG)) { ?>
					<a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=read&a=log&tid=', rawurlencode($read['tid']),'&fid=', rawurlencode($read['fid']); ?>" class="mr10 J_post_top J_qlogin_trigger" id="J_inside_logs">查看操作记录</a>
					<?php }
  if ($operateReply['toppedreply'] && $read['lou']){ 
  if (!$read['topped']){ ?>
					<a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=masingle&a=dotoppedreply&topped=1&tid=', rawurlencode($read['tid']),'&lou=', rawurlencode($read['lou']),'&pid=', rawurlencode($read['pid']); ?>" class="mr10 J_post_top J_qlogin_trigger">帖内置顶</a>
						<?php  } else { ?>
					<a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=masingle&a=dotoppedreply&topped=0&tid=', rawurlencode($read['tid']),'&lou=', rawurlencode($read['lou']),'&pids%5B%5D=', rawurlencode($read['pid']); ?>" class="mr10 J_post_top J_qlogin_trigger">取消置顶</a>
						<?php  } 
  } 
  if ($operateReply['read']){ ?>
					<a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=masingle&a=doinspect&tid=', rawurlencode($read['tid']),'&lou=', rawurlencode($read['lou']),'&pids%5B%5D=', rawurlencode($read['pid']); ?>" class="mr10 J_read_mark J_qlogin_trigger">已阅</a>
					<?php  } 
  if ($loginUser->getPermission('allow_report')) { ?>
					<a rel="nofollow" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=report&a=report&type=', rawurlencode($type),'&type_id=', rawurlencode($type_id); ?>" data-pid="<?php echo htmlspecialchars($read['pid'], ENT_QUOTES, 'UTF-8');?>" class="mr10 J_report J_qlogin_trigger">举报</a>
					<?php  } 
  if ($operateReply) { ?>
					<label for="label_<?php echo htmlspecialchars($read['pid'], ENT_QUOTES, 'UTF-8');?>"><input name="pids[]" id="label_<?php echo htmlspecialchars($read['pid'], ENT_QUOTES, 'UTF-8');?>" type="checkbox" value="<?php echo htmlspecialchars($read['pid'], ENT_QUOTES, 'UTF-8');?>" class="J_check checkbox">管理</label>
					<?php  } ?>
				</span>
				<?php  if ($read['lou'] != 0 && (!$pwforum->forumset['locktime'] || ($read['created_time'] + $pwforum->forumset['locktime'] * 86400) > Pw::getTime())) { ?>
				<a rel="nofollow" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=post&a=fastreply&tid=', rawurlencode($tid),'&pid=', rawurlencode($read['pid']); ?>" data-pid="<?php echo htmlspecialchars($read['pid'], ENT_QUOTES, 'UTF-8');?>" class="a_reply J_read_reply" data-topped="<?php echo htmlspecialchars(empty($read['istopped']) ? 'false' : 'true', ENT_QUOTES, 'UTF-8');?>">回复<span style="<?php echo htmlspecialchars($read['replies'] > 0 ? '' : 'display:none', ENT_QUOTES, 'UTF-8');?>">(<?php echo htmlspecialchars($read['replies'], ENT_QUOTES, 'UTF-8');?>)</span></a>
				<?php  } 
  if ($read['pid']) { ?>
				<a rel="nofollow" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=like&c=mylike&a=doLike&typeid=2&fromid=', rawurlencode($read['pid']); ?>" data-tid="<?php echo htmlspecialchars($tid, ENT_QUOTES, 'UTF-8');?>" data-pid="<?php echo htmlspecialchars($read['pid'], ENT_QUOTES, 'UTF-8');?>" data-fid="<?php echo htmlspecialchars($fid, ENT_QUOTES, 'UTF-8');?>" class="a_like J_like_btn J_qlogin_trigger">喜欢</a><span style="<?php echo htmlspecialchars($read['like_count'] ? '' : 'display:none', ENT_QUOTES, 'UTF-8');?>">(<a class="J_like_user_btn a_like_num" data-pid="<?php echo htmlspecialchars($read['pid'], ENT_QUOTES, 'UTF-8');?>" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=like&c=like&a=getLast&typeid=2&fromid=', rawurlencode($read['pid']); ?>"><?php echo htmlspecialchars($read['like_count'], ENT_QUOTES, 'UTF-8');?></a>)</span>
				<?php  } 

PwHook::display(array($threadDisplay, "runDo"), array('createHtmlForThreadButton',$read), "", $__viewer);
?>
			</div>
			<div style="display:none;" class="J_reply_wrap" id="J_reply_wrap_<?php echo htmlspecialchars($read['pid'], ENT_QUOTES, 'UTF-8');
 echo htmlspecialchars(empty($read['istopped']) ? '' : '_topped', ENT_QUOTES, 'UTF-8');?>"><div class="pop_loading"></div></div>
		</td>
	</tr>
</table>
</div>
<?php  if ($read['lou'] == 0) { 
  } 
  } ?>
				<!--上一主题下一主题-->
				<!--div class="floor_page">
					<a rel="nofollow" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=read&a=next&tid=', rawurlencode($tid); ?>" class="next" title="下一主题">下一主题</a>
					<a rel="nofollow" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=read&a=pre&tid=', rawurlencode($tid); ?>" class="pre" title="上一主题">上一主题</a>
				</div-->
				<?php $__tplPageCount=(int)$count;
$__tplPagePer=(int)$perpage;
$__tplPageTotal=(int)$totalpage;
$__tplPageCurrent=(int)$page;
if($__tplPageCount > 0 && $__tplPagePer > 0){
$__tmp = ceil($__tplPageCount / $__tplPagePer);
($__tplPageTotal !== 0 &&  $__tplPageTotal < $__tmp) || $__tplPageTotal = $__tmp;}
$__tplPageCurrent > $__tplPageTotal && $__tplPageCurrent = $__tplPageTotal;
if ($__tplPageTotal > 1) {
 
$_page_min = max(1, $__tplPageCurrent-1);
$_page_max = min($__tplPageTotal, $__tplPageCurrent+1);
?>
<div class="floor_page">
<?php  if ($__tplPageCurrent > $_page_min) { 
$_page_i = $__tplPageCurrent-1;
?>
<a href="<?php echo Wekit::app()->baseUrl,'/','read.php?tid=', rawurlencode($tid),'&fid=', rawurlencode($fid),'&page=', rawurlencode($_page_i); 
 echo htmlspecialchars($urlargs ? '&' . http_build_query($urlargs) : '', ENT_QUOTES, 'UTF-8');?>" class="pre" title="上一页">上一页</a>
<?php  } else { ?>
<span class="pre">上一页</span>
<?php  } 
  if ($__tplPageCurrent < $_page_max) {
$_page_i = $__tplPageCurrent+1;
?>
<a href="<?php echo Wekit::app()->baseUrl,'/','read.php?tid=', rawurlencode($tid),'&fid=', rawurlencode($fid),'&page=', rawurlencode($_page_i); 
 echo htmlspecialchars($urlargs ? '&' . http_build_query($urlargs) : '', ENT_QUOTES, 'UTF-8');?>" class="next" title="下一页">下一页</a>
<?php  } else { ?>
<span class="next">下一页</span>
<?php  } ?>
</div> 
<?php } ?>
				<div class="floor">
					<table width="100%" style="table-layout:fixed;">
						<tr>
							<td class="floor_left_none">
							</td>
							<td>
								<a rel="nofollow" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=post&fid=', rawurlencode($pwforum->fid); ?>" id="J_read_post_btn" class="btn_post<?php echo htmlspecialchars($postNeedLogin, ENT_QUOTES, 'UTF-8');?>">发帖</a>
								<!-- 锁定时间 -->
								<?php  if($showReply){ ?>
								<a rel="nofollow" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=post&a=reply&tid=', rawurlencode($tid); ?>" data-referer="true" class="btn_replay<?php echo htmlspecialchars($replyNeedLogin, ENT_QUOTES, 'UTF-8');?>">回复</a>
								<?php  } ?>
								<div class="J_page_wrap" data-key="true">
								<div class="pages" style="margin-right:3px;"><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=thread&fid=', rawurlencode($pwforum->fid),'&page=', rawurlencode($fpage); ?>" class="pages_pre" rel="nofollow">&laquo; 返回列表</a></div>
								<?php $__tplPageCount=(int)$count;
$__tplPagePer=(int)$perpage;
$__tplPageTotal=(int)$totalpage;
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
	<a href="<?php echo Wekit::app()->baseUrl,'/','read.php?tid=', rawurlencode($tid),'&fid=', rawurlencode($fid),'&page=', rawurlencode($_page_i); 
 echo htmlspecialchars($urlargs ? '&' . http_build_query($urlargs) : '', ENT_QUOTES, 'UTF-8');?>" class="pages_pre J_pages_pre">&laquo;&nbsp;上一页</a>
	<?php  if ($_page_min > 1) { 
		$_page_i = 1;		
	?>
	<a href="<?php echo Wekit::app()->baseUrl,'/','read.php?tid=', rawurlencode($tid),'&fid=', rawurlencode($fid),'&page=', rawurlencode($_page_i); 
 echo htmlspecialchars($urlargs ? '&' . http_build_query($urlargs) : '', ENT_QUOTES, 'UTF-8');?>">1...</a>
	<?php  } 
  for ($_page_i = $_page_min; $_page_i < $__tplPageCurrent; $_page_i++) { 
	?>
	<a href="<?php echo Wekit::app()->baseUrl,'/','read.php?tid=', rawurlencode($tid),'&fid=', rawurlencode($fid),'&page=', rawurlencode($_page_i); 
 echo htmlspecialchars($urlargs ? '&' . http_build_query($urlargs) : '', ENT_QUOTES, 'UTF-8');?>"><?php echo htmlspecialchars($_page_i, ENT_QUOTES, 'UTF-8');?></a>
	<?php  } 
  } ?>
	<strong><?php echo htmlspecialchars($__tplPageCurrent, ENT_QUOTES, 'UTF-8');?></strong>
<?php  if ($__tplPageCurrent < $_page_max) { 
  for ($_page_i = $__tplPageCurrent+1; $_page_i <= $_page_max; $_page_i++) { 
	?>
	<a href="<?php echo Wekit::app()->baseUrl,'/','read.php?tid=', rawurlencode($tid),'&fid=', rawurlencode($fid),'&page=', rawurlencode($_page_i); 
 echo htmlspecialchars($urlargs ? '&' . http_build_query($urlargs) : '', ENT_QUOTES, 'UTF-8');?>"><?php echo htmlspecialchars($_page_i, ENT_QUOTES, 'UTF-8');?></a>
	<?php  } 
  if ($_page_max < $__tplPageTotal) { 
		$_page_i = $__tplPageTotal;
	?>
	<a href="<?php echo Wekit::app()->baseUrl,'/','read.php?tid=', rawurlencode($tid),'&fid=', rawurlencode($fid),'&page=', rawurlencode($_page_i); 
 echo htmlspecialchars($urlargs ? '&' . http_build_query($urlargs) : '', ENT_QUOTES, 'UTF-8');?>">...<?php echo htmlspecialchars($__tplPageTotal, ENT_QUOTES, 'UTF-8');?></a>
	<?php  }
		$_page_i = $__tplPageCurrent+1;
	?>
	<a href="<?php echo Wekit::app()->baseUrl,'/','read.php?tid=', rawurlencode($tid),'&fid=', rawurlencode($fid),'&page=', rawurlencode($_page_i); 
 echo htmlspecialchars($urlargs ? '&' . http_build_query($urlargs) : '', ENT_QUOTES, 'UTF-8');?>" class="pages_next J_pages_next">下一页&nbsp;&raquo;</a>
<?php  } ?>
</div>
<?php } ?>
								
								</div>
							</td>
						</tr>
					</table>
				</div>
				<div style="display:none;" class="btn_post_menu" id="J_read_post_types">
					<ul>
						<?php  foreach ($pwforum->getThreadType($loginUser) as $key => $value) { 
  $_urladd_ = ($key != 'default') ? ('&special=' . $key) : ''; ?>
						<li><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=post&fid=', rawurlencode($pwforum->fid); 
 echo htmlspecialchars($_urladd_, ENT_QUOTES, 'UTF-8');?>" data-referer="true" class="<?php echo htmlspecialchars(trim($postNeedLogin), ENT_QUOTES, 'UTF-8');?>"><?php echo htmlspecialchars($value[0], ENT_QUOTES, 'UTF-8');?></a></li>
						<?php  } ?>
					</ul>
				</div>
				<pw-tpl id="read_bottom"/>
				<div id="cloudwind_read_bottom"></div>
			</div>
			<?php  if ($operateReply) { ?>
			<div id="J_post_manage_main" class="core_pop_wrap J_post_manage_pop" style="display:none;position:fixed;_position:absolute;">
				<div class="core_pop">
					<div style="width:250px;">
						<div class="pop_top"><a href="#" id="J_post_manage_close" class="pop_close">关闭</a><strong>帖子操作</strong>(已选中&nbsp;<span class="red" id="J_post_checked_count">1</span>&nbsp;篇&nbsp;&nbsp;<a href="" class="s4" id="J_post_manage_checkall" data-type="check">全选</a>)</div>
						<div class="pop_cont">
							<div class="pop_operat_list">
								<ul class="cc J_post_manage_col" data-role="read">
									<?php  if ($operateReply['delete']){ ?><li><a data-type="delete" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=masingle&a=delete'; ?>">删除</a></li><?php  } 
  if ($operateReply['unite']){ ?><li><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=masingle&a=unite'; ?>">合并</a></li><?php  } 
  if ($operateReply['split']){ ?><li><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=masingle&a=split'; ?>">拆分</a></li><?php  } 
  if ($operateReply['shield']){ ?><li><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=masingle&a=shield'; ?>">屏蔽</a></li><?php  } 
  if ($operateReply['remind']){ ?><li><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=masingle&a=remind'; ?>">提醒</a></li><?php  } ?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php  } ?>
		</div>
	</div>
	<!--.main-wrap,#main End-->
<div class="tac">
 <br />
 
</div>
<div class="footer_wrap">
	<div class="footer">
		 
		
		<p>Powered by <a href="http://www.diancanyo.com/" target="_blank" rel="nofollow">分享哟信息科技有限公司</a> &copy;2010-2103 所有权利保留</p>
	</div>
	 
	 
	 
	<div id="cloudwind_common_bottom"></div>
	<?php
PwHook::display(array(PwSimpleHook::getInstance("footer"), "runDo"), array(), "", $__viewer);
?>
</div>

<!--返回顶部-->
<a href="#" rel="nofollow" role="button" id="back_top" tabindex="-1">返回顶部</a>

</div>

<textarea id="J_like_user_ta" class="dn">
	<div id="" class="core_pop_wrap" style="position:absolute;">
		<div class="core_pop">
			<div class="floot_like_pop">
				<div class="pop_top"><a href="#" class="pop_close J_like_user_close">关闭</a>最新喜欢</div>
				<div class="pop_cont">
					<ul class="cc J_like_user_list"></ul>
				</div>
			</div>
		</div>
	</div>
</textarea>
<?php  if(!$is_design) { ?>
<script>
var TID = '<?php echo htmlspecialchars($tid, ENT_QUOTES, 'UTF-8');?>';
Wind.use('jquery', 'global', 'dialog', function(){

	<?php  if ($loginUser->isExists()) { ?>
	//已登录

	//管理操作
	Wind.js(GV.JS_ROOT +'pages/bbs/threadForumManage.js?v='+ GV.JS_VERSION);

	$('a.J_read_mark').on('click', function(e) {
		e.preventDefault();
		var $this = $(this);
		$.post(this.href, function(data) {
			Wind.Util.resultTip({
				error : (data.state == 'success' ? false : true),
				elem : $this,
				follow : true,
				msg : data.message[0]
			});
		}, 'json');
	});

	//加关注
	$('a.J_read_follow').on('click', function(e) {
		e.preventDefault();
		var $this = $(this);
		Wind.Util.ajaxMaskShow();
		$.getJSON( this.href, function(data) {
			Wind.Util.ajaxMaskRemove();
			if(data.state == 'success') {
				$this.removeClass('follow').addClass('unfollow').text('已关注');
				Wind.Util.resultTip({
					msg : data.message[0],
					follow : $this
				});

				$('#J_user_card_'+ $this.data('uid')).remove();
			}else if( data.state == 'fail' ) {
				Wind.Util.resultTip({
					error : true,
					msg : data.message[0],
					follow : $this
				});
			}
		});
	});

		<?php  if ($operateReply['toppedreply'] && $read['lou']){ ?>
	/*
	 * //帖内置顶
	*/
	(function(){
		var top_lock = false;
		$('a.J_post_top').on('click', function(e){
			e.preventDefault();
			var $this = $(this),
				topped = $this.data('topped');

			if(top_lock) {
				return false;
			}
			top_lock = true;
			$.post(this.href, function(data){
				if(data.state == 'success') {
					Wind.Util.resultTip({
						follow : $this,
						msg : data.message[0],
						callback : function(){
							location.reload();
						}
					});
				}else if(data.state == 'fail') {
					Wind.Util.resultTip({
						error : true,
						follow : $this,
						msg : data.message[0]
					});
					top_lock = false;
				}
			}, 'json');
		})
	})();
		<?php  } 
  } ?>

	//无uid的个人中心地址
	//var U_CENTER_NOUID = '<?php echo Wekit::app()->baseUrl,'/','index.php?m=space'; ?>';

	// 阅读页的常用交互
	Wind.js(GV.JS_ROOT +'pages/bbs/read.js?v='+ GV.JS_VERSION);

	// 快速回复&查看回复
	Wind.js(GV.JS_ROOT +'pages/bbs/readReply.js?v='+ GV.JS_VERSION);

	// 投票帖
	if($('ul.J_vote_item, a.J_vote_list_show').length) {
		Wind.js(GV.JS_ROOT +'pages/bbs/readVote.js?v='+ GV.JS_VERSION);
	}

	// 购买记录
	if($('#J_content_sell, #J_attach_buy, a.J_buy_record, .J_attach_post_del, a.J_attach_post_buy').length) {
		Wind.js(GV.JS_ROOT + 'pages/bbs/buyRecords.js?v=' + GV.JS_VERSION);
	}

	// 话题
	if($('#J_read_tag_wrap').length) {
		Wind.js(GV.JS_ROOT + 'pages/bbs/readTag.js?v=' + GV.JS_VERSION);
	}

	//媒体播放
	if( $('div.J_audio,div.J_video').length ) {
		Wind.js(window.GV.JS_ROOT + 'pages/bbs/media_play.js?v=' + GV.JS_VERSION);
	}


<?php  if(false != Wekit::C('bbs', 'read.image_lazy')) { ?>
	// 图片懒加载
	Wind.js(GV.JS_ROOT + 'util_libs/lazyload.js?v=' + GV.JS_VERSION, function(){
		$("img.J_lazy").lazyload({
	        effect: 'fadeIn',
	        error: function(settings){
	        	$(this).attr("src", '#').removeClass("J_lazy")
	        }
	    });
	});
<?php  } ?>
});
</script>
<?php  } 

PwHook::display(array($threadDisplay, "runDo"), array('runJs'), "", $__viewer);
?>

</body>
</html>