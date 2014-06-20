<!DOCTYPE html>
<html dir="ltr" lang="zh-CN" xmlns="http://www.w3.org/1999/xhtml">
<!-- saved from url=(0022)http://www.fenxiangyo.com/ -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-cache">
    <?php  if(empty($schoolInfo['schoolid'])) { ?>
    <script src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/qusite/qusite.js?v=<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','version'), ENT_QUOTES, 'UTF-8');?>" type="text/javascript"></script>
    <?php  } else { ?>
    <script src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/qusite/qusite_<?php echo htmlspecialchars($schoolInfo['schoolid'], ENT_QUOTES, 'UTF-8');?>.js?v=<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','version'), ENT_QUOTES, 'UTF-8');?>" type="text/javascript"></script>
    <?php  } ?>

    <title>
        <?php  if(!empty($SEOTitle)) { 
 echo htmlspecialchars($SEOTitle, ENT_QUOTES, 'UTF-8');
  } else { ?>
            点餐哟校园网络订餐,点餐哟校园手机订餐,分享哟生活轨迹服务平台,大学生的手机订餐系统,点餐哟平台让大学生在教室订餐,宿舍订餐以及实验室订餐
        <?php  } ?>
    </title>

    <?php  if(!empty($SEOKeyword)) { ?>
        <meta name="keywords" content="<?php echo htmlspecialchars($SEOKeyword, ENT_QUOTES, 'UTF-8');?>">
    <?php  } else { ?>
        <meta name="keywords" content="校园点餐哟 校园手机点餐 生活轨迹点餐 校园生活超市 短程服务 生活我帮带服务 校园物理位置社交平台 校园周边线上线下o2o平台">
    <?php  } 
  if(!empty($SEODescription)) { ?>
        <meta name="description" content="<?php echo htmlspecialchars($SEODescription, ENT_QUOTES, 'UTF-8');?>">
    <?php  } else { ?>
        <meta name="description"
        content="点餐哟平台是基于分享哟平台的点餐平台, 点餐哟平台让校园周边的商家以及消费者能够有机的结合起来, 让最后一公里买东西变得更加便捷, 商家重视提供优质的产品, 平台保证优质的服务;同时点餐哟平台让物理之间的距离不再冰冷呼吁生硬，让每一个人都能提供服务，让服务与被服务的人在生活圈中联系起来, 组成现实中的物理社交圈">
    <?php  } ?>
    
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

    <meta http-equiv="Content-Language" content="zh-CN">
    <meta http-equiv="imagetoolbar" content="no">
    <meta name="author" content="分享哟平台点餐哟点餐中心">
    <meta name="copyright" content="分享哟平台点餐中心版权所有">
    <base href=".">
    <link rel="stylesheet" href="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/4tschool/css/styles.css?v=<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','version'), ENT_QUOTES, 'UTF-8');?>" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/4tschool/css/formly.css?v=<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','version'), ENT_QUOTES, 'UTF-8');?>" type="text/css">
    <link rel="stylesheet" href="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/4tschool/css/colorbox.css?v=<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','version'), ENT_QUOTES, 'UTF-8');?>">
    <link rel="stylesheet" href="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/4tschool/css/4t_table.css?v=<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','version'), ENT_QUOTES, 'UTF-8');?>">
    <link rel="stylesheet" href="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/4tschool/css/iview.css?v=<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','version'), ENT_QUOTES, 'UTF-8');?>">
    <link rel="stylesheet" href="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/4tschool/css/new_version.css?v=<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','version'), ENT_QUOTES, 'UTF-8');?>">

    <!--styles for IE -->
    <!--[if lte IE 7]>
    <link rel="stylesheet" href="/css/ie.css?ebed04bf49ed29a7" type="text/css" media="screen"/><![endif]-->
    <!--styles -->
    <script>
        //全局变量 Global Variables
        var GV = {
            JS_ROOT: '<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','res'), ENT_QUOTES, 'UTF-8');?>/js/dev/',                   //js目录
            JS_VERSION: '<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>',                     //js版本号(不能带空格)
            JS_EXTRES: '<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>',
            TOKEN: '<?php echo htmlspecialchars(Wind::getComponent('windToken')->saveToken('csrf_token'), ENT_QUOTES, 'UTF-8');?>',  //token $.ajaxSetup data
            U_CENTER: '<?php echo Wekit::app()->baseUrl,'/','index.php?m=space'; ?>',    //用户空间(参数 : uid)
            <?php 
            $loginUser = Wekit::getLoginUser();
            if ($loginUser->isExists()) {
            ?>
            //登录后
            U_NAME: '<?php echo htmlspecialchars($loginUser->username, ENT_QUOTES, 'UTF-8');?>',                    //登录用户名
            U_AVATAR: '<?php echo htmlspecialchars(Pw::getAvatar($loginUser->uid), ENT_QUOTES, 'UTF-8');?>',             //登录用户头像
            <?php 
            }
            ?>
            theme : {
                name : '4tschool'
                ,getBaseUrl : function(){
                  return '<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/' + this.name + '/';
                },getImageUrl : function(image){
                  return this.getBaseUrl() + 'images/' + image;
                },getJsUrl: function(js){
                  return this.getBaseUrl() + 'js/' + js;
                }
            },
            U_AVATAR_DEF: '<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','images'), ENT_QUOTES, 'UTF-8');?>/face/face_small.jpg',         //默认小头像
            U_ID: parseInt('<?php echo htmlspecialchars($loginUser->uid, ENT_QUOTES, 'UTF-8');?>'),                 //uid
            REGION_CONFIG: '',                           //地区数据
            CREDIT_REWARD_JUDGE: '<?php echo $loginUser->showCreditNotice();?>',     //是否积分奖励，空值:false, 1:true
            URL: {
                LOGIN: '<?php echo Wekit::app()->baseUrl,'/','index.php?m=u&c=login'; ?>',                   //登录地址
                QUICK_LOGIN: '<?php echo Wekit::app()->baseUrl,'/','index.php?m=u&c=login&a=fast'; ?>',                //快速登录
                IMAGE_RES: '<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','images'), ENT_QUOTES, 'UTF-8');?>',                   //图片目录
                CHECK_IMG: '<?php echo Wekit::app()->baseUrl,'/','index.php?m=u&c=login&a=showverify'; ?>',              //验证码图片url，global.js引用
                VARIFY: '<?php echo Wekit::app()->baseUrl,'/','index.php?m=verify&a=get'; ?>',                 //验证码html
                VARIFY_CHECK: '<?php echo Wekit::app()->baseUrl,'/','index.php?m=verify&a=check'; ?>',             //验证码html
                HEAD_MSG: {
                    LIST: '<?php echo Wekit::app()->baseUrl,'/','index.php?m=message&c=notice&a=minilist'; ?>'             //头部消息_列表
                },
                SHOP_DETAIL : 'index.php?m=app&app=4tschool&c=shopdetails&schoolid=<?php echo htmlspecialchars($schoolInfo["schoolid"], ENT_QUOTES, 'UTF-8');?>&shopid=', //商店详情地址
                USER_CARD: '<?php echo Wekit::app()->baseUrl,'/','index.php?m=space&c=card'; ?>',                //小名片(参数 : uid)
                LIKE_FORWARDING: '<?php echo Wekit::app()->baseUrl,'/','index.php?c=post&a=doreply'; ?>',             //喜欢转发(参数 : fid)
                REGION: '<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=webData&a=area'; ?>',                 //地区数据
                SCHOOL: '<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=webData&a=school'; ?>',               //学校数据
                EMOTIONS: "<?php echo Wekit::app()->baseUrl,'/','index.php?m=emotion&type=bbs'; ?>",         //表情数据
                CRON_AJAX: '<?php echo htmlspecialchars($runCron, ENT_QUOTES, 'UTF-8');?>',                     //计划任务 后端输出执行
                FORUM_LIST: '<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=forum&a=list'; ?>',               //版块列表数据
                CREDIT_REWARD_DATA: '<?php echo Wekit::app()->baseUrl,'/','index.php?m=u&a=showcredit'; ?>',         //积分奖励 数据
                AT_URL: '<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=remind'; ?>',                  //@好友列表接口
                TOPIC_TYPIC: '<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=forum&a=topictype'; ?>'             //主题分类
            }
        };
    </script>

    <script src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/4tschool/js/jquery.ui.totop.js" type="text/javascript"></script>
    <script src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/4tschool/js/jquery.slides.min.js" type="text/javascript"></script>
    <script src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/4tschool/js/jquery.colorbox-min.js"></script>
    <script type="text/javascript" src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/4tschool/js/scroll.js"></script>
    <script src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/4tschool/js/main.js?v=<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','version'), ENT_QUOTES, 'UTF-8');?>" type="text/javascript"></script>

    <!-- 公告牌,基于最重要的显示权重最高的(永远显示权重为1000的) -->
    <script src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/4tschool/js/notify/jquery.noty.js" type="text/javascript"></script>
    <script src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/4tschool/js/notify/layouts/top.js" type="text/javascript"></script>
    <script src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/4tschool/js/notify/themes/defaulttheme.js" type="text/javascript"></script>

