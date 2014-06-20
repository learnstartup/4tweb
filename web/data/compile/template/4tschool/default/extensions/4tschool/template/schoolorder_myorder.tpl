<!DOCTYPE html>
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

.alert {
padding: 8px 35px 8px 14px;
margin-top: 10px;
margin-bottom: 10px;
text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
background-color: #fcf8e3;
border: 1px solid #fbeed5;
-webkit-border-radius: 4px;
-moz-border-radius: 4px;
border-radius: 4px;
}

.alert, .alert h4 {
color: #c09853;
}

.alert-info {
background-color:#FF6600;
color:#FFFFFF;
border-color: #bce8f1;
}

.close {
float: right;
font-size: 20px;
font-weight: bold;
line-height: 20px;
color: #000000;
text-shadow: 0 1px 0 #ffffff;
opacity: 0.2;
filter: alpha(opacity=20);
}

button.close {
padding: 0;
cursor: pointer;
background: transparent;
border: 0;
-webkit-appearance: none;
}

.alert .close {
position: relative;
top: -2px;
right: -21px;
line-height: 20px;
}

.returnMsg{	
	text-align: center;
	display: block;
	font-size: 14px;
	padding: 0 3px;                    
}

</style>
<div class="clear"></div>
<div class="wrapper line new_box new_bg">
	<div class="mydnew_sidel" style="background-color:white">

<?php foreach ($myMenus as $key => $item) {?>
<div class="mydnew_sidel_title">
	<h3><?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8');?></h3>
</div>
<ul class="my_content">
	 <?php foreach ($item as $eachkey => $eachMenu) {?>
		<li><a class="<?php echo htmlspecialchars($eachMenu['name'] == $selectedMenu?'current':'', ENT_QUOTES, 'UTF-8');?>" href="<?php echo htmlspecialchars($eachMenu['link'], ENT_QUOTES, 'UTF-8');?>&schoolid=<?php echo htmlspecialchars($schoolId, ENT_QUOTES, 'UTF-8');?>" >
			<?php echo htmlspecialchars($eachMenu['name'], ENT_QUOTES, 'UTF-8');?><font style="color:red;font-weight:bolder"><?php if($eachMenu['name'] == '待评价'){echo '('.$countNoComment.')';}?></font>
			<?php  if($eachMenu['isnew']){ ?>
			<span class="order-open" style="font-size:10px">New</span>
			<?php  } ?>			
		</a>
		</li>
	<?php }?>
</ul>

<?php }?>
</div>

	<div class="centersidebar" id="orderList">
	<div class="myddorder_tab"><a class="current"><span><?php echo htmlspecialchars($subtitle, ENT_QUOTES, 'UTF-8');?></span></a>
		<span style="color:red">请仔细查看订单列表，确保未分配的订单已被及时处理，谢谢</span>
		<div class="clear"></div>
	</div>
	<form action="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&c=schoolorder&a=myorder&app=4tschool'; ?>" id="schoolordersForm" method="post">
	<input type="hidden" class="pageurl" name="pageurl" value="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&c=schoolorder&a=myorder&app=4tschool'; ?>">
	<?php  if ('' !=$message) { ?>
		<div class="alert alert-info" style="display:none">
              <button type="button" class="close closeInfo" data-dismiss="alert">×</button>
              <span class="returnMsg"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8');?></span>
        </div>
	<?php  } ?>
	<div class="myddorder_search clearfix">
		<div class="time_box">
			<select id="o_time" style="z-index:0;" class="choosenDaterange" name="choosenDaterange">
				<?php foreach($orderRange as $key => $value) {?>
				<option 
					<?php if($key == $choosenDaterangeid) echo "selected"; ?> value="<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8');?>" ><?php echo htmlspecialchars($value, ENT_QUOTES, 'UTF-8');?>
				</option>
				<?php }?>
			</select>

			<select id="o_status" style="z-index:0;" class="choosenStatusCategory" name="choosenStatusCategory">
				<?php foreach($orderStatusCategory as $key => $value) {?>
				<option 
					<?php if($key == $choosenStatusCategoryid) echo "selected"; ?> value="<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8');?>" ><?php echo htmlspecialchars($value, ENT_QUOTES, 'UTF-8');?>
				</option>
			<?php }?>
			</select>

			<select id="o_cassign" style="z-index:0;" class="cassignstatus" name="cassignstatus">
				<option <?php if(0 == $cassignstatus) echo "selected"; ?>  value='0'>分配状态</option>
				<option 
					<?php if(-1 == $cassignstatus) echo "selected"; ?> value="-1" >未分配接管人员
				</option>
				<option 
					<?php if(1 == $cassignstatus) echo "selected"; ?> value="1" >已分配接管人员
				</option>
			</select>
			
		</div>
		<div class="myddorder_inquiry">
			<input id="searchKey" class="text gray" style="width: 130px;" type="text" value="<?php echo htmlspecialchars($searchTxt==''?'订单号、收货人姓名':$searchTxt, ENT_QUOTES, 'UTF-8');?>">
			<input type="submit" id="searchBtn" class="btn_search" value="查询">
		</div>
	</div>
	
	<div class="clear"></div>

	<?php include("F:\\company\\Project\\GIT\\4tweb\\web\\data\\compile/template/4tschool/default/extensions/4tschool/template/orderlist.tpl"); 
 $__tplPageCount=(int)$count;
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
	<a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&c=schoolorder&a=myorder&page=', rawurlencode($_page_i),'&app=4tschool'; 
 echo htmlspecialchars($args ? '&' . http_build_query($args) : '', ENT_QUOTES, 'UTF-8');?>" class="pages_pre J_pages_pre">&laquo;&nbsp;上一页</a>
	<?php  if ($_page_min > 1) { 
		$_page_i = 1;		
	?>
	<a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&c=schoolorder&a=myorder&page=', rawurlencode($_page_i),'&app=4tschool'; 
 echo htmlspecialchars($args ? '&' . http_build_query($args) : '', ENT_QUOTES, 'UTF-8');?>">1...</a>
	<?php  } 
  for ($_page_i = $_page_min; $_page_i < $__tplPageCurrent; $_page_i++) { 
	?>
	<a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&c=schoolorder&a=myorder&page=', rawurlencode($_page_i),'&app=4tschool'; 
 echo htmlspecialchars($args ? '&' . http_build_query($args) : '', ENT_QUOTES, 'UTF-8');?>"><?php echo htmlspecialchars($_page_i, ENT_QUOTES, 'UTF-8');?></a>
	<?php  } 
  } ?>
	<strong><?php echo htmlspecialchars($__tplPageCurrent, ENT_QUOTES, 'UTF-8');?></strong>
