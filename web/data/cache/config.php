<?php
  return array(
	'data' => array(
		'site' => array(
			'upgradestrategy' => array(
				'credit1' => '1',
				'credit2' => '1',
				'postnum' => '1',
			),
			'cookie.domain' => '',
			'cookie.path' => '',
			'debug' => '0',
			'info.name' => '点餐哟外卖平台',
			'managereasons' => '问题已收集，谢谢反馈！
建议已收集，谢谢反馈！
已关注，谢谢反馈！
广告帖
恶意灌水
非法内容
与版规不符
重复发帖
------------------------------------------------
优秀文章
原创内容',
			'onlinetime' => '30',
			'punch.friend.open' => '1',
			'punch.friend.reward' => array(
				'friendNum' => '3',
				'rewardMeNum' => '1',
				'rewardNum' => '1',
			),
			'punch.open' => '1',
			'punch.reward' => array(
				'type' => '1',
				'min' => '1',
				'max' => '5',
				'step' => '1',
			),
			'refreshtime' => '0',
			'time.cv' => '0',
			'time.timezone' => '8',
			'visit.message' => '站点升级中。。。',
			'info.notice' => '',
			'task.isOpen' => '1',
			'medal.isopen' => '1',
			'homeUrl' => 'index.php?m=app&app=4tschool',
			'windid' => 'local',
			'homeRouter' => array(
				'm' => 'app',
				'c' => 'index',
				'a' => 'run',
				'app' => '4tschool',
			),
			'hash' => 'QEzv6lcr',
			'cookie.pre' => 'HqN',
			'info.mail' => '81552433@qq.com',
			'info.url' => 'http://www.diancanyo.com',
			'theme.site.pack' => 'site',
			'theme.site.default' => 'default',
			'theme.space.pack' => 'space',
			'theme.space.default' => 'default',
			'theme.forum.pack' => 'forum',
			'theme.portal.pack' => 'portal/appcenter',
			'info.icp' => '',
			'info.logo' => '',
			'statisticscode' => '<script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src=\'" + _bdhmProtocol + "hm.baidu.com/h.js%3F3bf15cf5566f3927e165b2d12ea5534e\' type=\'text/javascript\'%3E%3C/script%3E"));
</script>',
			'visit.state' => '0',
			'visit.group' => '',
			'visit.gid' => '',
			'visit.ip' => '',
			'visit.member' => '',
			'rewrite' => array(
				'indexrun' => array(
					'format' => 'school-{schoolid}-4tschool-index-run',
					'pattern' => '/^school\\-(?P<schoolid>(\\d+)?)\\-4tschool\\-index\\-run$/i',
					'route' => 'app/index/run',
				),
				'shopdetails' => array(
					'format' => 'school-{schoolid}-4tschool-shopdetails-run-{shopid}',
					'pattern' => '/^school\\-(?P<schoolid>(\\d+)?)\\-4tschool\\-shopdetails\\-run\\-(?P<shopid>(\\d+)?)$/i',
					'route' => 'app/shopdetails/run',
				),
				'shopphone' => array(
					'format' => 'school-{schoolid}-4tschool-shopdetails-showphone-{shopid}',
					'pattern' => '/^school\\-(?P<schoolid>(\\d+)?)\\-4tschool\\-shopdetails\\-showphone\\-(?P<shopid>(\\d+)?)$/i',
					'route' => 'app/shopdetails/showphone',
				),
				'mdetails' => array(
					'format' => 'school-{schoolid}-4tschool-shopdetails-{shopid}-mid-{mid}',
					'pattern' => '/^school\\-(?P<schoolid>(\\d+)?)\\-4tschool\\-shopdetails\\-(?P<shopid>(\\d+)?)\\-mid\\-(?P<mid>(\\d+)?)$/i',
					'route' => 'app/shopdetails/mdetail',
				),
			),
		),
		'credit' => array(
			'credits' => array(
				'1' => array(
					'name' => '铜币',
					'unit' => '枚',
					'open' => '1',
					'log' => '1',
				),
				'2' => array(
					'name' => '威望',
					'unit' => '点',
					'open' => '1',
					'log' => '1',
				),
				'3' => array(
					'name' => '银元',
					'unit' => '个',
					'open' => '1',
					'log' => '1',
				),
				'4' => array(
					'name' => '贡献',
					'unit' => '点',
				),
				'5' => array(
					'name' => '鸡蛋',
					'unit' => '个',
				),
				'6' => array(
					'name' => '鲜花',
					'unit' => '朵',
				),
			),
			'strategy' => array(
				'0' => '',
				'register' => array(
					'limit' => '1',
					'credit' => array(
						'1' => '10',
						'2' => '10',
						'3' => '0',
						'4' => '0',
					),
				),
				'login' => array(
					'limit' => '1',
					'credit' => array(
						'1' => '0',
						'2' => '2',
						'3' => '0',
						'4' => '0',
					),
				),
				'sendmsg' => array(
					'limit' => '0',
					'credit' => array(
						'1' => '0',
						'2' => '0',
						'3' => '0',
						'4' => '0',
					),
				),
				'post_topic' => array(
					'limit' => '0',
					'credit' => array(
						'1' => '2',
						'2' => '2',
						'3' => '0',
						'4' => '0',
					),
				),
				'delete_topic' => array(
					'limit' => '0',
					'credit' => array(
						'1' => '-2',
						'2' => '-2',
						'3' => '0',
						'4' => '0',
					),
				),
				'post_reply' => array(
					'limit' => '0',
					'credit' => array(
						'1' => '0',
						'2' => '1',
						'3' => '0',
						'4' => '0',
					),
				),
				'delete_reply' => array(
					'limit' => '0',
					'credit' => array(
						'1' => '0',
						'2' => '-1',
						'3' => '0',
						'4' => '0',
					),
				),
				'digest_topic' => array(
					'limit' => '0',
					'credit' => array(
						'1' => '10',
						'2' => '10',
						'3' => '0',
						'4' => '0',
					),
				),
				'remove_digest' => array(
					'limit' => '0',
					'credit' => array(
						'1' => '-10',
						'2' => '-10',
						'3' => '0',
						'4' => '0',
					),
				),
				'upload_att' => array(
					'limit' => '0',
					'credit' => array(
						'1' => '0',
						'2' => '0',
						'3' => '0',
						'4' => '0',
					),
				),
				'download_att' => array(
					'limit' => '0',
					'credit' => array(
						'1' => '0',
						'2' => '0',
						'3' => '0',
						'4' => '0',
					),
				),
				'belike' => array(
					'limit' => '10',
					'credit' => array(
						'1' => '0',
						'2' => '1',
						'3' => '0',
						'4' => '0',
					),
				),
			),
		),
		'bbs' => array(
			'content.length.max' => '5000',
			'content.length.min' => '3',
			'post.check.end_hour' => '0',
			'post.check.end_min' => '0',
			'post.check.groups' => array(
				'0' => '3',
				'1' => '4',
				'2' => '5',
			),
			'post.check.open' => '0',
			'post.check.start_hour' => '0',
			'post.check.start_min' => '0',
			'post.timing.end_hour' => '0',
			'post.timing.end_min' => '0',
			'post.timing.groups' => array(
				'0' => '7',
				'1' => '8',
				'2' => '9',
				'3' => '10',
				'4' => '11',
				'5' => '12',
				'6' => '13',
				'7' => '14',
				'8' => '3',
				'9' => '4',
				'10' => '5',
			),
			'post.timing.open' => '0',
			'post.timing.start_hour' => '0',
			'post.timing.start_min' => '0',
			'read.anoymous_displayname' => '',
			'read.defined_floor_name' => '0:楼主
1:沙发
2:板凳
3:地板',
			'read.display_info' => array(
				'uid' => '1',
				'fans' => '1',
				'follows' => '1',
				'posts' => '1',
			),
			'read.display_info_vieworder' => array(
				'uid' => '0',
				'regdate' => '1',
				'lastvisit' => '2',
				'fans' => '3',
				'follows' => '4',
				'posts' => '5',
				'homepage' => '6',
				'location' => '7',
				'qq' => '8',
				'aliww' => '9',
				'birthday' => '10',
				'hometown' => '11',
			),
			'read.display_member_info' => '1',
			'read.floor_name' => '楼',
			'read.perpage' => '15',
			'read.shield_banthreads' => '1',
			'thread.hotthread_replies' => '3',
			'thread.leftside_width' => '',
			'thread.max_pages' => '1000',
			'thread.new_thread_minutes' => '20',
			'thread.perpage' => '20',
			'title.length.max' => '100',
			'editor.style' => '0',
			'content.duplicate' => '1',
			'ubb.cvtimes' => '30',
			'ubb.img.open' => '1',
			'ubb.img.width' => '700',
			'ubb.img.height' => '0',
			'ubb.size.max' => '5',
			'ubb.flash.open' => '1',
			'ubb.media.open' => '1',
			'ubb.iframe.open' => '0',
		),
		'attachment' => array(
			'extsize' => array(
				'jpg' => '2048',
				'gif' => '2048',
				'png' => '2048',
				'bmp' => '2048',
				'xls' => '2048',
				'txt' => '2048',
				'doc' => '2048',
				'docx' => '2048',
				'rar' => '2048',
				'zip' => '2048',
				'pdf' => '2048',
			),
			'mark.file' => 'mark.gif',
			'mark.fontcolor' => '#000000',
			'mark.fontfamily' => 'en_arial.ttf',
			'mark.fontsize' => '5',
			'mark.gif' => '0',
			'mark.limitheight' => '50',
			'mark.limitwidth' => '100',
			'mark.markset' => array(
				'0' => 'bbs',
				'1' => 'album',
			),
			'mark.position' => '9',
			'mark.quality' => '90',
			'mark.text' => '点餐哟',
			'mark.transparency' => '90',
			'mark.type' => '2',
			'pathsize' => '2048',
			'thumb' => '1',
			'thumb.quality' => '90',
			'thumb.size.height' => '',
			'thumb.size.width' => '500',
			'attachnum' => '10',
		),
		'components' => array(
			'mobileplat' => array(
				'path' => 'SRV:mobile.srv.plat.T4Mobilewangjian',
			),
		),
		'seo' => array(
			'seo_bbs_thread_1' => array(
				'mod' => 'bbs',
				'page' => 'thread',
				'param' => '1',
				'title' => '',
				'keywords' => '',
				'description' => '',
			),
			'seo_bbs_thread_2' => array(
				'mod' => 'bbs',
				'page' => 'thread',
				'param' => '2',
				'title' => '',
				'keywords' => '',
				'description' => '',
			),
		),
		'nav' => array(
			'main' => array(
				'0' => array(
					'name' => '<a href="http://www.diancanyo.com/index.php?m=app&app=4tschool">点餐哟外卖平台</a>',
					'sign' => 'app|index|run|',
				),
			),
			'bottom' => array(
				'0' => array(
					'name' => '<a href="http://www.phpwind.com/index.php?m=aboutus&a=index&menuid=16">关于phpwind</a>',
					'sign' => '',
				),
				'1' => array(
					'name' => '<a href="http://www.phpwind.com/index.php?m=aboutus&a=index&menuid=20">联系我们</a>',
					'sign' => '',
				),
				'3' => array(
					'name' => '<a href="http://www.phpwind.net/thread-htm-fid-54.html">问题反馈</a>',
					'sign' => '',
				),
				'2' => array(
					'name' => '<a href="http://www.phpwind.net/thread-htm-fid-39.html">程序建议</a>',
					'sign' => '',
				),
			),
			'my' => array(
				'0' => array(
					'name' => '<a href="http://www.diancanyo.com/index.php?m=space"><em class="icon_space"></em>我的空间</a>',
					'sign' => 'space',
				),
				'1' => array(
					'name' => '<a href="http://www.diancanyo.com/index.php?m=my&c=fresh"><em class="icon_fresh"></em>我的关注</a>',
					'sign' => 'fresh',
				),
				'2' => array(
					'name' => '<a href="http://www.diancanyo.com/index.php?m=bbs&c=forum&a=my"><em class="icon_forum"></em>我的版块</a>',
					'sign' => 'forum',
				),
				'3' => array(
					'name' => '<a href="http://www.diancanyo.com/index.php?m=my&c=article"><em class="icon_article"></em>我的帖子</a>',
					'sign' => 'article',
				),
				'4' => array(
					'name' => '<a href="http://www.diancanyo.com/index.php?m=vote&c=my"><em class="icon_vote"></em>我的投票</a>',
					'sign' => 'vote',
				),
				'5' => array(
					'name' => '<a href="http://www.diancanyo.com/index.php?m=task"><em class="icon_task"></em>我的任务</a>',
					'sign' => 'task',
				),
				'6' => array(
					'name' => '<a href="http://www.diancanyo.com/index.php?m=medal"><em class="icon_medal"></em>我的勋章</a>',
					'sign' => 'medal',
				),
			),
		),
	),
	'expires' => '0',
);
?>