</head>
<body>
<div id="ADAREA"></div>

<div class="site-header">
    <div class="site-top new_box" style="background-color:<?php $hostname = $_SERVER['SERVER_NAME']; if($hostname == 'www.diancanyo.com' || $hostname == 'diancanyo.com'){echo '';}elseif($hostname == 'dev.diancanyo.com') {echo '#5ff6bb';}elseif($hostname == 'rc.diancanyo.com') {echo '#ebcda6';}else{echo '#94eaf2';} ?>">
        <div class="clear"></div>
        <div class="row">
            <div class="twelvecol">
                <div class="top-phone">
                    <span class="welcome">
                       <a href="<?php echo Wekit::app()->baseUrl,'/','school-', rawurlencode($schoolInfo['schoolid']),'-4tschool-index-run?app=4tschool'; ?>"><font>首页</font></a>
                      <?php  if ($loginUser->uid <= 0) { ?>
                      您好! 欢迎来到点餐哟订餐 
                        <a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=u&c=login&schoolid=', rawurlencode($schoolInfo['schoolid']); ?>"><font>[登录]</font></a> <a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=u&c=register&schoolid=', rawurlencode($schoolInfo['schoolid']); ?>"><font>[注册]</font></a>
                      <?php  } else { ?>
                      欢迎您来到点餐哟订餐,
                        <?php  if($schoolInfo['openorder'] == 1) {?>
                         <a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&c=schoolorder&a=myorder&app=4tschool'; ?>"><?php echo htmlspecialchars($loginUser->username, ENT_QUOTES, 'UTF-8');?></a> 
                        <?php  } else { ?>
                         <a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&c=myaccount&app=4tschool'; ?>"><?php echo htmlspecialchars($loginUser->username, ENT_QUOTES, 'UTF-8');?></a>
                        <?php  } ?>

                        <a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=u&c=login&a=logout&schoolid=', rawurlencode($schoolInfo['schoolid']); ?>"><font>[登出]</font></a>
                      <?php  } ?>
                       / <?php echo htmlspecialchars($schoolInfo['name'], ENT_QUOTES, 'UTF-8');?>
                        <a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&c=choose&app=4tschool'; ?>" style="margin-top:30px;"><font>[重选]</font></a> &nbsp;
                         <a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&app=com_qq_login'; ?>" target="_blank" style="vertical-align:top"><img src="themes/extres/com_qq_login/Connect_logo_3.png" valign="middle" /></a>
                                
                    </span>

                    <div class="clear"></div>
                </div>
                <div class="top-menu">
                    <div class="head-link">
                        <ul id="megamenu" class="mega-menu">
                            <?php  if($schoolInfo['openorder'] == 1 && $loginUser->uid > 0) {?>
                                <li class="head-fav">
                                    <a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&c=schoolorder&a=myorder&schoolid=', rawurlencode($schoolInfo['schoolid']),'&app=4tschool'; ?>">
                                    <font>我的订餐</font></a>
                                </li>
                                <li class='head_cart'>
                                    <a id="topbar_cart" class="cart" rel="nofollow" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&c=orderpreview&app=4tschool'; ?>">美食篮
                                    <span id="topbar-cart-food-num"><?php echo htmlspecialchars($itemCount==0?'(空)':'('.$itemCount.')', ENT_QUOTES, 'UTF-8');?></span>
                                    </a>
                                </li>
                            <?php  } else { 
  } ?>
                            <li><a id="addtoFavorite" href="http://www.diancanyo.com/">收藏本站</a></li>

                            <?php  if($schoolInfo['openliuyanban'] == 1) {?>
                            <li style="display:none"><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&c=feedback&app=4tschool'; ?>">留言板</a></li>
                            <?php  } ?>
                            
                            <li style="display:none"><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&c=shopadvantage&app=4tshop'; ?>">我是商家</a></li>


                            <li><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&c=about&app=4tschool'; ?>">帮助 </a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="row <?php if($addheaderlong){echo 'headercontrollout';} ?>" style="display:<?php if(!empty($webstatus)){echo 'none';}?>">
        <div class="twelvecol" style="width:<?php if($addheaderlong){echo '1200px';} ?>">
            <div class="line new_box">
            <div class="my-logo">
                <a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&app=4tschool'; ?>">
                    <img src="themes/extres/4tschool/images/logo.png" alt="diancanyo.com - 点餐哟"/>
                </a>
            </div>
            <div class="my-search">
                <form id='searchForm' class="J_ajaxForm" action="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&c=', rawurlencode($searchArgs['target']),'&ifdeliver=y&app=4tschool'; ?>"
                      method="post">
                    <input id='searchType' type='hidden' name='type'
                           value="<?php echo htmlspecialchars($searchArgs['type']==null?'m':$searchArgs['type'], ENT_QUOTES, 'UTF-8');?>">
                    <input id='keyword' type='hidden' name='keyword' value=''>

                    <div>
                        <ul class="tabs">
                            <li class="<?php echo htmlspecialchars($searchArgs['type']=='s'?'active':'', ENT_QUOTES, 'UTF-8');?>" tab="1"><a
                                    href="javascript:void(0)">搜索店铺</a>
                            </li>
                            <li class="<?php echo htmlspecialchars($searchArgs['type']=='m'||$searchArgs['type']==''?'active':'', ENT_QUOTES, 'UTF-8');?>" tab="2"><a
                                    href="javascript:void(0)">搜索美食</a></li>
                        </ul>

                        <div class="tab_container">
                            <div id="tab1" class="tab_content"
                                 style="<?php echo htmlspecialchars($searchArgs['type']=='s'?'display:block':'display:none', ENT_QUOTES, 'UTF-8');?>">
                                <input id="s_keyword" name="shop" class="my-input" type="text"
                                       value="<?php echo htmlspecialchars($searchArgs['type']=='s'?$searchArgs['keyword']:'', ENT_QUOTES, 'UTF-8');?>">
                                <button type="submit" class="btn btn_submit"
                                        style="height:33px; width:85px; border-color:#F87D0B; background:url(<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/4tschool/images/search_submit.png)"></button>
                            </div>


                            <div id="tab2" class="tab_content"
                                 style="<?php echo htmlspecialchars($searchArgs['type']=='m'||$searchArgs['type']==null?'display:block':'display:none', ENT_QUOTES, 'UTF-8');?>">
                                <input id="m_keyword" class="my-input" type="text" name="merchandise"
                                       value="<?php echo htmlspecialchars($searchArgs['type']=='m'?$searchArgs['keyword']:'', ENT_QUOTES, 'UTF-8');?>">
                                <button type="submit" class="btn btn_submit"
                                        style="height:33px; width:85px; border-color:#F87D0B; background:url(<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/4tschool/images/search_submit.png)"></button>
                            </div>
                        </div>
                    </div>
                <input type="hidden" name="csrf_token" value="<?php echo WindSecurity::escapeHTML(Wind::getComponent('windToken')->saveToken('csrf_token')); ?>"/></form>
            </div>
            <div class="hot-tag" style="width:400px">
                <span>热门搜索: </span>
<?php foreach ($hotsearches as $key => $item) {?>
<a class="hotSearch" href="<?php echo htmlspecialchars($item['link'], ENT_QUOTES, 'UTF-8');?>&type=<?php echo htmlspecialchars($item['type'], ENT_QUOTES, 'UTF-8');?>&schoolid=<?php echo htmlspecialchars($schoolInfo['schoolid'], ENT_QUOTES, 'UTF-8');?>&keyword=<?php echo htmlspecialchars($item['keyword'], ENT_QUOTES, 'UTF-8');?>&hotkey=h&ifdeliver=y"><?php echo htmlspecialchars($item['keyword'], ENT_QUOTES, 'UTF-8');?></a>
 <?php }?>

 <script type="text/javascript">
    $(".hotSearch").click(function(event)
    {
        //event.preventDefault();
        var keyword = $(this).html();
        var type = $(this).attr('href');
        $("#keyword").val(keyword);
        $("#searchType").val(type);

        if(type == 'm')
        {
            var item1 = $('.tabs').find("li")[1];
            $(item1).click();
            //set keyword and submit
            $("#m_keyword").val(keyword);
            $("#s_keyword").val('');
            $("#tab2").show();
            $("#tab1").hide();
            //$("#tab2").children(".btn_submit").click();
        }
        else
        {
            var item0 = $('.tabs').find("li")[0];
            $(item0).click();

            //set keyword and submit
            $("#s_keyword").val(keyword);
             $("#m_keyword").val('');
            $("#tab1").show();
            $("#tab2").hide();
            //$("#tab1").children(".btn_submit").click();
        }

    });

 </script>
            </div>
            </div>
        </div>
    <div class="spacer" style="height:10px;"></div>

    <div class="twelvecol">
        <a target="_blank" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&c=dcymall&app=4tschool'; ?>">
            <img src="themes/extres/4tschool/images/dianbi.jpg" style="width:100%" title="点餐哟外卖平台">
        </a>
    </div>
     
    </div>
    <div class="hiddenNotify" style="display:none">
        <?php   echo $topAnn['content'] ?>
    </div>
