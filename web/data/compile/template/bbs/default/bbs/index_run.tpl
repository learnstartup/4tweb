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
<?php  if ($operateThread) { ?>
<link href="<?php echo Wekit::app()->themes.'/site/default/css'.Wekit::getGlobal('theme','debug'); ?>/management.css?v=<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>" rel="stylesheet" />
<?php }?>
</head>
<body>
<style type="text/css">
</style><?php  
    			$__design_pageid = 6;
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
		
		<div class="bread_crumb" id="bread_crumb">
			<a href="<?php echo Wekit::app()->baseUrl; ?>" class="home" title="<?php echo Wekit::C("site", "info.name"); ?>">首页</a><em>&gt;</em><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs'; ?>">本站新帖</a>
		</div>
		
		<div id="cloudwind_forum_top"></div>
		<div class="main cc">
			<div class="main_body">
				<div class="main_content cc">
					 
					 
					<div class="box_wrap thread_page J_check_wrap">
						<nav>
							<div class="content_nav" id="hashpos_ttype">
								<div class="content_filter">
									<a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&order=postdate'; ?>" class="<?php echo htmlspecialchars(Pw::isCurrent($order == 'postdate'), ENT_QUOTES, 'UTF-8');?>">最新发帖</a><span>|</span><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs'; ?>" class="<?php echo htmlspecialchars(Pw::isCurrent($order != 'postdate'), ENT_QUOTES, 'UTF-8');?>">最后回复</a>
								</div>
								<ul>
									<li class="current"><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs'; ?>">本站新帖</a></li>
									<?php  if ($loginUser->isExists()) { ?><li><a rel="nofollow" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=forum&a=my'; ?>">我的版块</a></li><?php  } ?>
								</ul>
							</div>
						</nav>
						<!--公告-->
						<?php $__tpl_data = call_user_func_array(
								array(Wekit::load("SRV:announce.srv.PwAnnounceService"), 
								"getAnnounceForBbsScroll"), 
								array(array())); 
  if($__tpl_data){ ?>
<div class="core_announce_wrap">
	<div class="core_announce">
		<ul class="J_slide_auto cc">
		<?php  foreach($__tpl_data as $key => $value){ 
		 if($value['typeid']){
		 	$url = $value['url']; 
		 	$showTarget = 'target=_blank';
		 }else{
		 	$url = WindUrlHelper::createUrl('announce/index/run',array('aid'=>$key)); 
		 	$showTarget='target=_self';
		 }
		 ?>
		 <li><a href="<?php echo $url;?>" <?php echo htmlspecialchars($showTarget, ENT_QUOTES, 'UTF-8');?>><?php echo htmlspecialchars($value['subject'], ENT_QUOTES, 'UTF-8');?></a><span><?php echo htmlspecialchars($value['start_date'], ENT_QUOTES, 'UTF-8');?></span></li>
		 <?php 
		 } ?>
		</ul>
	</div>
</div>
<?php  } 
  ?>
						<!--公告结束-->
						<?php  if ($threaddb) { ?>
						<div class="thread_posts_list">
							<table width="100%" id="J_posts_list" summary="帖子列表">
								<?php  foreach ($threaddb as $key => $value) { ?>
								<tr>
									<td class="author"><a class="J_user_card_show" data-uid="<?php echo htmlspecialchars($value['created_userid'], ENT_QUOTES, 'UTF-8');?>" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=space&uid=', rawurlencode($value['created_userid']); ?>"><img src="<?php echo htmlspecialchars(Pw::getAvatar($value['created_userid'], 'small'), ENT_QUOTES, 'UTF-8');?>" onerror="this.onerror=null;this.src='<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','images'), ENT_QUOTES, 'UTF-8');?>/face/face_small.jpg'" width="45" height="45" alt="<?php echo htmlspecialchars($value['created_username'], ENT_QUOTES, 'UTF-8');?>" /></a></td>
									<td class="subject">
										<p class="title">
											<?php  if ($operateThread) { ?>
											<input class="J_check" name="" type="checkbox" value="<?php echo htmlspecialchars($value['tid'], ENT_QUOTES, 'UTF-8');?>" />
											<?php  } ?>
											<span class="posts_icon"><i class="icon_<?php echo htmlspecialchars($value['icon'], ENT_QUOTES, 'UTF-8');?>" title="<?php echo htmlspecialchars($icon[$value['icon']], ENT_QUOTES, 'UTF-8');?>"></i></span>
											<?php  if ($forums[$value['fid']]) { ?>
											<a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=thread&fid=', rawurlencode($value['fid']); ?>" class="st">[<?php echo $forums[$value['fid']]['name'];?>]</a>
											<?php  } ?>
											<a href="<?php echo Wekit::app()->baseUrl,'/','read.php?tid=', rawurlencode($value['tid']),'&fid=', rawurlencode($value['fid']); ?>" class="st" style="<?php echo htmlspecialchars($value['highlight_style'], ENT_QUOTES, 'UTF-8');?>" title="<?php echo htmlspecialchars($value['subject'], ENT_QUOTES, 'UTF-8');?>"><?php echo htmlspecialchars(Pw::substrs($value['subject'],$numofthreadtitle), ENT_QUOTES, 'UTF-8');?></a>
											<?php
PwHook::display(array($threadList, "runDo"), array('createHtmlAfterSubject',$value), "", $__viewer);

  if ($value['ifupload']) { ?><span class="posts_icon"><i class="icon_<?php echo htmlspecialchars($uploadIcon[$value['ifupload']], ENT_QUOTES, 'UTF-8');?>" title="<?php echo htmlspecialchars($icon[$uploadIcon[$value['ifupload']]], ENT_QUOTES, 'UTF-8');?>"></i></span><?php  } ?>
										</p>
										<p class="info">
											楼主：<a class="J_user_card_show" data-uid="<?php echo htmlspecialchars($value['created_userid'], ENT_QUOTES, 'UTF-8');?>" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=space&uid=', rawurlencode($value['created_userid']); ?>"><?php echo htmlspecialchars($value['created_username'], ENT_QUOTES, 'UTF-8');?></a><span><?php  echo Pw::time2str($value['created_time'], 'Y-m-d');?></span>
											最后回复：<a class="J_user_card_show" data-uid="<?php echo htmlspecialchars($value['lastpost_userid'], ENT_QUOTES, 'UTF-8');?>" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=space&uid=', rawurlencode($value['lastpost_userid']); ?>"><?php echo htmlspecialchars($value['lastpost_username'], ENT_QUOTES, 'UTF-8');?></a><span><a href="<?php echo Wekit::app()->baseUrl,'/','read.php?tid=', rawurlencode($value['tid']),'&fid=', rawurlencode($value['fid']),'&page=e'; ?>#a" rel="nofollow" aria-label="最后回复时间"><?php  echo Pw::time2str($value['lastpost_time'], 'm-d H:i');?></a></span>
										</p>
									</td>
									<td class="num">
										<span>回复<em><?php echo htmlspecialchars($value['replies'], ENT_QUOTES, 'UTF-8');?></em></span>
										<span>浏览<em><?php echo htmlspecialchars($value['hits'], ENT_QUOTES, 'UTF-8');?></em></span>
									</td>
								</tr>
								<?php  } ?>
							</table>
						</div>
							<?php  if ($operateThread) { ?>
							<div class="management J_post_manage_col" data-role="list">
								<label class="mr10"><input class="J_check_all" type="checkbox">全选</label>
								<?php  if ($operateThread['topped']){ ?><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=manage&a=topped'; ?>">置顶</a><?php  } 
  if ($operateThread['digest']){ ?><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=manage&a=digest'; ?>">精华</a><?php  } 
  if ($operateThread['highlight']){ ?><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=manage&a=highlight'; ?>">加亮</a><?php  } 
  if ($operateThread['up']){ ?><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=manage&a=up'; ?>">提前</a><?php  } 
  if ($operateThread['type']){ ?><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=manage&a=type'; ?>">分类</a><?php  } 
  if ($operateThread['move']){ ?><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=manage&a=move'; ?>">移动</a><?php  } 
  if ($operateThread['copy']){ ?><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=manage&a=copy'; ?>">复制</a><?php  } 
  if ($operateThread['unite']){ ?><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=manage&a=unite'; ?>">合并</a><?php  } 
  if ($operateThread['lock']){ ?><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=manage&a=lock'; ?>">锁定</a><?php  } 
  if ($operateThread['down']){ ?><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=manage&a=down'; ?>">压帖</a><?php  } 
  if ($operateThread['delete']){ ?><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=manage&a=delete'; ?>">删除</a><?php  } ?>
							</div>
							<?php  } 
  } else { ?>
						<div class="not_content">
							啊哦，本站暂没有任何内容哦！
						</div>
						<?php  } ?>
					</div>
					<div class="cc mb20">
						<div class="J_page_wrap" data-key="true">
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
	<a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&page=', rawurlencode($_page_i); 
 echo htmlspecialchars($urlargs ? '&' . http_build_query($urlargs) : '', ENT_QUOTES, 'UTF-8');?>" class="pages_pre J_pages_pre">&laquo;&nbsp;上一页</a>
	<?php  if ($_page_min > 1) { 
		$_page_i = 1;		
	?>
	<a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&page=', rawurlencode($_page_i); 
 echo htmlspecialchars($urlargs ? '&' . http_build_query($urlargs) : '', ENT_QUOTES, 'UTF-8');?>">1...</a>
	<?php  } 
  for ($_page_i = $_page_min; $_page_i < $__tplPageCurrent; $_page_i++) { 
	?>
	<a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&page=', rawurlencode($_page_i); 
 echo htmlspecialchars($urlargs ? '&' . http_build_query($urlargs) : '', ENT_QUOTES, 'UTF-8');?>"><?php echo htmlspecialchars($_page_i, ENT_QUOTES, 'UTF-8');?></a>
	<?php  } 
  } ?>
	<strong><?php echo htmlspecialchars($__tplPageCurrent, ENT_QUOTES, 'UTF-8');?></strong>
<?php  if ($__tplPageCurrent < $_page_max) { 
  for ($_page_i = $__tplPageCurrent+1; $_page_i <= $_page_max; $_page_i++) { 
	?>
	<a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&page=', rawurlencode($_page_i); 
 echo htmlspecialchars($urlargs ? '&' . http_build_query($urlargs) : '', ENT_QUOTES, 'UTF-8');?>"><?php echo htmlspecialchars($_page_i, ENT_QUOTES, 'UTF-8');?></a>
	<?php  } 
  if ($_page_max < $__tplPageTotal) { 
		$_page_i = $__tplPageTotal;
	?>
	<a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&page=', rawurlencode($_page_i); 
 echo htmlspecialchars($urlargs ? '&' . http_build_query($urlargs) : '', ENT_QUOTES, 'UTF-8');?>">...<?php echo htmlspecialchars($__tplPageTotal, ENT_QUOTES, 'UTF-8');?></a>
	<?php  }
		$_page_i = $__tplPageCurrent+1;
	?>
	<a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&page=', rawurlencode($_page_i); 
 echo htmlspecialchars($urlargs ? '&' . http_build_query($urlargs) : '', ENT_QUOTES, 'UTF-8');?>" class="pages_next J_pages_next">下一页&nbsp;&raquo;</a>
<?php  } ?>
</div>
<?php } ?>
						</div>
					</div>
					
					<?php  if ($operateThread) { ?>
					<div id="J_post_manage_main" class="core_pop_wrap J_post_manage_pop" style="display:none;">
						<div class="core_pop">
							<div style="width:415px;">
								<div class="pop_top"><a href="#" id="J_post_manage_close" class="pop_close">关闭</a><strong>帖子操作</strong>(已选中&nbsp;<span class="red" id="J_post_checked_count">1</span>&nbsp;篇&nbsp;&nbsp;<a href="" class="s4" id="J_post_manage_checkall" data-type="check">全选</a>)</div>
								<div class="pop_cont">
									<div class="pop_operat_list">
										<ul class="cc">
											<?php  if ($operateThread['topped']){ ?><li><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=manage&a=topped'; ?>">置顶</a></li><?php  } 
  if ($operateThread['digest']){ ?><li><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=manage&a=digest'; ?>">精华</a></li><?php  } 
  if ($operateThread['highlight']){ ?><li><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=manage&a=highlight'; ?>">加亮</a></li><?php  } 
  if ($operateThread['up']){ ?><li><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=manage&a=up'; ?>">提前</a></li><?php  } 
  if ($operateThread['type']){ ?><li><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=manage&a=type'; ?>">分类</a></li><?php  } 
  if ($operateThread['move']){ ?><li><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=manage&a=move'; ?>">移动</a></li><?php  } 
  if ($operateThread['copy']){ ?><li><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=manage&a=copy'; ?>">复制</a></li><?php  } 
  if ($operateThread['unite']){ ?><li><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=manage&a=unite'; ?>">合并</a></li><?php  } 
  if ($operateThread['lock']){ ?><li><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=manage&a=lock'; ?>">锁定</a></li><?php  } 
  if ($operateThread['down']){ ?><li><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=manage&a=down'; ?>">压帖</a></li><?php  } 
  if ($operateThread['delete']){ ?><li><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=manage&a=delete'; ?>">删除</a></li><?php  } ?>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php  } ?>
					 
				</div>
			</div>
			<div class="main_sidebar">
				<?php  if (!$loginUser->isExists()) { 
  Wind::import('APPS:u.service.helper.PwUserHelper'); 
  $_loginWay = PwUserHelper::getLoginMessage(); ?>
	<div class="box_wrap sidebar_login">
		<form id="J_login_form" action="<?php echo Wekit::app()->baseUrl,'/','index.php?m=u&c=login&a=dologin'; ?>" method="post">
		<dl>
			<dt id="J_sidebar_login_dt">
				<label for="J_username">用户名</label><input required type="text" class="input" id="J_username" name="username" placeholder="<?php echo htmlspecialchars($_loginWay, ENT_QUOTES, 'UTF-8');?>">
				<label for="J_password">密　码</label><input required type="password" class="input" id="J_password" name="password" placeholder="密码">
			</dt>
			<dd class="associate"><a class="sendpwd" rel="nofollow" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=u&c=findPwd'; ?>">找回密码</a><label for="head_checkbox" title="下次自动登录"><input type="checkbox" id="head_checkbox" name="cktime" value="31536000">自动登录</label></dd>
			<dd class="operate"><button type="submit" id="J_sidebar_login" class="btn btn_big btn_submit">登录</button><a class="btn btn_big btn_error" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=u&c=register'; ?>" rel="nofollow">立即注册</a></dd>
		</dl>
		<input type="hidden" name="csrf_token" value="<?php echo WindSecurity::escapeHTML(Wind::getComponent('windToken')->saveToken('csrf_token')); ?>"/></form>
	</div>
<?php  } else { 
  $_group = $loginUser->getGroupInfo(); ?>
	<div class="box_wrap user_info">
		<dl class="cc">
			<dt id="J_ava_ie6">
				<a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=space&uid=', rawurlencode($loginUser->uid); ?>"><img class="J_avatar" src="<?php echo htmlspecialchars(Pw::getAvatar($loginUser->uid), ENT_QUOTES, 'UTF-8');?>" data-type="middle" width="72" height="72" alt="<?php echo htmlspecialchars($loginUser->username, ENT_QUOTES, 'UTF-8');?>" /></a>
				<a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=profile&c=avatar&_left=avatar'; ?>"><b></b><span>修改头像</span></a>
			</dt>
			<dd>
				<div class="name"><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=space&uid=', rawurlencode($loginUser->uid); ?>" class="username"><?php echo htmlspecialchars($loginUser->username, ENT_QUOTES, 'UTF-8');?><i></i></a></div>
				<div class="level"><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=profile&c=right&_left=right'; ?>"><?php echo htmlspecialchars($_group['name'], ENT_QUOTES, 'UTF-8');?></a></div>
				<div class="level_img">
					<img src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','images'), ENT_QUOTES, 'UTF-8');?>/level/<?php echo htmlspecialchars($_group['image'], ENT_QUOTES, 'UTF-8');?>" alt="<?php echo htmlspecialchars($_group['name'], ENT_QUOTES, 'UTF-8');?>" />
				</div>
			</dd>
		</dl>
		<div class="num">
			<ul class="cc">
				<li><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=my&c=follow'; ?>"><span><?php echo htmlspecialchars($loginUser->info['follows'], ENT_QUOTES, 'UTF-8');?></span><em>关注</em></a></li>
				<li><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=my&c=fans'; ?>"><span><?php echo htmlspecialchars($loginUser->info['fans'], ENT_QUOTES, 'UTF-8');?></span><em>粉丝</em></a></li>
				<li class="tail"><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=my&c=article'; ?>"><span><?php echo htmlspecialchars($loginUser->info['postnum'], ENT_QUOTES, 'UTF-8');?></span><em>帖子</em></a></li>
			</ul>
		</div>
	<?php  if (Wekit::C('site','medal.isopen')): ?>
		<div class="medal_widget" id="J_medal_widget">
			<a href="javascript:;" class="next next_disabled J_lazyslide_next" title="下一组"><em></em></a>
			<a href="javascript:;" class="pre pre_disabled J_lazyslide_prev" title="上一组"><em></em></a>
			<div class="medal_list_wrap">
			<ul id="J_medal_widget_ul" class="cc J_lazyslide_list" style="width:900px;">
			<?php  
				$J_medals = Wekit::load('medal.srv.PwMedalCache')->getMyAndAutoMedal($loginUser->uid);
				$_medals = array_slice($J_medals, 0, 6, true);
				foreach ($_medals as $medal):
			
  if($medal['award_status'] !=4): ?>
					<li class="doing"><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=medal'; ?>"><img src="<?php echo htmlspecialchars($medal['icon'], ENT_QUOTES, 'UTF-8');?>" width="30" height="30" title="<?php echo htmlspecialchars($medal['name'], ENT_QUOTES, 'UTF-8');?>" alt="<?php echo htmlspecialchars($medal['name'], ENT_QUOTES, 'UTF-8');?>" /></a></li>
				<?php  else: ?>
					<li><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=medal'; ?>"><img src="<?php echo htmlspecialchars($medal['icon'], ENT_QUOTES, 'UTF-8');?>" width="30" height="30" title="<?php echo htmlspecialchars($medal['name'], ENT_QUOTES, 'UTF-8');?>" alt="<?php echo htmlspecialchars($medal['name'], ENT_QUOTES, 'UTF-8');?>" /></a></li>
				<?php  endif; 
  endforeach; ?>
			</ul>
			<textarea id="J_sidebar_medal_ta" style="display:none">
				<?php  	foreach ($J_medals as $medal): 
  if($medal['award_status'] !=4): ?><li class="doing"><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=medal'; ?>"><img src="<?php echo htmlspecialchars($medal['icon'], ENT_QUOTES, 'UTF-8');?>" width="30" height="30" title="<?php echo htmlspecialchars($medal['name'], ENT_QUOTES, 'UTF-8');?>" alt="<?php echo htmlspecialchars($medal['name'], ENT_QUOTES, 'UTF-8');?>" /></a></li><?php  else: ?><li><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=medal'; ?>"><img src="<?php echo htmlspecialchars($medal['icon'], ENT_QUOTES, 'UTF-8');?>" width="30" height="30" title="<?php echo htmlspecialchars($medal['name'], ENT_QUOTES, 'UTF-8');?>" alt="<?php echo htmlspecialchars($medal['name'], ENT_QUOTES, 'UTF-8');?>" /></a></li><?php  endif; 
  endforeach; ?></textarea>
			</div>
		</div>
	<?php  endif; 
  
	$punchService = Wekit::load('space.srv.PwPunchService');
	list($punchOpen,$punchFriendOpen) = $punchService->getPunchConfig();
	if ($punchOpen) {
		list($punchStatus,$punchButton,$punchData) = $punchService->getPunch();
		$punchStatus = $punchStatus ? '' : 'punch_widget_disabled';
		list($monthDay,$weekDay) = $punchService->formatWeekDay(Pw::getTime());
	 ?>
	<div class="cc punch_widget_wrap">
		<div id="J_punch_main_tip" class="fl dn">
		<?php  if ($punchData) { ?>
			<div class="tips">
				<div class="core_arrow_top"><em></em><span></span></div>
				<?php echo htmlspecialchars($punchData['username'], ENT_QUOTES, 'UTF-8');?>已帮你领取<span class="red"><?php echo htmlspecialchars($punchData['cNum'], ENT_QUOTES, 'UTF-8');?></span><?php echo htmlspecialchars($punchData['cUnit'], ENT_QUOTES, 'UTF-8');
 echo htmlspecialchars($punchData['cType'], ENT_QUOTES, 'UTF-8');?>
			</div>
		<?php  } ?>
		</div>
		<div class="punch_widget <?php echo htmlspecialchars($punchStatus, ENT_QUOTES, 'UTF-8');?>" id="J_punch_widget">
			<div class="date"><?php echo htmlspecialchars($monthDay, ENT_QUOTES, 'UTF-8');?><span><?php echo htmlspecialchars($weekDay, ENT_QUOTES, 'UTF-8');?></span></div>
			<div class="cont"><a data-punchurl="<?php echo Wekit::app()->baseUrl,'/','index.php?m=space&c=punch&a=punchtip'; ?>" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=space&c=punch&a=punch'; ?>" id="J_punch_mine" tabindex="-1" target="_blank"><?php echo htmlspecialchars($punchButton, ENT_QUOTES, 'UTF-8');?></a></div>
			<?php  if ($punchFriendOpen) { ?>
			<a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=space&c=punch&a=friend'; ?>" id="J_punch_friend" class="help_ta" tabindex="-1" target="_blank">帮Ta打卡</a>
			<?php  } ?>
		</div>
	</div>
<?php  } ?>
	</div>
<?php  } 
  if ($loginUser->info['join_forum']) { 
	Wind::import('APPS:bbs.controller.ForumController');
	$myJoinForum = ForumController::splitStringToArray($loginUser->info['join_forum']);
	$myJoinForumCount = count($myJoinForum);
	
?>
<div class="box_wrap my_forum_list"><!--切换样式 my_forum_list_cur -->
	<h2 class="box_title J_sidebar_box_toggle">我的版块<span class="num"><?php echo htmlspecialchars($myJoinForumCount, ENT_QUOTES, 'UTF-8');?></span></h2>
	<ul>
	<?php  foreach ($myJoinForum as $v => $k) { ?>
		<li><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=thread&fid=', rawurlencode($v); ?>"><?php echo htmlspecialchars($k, ENT_QUOTES, 'UTF-8');?></a></li>
	<?php  } ?>
	</ul>
</div>
<?php  } ?>
<!--advertisement id='Site.Sider.User' sys='1'/-->
 
		<?php 
			$forumdb = Wekit::load('forum.srv.PwForumService')->getCommonForumList();
			if ($pwforum instanceof PwForumBo) {
				$__currentCateId = $pwforum->getCateId();
				$__currentFid = $pwforum->fid;
				!isset($forumdb[0][$__currentCateId]) && $__currentCateId = key($forumdb[0]);
			} else {
				$__currentCateId = key($forumdb[0]);
				$__currentFid = 0;
			}
		?>
		<div class="box_wrap" aria-label="版块列表" role="tablist">
			<h2 class="box_title J_sidebar_box_toggle">版块列表</h2>
			<div class="forum_menu" >
			<?php  foreach ($forumdb[0] as $k => $cate) { 
  if ($forumdb[$cate['fid']]) { ?>
				<dl class="<?php echo htmlspecialchars(Pw::isCurrent($k == $__currentCateId), ENT_QUOTES, 'UTF-8');?>">
					<dt class="J_sidebar_forum_toggle"><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=cate&fid=', rawurlencode($cate['fid']); ?>"><?php echo htmlspecialchars(strip_tags($cate['name']), ENT_QUOTES, 'UTF-8');?></a></dt>
					<dd role="tabpanel">
						<?php  foreach ($forumdb[$cate['fid']] as $forums) { ?>
						<p><a class="<?php echo htmlspecialchars(Pw::isCurrent($forums['fid'] == $__currentFid), ENT_QUOTES, 'UTF-8');?>" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=thread&fid=', rawurlencode($forums['fid']); ?>"><?php echo htmlspecialchars(strip_tags($forums['name']), ENT_QUOTES, 'UTF-8');?></a></p>
						<?php  } ?>
					</dd>
				</dl>
				<?php  } 
  } ?>
			</div>
		</div>
<?php $__tpl_data = call_user_func_array(
								array(Wekit::load("SRV:tag.srv.PwTagService"), 
								"getHotTags"), 
								array('0','10')); 
  if($__tpl_data) {?>
<div class="box_wrap">
	<h2 class="box_title">热门话题</h2>
	<div class="tags_hot">
	<ul class="cc">
		<?php  foreach($__tpl_data as $k=>$v){ ?>
		<li><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=tag&a=view&name=', rawurlencode($v['tag_name']); ?>" class="title"><?php echo htmlspecialchars($v['tag_name'], ENT_QUOTES, 'UTF-8');?></a></li>
		<?php  } ?>
	</ul>
	</div>
</div>
 
<?php  } 
  
  
	if ($loginUser->info['recommend_friend']) {
		$pFriends = Wekit::load('attention.srv.PwAttentionRecommendFriendsService')->getRecommentUser($loginUser);
		if ($pFriends) {
		$otherFriends = array_slice($pFriends,3);
		$pFriends = array_slice($pFriends,0,3);
 ?>
<div class="box_wrap" id="J_friend_maybe">
	<h2 class="box_title J_sidebar_box_toggle">可能认识的人</h2>
	<div class="side_may_list" id="J_friend_maybe_list" data-url="<?php echo Wekit::app()->baseUrl,'/','index.php?m=my&c=follow&a=recommendfriend'; ?>">
	<?php 
		$i = 0;
		foreach($pFriends as $v){
			$pUid = $v['uid'];
			//if ($v['cnt'] < 1) continue;
			$class = ($i > 1) ? 'display:none;' : '';
			$class2 = ($i > 0) ? 'display:none;' : '';
			$load = ($i > 0) ? 'false' : 'true';
			$arrow = ($i == 0) ? '&uarr;' : '&darr;';
	 ?>
		<div class="J_friend_maybe_items">
			<dl>
				<dt><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=space&uid=', rawurlencode($pUid); ?>" class="J_user_card_show" data-uid="<?php echo htmlspecialchars($pUid, ENT_QUOTES, 'UTF-8');?>"><img class="J_avatar" src="<?php echo htmlspecialchars(Pw::getAvatar($pUid,'small'), ENT_QUOTES, 'UTF-8');?>" width="50" height="50" data-uid="<?php echo htmlspecialchars($pUid, ENT_QUOTES, 'UTF-8');?>" data-type="small" /></a></dt>
				<dd>
					<p class="title"><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=space&uid=', rawurlencode($pUid); ?>" class="J_user_card_show" data-uid="<?php echo htmlspecialchars($pUid, ENT_QUOTES, 'UTF-8');?>"><?php echo htmlspecialchars($v['username'], ENT_QUOTES, 'UTF-8');?></a></p>
					<p><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=my&c=follow&a=add&uid=', rawurlencode($pUid); ?>" class="core_follow J_friend_maybe_follow mr10" role="button" rel="nofollow">关注</a>
					<?php  if ($v['cnt']) { ?>
					<a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=my&c=follow&a=samefriend&uid=', rawurlencode($pUid); ?>" class="unmore J_friend_view" data-uid="<?php echo htmlspecialchars($pUid, ENT_QUOTES, 'UTF-8');?>"><?php echo htmlspecialchars($v['cnt'], ENT_QUOTES, 'UTF-8');?>个共同好友<?php echo $arrow;?></a>
					<?php  } ?>
					</p>
				</dd>
			</dl>
			<?php  if ($v['sameUser']) { ?>
			<div id="J_friend_related_<?php echo htmlspecialchars($pUid, ENT_QUOTES, 'UTF-8');?>" class="related J_friend_related" style="<?php echo htmlspecialchars($class2, ENT_QUOTES, 'UTF-8');?>" data-load="<?php echo htmlspecialchars($load, ENT_QUOTES, 'UTF-8');?>">
				
				<div class="menu_arrow"><em></em><span></span></div>
				<?php  
					$tmp = array();
					foreach($v['sameUser'] as $sk => $su){
						if (!trim($su)) continue;
						$tmp[] = sprintf('<a href="%s" class="J_user_card_show" data-uid="%d" target="_blank">%s</a>',WindUrlHelper::createUrl('space/index/run',array('uid'=>$sk)),$sk,$su);
					}
					$tmp = implode('、', $tmp);
				 ?>
				 您关注的人中： <?php echo $tmp;
  if($v['cnt'] > 3) {?>等<?php echo htmlspecialchars($v['cnt'], ENT_QUOTES, 'UTF-8');?>人<?php  } ?> 也关注了Ta
			</div>
			<?php  } ?>
		</div>
	<?php 
		$i++;
		}
	 ?>
		
	</div>
</div>
<?php  }} ?>
 
 
<!--design role="segment" id="linkdemo"/-->
			</div>
		</div>
		<div id="cloudwind_forum_bottom"></div>
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
<?php  if(!$is_design) { ?>
<script>
var FID = '<?php echo htmlspecialchars($pwforum->fid, ENT_QUOTES, 'UTF-8');?>';
Wind.use('jquery', 'global', function(){
<?php  if (!$threaddb) { ?>
	//无内容 发帖引导
	Wind.js(GV.JS_ROOT + 'pages/common/postGuide.js?v=' + GV.JS_VERSION);
<?php  } else { ?>
	if(GV.U_ID) {
		Wind.js(GV.JS_ROOT +'pages/bbs/threadForumManage.js?v=' + GV.JS_VERSION);
	}
<?php  } ?>
});
</script>
<?php  } ?>

</body>
</html>