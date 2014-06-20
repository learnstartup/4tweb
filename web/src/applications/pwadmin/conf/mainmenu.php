<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * 后台默认菜单配置信息,菜单配置格式如下：
 * 一个菜单个配置格式中包含: 菜单名称, 路由信息, 菜单图标, 菜单tip, 父节点, 上一个菜单
 * 菜单:  'key' => array('菜单名称', '应用路由', 'icon' , ' tip' ,'父节点key', '上一个菜单key'),
 *
 * <note>
 * 1. 如果没有填写上一个菜单则默认放置在节点最后.
 * 2. 如果没有父节点则并放置在'上一个菜单之后'.
 * 3. 如果'父节点','上一个菜单'都没有则散落的放置在最外层.
 * </note>
 *
 * 节点定义: 'Key' => array('节点名称', 子菜单, 'icon', 'tip' ,'父节点key'),
 */
return array(
	/*========为了演示，将后台导航菜单添加完善=========*/
//	'offen' => array('常用', array()),
//	'offen' => array('常用', '', '', '', ''),


	/**=====配置开始于此=====**/
	'custom' => array('常用', array()),
	'admin' => array('创始人', array()),
	'config' => array('全局', array()),
	'u' => array('用户', array()),
	// 'contents' => array('内容', array()),
	// 'bbs' => array('论坛', array()),
	// 'design' => array('门户', array()),
	'data' => array('工具', array()),
	// 'appcenter' => array('应用', array()),
	// 'platform' => array('云平台', array()),
	'4tschool' => array('外卖平台设置', array()),
	'4tshop' => array('外卖商家', array()),
	'4tpromotion' => array('外卖推广', array()),
	'4tordertouser' => array('外卖订单处理', array()),
	'4torderstatistic' => array('外卖统计', array()),
	'4tgiftexchange' => array('兑换管理', array()),

	'custom_set' => array('常用菜单', 'custom/*', '', '', 'custom'),
	'admin_founder' => array('创始人管理', 'founder/*', '', '', 'admin'),
	'admin_auth' => array('后台权限', 'auth,role/*', '', '', 'admin'),
	'admin_safe' => array('后台安全', 'safe/*', '', '', 'admin'),
	
	'windid_windid' => array('WindID设置', 'windid/windid/*', '', '', 'admin'),
	'windid_client' => array('客户端管理', 'windid/client/*', '', '', 'admin'),

	'windid_notify' => array('通知队列', 'windid/notify/*', '', '', 'admin'),
	//'windid_regist' => array('注册设置', 'windid/regist/*', '', '', 'admin'),
	//'windid_storage' => array('头像存储设置', 'windid/storage/*', '', '', 'admin'),
	//'windid_credit' => array('积分设置', 'windid/credit/*', '', '', 'admin'),
	//'windid_time' => array('时区设置', 'windid/time/*', '', '', 'admin'),
	//'windid_user' => array('用户管理', 'windid/user/*', '', '', 'admin'),
	//'windid_messages' => array('私信管理', 'windid/messages/*', '', '', 'admin'),
	//'windid_area' => array('地区库', 'windid/areadata/*', '', '', 'admin'),
	//'windid_school' => array('学校库', 'windid/schooldata/*', '', '', 'admin'),

	'config_site' => array('站点设置', 'config/config/*', '', '', 'config'),
	'config_nav' => array('导航设置', 'nav/nav/*', '', '', 'config'),
	'config_register' => array('注册登录', 'config/regist/*', '', '', 'config'),
	'config_mobile' => array('手机服务', 'config/mobile/*', '', '', 'config'),
	'config_credit' => array('积分设置', 'credit/credit/*', '', '', 'config'),
	'config_editor' => array('编辑器', 'config/editor/*', '', '', 'config'),
	'config_emotion' => array('表情管理', 'emotion/emotion/*', '', '', 'config'),
	'config_attachment' => array('附件相关', 'config/attachment,stroage/*', '', '', 'config'),
	'config_watermark' => array('水印设置', 'config/watermark/*', '', '', 'config'),
	'config_verifycode' => array('验证码', 'verify/verify/*', '', '', 'config'),
	'config_seo' => array('SEO优化', 'seo,app/manage/*', '', '', 'config'),
	'config_rewrite' => array('URL伪静态', 'rewrite/rewrite/*', '', '', 'config'),
	'config_domain' => array('二级域名', 'rewrite/domain/*', '', '', 'config'),
	'config_email' => array('电子邮件', 'config/email/*', '', '', 'config'),
	'config_pay' => array('网上支付', 'config/pay/*', '', '', 'config'),
	'config_area' => array('地区库', 'windid/areadata/*', '', '', 'config'),
	'config_school' => array('学校库', 'windid/schooldata/*', '', '', 'config'),

	'u_groups' => array('用户组权限', 'u/groups/*', '', '', 'u'),
	'u_upgrade'=> array('用户组提升','u/upgrade/*','','','u'),
	'u_manage' => array('用户管理', 'u/manage/*', '', '', 'u'),
	'u_forbidden' => array('用户禁止', 'u/forbidden/*', '', '', 'u'),
	'u_check' => array('新用户审核', 'u/check/*', '', '', 'u'),

	// 'bbs_article' => array('帖子管理', 'bbs/article/*', '', '', 'contents'),
	// 'contents_tag' => array('话题管理', 'tag/manage/*', '', '', 'contents'),
	// 'contents_message' => array('私信管理', 'message/manage/*', '', '', 'contents'),
	// 'contents_report' => array('举报管理', 'report/manage/*', '', '', 'contents'),
	//'bbs_contentcheck' => array('内容审核', array(), '', '', 'contents'),
	// 'bbs_contentcheck_forum' => array('帖子审核', 'bbs/contentcheck/*', '', '', 'contents'),
	// 'contentcheck_word' => array('敏感词管理', 'word/manage/*', '', '', 'contents'),
	// 'contents_user_tag' => array('个人标签', 'u/tag/*', '', '', 'contents'),
	// 'bbs_recycle' => array('回收站', 'bbs/recycle/*', '', '', 'contents'),

	// 'bbs_configbbs' => array('论坛设置', 'bbs/configbbs/*', '', '', 'bbs'),
	// 'bbs_setforum' => array('版块管理', 'bbs/setforum/*', '', '', 'bbs'),
	// 'bbs_setbbs' => array('功能细节', 'bbs/setbbs/*', '', '', 'bbs'),
	

	// 'design_page' => array('页面管理', 'design/page,portal/*', '', '', 'design'),
	// 'design_component' => array('模块模板', 'design/component/*', '', '', 'design'),
	// 'design_module' => array('模块管理', 'design/module,data,property,template/*', '', '', 'design'),
	// 'design_push' => array('数据管理', 'design/push/*', '', '', 'design'),
	// 'design_permissions' => array('权限查看', 'design/permissions/*', '', '', 'design'),

	'database_backup' => array('数据库', 'backup/backup/*', '', '', 'data'),
	'cache_m' => array('缓存管理', 'bbs/cache/*', '', '', 'data'),
	'data_hook' => array('Hook管理', 'hook/manage/*', '', '', 'data'),
	'cron_operations' => array('计划任务', 'cron/cron/*', '', '', 'data'),
	'log_manage' => array('管理日志', 'log/manage,loginlog,adminlog/*', '', '', 'data'),

	'4tschool_shop' =>array('商家管理','admin.php?app=4tschool&m=app&c=shop','','','4tshop'),
	'4tschool_shoparea' =>array('商家区域管理','admin.php?app=4tschool&m=app&c=shoparea','','','4tshop'),
	// '4tschool_promo' =>array('商家活动管理','admin.php?app=4tschool&m=app&c=promo','','','4tshop'),
	'4tschool_merchandise' =>array('菜品管理','admin.php?app=4tschool&m=app&c=merchandise&isall=all','','','4tshop'),
	'4tschool_noitem' =>array('菜品缺货列表','admin.php?app=4tschool&m=app&c=merchandise&a=noitem','','','4tshop'),
	'4tschool_shopstatusrecord' =>array('商家开关记录','admin.php?app=4tschool&m=app&c=shopstatusrecord','','','4tshop'),

	//'app_album' => array('相册管理', 'app/manage/*?app=album', '', '', 'appcenter'),
	// 'app_vote' => array('投票管理', 'vote/manage/*', '', '', 'appcenter'),
	// 'app_medal' => array('勋章管理', 'medal/medal/*', '', '', 'appcenter'),
	// 'app_task' => array('任务中心', 'task/manage/*', '', '', 'appcenter'),
	// 'app_punch' => array('每日打卡', 'config/punch/*', '', '', 'appcenter'),
	// 'app_link' => array('友情链接', 'link/link/*', '', '', 'appcenter'),
	// 'app_message' => array('消息群发', 'message/manage/send', '', '', 'appcenter'),
	// 'app_announce' => array('公告管理', 'announce/announce/*', '', '', 'appcenter'),

	// 'platform_server' => array('平台首页', 'appcenter/server/run', '', '', 'platform'),
	// 'platform_appList' => array('应用中心', 'appcenter/server/appcenter', '', '', 'platform'),
	// 'platform_server_check' => array('服务检测', 'appcenter/server/check', '', '', 'platform'),
	// 'platform_index'   => array('应用管理', 'appcenter,app/app,develop,manage/*', '', '', 'platform'),
	// 'platform_siteStyle'  => array('模板管理','appcenter/style/*','','','platform'),
	// 'platform_upgrade'  => array('在线升级','appcenter/upgrade,fixup/*','','','platform'),


	'4tschool_schoolmanage' =>array('一级区域设置','admin.php?app=4tschool&m=app&c=schoolpeople','','','4tschool'),
	'4tschool_manage' =>array('一级区域联系方式','admin.php?app=qusite&m=app&c=manage','','','4tschool'),
	'4tschool_schoolarea' =>array('二级区域设置','admin.php?app=4tschool&m=app&c=schoolarea','','','4tschool'),
	'4tschool_tag' =>array('外卖标签管理','admin.php?app=4tschool&m=app&c=tag','','','4tschool'),
	'4tschool_systagtree' =>array('分类结构管理','admin.php?app=4tschool&m=app&c=systagtree','','','4tschool'),
	'4tschool_ordertousers' =>array('代客下单','admin.php?app=4tschool&m=app&c=Schoolusersorder&a=schoolOrder','','','4tordertouser'),
	'4tschool_refuseorder' =>array('拒签管理','admin.php?app=4tschool&m=app&c=refuseorder&a=run','','','4tordertouser'),

	'4tschool_orderstatistics_shop' =>array('商家外卖统计','admin.php?app=4tschool&m=app&c=Shoporder&a=run','','','4torderstatistic'),
	'4tschool_orderstatistics_agent' =>array('代理返利统计','admin.php?app=4tschool&m=app&c=Shoporder&a=agent','','','4torderstatistic'),

	'4tschool_gift_exchange' =>array('礼品兑换','admin.php?app=4tschool&m=app&c=giftexchange&a=run','','','4tgiftexchange'),
	'4tschool_add_my_money' =>array('增加点币','admin.php?app=4tschool&m=app&c=myaccount&a=run','','','4tgiftexchange'),


	// '4tschool_boutique' =>array('精品推荐管理','admin.php?app=4tschool&m=app&c=boutique','','','4tpromotion'),
	'4tschool_promotionalmanage' =>array('推广管理','admin.php?app=4tschool&m=app&c=promotionalmanage','','','4tpromotion'),
	// '4tschool_push' =>array('推送管理','admin.php?app=4tschool&m=app&c=push','','','4tpromotion'),
	'4tschool_announce' =>array('外卖通告','admin.php?app=4tschool&m=app&c=announce','','','4tpromotion'),
	'4tschool_cateweekreport' =>array('美食周报','admin.php?app=4tschool&m=app&c=cateweekreport','','','4tpromotion'),
	'4tschool_firstordercheck' =>array('今天送可乐','admin.php?m=app&c=firstordercheck&a=run&app=4tschool','','','4tpromotion'),


	//混乱的配置，先统一，后续再系统规划整理
	'_extensions' => array(
		//'config' => array('resource' => 'APPS:config.conf.configmenu.php'),//全局
		//'nav' => array('resource' => 'APPS:nav.conf.navmenu.php'),
		//'credit' => array('resource' => 'APPS:credit.conf.creditmenu.php'),
		//'seo' => array('resource' => 'APPS:seo.conf.seomenu.php'),
		//'rewrite' => array('resource' => 'APPS:rewrite.conf.rewritemenu.php'),
		//'u' => array('resource' => 'APPS:u.conf.umenu.php'),//用户
		//'tag'	=> array('resource' => 'APPS:tag.conf.tagmenu.php'),//话题
		//'message' => array('resource' => 'APPS:message.conf.messagemenu.php'),//消息
		//'report' => array('resource' => 'APPS:report.conf.reportmenu.php'),//举报
		//'bbs' => array('resource' => 'APPS:bbs.conf.bbsmenu.php'),//论坛
		//'other' => array('resource' => 'ADMIN:conf.testmenu.php'),//临时的门户、手机、数据
	
		//'backup' => array('resource' => 'APPS:backup.conf.backupmenu.php'),//临时的门户、手机、数据

		//'word' => array('resource' => 'APPS:word.conf.wordmenu.php'),

		//'link' => array('resource' => 'APPS:link.conf.linkmenu.php'),//运营
		//'punch' => array('resource' => 'APPS:u.conf.punchmenu.php'),
		//'appcenter' => array('resource' => 'APPS:appcenter.conf.appcentermenu.php'),//应用
		//'medal'	=> array('resource' => 'APPS:medal.conf.medalmenu.php'),
		//'task'	=> array('resource' => 'APPS:task.conf.taskmenu.php'),
		//'vote'	=> array('resource' => 'APPS:vote.conf.votemenu.php'),
		//'announce'	=> array('resource' => 'APPS:announce.conf.announcemenu.php'),
		//'emotion' => array('resource' => 'APPS:emotion.conf.emotionmenu.php'),
		//'cron' => array('resource' => 'APPS:cron.conf.cronmenu.php'),
	),
);
/**=====配置结束于此=====**/