</div>

<script language="JavaScript" type="text/JavaScript">

    function SetCookie(name,value)//两个参数，一个是cookie的名子，一个是值
    {
        var Days = 30; //此 cookie 将被保存 30 天
        var exp = new Date(); //new Date("December 31, 9998");
        exp.setTime(exp.getTime() + Days*24*60*60*1000);
        document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
    }
    function getCookie(name)//取cookies函数
    {
        var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
        if(arr != null) return unescape(arr[2]); return null;

    }
    function delCookie(name)//删除cookie
    {
        var exp = new Date();
        exp.setTime(exp.getTime() - 1);
        var cval=getCookie(name);
        if(cval!=null) document.cookie= name + "="+cval+";expires="+exp.toGMTString();
    }

</script>


<script language="javascript">
    $(document).ready(function () {

    $("#addtoFavorite").click(function (event) {

        var ctrl = (navigator.userAgent.toLowerCase()).indexOf('mac') != -1 ? 'Command/Cmd' : 'CTRL';
        var url = $(this).attr("href");
        if (document.all)//ie
            window.external.AddFavorite(url, '点餐哟校园订餐');
        else//chrome and others
            alert('您可以通过快捷键' + ctrl + ' + D 加入到收藏夹');

        event.preventDefault();
    });
});

</script> 