<?php  if ($__tplPageCurrent < $_page_max) { 
  for ($_page_i = $__tplPageCurrent+1; $_page_i <= $_page_max; $_page_i++) { 
	?>
	<a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&c=schoolorder&a=myorder&page=', rawurlencode($_page_i),'&app=4tschool'; 
 echo htmlspecialchars($args ? '&' . http_build_query($args) : '', ENT_QUOTES, 'UTF-8');?>"><?php echo htmlspecialchars($_page_i, ENT_QUOTES, 'UTF-8');?></a>
	<?php  } 
  if ($_page_max < $__tplPageTotal) { 
		$_page_i = $__tplPageTotal;
	?>
	<a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&c=schoolorder&a=myorder&page=', rawurlencode($_page_i),'&app=4tschool'; 
 echo htmlspecialchars($args ? '&' . http_build_query($args) : '', ENT_QUOTES, 'UTF-8');?>">...<?php echo htmlspecialchars($__tplPageTotal, ENT_QUOTES, 'UTF-8');?></a>
	<?php  }
		$_page_i = $__tplPageCurrent+1;
	?>
	<a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&c=schoolorder&a=myorder&page=', rawurlencode($_page_i),'&app=4tschool'; 
 echo htmlspecialchars($args ? '&' . http_build_query($args) : '', ENT_QUOTES, 'UTF-8');?>" class="pages_next J_pages_next">下一页&nbsp;&raquo;</a>
<?php  } ?>
</div>
<?php } ?>
	<div class="spacer"></div>
<input type="hidden" name="csrf_token" value="<?php echo WindSecurity::escapeHTML(Wind::getComponent('windToken')->saveToken('csrf_token')); ?>"/></form>
</div>
</div>
<div class="clear"></div>
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
<?php  } ?>




<script>
$(function () {
    if($(".alert-info").length==1)
    {
        $(".alert-info").toggle('normal');
    }        
});
Wind.use('jquery', 'global', 'ajaxForm', 'dialog', function(){

	$(".closeInfo").click(function(event)
	{
		$(".alert-info").toggle('normal');
		event.preventDefault();
	});

	$(".assignSingle").click(function(event)
	{
		//get the itemid and get the people in this school, then assign
		$(".assignDelivery").show();
		var liElement = $(this).parent().parent();
		var checkBoxInRow = $(liElement).find('.checkSingle')[0];
		if(checkBoxInRow)
			$(checkBoxInRow).attr("checked","checked");

		event.preventDefault();

	});

	//get checked items
	function getCheckedItems()
	{
		var checkedItems =new Array()
		$(".checkSingle").each(function(i,item)
		{
			var checked = $(item).attr("checked");
			if(checked == "checked")
			{
				var itemId = $(item).attr('name');
				checkedItems.push(itemId);

			}
		});

		return checkedItems;
	}
	
	//check and show ppl to assign
	$('.checkSingle').click(function(event)
	{
		var currentchecked = $(this).attr("checked");
		if(currentchecked == "checked")
		{
			$(".assignDelivery").show();
		}

		var allChecked = true;
		$(".checkSingle").each(function(i,item)
		{
			var checked = $(item).attr("checked");
			if(checked != "checked")
			{
				allChecked = false;
			}
		});

	});

	//focus to clear
	$("#searchKey").focus(function(event)
	{
		$(this).val('');
	});

	//change date range
	$(".choosenDaterange").change(function(event){
		searchPage();
	});

	//change status of order
	$(".choosenStatusCategory").change(function(event){
		searchPage();
	});

	//input and search
	$(".btn_search").click(function(event)
	{
		event.preventDefault();
		searchPage();
	});

	//school area chane
	$(".carea").change(function(event)
	{
		searchPage();
	});


	//school area chane
	$(".cassignstatus").change(function(event)
	{
		searchPage();
	});

	//post data and search
	function searchPage()
	{
		var choosenDateRange = $(".choosenDaterange").val();
		var choosenStatusCategory = $(".choosenStatusCategory").val();
		var searchTxt = $('#searchKey').val();
		var schoolArea = $(".carea").val();
		var cassignstatus = $(".cassignstatus").val();

		var dateRangeUrl = "&choosenDaterange=" + choosenDateRange;
		var statusCategoryRangeUrl = "&choosenStatusCategory=" + choosenStatusCategory;
		var searchUrl = "&searchTxt=" + searchTxt;
		var areaUrl = "";
		var assignStatusUrl = "&cassignstatus=" + cassignstatus;

		window.location.href = $(".pageurl").val() + dateRangeUrl + statusCategoryRangeUrl + searchUrl + areaUrl + assignStatusUrl; 
	}

});
</script>