<style type="text/css">  
        .go_top {z-index:1;width:119px;height:350px;position:absolute;left:20px;float:left;margin:0px;}  
        .top a { text-decoration:none; }  
        .go_top img{
            width:150px;
            height:150px;
        }
        .go_top span{
            font-weight: bolder;
            color: #DA4A33;
        }
        .top a,  
        .top a:hover { /*background:url(http://img4.ddimg.cn/00016/basic/bg_float_bt.gif) left bottom no-repeat;*/ color:#656a77; text-align:left; display:block; padding-left:6px; padding-bottom:10px; font-size:12px; border:0 1px 1px 1px;   
        border-color: #EFEFEF;  
        border-style: solid;  
        border-width: 0 2px 2px;}  
        .top a:hover { color:#ff6600; } 
         .shop-resting{
            width:165px;
            height:100px;
            position:absolute;
            z-index:99;
            background-color:#9DC8FD; 
            opacity:0.8;
            border:1px solid #CFCFCF;
        }

        .sticky{
            width:1px;
            height:0px;
            border-left:60px solid #9DC8FD;
            border-top:60px solid #F2F2F2;
            float: right;
        }
        .sticky div{
            margin-left: -35px;
            margin-top: -50px; 
            width: 40px;
            color: #FF4400;
            -webkit-transform: rotate(45deg);
            -moz-transform: rotate(45deg);            
        }   
    </style> 
<!-- {{ for the recommend products in the index-->
<script type="text/javascript" src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/4tschool/js/raphael-min.js"></script>
<script src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/4tschool/js/jquery.easing.js" type="text/javascript"></script>
<script src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/4tschool/js/iview.pack.js" type="text/javascript"></script>
<script src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/4tschool/js/jquery.easytabs.js" type="text/javascript"></script>
<script src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/4tschool/js/jquery.carouFredSel-6.2.1-packed.js" type="text/javascript"></script>
<!-- }} -->

<script src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/4tschool/js/4tindex.js" type="text/javascript"></script>

<script language="javascript" type="text/javascript">   
    var w3c = (document.getElementById) ? true : false;   
    var agt = navigator.userAgent.toLowerCase();   
    var ie = ((agt.indexOf("msie") != -1) && (agt.indexOf("opera") == -1) && (agt.indexOf("omniweb") == -1));   
    var mymovey = new Number();   
    function IeTrueBody(){   
    return (document.compatMode && document.compatMode!="BackCompat") ? document.documentElement : document.body;  
    }   
    function GetScrollTop(){   
    return ie ? IeTrueBody().scrollTop : window.pageYOffset;   
    }   
    function heartBeat(){   
    diffY=GetScrollTop();   
    mymovey += Math.floor((diffY-document.getElementById('backi').style.top.replace("px","")+150)*0.1);   
    document.getElementById('backi').style.top = mymovey+"px"; }   
    window.setInterval("heartBeat()",1);   
</script>

<script type="text/javascript">
    var _FlowCount = 0;
    function flowaction() {
        var strhtml;
        strhtml = $('#OrderFlow .FlowItem').eq(_FlowCount - 1).html();
        if (strhtml == null) {
            return false;
        }
        $('#OrderFlow .FlowItem').eq(_FlowCount - 1).remove();
        $('#OrderFlow').prepend('<div class="FlowItem first">' + strhtml + '</div>');
        $('#OrderFlow .FlowItem').slideDown(500);
    }

    $(document).ready(function () {
        _FlowCount = $('#OrderFlow .FlowItem').length;
        if (_FlowCount == 0) {
            $('#OrderFlow').hide();
        }
        else if (_FlowCount == 1) {
            $('#OrderFlow').css("height", "50px")
        }
        else if (_FlowCount == 2) {
            $('#OrderFlow').css("height", "100px")
        }
        else if (_FlowCount == 3) {
            $('#OrderFlow').css("height", "150px")
        }
        else if (_FlowCount == 4) {
            $('#OrderFlow').css("height", "200px")
        }
        var Interval;
        Interval = setInterval('flowaction()', 3000);
        $("#OrderFlow").hover(
                function () {
                    clearInterval(Interval);
                },
                function () {
                    Interval = setInterval('flowaction()', 3000);
                }
        );
        $(".FlowItem").each(function (i) {
            var flow_json = JSON.parse($(this).children(".flow_json").eq(0).text());
            order_item = flow_json[$(this).attr("data-merchant")];
            var item_text = '';
            for (var j = 0; j < order_item.length; j++) {
                item_text += order_item[j].FoodName + order_item[j].FoodCount + " 份,";
            }
            if (getLen(item_text) > 20) {
                item_text = item_text.substr(0, 20) + '...';
            }
            item_text = item_text.substring(0, item_text.length - 1);
            $(this).children(".flow_text:eq(0)").text(item_text);
        })
    })
</script>
<script type="text/javascript">
    $(function(){
        $("#orderonline").change(function() {

            if($("#orderonline").attr("checked") == 'checked')
            {
                $("#allshop").removeAttr('checked');
                $('#ul1').css({'display':'none'});
                $('#ul2').css({'display':''});
            }
            else
            {
                $("#allshop").attr({'checked':'checked'});
                $('#ul1').css({'display':''});
                $('#ul2').css({'display':'none'});
            }
        });
    }); 
    $(function(){
        $("#allshop").change(function() {

            if($("#allshop").attr("checked") == 'checked')
            {
                $("#orderonline").removeAttr('checked');
                $('#ul1').css({'display':''});
                $('#ul2').css({'display':'none'});
            }
            else
            {
                $("#orderonline").attr({'checked':'checked'});
                $('#ul1').css({'display':'none'});
                $('#ul2').css({'display':''});
            }
        });
    }); 
</script>

<div class="clear"></div>
<div class="spacer" style="height:5px"></div>
<div class="row" style="display:none">
    <div class="index_banner new_box" style="height:200px">
        <div>
            <img src="themes/extres/4tschool/images/advertisement_<?php $hostname = $_SERVER['SERVER_NAME']; if($hostname == 'www.diancanyo.com'){echo 'live';}elseif($hostname == 'dev.diancanyo.com') {echo 'dev';}elseif($hostname == 'rc.diancanyo.com') {echo 'rc';}else{echo 'local';} ?>.jpg" alt="点餐哟二维码" style=""/>
        </div>
    </div>
</div>
<div class="row new_box" style="height:99px">
    <img src="themes/extres/4tschool/images/navigation.jpg" title="点餐哟外卖平台">
</div>

<?php  if($schoolInfo['openclassannounce']){ ?>
<div class="row">
    <div class="twelvecol">
        <div class="category_navigation new_box">
            <ul class="category_list">
                <?php foreach ($nav as $key => $navItem) {?>
                <li>
                    <span class="category_name"><?php echo htmlspecialchars($navItem->title, ENT_QUOTES, 'UTF-8');?><span class="patch"></span></span>
                    <?php  if($navItem->children !== 'false' && $navItem->children[0]->children !== 'false'){ ?>
                    <ul class="sub_category_list">
                    <?php  }else{ ?>
                    <ul class="sub_category_list twolevel">
                    <?php  } 
  foreach($navItem->children as $key=>$subCategory){ ?>
                        <li>
                            <span class="sub_category_name">
                                <a target="_blank" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&c=merchandiselist&schoolid=', rawurlencode($schoolInfo['schoolid']),'&app=4tschool'; ?>&systid=<?php echo htmlspecialchars($subCategory->a_attr->id, ENT_QUOTES, 'UTF-8');?>"><?php echo htmlspecialchars($subCategory->title, ENT_QUOTES, 'UTF-8');?></a>
                            </span>
                            <ul class="product_list">
                                <?php  if(!empty($subCategory) && isset($subCategory->children) && is_array($subCategory->children)){ 
  foreach($subCategory->children as $key=>$item){ ?>
                                        <li><span class="product_name">
                                                <a target="_blank" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&c=merchandiselist&schoolid=', rawurlencode($schoolInfo['schoolid']),'&app=4tschool'; ?>&systid=<?php echo htmlspecialchars($item->a_attr->id, ENT_QUOTES, 'UTF-8');?>&ifdeliver=y"><?php echo htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8');?></a>
                                            </span>
                                        </li>
                                    <?php  } 
  } ?>
                            </ul>
                        </li>
                        <?php  } ?>
                        <li class="bottom"></li>
                    </ul>
                </li>
                <?php  } ?>
            </ul>
        </div>
        <div class="iview_container new_box">
            
            <div class="recommend iview">
                <?php  foreach($boutiqueList as $key=>$boutique){ ?>
                <div data-iview:thumbnail="<?php echo htmlspecialchars($boutique['imgurl'], ENT_QUOTES, 'UTF-8');?>"
                     data-iview:image="<?php echo htmlspecialchars($boutique['imgurl'], ENT_QUOTES, 'UTF-8');?>" style="z-index:-1;">
                    <a target="_blank" href="<?php echo htmlspecialchars($boutique['link'], ENT_QUOTES, 'UTF-8');?>">&nbsp;</a>
                    <div class="iview-caption hidden" data-x="0" data-y="0"  data-transition="fade">
                        <span class="boutique_name"><?php echo htmlspecialchars($boutique['description'], ENT_QUOTES, 'UTF-8');?></span>
                    </div>
                </div>
                <?php  } ?>
            </div>
            <div class="iview_mask"></div>
        </div>
        <div class="info_panel new_box floatLeft">
             <h3 class="announce_title">公告</h3>
             <div class="tabs" style="height:118px; margin:6px">
                 <ul>
                     <?php  foreach($eachContentInfo as $key=>$item){ ?>
                     <li class="announce-list">
                         <a target="_blank" class="announce_overflow" title="<?php echo htmlspecialchars($item['subject'], ENT_QUOTES, 'UTF-8');?>" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&c=announcedetails&id=', rawurlencode($item['aid']),'&schoolid=', rawurlencode($schoolInfo['schoolid']),'&app=4tschool'; ?>"><?php echo htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8');?></a>
                     </li>
                     <?php  } ?>
                 </ul>
             </div>
             <div id="announce_space"></div>
             <div id="announce_bg">
                <div id="annonce_photo">
                    <img src="themes/extres/4tschool/images/person_small_photo.png" alt="头像"/>
                </div>
                <div id="annouce_photo_title">
                    Hi! 
                    <?php  if($username != '游客'){ ?>
                    <a target="_blank" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&c=myaccount&page=1&schoolid=', rawurlencode($schoolInfo['schoolid']),'&app=4tschool'; ?>">
                       <strong>
                            <?php  if(empty($username)){echo '你好';}else{echo $username;}?>
                       </strong>
                    </a>
                    <?php  }else{ ?>
                        <strong>
                            <?php  if(empty($username)){echo '你好';}else{echo $username;}?>
                        </strong>
                    <?php  } ?>
                </div>
                <?php  if(empty($userid)){ ?>
                <div class="register">
                    <a target="_blank" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=u&c=register&schoolid=', rawurlencode($schoolInfo['schoolid']); ?>">免费注册</a>
                    <div style="float:left">&nbsp;</div>
                    <a target="_blank" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=u&c=login&schoolid=', rawurlencode($schoolInfo['schoolid']); ?>">登陆</a>
                </div>
                <!-- <div class="register">
                    <a target="_blank" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=u&c=register&schoolid=', rawurlencode($schoolInfo['schoolid']); ?>">登陆</a>
                </div> -->
                <?php  } 
  if(!empty($userid)){ ?>
                <div id="person_title">
                    <div class="msg_title">积分</div>
                    <div class="msg_title">已评价</div>
                    <div class="msg_title">待评价</div>
                    <div class="msg_title">已消费</div>
                </div>
                <div id="person_button">
                    <div class="msg_num_right"> 
                        <a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&c=myaccount&a=mycredit&page=1&schoolid=', rawurlencode($schoolInfo['schoolid']),'&app=4tschool'; ?>" target="_blank">
                            <?php echo htmlspecialchars($myCredit[0]['credit']==''?'0.00':$myCredit[0]['credit'], ENT_QUOTES, 'UTF-8');?>
                        </a>
                    </div>
                    <div class="msg_num_left">
                        <a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&c=shopcomment&a=mycomment&page=1&schoolid=', rawurlencode($schoolInfo['schoolid']),'&app=4tschool'; ?>" target="_blank">
                            <?php echo htmlspecialchars($countComment ==''?'0':$countComment, ENT_QUOTES, 'UTF-8');?>
                        </a>
                    </div>
                    <div class="msg_num_left">
                        <a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&c=shopcomment&a=mynocomment&page=1&schoolid=', rawurlencode($schoolInfo['schoolid']),'&app=4tschool'; ?>" target="_blank">
                            <?php echo htmlspecialchars($countNoComment ==''?'0':$countNoComment, ENT_QUOTES, 'UTF-8');?>
                        </a>
                    </div>
                    <div class="msg_num_left">
                        <a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&c=myaccount&a=mycredit&page=1&schoolid=', rawurlencode($schoolInfo['schoolid']),'&app=4tschool'; ?>" target="_blank">
                            <?php echo htmlspecialchars($countMoney==''?'0':$countMoney, ENT_QUOTES, 'UTF-8');?>
                        </a>
                    </div>
                </div>
                <?php  } ?>
             </div>
             <div id="announce_panel">
                    <a target="_blank" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&c=contribute&app=4tschool'; ?>&schoolid=<?php echo htmlspecialchars($schoolId, ENT_QUOTES, 'UTF-8');?>" class="more-shop-button">美食达人</a>&nbsp;&nbsp;&nbsp;
                    <a target="_blank" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&c=partimejob&app=4tschool'; ?>&schoolid=<?php echo htmlspecialchars($schoolId, ENT_QUOTES, 'UTF-8');?>" class="more-shop-button">合作伙伴</a>
             </div>
        </div>

    </div>
    <div class="clear"></div>
</div>
<?php  } 
  if($schoolInfo['opencombo']) { ?>
<div class="spacer"></div>
<div class="clear"></div>
<?php  } 
  if(file_exists("themes/extres/4tschool/images/banner_".$schoolInfo['schoolid'].".jpg")){ ?>
<div class="row">
    <div class="index_banner new_box">
        <img src="themes/extres/4tschool/images/banner_<?php echo htmlspecialchars($schoolInfo['schoolid'], ENT_QUOTES, 'UTF-8');?>.jpg" alt="点餐哟，叫外卖"/>
    </div>
</div>
<?php  } 
  if($schoolInfo['opencombo']) { ?>
<div class="row">
    <div class="twelvecol">
            <div class="set_meal no_border no_background">
                <div class="tabs">
                    <div class="labels h3">
                        <span class="floatLeft">套餐推荐</span>
                        <ul>
                            <?php  foreach($combo as $key=>$item){ ?>
                                <li><?php echo htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8');?></li>
                            <?php  } ?>
                            <li class="clear"></li>
                        </ul>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                    <div class="contents">
                        <ul class="set_meal_list">
                            <?php  foreach($combo as $idx => $item){ ?>
                            <li>
                                <ul>
                                    <?php  foreach($item->children as $key => $comboItem){ ?>
                                    <li>
                                        <a target="_blank" href="<?php echo Wekit::app()->baseUrl,'/','school-', rawurlencode($schoolInfo['schoolid']),'-4tschool-shopdetails-run-', rawurlencode($comboItem['shopid']),'?mid=', rawurlencode($comboItem['id']),'&type=m&app=4tschool'; ?>">
                                        <img class="floatLeft" src="<?php echo htmlspecialchars($comboItem['imageurl'], ENT_QUOTES, 'UTF-8');?>" width="196" height="120"/><span class="comboTitle"><?php echo htmlspecialchars($comboItem['name'], ENT_QUOTES, 'UTF-8');?></span>
                                        </a>
                                    </li>
                                    <?php  } ?>
                                </ul>
                            </li>
                            <?php  } ?>
                        </ul>
                        <div class="clear"></div>
                    </div>
                </div>

                <div class="clear"></div>
            </div>
    </div>
</div>
<?php  } ?>

<!-- 推荐餐厅 -->
<div class="row">
    <div class="">
        <div class="line new_box">
            <div class="bbox">
                <h3 class="word-space">
                    <div style="float:left">
                    送外卖的商家
                    <span>
                        繁忙时段请尽量提前半小时下单..
                    </span>
                    </div>
                    <div style="float:right;float-right:40px">
                        <a target="_blank" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&c=allshop&app=4tschool'; ?>&schoolid=<?php echo htmlspecialchars($schoolId, ENT_QUOTES, 'UTF-8');?>&ifdeliver=y" title="点餐哟外卖商家" class="more-shop-button">查看全部商家</a>&nbsp;
                    </div>
                </h3>
            </div>
            <div class="spacer" id="conditionshop">
                <span>
                    &nbsp;<input type="checkbox" disabled="disbaled" checked="checked" value="open" name="push" id="push">置顶
                </span>
                <span>
                    &nbsp;<input type="checkbox" value="open" name="filter" id="orderonline">在线下单
                </span>
                <span>
                    &nbsp;<input type="checkbox" value="open" checked="checked" name="allshop" id="allshop">全部外卖商家
                </span>
                <div style="float:right; margin-right:10px">
                    <span class="icon order-open">外</span>
                    <span>该商家提供外卖服务</span>
                    <span class="icon terminal-open">订</span>
                    <span>该商家支持在线下单订外卖</span>
                    <span class="icon discount">返</span>
                    <span>该商家点餐返点币</span>
                </div>
            </div>
            <ul class="all-shops" id="ul1" style="display:">
                <?php foreach ($shopList as $key => $item) {?>
                    <li class=grid>
                        <a target="_blank" title="<?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8');?>" href="<?php echo Wekit::app()->baseUrl,'/','school-', rawurlencode($schoolId),'-4tschool-shopdetails-run-', rawurlencode($item['id']),'?app=4tschool'; ?>">

                            <?php  if($item['ispartner'] == 1 && $item['isshopopen'] == 0 && $item['openordertouser'] == 0){ ?>
                        <div class="shop-resting">
                            <div class="sticky">
                                <div><label>休息中</label></div>      
                            </div>
                        </div>
                        <div style="width:165px;height:70px;position:absolute;z-index:999;padding:5px;color:white;font-size:15px;font-weight:600;text-align:center;margin-top:20px;">
                            <span>
                                营业时间<br/>
                                <?php echo htmlspecialchars($item['orderbegin'], ENT_QUOTES, 'UTF-8');?>-<?php echo htmlspecialchars($item['orderend'], ENT_QUOTES, 'UTF-8');?>
                            </span>
                        </div>
                        <?php  } ?>
                            
                            <div class="hot-shops">
                                <div class="hot-shops-img">
                                    <img alt="<?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8');?>" src="<?php echo htmlspecialchars($item['imageurl'], ENT_QUOTES, 'UTF-8');?>">
                                </div>
                                <div class="hot-shops-info">
                                    <?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8');?><br/>
                                    <font class="" style="color:grey;font-size:11px"><?php echo htmlspecialchars($item['description'], ENT_QUOTES, 'UTF-8');?></font>
                                </div>
                            </div>
                        </a>
                        <div style="float:left">
                        <?php  if($item['averagespeed']) { ?>                        
                        <span class="little-font light-font">平均送餐速度
                            <?php  if($item['averagespeed']<=40) { ?>
                            <span class="delivery-time-fast"><?php echo htmlspecialchars($item['averagespeed'], ENT_QUOTES, 'UTF-8');?>分钟</span>
                            <?php  } elseif($item['averagespeed']<=60) {?>
                            <span class="delivery-time-mid"><?php echo htmlspecialchars($item['averagespeed'], ENT_QUOTES, 'UTF-8');?>分钟</span>
                            <?php  } else {?>
                            <span class="delivery-time-slow"><?php echo htmlspecialchars($item['averagespeed'], ENT_QUOTES, 'UTF-8');?>分钟</span>
                            <?php  } ?>                            
                        </span>  
                        <?php  }else{ ?>
                        <span class="little-font light-font">暂无速度点评</span>
                        <?php  } ?>                            
                        </div>
                        <div class="shop-status"><br/>
                            <a target="_blank" href="<?php echo Wekit::app()->baseUrl,'/','school-', rawurlencode($schoolId),'-4tschool-shopdetails-run-', rawurlencode($item['id']),'?app=4tschool'; ?>">
                            <div style="float:left">
                                <?php  if($schoolInfo['openorder'] == 1){ ?>
                                <span class="order-open" title="该商家支持送外卖">外</span>
                                <?php  } 
  if($schoolInfo['openorder'] == 1 && $item['isshopopen'] == 1 && $item['openorder'] == 1){ ?>
                                <span class="terminal-open" title="该商家支持在线下单">订</span>
                                <?php  } 
  if($item['ifrebate']){ ?>
                                <span class="discount" title="该商家点餐返点币">返</span>
                                <?php  } 
  if($schoolInfo['openorder'] == 1 && $item['isshopopen']==0 && $item['openorder'] == 1){ ?>
                                <span class="no-online-service" title="该商家支持送外卖">仅电话下单</span>
                                <?php  } 
  if($item['isshopopen']==0 && $item['openorder'] == 0){ ?>
                                <br/>
                                <span class="icon stop-service" title="该商家暂不提供服务">该商家暂不提供服务</span>
                                <?php  } ?>  
                            </div>
                            </a>
                                <div class="start-price" style="float:right">
                                    <a target="_blank" title="<?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8');?>" href="<?php echo Wekit::app()->baseUrl,'/','school-', rawurlencode($schoolId),'-4tschool-shopdetails-run-', rawurlencode($item['id']),'?app=4tschool'; ?>">
                                        <?php echo htmlspecialchars($item['startingprice'], ENT_QUOTES, 'UTF-8');?>元起送
                                    </a>
                                    <a style="display:none" href="<?php echo Wekit::app()->baseUrl,'/','school-', rawurlencode($schoolInfo['schoolid']),'-4tschool-shopdetails-showphone-', rawurlencode($item['id']),'?app=4tschool'; ?>" target="_blank">    
                                    <img alt="diancanyo.com - 点餐哟" width="14px" height="14px" title="商家电话" src="themes/extres/4tschool/images/Phone_page.png">
                                </a>         
                                </div>
                        </div>
                    </li>
                
                <?php }?>
                <div class="clear"></div>
            </ul>

            <ul class="all-shops" id="ul2" style="display:none">
                <?php foreach ($shopList as $key => $item) {
  if($schoolInfo['openorder'] == 1 && $item['isshopopen'] == 1 && $item['openorder'] == 1){ ?>
                    <li class=grid <?php echo htmlspecialchars($item['isopen']==1?"":"", ENT_QUOTES, 'UTF-8');?>>
                        <a target="_blank" href="<?php echo Wekit::app()->baseUrl,'/','school-', rawurlencode($schoolId),'-4tschool-shopdetails-run-', rawurlencode($item['id']),'?app=4tschool'; ?>">
                            <div class="hot-shops">
                                <div class="hot-shops-img">
                                    <img
                                    alt="<?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8');?>" src="<?php echo htmlspecialchars($item['imageurl'], ENT_QUOTES, 'UTF-8');?>">
                                </div>
                                <div class="hot-shops-info">
                                    <?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8');?><br/>
                                    <font class="" style="color:grey;font-size:11px"><?php echo htmlspecialchars($item['description'], ENT_QUOTES, 'UTF-8');?></font>
                                </div>
                            </div>
                        </a>
                        <div style="float:left">
                        <?php  if($item['averagespeed']) { ?>                        
                        <span class="little-font light-font">平均送餐速度
                            <?php  if($item['averagespeed']<=40) { ?>
                            <span class="delivery-time-fast"><?php echo htmlspecialchars($item['averagespeed'], ENT_QUOTES, 'UTF-8');?>分钟</span>
                            <?php  } elseif($item['averagespeed']<=60) {?>
                            <span class="delivery-time-mid"><?php echo htmlspecialchars($item['averagespeed'], ENT_QUOTES, 'UTF-8');?>分钟</span>
                            <?php  } else {?>
                            <span class="delivery-time-slow"><?php echo htmlspecialchars($item['averagespeed'], ENT_QUOTES, 'UTF-8');?>分钟</span>
                            <?php  } ?>                            
                        </span>  
                        <?php  }else{ ?>
                        <span class="little-font light-font">暂无速度点评</span>
                        <?php  } ?>                            
                        </div>
                        <div class="shop-status"><br/>
                            <a target="_blank" href="<?php echo Wekit::app()->baseUrl,'/','school-', rawurlencode($schoolId),'-4tschool-shopdetails-run-', rawurlencode($item['id']),'?app=4tschool'; ?>">
                            <div style="float:left">
                                
                                <?php  if($item['openorder']==1){ ?>
                                <span class="order-open" title="该商家支持送外卖">外</span>
                                <?php  } 
  if($schoolInfo['openorder'] == 1 && $item['isshopopen'] == 1 && $item['openorder'] == 1){ ?>
                                <span class="terminal-open" title="该商家支持在线下单">订</span>
                                <?php  } 
  if($item['ifrebate']){ ?>
                                <span class="discount" title="该商家点餐返点币">返</span>
                                <?php  } 
  if($schoolInfo['openorder'] == 1 && $item['isshopopen']==0 && $item['openorder'] == 1){ ?>
                                <span class="no-online-service" title="该商家支持送外卖">仅电话下单</span>
                                <?php  } 
  if($item['isshopopen']==0 && $item['openorder'] == 0){ ?>
                                <br/>
                                <span class="icon stop-service" title="该商家暂不提供服务">该商家暂不提供服务</span>
                                <?php  } ?>
                                </div>
                            </a>
                            <div class="start-price" style="float:right">
                                <a target="_blank" title="<?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8');?>" href="<?php echo Wekit::app()->baseUrl,'/','school-', rawurlencode($schoolId),'-4tschool-shopdetails-run-', rawurlencode($item['id']),'?app=4tschool'; ?>">
                                    <?php echo htmlspecialchars($item['startingprice'], ENT_QUOTES, 'UTF-8');?>元起送
                                </a>
                                <a style="display:none" href="<?php echo Wekit::app()->baseUrl,'/','school-', rawurlencode($schoolInfo['schoolid']),'-4tschool-shopdetails-showphone-', rawurlencode($item['id']),'?app=4tschool'; ?>" target="_blank">    
                                    <img alt="diancanyo.com - 点餐哟" width="14px" height="14px" title="商家电话" src="themes/extres/4tschool/images/Phone_page.png">
                                </a>    
                            </div>
                        </div>
                    </li>
                </a>
                <?php  } 
 }?>
                <div class="clear"></div>
            </ul>
        </div>
    </div>

    <div class="clear"></div>
</div>

<div class="row" style="display:<?php if(!$schoolextra['openmap']){echo 'none';} ?>">
    <div class="twelvecol">
        <div class="shops new_box">
            <div class="title">
                <h3>附近外卖商家</h3>
                <ul>
                    <li>
                        <label>
                            <input class="floatLeft shop_filter" checked="checked" type="checkbox" name="filter_for_shop" value="function(shop){return shop.openorder == '1';}" />
                            <img class="floatLeft" src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/4tschool/images/green_marker.png" width="15" height="20" />
                            <span class="floatLeft">送外卖商家</span>
                            <span class="floatLeft" id="provideDeliveryNumber"></span>
                            <div class="clear"></div>
                        </label>
                    </li>
                    <li><label>
                        <input class="floatLeft shop_filter" type="checkbox" checked="checked" name="filter_for_shop" value="function(shop){return shop.openorder != '1';}"/>
                        <img class="floatLeft" src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/4tschool/images/blue_marker.png" width="15" height="20" />
                        <span class="floatLeft">不送外卖商家</span>
                        <span class="floatLeft" id="nonprovideDeliveryNumber"></span>
                        <div class="clear"></div>
                        </label>
                    </li>
                    <li>
                        <label>
                            <img class="floatLeft" src="http://api0.map.bdimg.com/images/marker_red_sprite.png" width="39" height="35" />
                            <input type="button" onclick="ShopMap.resetCenter();void 0;" value="地图返回学校中心点" />
                        </label>
                    </li>
                    <li class="clear"></li>
                </ul>
                <span class="clear"></span>
            </div>
            <div class="clear"></div>
            <div class="new_box">
                <div id="map"></div>
            </div>
        </div>
    </div>
</div>

<?php  if(false){ ?>
<!-- 热卖推荐 -->
<div class="row">
    <div class="twelvecol">
        <div class="line">
            <div class="bbox" id="bbox">
                <h3 id="HotMerchandises">热卖推荐<span>大家都在吃！</span><span class="index-info">点餐哟，订餐！看看别人吃什么,我当订餐冠军！</span></h3>

            </div>
            <div class="recommend-shops">
                <div class="recommend-pic">
                    <ul class="new_box">
                        <?php foreach ($merchandiseList as $key => $item) {?>
                        <li>
                            <div class="recommend-merchandise">
                                <a target="_blank" href="<?php echo Wekit::app()->baseUrl,'/','school-', rawurlencode($schoolInfo['schoolid']),'-4tschool-shopdetails-run-', rawurlencode($item['shopid']),'?mid=', rawurlencode($item['id']),'&app=4tschool'; ?>">
                                    <img height="90px" width="165px" alt="<?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8');?>"
                                         src="<?php echo htmlspecialchars($item['imageurl'], ENT_QUOTES, 'UTF-8');?>">
                                </a>
                            </div>
                            <div class="recommend-name">
                                <a target="_blank" href="<?php echo Wekit::app()->baseUrl,'/','school-', rawurlencode($schoolInfo['schoolid']),'-4tschool-shopdetails-run-', rawurlencode($item['shopid']),'?mid=', rawurlencode($item['id']),'&app=4tschool'; ?>"><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8');?></a>
                            </div>
                            <div class="hot-order">
                                <span class="hot-price">￥<?php echo htmlspecialchars($item['currentprice'], ENT_QUOTES, 'UTF-8');?>/<?php echo htmlspecialchars($item['unit'], ENT_QUOTES, 'UTF-8');?></span>
                            </div>
                        </li>
                        <?php }?>

                    </ul>
                    <div class="spacer"></div>
                </div>

                <div class="recommend-text last">
                    <div class="ranking-tab new_box">
                        <p class="ranking">点餐冠军</p>
                        <ul>
                            <?php foreach ($mostOrderedPPl as $key => $item) {?>
                            <li>
                                <?php echo htmlspecialchars($item['username'], ENT_QUOTES, 'UTF-8');?>
                                <span>累计消费<?php echo htmlspecialchars($item['counttotal'], ENT_QUOTES, 'UTF-8');?>元</span>
                            </li>
                            <?php }?>
                        </ul>
                    </div>
                </div>
                 <div class="spacer"></div>
            </div>
        </div>
    </div>
</div>
<?php  if($promoMerchandiseList) { ?>
<div class="row">
    <div class="twelvecol">
        <div class="bbox">
            <h3>限时特惠<span>看的见的实惠！</span><span class="index-info">点餐哟，订餐！商家大让利,您的实惠是实实在在的实惠</span></h3>
        </div>
        <?php  foreach($promoMerchandiseList as $Item) { ?>
        <div class="step-shop-merchandises">
            <ul>
                <li>
                    <span><?php echo htmlspecialchars($Item['name'], ENT_QUOTES, 'UTF-8');?></span>
                </li>
                <li>
                    <span class="original-price"}>￥<?php echo htmlspecialchars($Item['price'], ENT_QUOTES, 'UTF-8');?></span>

                    <span>￥<?php echo htmlspecialchars($Item['currentprice'], ENT_QUOTES, 'UTF-8');?></span>

                </li>
                <li>
                    <a class="btn" target="_blank" href="<?php echo Wekit::app()->baseUrl,'/','school-', rawurlencode($schoolInfo['schoolid']),'-4tschool-shopdetails-run-', rawurlencode($Item['shopid']),'?mid=', rawurlencode($Item['id']),'&type=m&app=4tschool'; ?>">来一份</a>
                </li>
                <li>
                    <span>已售<?php echo htmlspecialchars($Item['ordercount'], ENT_QUOTES, 'UTF-8');?>份</span>
                </li>
                <li>
                    <a target="_blank" href="<?php echo Wekit::app()->baseUrl,'/','school-', rawurlencode($schoolInfo['schoolid']),'-4tschool-shopdetails-run-', rawurlencode($Item['shopid']),'?type=m&app=4tschool'; ?>"><?php echo htmlspecialchars($Item['ShopName'], ENT_QUOTES, 'UTF-8');?></a>
                </li>
                <li>
                    <span class="discount">限时特惠</span>
                </li>
            </ul>
        </div>
        <?php  } ?>
    </div>
</div>
<?php  } 
  } ?>
</div>   
<div id="backi" class="go_top"> 
    <span>Android客户端</span>
    <img src="themes/extres/4tschool/images/two_dimension_code.png"><br/><br/><br/>
    <span>微信下单</span>
    <img src="themes/extres/4tschool/images/getqrcode.jpg">
</div>  

<input type="hidden" id="ajaxUrl" value="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&a=getCurrentSchoolShops&app=4tschool'; ?>">

<div class="site-footer">
  <div class="row">
    <div class="twelvecol" id="footer">
      <div class="line new_box">
        <ul class="footer-menu">

        <li class="footer-special"><span class="footer-about">关于我们</span>
          <ul>
             <li><span class="footer-arrow"><a target="_blank"  href="index.php?m=app&app=4tschool&c=about#关于点餐哟">关于点餐哟</a></span></li>
            
            <li><span class="footer-arrow"><a target="_blank"  href="index.php?m=app&app=4tschool&c=about&a=hire#公益创业">公益创业</a></span></li>
            
            <li><span class="footer-arrow"><a target="_blank"  href="index.php?m=app&app=4tschool&c=about&a=businessjoin#商家入驻">商家入驻</a></span></li>
            
            <li><span class="footer-arrow"><a target="_blank"  href="index.php?m=app&app=4tschool&c=about&a=contactus#联系我们">联系方式</a></span></li>
           </ul>
        </li>


        <li class="footer-special"><span class="footer-about">吃饭与兼职</span>
          <ul>
             <li><span class="footer-arrow"><a target="_blank"  href="index.php?m=app&app=4tschool&c=about&a=whichorder#啥餐可点">啥餐可点</a></span></li>
            
            <li><span class="footer-arrow"><a target="_blank"  href="index.php?m=app&app=4tschool&c=about&a=money#兼职可做">兼职可做</a></span></li>
            
            <li><span class="footer-arrow"><a target="_blank"  href="index.php?m=app&app=4tschool&c=about&a=whattoexchange#免费餐品">免费餐品</a></span></li>
            
            <li><span class="footer-arrow"><a target="_blank"  href="index.php?m=app&app=4tschool&c=about&a=group#美食群组">美食群组</a></span></li>
           </ul>
        </li>

         
        <li class="footer-special"><span class="footer-about">订餐流程</span>
          <ul>
            <li><span class="footer-arrow"><a target="_blank"  href="index.php?m=app&app=4tschool&c=about&a=whycellphone#注册方法">注册方法</a></span></li>


            <li><span class="footer-arrow"><a target="_blank"  href="index.php?m=app&app=4tschool&c=about&a=howtoorder#预定美味">预定美味</a></span></li>
            
            <li><span class="footer-arrow"><a target="_blank"  href="index.php?m=app&app=4tschool&c=about&a=checkorder#订餐流程">订餐流程</a></span></li>
          </ul>
        </li>

        <li class="footer-special"><span class="footer-about">订餐送达</span>
          <ul>
            
            <li><span class="footer-arrow"><a target="_blank" href="index.php?m=app&app=4tschool&c=about&a=whyorderadvance#提前订餐">提前订餐</a></span></li>

            <li><span class="footer-arrow"><a target="_blank"  href="index.php?m=app&app=4tschool&c=about&a=orderintime#送餐时间">
            送餐时间</a></span></li>

            <li><span class="footer-arrow"><a target="_blank"  href="index.php?m=app&app=4tschool&c=about&a=helpimprove#投诉建议">投诉建议</a>
            </span ></li>

          </ul>
        </li>

        <li class="footer-special"><span class="footer-about">点餐Social</span>
          <ul>
            <li><span class="footer-arrow"><a target="_blank"  href="http://www.baidu.com/s?fr=bks0000&cl=3&wd=%B5%E3%B2%CD%D3%B4&t=5&rsv_baike=2">百度点餐</a></span></li>
            <li><span class="footer-arrow"><a target="_blank"  href="http://weibo.com/u/3846665494">@点餐哟</a></span></li>
            <li><span class="footer-arrow"><a target="_blank"  href="http://www.phpwind.net">PW论坛</a></span></li>
            <li><span class="footer-arrow"><a target="_blank"  href="index.php?m=app&app=4tschool&c=about&a=law#法律声明">法律声明</a></span></li>
          </ul>
        </li>

        </ul>
      </div>
       <div class="copyright">
        <p> 地址：江西省南昌市师范大学国家大学科技园化学楼3楼</p>
        <p>  @点餐哟由  <a href="http://www.phpwind.net" target="_blank">phpwind.net外卖平台开源技术而来</p>
        <p><a href="http://www.miibeian.gov.cn/" target="_blank">赣ICP备12002031号-3</a>&nbsp;<a href="http://www.anquan.org/s/www.diancanyo.com" name="qhleOTAGSmDExz5SK2WQN2tFqzuJlgmiMpAETkMPZXWfr0Gd73" >安全联盟</a></p>
        <a  key ="52de1bf23b05a3da0ffbaf65"  logo_size="124x47"  logo_type="official"  href="http://www.anquan.org" ><script src="http://static.anquan.org/static/outer/js/aq_auth.js"></script></a>
        <a  key ="52de1bf23b05a3da0ffbaf65"  logo_size="124x47"  logo_type="realname"  href="http://www.anquan.org" ><script src="http://static.anquan.org/static/outer/js/aq_auth.js"></script></a>
       </div>
    </div>
  </div>
</div>
<div id="oldie">
  <span class="kill-ie6">kill ie6</span>
  <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;您正在使用的IE6浏览器可能存在漏洞，超过95%的分享哟用户已经把浏览器升级到更高版本或者使用其他浏览器。</p>
  <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;为了您能正常访问分享网，请升级您的IE浏览器(<a href="http://www.microsoft.com/zh-cn/download/details.aspx?id=2">IE7</a>｜<a href="http://www.microsoft.com/zh-cn/download/details.aspx?id=43"> IE8</a>｜<a href="http://www.microsoft.com/zh-cn/download/details.aspx?id=13950">IE9</a>)，或者使用<a href="http://www.google.cn/intl/zh-CN/chrome/browser/">Google Chrome</a>｜<a href="http://www.firefox.com.cn/download/">Firefox</a>浏览器。 立刻升级吧！</p>
</div>

<script language="javascript">
function generate(information,layout) {

    var dayofNotify = getCookie('dayofnotify');

    var myDate=new Date()

    var year = myDate.getFullYear();
    var month = myDate.getMonth();
    var day = myDate.getDay();

    var yearMD = year +'-'+month+'-'+day;

    if(yearMD == dayofNotify)
        return;

    information = information + "";

    var n = noty({
        text: information,
        type: 'success',
        dismissQueue: true,
        layout: layout,
        //theme: 'defaultTheme',
         buttons: [
                    {addClass: 'btn btn-primary', text: '今天不再显示', onClick: function($noty) {
                        
                        SetCookie('dayofnotify',yearMD);
                        $noty.close();
                        
                      }
                    }
                  ]
    });
    console.log('html: '+n.options.id);
    }


</script>

<?php  if(empty($topAnn) == false) {?>
    <script language="javascript">

        generate($(".hiddenNotify").html(),"top");
    </script>
<?php  } 
  $hostname = $_SERVER['SERVER_NAME']; if($hostname == 'www.diancanyo.com') {?>
<script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F3bf15cf5566f3927e165b2d12ea5534e' type='text/javascript'%3E%3C/script%3E"));
</script>
<?php  } 
  if($schoolextra['openmap']) { ?>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=9382be6fe79b10703bff94b0fb28051a">
var ShopMap = {};
(function(){
    var map = null;
    var center = null;
    var schoolPosition = {
        lat : 115.930186, lng :28.680594
    };
    var defaultCenterByArray = [ 115.930293,28.679136 ];
    var defaultCenter = {
       lat : defaultCenterByArray[0]
       ,lng: defaultCenterByArray[1]
    };
    var defaultZoom = 17;
    this.resetCenter = function(){
        map.setCenter(center);
    };
    var filters = [];
    var provideNumbder = 0;
    var nonprovideNumber = 0;

    var updaterNumber = function(){
        $('#provideDeliveryNumber').html("("+provideNumbder+")");
        $('#nonprovideDeliveryNumber').html("("+nonprovideNumber+")");
    };
    var Shops = {};
    var isValidLatLng = function(lat,lng){
       return lat && lng && parseFloat(lat) != 0 && parseFloat(lng) != 0;
    };

    this.addShops = function(shops){
        $(shops).each(function(){
            if(Shops[this.id]) return;
            Shops[this.id] = this;
            var pos = isValidLatLng(this.latitude,this.longitude)
                        ?  {lat : this.latitude,lng:this.longitude}
                        : testShops[this.name];
            var deliveryRanges = [];

            for(var i = 0; i < this.deliverytime.length; ++i){
               deliveryRanges[i] = {
                   start : this.deliverytime[i].begintime
                   , end: this.deliverytime[i].endtime
               };
            }
            var conf = {
                title: this.name
                ,id : this.id
                ,info : {
                    phoneNumber : this.phonenumber
                    ,deliveryRanges :deliveryRanges
                    ,startingprice : this.startingprice || null
                }
            };
            if(pos){
                var marker = null;
                if(this.openorder==1){
                    marker = ShopMap.addGreenMarker(pos.lat,pos.lng,conf);
                    ++provideNumbder;
                }else{
                    marker = ShopMap.addBlueMarker(pos.lat,pos.lng,conf);
                    ++nonprovideNumber;
                }
                this.marker = marker;
            }else{
                console.log(this.name + "缺少经纬度");
            }
        });
        updaterNumber();
        onFilterChange();
    };

    function isPassFilter(shop){
       var isPass = false;
       $(filters).each(function(){
            if(this != null && $.isFunction(this)){
               if(this(shop)){
                 isPass = true;
                 return false;
               }
            }
            return true;
       });
       return isPass;
    }
    var onFilterChange= function(){
        $.each(Shops,function(key,shop){
            if(!shop.marker)return;
            var marker = shop.marker;
            if(!isPassFilter(shop)){
                marker.getMap() &&  map.removeOverlay(marker);
            }else{
                marker.getMap() || map.addOverlay(marker);
            }
        });
    };
    function execBy(str){
       return eval('(' + str + ')');
    }
    this.InitShopsMap = function(element,callback){
        if(map!=null)return;
        $(".shop_filter").each(function(){
            this.filterId = filters.length;
            filters.push($(this).is(':checked') ? execBy(this.value) : null);
            $(this).click(function(){
                filters[this.filterId] = $(this).is(':checked') ? execBy(this.value) : null;
                onFilterChange();
            });
        });

        //region
        center = new BMap.Point(defaultCenter.lat,defaultCenter.lng);
        var mapOption = {
            mapType:BMAP_NORMAL_MAP,
            maxZoom:19,
            drawMargin:0,
            enableFulltimeSpotClick: true,
            enableHighResolution:true,
            enableMapClick : false
        };
        map = new BMap.Map(element,mapOption);
        map.addControl(new BMap.NavigationControl());
        map.centerAndZoom(center,defaultZoom);
        this.addMarker(schoolPosition.lat,schoolPosition.lng);
        callback();
        //endregion
    };

    function makeInfoHtml(info){
        var content = "";
        if(info.startingprice > 0){
            content += "<p>起送价格:"+info.startingprice+"(元)</p>";
        }else{
            content += "<p>不送外卖</p>";
        }
        if(info.deliveryRanges && info.deliveryRanges.length && info.deliveryRanges.length > 0){
            content += "<p>外卖时段:<br/>";
            var glue = "";
            for(var i = 0; i < info.deliveryRanges.length; ++i){
                var r = info.deliveryRanges[i];
                content += glue + "<span>"+ r.start + "-" + r.end+"</span>";
                glue = "<br/>";
            }
            content += "</p>";
        }
        return content;
    }

    /**
     * 添加marker
     * @param lat
     * @param lng
     * @param opt
     */
    this.addMarker = function(lat,lng,opt){
        var point = new BMap.Point(lat,lng);
        var marker =  new BMap.Marker(point,opt);
        if(opt && opt.info){
            marker.info = "<strong><a target='_blank' href='"+GV.URL.SHOP_DETAIL + opt.id+"'>"+opt.title+"</a></strong><a style='font-size:smaller;margin-left:5px;text-decoration:underline;'  target='_blank' href='"+GV.URL.SHOP_DETAIL+opt.id+"'>(菜单和电话)</a>";
            marker.info += makeInfoHtml(opt.info);
            marker.addEventListener("click",function(){
                this.openInfoWindow(new BMap.InfoWindow(
                    this.info
                    ,{enableMessage : false}
                ));
            });
        }
        marker.addEventListener("mouseover",function(){
            this.setTop(true);
        });
        marker.addEventListener("mouseout",function(){
            this.setTop(false);
        });
        map.addOverlay(marker);
        return marker;
    };

    this.addGreenMarker = function(lat,lng,conf){
        var info  = conf || {};
        info.icon = this.getGreenMarkerIcon();
        return this.addMarker(lat,lng,info);
    };
    this.addBlueMarker = function(lat,lng,conf){
        var info  = conf || {};
        info.icon = this.getBlueMarkerIcon();
        return this.addMarker(lat,lng,info);
    };
    this.getGreenMarkerIcon = function(){
        return this.getMarkerIcon("green_marker.png",15,20);
    };
    this.getBlueMarkerIcon = function(){
        return this.getMarkerIcon("blue_marker.png",15,20);
    };
    this.getMarkerIcon = function(image,width,height){
      return new BMap.Icon(GV.theme.getImageUrl(image),new BMap.Size(width,arguments[2]||width),{
          imageSize : new BMap.Size(width,arguments[2]||width)
      });
    };
}).call(ShopMap);

$(function(){
    ShopMap.InitShopsMap('map',fetchShopList);
});

var testShops = {
    //  '大食头' :{ lat: 115.930383,lng: 28.677996},
    //  '清清餐厅' : { lat: 115.930423,lng: 28.678031},
    //  '济之岛':{ lat:115.93041,lng:28.678079},
    //'一品轩':{ lat:115.930405,lng:28.678182},
    //'港饮派对':{ lat:115.930145,lng:28.679873},
    //'浏阳蒸菜':{lat:115.930967,lng:28.685704}
};

function fetchShopList(){
    var postUrl = $("#ajaxUrl").val();
    $.post(postUrl,{"ispartner":1,csrf_token: GV['TOKEN']},function(r) {
        var shops = $.parseJSON(r);
        ShopMap.addShops(shops);
        // [{"id":"28","userid":"0"
        // ,"name":"\u8001\u5e08\u5927\u987a\u5e26"
        // ,"address":"\u5206\u4eab\u54df\u8ba2\u9910"
        // ,"areaid":"25","phonenumber":"18679187590"
        // ,"contactnumber":"","openorder":"1","packingprice":"0.0"
        // ,"deliveryprice":"0.0","orderbegin":"09:30:00","orderend":"18:30:00"
        // ,"createdate":"1370337343","lastupdatetime":"1379835121"
        // ,"description":"\u4e0d\u52a0\u4ef7\u987a\u5e26\uff1a\u996e\u6599\uff0c\u96f6\u98df\uff0c\u9999\u70df\uff0c\u6c34\u679c...."
        // ,"ordercount":"165","imageurl":"http:\/\/localhost\/src\/extensions\/4tschool\/uploaded_images\/28\/shop_28.png"
        // ,"isactive":"1","ispartner":"1"
        // ,"hasterminal":"0","averagemakeorder":"0.0"
        // ,"averagebakeout":"0.0","averagetocenter":"0.0"
        // ,"averagedelivery":"0.0","actualmakeorder":"0.0","actualbakeout":"0.0"
        // ,"actualtocenter":"0.0","actualdelivery":"0.0","commentcount":"0","isopen":true}]
    });
}    
</script>
<?php  } ?>
</body>
</html>