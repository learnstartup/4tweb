<!doctype html>
<html dir="ltr" lang="zh-CN" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!-- saved from url=(0022)http://www.fenxiangyo.com/ -->
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

    <link rel="stylesheet" href="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/4tschool/css/jcart.css" type="text/css" media="screen">
    <link href="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/4tschool/css/jquery-ui-1.10.3.custom.css" rel="stylesheet">
    <!--<script type="text/javascript" src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/4tschool/js/jquery-1.9.1.js"></script>-->
    <!--<script type="text/javascript" src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/4tschool/js/jquery-ui-1.10.3.custom.js"></script>-->
    <script type="text/javascript" src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/4tschool/js/jcart.js"></script>

    <?php  if($schoolInfo['openshundai'] == 0 ) {?>
    <style>
        .step-content, .setp-banner, .step-shop-menu {
            width:890px;
        }
        html,body{
            width:100%;
            height:100%;
        }        
    </style>
    <?php  } ?>
</head>
<body>
<div class="clear"></div>
<div class="wrap-sd">
<div class="sdrow">
<div class="twelvecol" style="width:<?php if($addheaderlong){echo '890px';} ?>">
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
<div id="wrapper" class="twelvecol" style="width:75%">
<?php  if($schoolInfo['openshundai'] == 1 && $openshundai == 1) {?>
<div class="step-left">
    <div class="step-incidentally-header"><a>顺带</a></div>
    <div id="accordion">
        <?php  foreach ($incidentallyTagList as $tagItem) { ?>
        <h3><?php echo htmlspecialchars($tagItem['name'], ENT_QUOTES, 'UTF-8');?></h3>

        <div>
            <?php  foreach ($incidentallyMerchandiseList as $item) {
  if ($item['tagid']==$tagItem['id']) { ?>
            <div class="step-incidentally-menu">
                <form class="jcart" action="" method="post">
                     <?php  if($shop['openorder'] == 1) {?>
                    <input type="hidden" value="<?php echo htmlspecialchars($item['id'], ENT_QUOTES, 'UTF-8');?>" name="my-item-id">
                    <input type="hidden" value="<?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8');?>" name="my-item-name">
                    <input type="hidden" value="<?php echo htmlspecialchars($item['currentprice'], ENT_QUOTES, 'UTF-8');?>" name="my-item-price">
                    <input type="hidden" value="1" name="my-item-qty">
                    <input type="hidden" value="<?php echo htmlspecialchars($IncidentallyShopId, ENT_QUOTES, 'UTF-8');?>" name="my-vendor-guid">
                    <input type="hidden" value='顺带' name="my-vendor-name">
                    <input type="hidden" value="1" name="my-box-qty">
                    <input type="hidden" value="1" name="my-box-unitprice">
                    <input type="hidden" value="<?php echo htmlspecialchars($item['unit'], ENT_QUOTES, 'UTF-8');?>" name="my-unitname">
                    <input type="hidden" value="<?php echo htmlspecialchars($item['needPackingPrice'], ENT_QUOTES, 'UTF-8');?>" name="my-needPackingPrice">
                    <input type="hidden" value="<?php echo htmlspecialchars($item['startingprice']==''?0:$item['startingprice'], ENT_QUOTES, 'UTF-8');?>" name="my-startingprice">
                    <input type="hidden"
                           value="<?php echo Wekit::app()->baseUrl,'/','school-', rawurlencode($schoolInfo['schoolid']),'-4tschool-shopdetails-run-', rawurlencode($shop['id']),'?app=4tschool'; ?>"
                           name="my-item-url">
                    <input type="hidden" name="jcartToken"
                           value="<?php echo $_SESSION['jcartToken'];?>"/>
                    <?php  } ?>

                    <div class="s-left">
                        <span><a target="_blank" href="<?php echo Wekit::app()->baseUrl,'/','school-', rawurlencode($schoolInfo['schoolid']),'-4tschool-shopdetails-', rawurlencode($shop['id']),'-mid-', rawurlencode($item['id']),'?app=4tschool'; ?>" style="display:inline"><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8');?></a></span>
                    </div>
                    <div class="s-right">
                        <span>￥<?php echo htmlspecialchars($item['currentprice'], ENT_QUOTES, 'UTF-8');?>/<?php echo htmlspecialchars($item['unit'], ENT_QUOTES, 'UTF-8');?></span>

                        <a target="_blank" class="btn" href="<?php echo Wekit::app()->baseUrl,'/','school-', rawurlencode($schoolInfo['schoolid']),'-4tschool-shopdetails-', rawurlencode($shop['id']),'-mid-', rawurlencode($item['id']),'?app=4tschool'; ?>" style="display:inline">详情</a>

                        <?php  if($shop['openorder'] == 1) {
  if($item['remainder'] > 0) { ?>

                        <input class="btn" type="submit" value="来一份" name="my-add-button">
                        <?php  } else { ?>
                                    <input type="submit" value="缺货" disabled="disabled">
                        <?php  } 
  } ?>
                    </div>
                <input type="hidden" name="csrf_token" value="<?php echo WindSecurity::escapeHTML(Wind::getComponent('windToken')->saveToken('csrf_token')); ?>"/></form>
            </div>
            <?php  } 
  } ?>
        </div>
        <?php  } ?>
    </div>
    
</div>
<?php  } ?>

<div class="step-content">
    <div class="my-step-left">
        <div class="step-fenge">
            <div class="setp-banner">
                <ul class="step-shop-left">
                    <li class="step-title">
						<span>
                            <?php echo htmlspecialchars($shop['name'], ENT_QUOTES, 'UTF-8');?>
                        </span>
                        <?php  if($shop['averagespeed']) { ?>                        
                        <span class="little-font light-font">平均送餐速度
                            <?php  if($shop['averagespeed']<=40) { ?>
                            <span class="delivery-time-fast"><?php echo htmlspecialchars($shop['averagespeed'], ENT_QUOTES, 'UTF-8');?>分钟</span>
                            <?php  } elseif($shop['averagespeed']<=60) {?>
                            <span class="delivery-time-mid"><?php echo htmlspecialchars($shop['averagespeed'], ENT_QUOTES, 'UTF-8');?>分钟</span>
                            <?php  } else {?>
                            <span class="delivery-time-slow"><?php echo htmlspecialchars($shop['averagespeed'], ENT_QUOTES, 'UTF-8');?>分钟</span>
                            <?php  } ?>                            
                        </span>  
                        <?php  }else{ ?>
                        <span class="little-font light-font">该商家暂无人点评送餐速度</span>
                        <?php  } 
  if($schoolInfo['openorder'] == 1){ ?>
                                <span class="order-open" title="该商家支持送外卖">外</span>
                                <?php  } 
  if($schoolInfo['openorder'] == 1 && $shop['isshopopen'] == 1 && $shop['openorder'] == 1){ ?>
                                <span class="terminal-open" title="该商家支持在线下单">订</span>
                                <?php  } 
  if($shop['ifrebate']){ ?>
                                <span class="discount" title="该商家点餐返点币">返</span>
                                <?php  } 
  if($schoolInfo['openorder'] == 1 && $shop['isshopopen']==0 && $shop['openorder'] == 1){ ?>
                                <span class="no-online-service" title="该商家支持送外卖">仅电话下单</span>
                                <?php  } 
  if($shop['isshopopen']==0 && $shop['openorder'] == 0){ ?>
                                <br/>
                                <span class="icon stop-service" title="该商家暂不提供服务">该商家暂不提供服务</span>
                                <?php  } ?>                                                     
                    </li>
                   
                   <li>电话：
                    <?php  if(!empty($shop['phonenumber']) && $shop['phonenumber'] != '无') {
 echo htmlspecialchars($shop['phonenumber'], ENT_QUOTES, 'UTF-8');
  } ?> 
                     &nbsp;
                     <?php  if(!empty($shop['contactnumber']) && $shop['contactnumber'] != '无') {
 echo htmlspecialchars($shop['contactnumber'], ENT_QUOTES, 'UTF-8');
  } ?> 
                     
                   </li>

                   <?php  if(!empty($timeList)) {?>
                    <li>外卖时间:
                        <?php  foreach($timeList as $mkey => $item) { ?>
                            <!--<?php echo "<br/>"; ?>-->
                            <?php echo htmlspecialchars($item['begintime'], ENT_QUOTES, 'UTF-8');?> - <?php echo htmlspecialchars($item['endtime'], ENT_QUOTES, 'UTF-8');
  } ?> 
                    </li>

                    <?php  } ?>
                    <li>备注：<?php echo htmlspecialchars($shop['description'], ENT_QUOTES, 'UTF-8');?></li>
                    <li>地址：<?php echo htmlspecialchars($shop['address'], ENT_QUOTES, 'UTF-8');?></li>
                    <li><!-- JiaThis Button BEGIN -->
<div class="jiathis_style"><span class="jiathis_txt">分享到：</span>
<a class="jiathis_button_qzone"></a>
<a class="jiathis_button_tsina"></a>
<a class="jiathis_button_weixin"></a>
<a class="jiathis_button_renren"></a>
<a class="jiathis_button_fav"></a>
<a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jiathis_separator jtico jtico_jiathis" target="_blank"></a>
<a class="jiathis_counter_style"></a>
</div>
<script type="text/javascript" >
var jiathis_config={
    summary:"嗯, 对,这个符合我的口味,还省钱",
    title:"在点餐哟发现我喜欢的店:)",
    shortUrl:true,
    hideMore:false
}
</script>
<script type="text/javascript" src="http://v3.jiathis.com/code/jia.js" charset="utf-8"></script>
<!-- JiaThis Button END -->
</li>
                </ul>
                <ul class="step-shop-right">
                    <li style="padding-right:100px;" class="step-notice-open"><b><?php echo htmlspecialchars($shop['openorder']==0?'此商家不送外卖':"此商家送外卖", ENT_QUOTES, 'UTF-8');
  if($schoolInfo['openorder'] == 1 && $shop['isshopopen'] == 1 && $shop['openorder']) {?>
                        ,支持在线下单

                     <?php  } ?> 
                    </b></li>

                    <?php  if($shop['openorder'] == 1) {?>
                    <li>起送金额：<font color="#FF4400"><?php echo htmlspecialchars($shop['startingprice'], ENT_QUOTES, 'UTF-8');?>元</font>
                        <a href="<?php echo Wekit::app()->baseUrl,'/','school-', rawurlencode($schoolInfo['schoolid']),'-4tschool-shopdetails-showphone-', rawurlencode($shop['id']),'?app=4tschool'; ?>" target="_blank">
                            <img alt="diancanyo.com - 点餐哟" width="20px" height="20px" title='商家电话' src="themes/extres/4tschool/images/Phone_page.png">
                        </a>
                    </li>

                    <li>外卖打包费：每份<font color="#FF4400"><?php echo htmlspecialchars($shop['packingprice'] + $shop['deliveryprice'], ENT_QUOTES, 'UTF-8');?></font>元(注: 商家行为)</li>

                    <?php  } ?> 


                    <li>店铺人气：<a id="shop_favorites_count"><?php echo htmlspecialchars($shop['ordercount'], ENT_QUOTES, 'UTF-8');?></a>
                    </li>
                    <li>
                        <div id="marked" style="display: <?php echo htmlspecialchars($isFavorite?'block':'none', ENT_QUOTES, 'UTF-8');?>">
                            <font color="#FF4400"><span>[已收藏]</span></font>
                        </div>
                        <div id="mark" style="display: <?php echo htmlspecialchars($isFavorite?'none':'block', ENT_QUOTES, 'UTF-8');?>">
                            <a id="add_favorites" href="<?php echo htmlspecialchars($userId, ENT_QUOTES, 'UTF-8');?>">[点击收藏]</a>

                            <form action="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&c=Shopdetails&a=myFavorite&app=4tschool'; ?>" id="schoolordersForm"
                                  method="post">
                                <input type="hidden" name="shopId" value="<?php echo htmlspecialchars($shop['id'], ENT_QUOTES, 'UTF-8');?>">
                                <input type="hidden" class="bookmarkShopUrl" name="bookmarkShopUrl"
                                       value="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&c=shopdetails&a=myFavorite&app=4tschool'; ?>">
                            <input type="hidden" name="csrf_token" value="<?php echo WindSecurity::escapeHTML(Wind::getComponent('windToken')->saveToken('csrf_token')); ?>"/></form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="clear">
            <input id="addToCart" type="hidden" value="<?php echo htmlspecialchars($cartMid, ENT_QUOTES, 'UTF-8');?>">
        </div>
        <?php  if(!empty($hotMerchandiseList)) {?>
        <div class="step-sign">
            <p class="site-title">热卖美食</p>
            <div id="special-food" style="width: 648px; overflow: hidden;">
                <div style="overflow: hidden; width: 32766px;">
                    <div style="float: left;">
                        <?php  foreach($hotMerchandiseList as $mkey => $item) { ?>
                        <div class="top-4">
                            <form class="jcart" action="" method="post">
                                <?php  if($shop['openorder'] == 1) {?>
                                <input type="hidden" value="<?php echo htmlspecialchars($item['id'], ENT_QUOTES, 'UTF-8');?>"
                                       name="my-item-id">
                                <input type="hidden" value="<?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8');?>" name="my-item-name">
                                <input type="hidden" value="<?php echo htmlspecialchars($item['currentprice'], ENT_QUOTES, 'UTF-8');?>" name="my-item-price">
                                <input type="hidden" value="1" name="my-item-qty">
                                <input type="hidden" value="<?php echo htmlspecialchars($item['dmoney'], ENT_QUOTES, 'UTF-8');?>" name="my-item-dmoney">
                                <input type="hidden" value="<?php echo htmlspecialchars($shop['id'], ENT_QUOTES, 'UTF-8');?>"
                                       name="my-vendor-guid">
                                <input type="hidden" value="<?php echo htmlspecialchars($shop['name'], ENT_QUOTES, 'UTF-8');?>" name="my-vendor-name">
                                <input type="hidden" value="1" name="my-box-qty">
                                <input type="hidden" value="1" name="my-box-unitprice">
                                <input type="hidden" value="<?php echo htmlspecialchars($item['shoppromoid'], ENT_QUOTES, 'UTF-8');?>" name="my-promo">
                                <input type="hidden" value="<?php echo htmlspecialchars($item['startingprice']==''?0:$item['startingprice'], ENT_QUOTES, 'UTF-8');?>" name="my-startingprice">
                                <input type="hidden"
                                       value="<?php echo Wekit::app()->baseUrl,'/','school-', rawurlencode($schoolInfo['schoolid']),'-4tschool-shopdetails-run-', rawurlencode($shop['id']),'?app=4tschool'; ?>"
                                       name="my-item-url">
                                <input type="hidden" value="<?php echo htmlspecialchars($item['needPackingPrice'], ENT_QUOTES, 'UTF-8');?>" name="my-needPackingPrice">
                                <input type="hidden" name="jcartToken"
                                       value="<?php echo $_SESSION['jcartToken'];?>"/>

                                <?php  } ?>
                                 <img width="135px" height="100px" src=<?php echo htmlspecialchars($item['imageurl'], ENT_QUOTES, 'UTF-8');?>>
                                <div style="width:100%">
                                    <a target="_blank" title="<?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8');?>" href="<?php echo Wekit::app()->baseUrl,'/','school-', rawurlencode($schoolInfo['schoolid']),'-4tschool-shopdetails-', rawurlencode($shop['id']),'-mid-', rawurlencode($item['id']),'?app=4tschool'; ?>" style="display:inline"><?php echo htmlspecialchars($item['substrname'], ENT_QUOTES, 'UTF-8');?>...</a></div>
                                <div style="width:100%">
                                    ￥<?php echo htmlspecialchars($item['currentprice'], ENT_QUOTES, 'UTF-8');?>/<?php echo htmlspecialchars($item['unit'], ENT_QUOTES, 'UTF-8');
  if($shop['openorder'] == 1 && $schoolInfo['openorder'] == 1 && $item['isshopopen'] == 1) {
  if($item['remainder'] > 0) { ?>
                                    <input class="btn" type="submit" value="来一份" name="my-add-button">
                                    <?php  } else { ?>
                                    <input type="submit" value="缺货" disabled="disabled">
                                    <?php  } 
  } ?>
                                </div>
                            <input type="hidden" name="csrf_token" value="<?php echo WindSecurity::escapeHTML(Wind::getComponent('windToken')->saveToken('csrf_token')); ?>"/></form>
                        </div>
                        <?php if($mkey==3)break;
  } ?>
                    </div>
                </div>
            </div>
        </div>
        <?php  } ?>

        <div class="clear"></div>
        <div id="catab" class="step-tab">
            <p class="site-title">菜品分类</p>
            <ul>
                <?php  foreach($tagList as $key => $item) { ?>
                <li><span class="<?php echo htmlspecialchars($item==$defaultSelected?'ctgmenu ctgactive':'ctgmenu', ENT_QUOTES, 'UTF-8');?>"
                          curindex=<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8');?>><?php echo htmlspecialchars($item, ENT_QUOTES, 'UTF-8');?></span>
                </li>
                <?php }?>
            </ul>
        </div>
        <div class="clear"></div>

        <ul class="step-shop-list">
            <li>
                <ul>
                    <?php  foreach($tagList as $tkey => $item) { ?>
                    <li style=" display: <?php echo htmlspecialchars($item==$defaultSelected?'block':'none', ENT_QUOTES, 'UTF-8');?>" id="list<?php echo htmlspecialchars($tkey, ENT_QUOTES, 'UTF-8');?>"
                        class="li-first">
                        <?php  foreach($merchandiseList as $mkey => $item) { 
  if($item['tagid']==$tkey) { ?>
                        <div id="<?php echo htmlspecialchars($item['id']==$mid?"m$mid":"", ENT_QUOTES, 'UTF-8');?>" class="<?php echo htmlspecialchars($item['id']==$mid?"step-shop-menu selected":"step-shop-menu", ENT_QUOTES, 'UTF-8');?>">
                            <form class="jcart" action="" method="post">
                                <?php  if($shop['openorder'] == 1) {?>
                                <input type="hidden" value="<?php echo htmlspecialchars($item['id'], ENT_QUOTES, 'UTF-8');?>" name="my-item-id">
                                <input type="hidden" value="<?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8');?>" name="my-item-name">
                                <input type="hidden" value="<?php echo htmlspecialchars($item['currentprice'], ENT_QUOTES, 'UTF-8');?>" name="my-item-price">
                                <input type="hidden" value="1" name="my-item-qty">
                                <input type="hidden" value="<?php echo htmlspecialchars($item['dmoney'], ENT_QUOTES, 'UTF-8');?>" name="my-item-dmoney">
                                <input type="hidden" value="<?php echo htmlspecialchars($shop['id'], ENT_QUOTES, 'UTF-8');?>" name="my-vendor-guid">
                                <input type="hidden" value="<?php echo htmlspecialchars($shop['name'], ENT_QUOTES, 'UTF-8');?>" name="my-vendor-name">
                                <input type="hidden" value="1" name="my-box-qty">
                                <input type="hidden" value="1" name="my-box-unitprice">
                                <input type="hidden" value="<?php echo htmlspecialchars($item['unit'], ENT_QUOTES, 'UTF-8');?>" name="my-unitname">
                                <input type="hidden" value="<?php echo htmlspecialchars($item['shoppromoid'], ENT_QUOTES, 'UTF-8');?>" name="my-promo">
                                <input type="hidden" value="<?php echo htmlspecialchars($item['startingprice']==''?0:$item['startingprice'], ENT_QUOTES, 'UTF-8');?>" name="my-startingprice">
                                <input type="hidden"
                                       value="<?php echo Wekit::app()->baseUrl,'/','school-', rawurlencode($schoolInfo['schoolid']),'-4tschool-shopdetails-run-', rawurlencode($shop['id']),'?app=4tschool'; ?>"
                                       name="my-item-url">
                                <input type="hidden" value="<?php echo htmlspecialchars($item['needPackingPrice'], ENT_QUOTES, 'UTF-8');?>" name="my-needPackingPrice">
                                <input type="hidden" name="jcartToken"
                                       value="<?php echo $_SESSION['jcartToken'];?>"/>
                                <?php  } 
  if(empty($item['descriptionurl'])){ ?>
                                <div class="s-left">
                                    <span><a target="_blank" href="<?php echo Wekit::app()->baseUrl,'/','school-', rawurlencode($schoolInfo['schoolid']),'-4tschool-shopdetails-', rawurlencode($shop['id']),'-mid-', rawurlencode($item['id']),'?app=4tschool'; ?>"><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8');?></a></span>
                                </div>
                                <?php  }else{?>
                                <div class="s-left">
                                    <span><a target="_blank" href="<?php echo htmlspecialchars($item['descriptionurl'], ENT_QUOTES, 'UTF-8');?>"><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8');?></a></span>
                                </div>
                                <?php  }?>
                                <div class="s-right">
                                    <span>￥<?php echo htmlspecialchars($item['currentprice'], ENT_QUOTES, 'UTF-8');?>/<?php echo htmlspecialchars($item['unit'], ENT_QUOTES, 'UTF-8');?></span>
                                    <?php  if(empty($item['descriptionurl'])){ ?>
                                    <a target="_blank" class="btn" href="<?php echo Wekit::app()->baseUrl,'/','school-', rawurlencode($schoolInfo['schoolid']),'-4tschool-shopdetails-', rawurlencode($shop['id']),'-mid-', rawurlencode($item['id']),'?app=4tschool'; ?>" style="display:inline">详情</a>
                                    <?php  }else{?>
                                    <a target="_blank" class="btn" href="<?php echo htmlspecialchars($item['descriptionurl'], ENT_QUOTES, 'UTF-8');?>" style="display:inline">详情</a>
                                    <?php  }
  if($schoolInfo['openorder'] == 1 && $item['isshopopen'] == 1 && $item['openorder'] == 1) {
  if($item['remainder'] > 0) { ?>
                                    <input class="btn" type="submit" value="来一份" name="my-add-button">
                                    <?php  } else { ?>
                                    <input type="submit" value="缺货" disabled="disabled">
                                    <?php  } 
  } ?>
                                </div>
                            <input type="hidden" name="csrf_token" value="<?php echo WindSecurity::escapeHTML(Wind::getComponent('windToken')->saveToken('csrf_token')); ?>"/></form>
                        </div>
                        <?php  } 
  } ?>
                    </li>
                    <?php  } ?>
                </ul>
            </li>
        </ul>
    </div>
    <div>
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




    </div>        
</div>
</div>
</div>
</div>
<div style="margin-top:8px;">
    <img src="themes/extres/4tschool/images/cartoon.png"/>
</div>
<div class="clear"></div>
<div class="step-right">
    <div id="sidebar" class="my-step-right">

         <?php  if(empty($topAnn) == false) {?>
         <!-- 最新公告 -->
        <div class="my-info" style="display:none">
           
                <table width="100%" class="menu-express">
                    <tbody>
                    <tr>
                        <td></td>
                        <td>
                            <span><strong>最新公告:</strong>
                              <a target="_blank" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&c=announcedetails&app=4tschool'; ?>&id=<?php echo htmlspecialchars($topAnn['aid'], ENT_QUOTES, 'UTF-8');?>"><font><?php echo htmlspecialchars($topAnn['subject'], ENT_QUOTES, 'UTF-8');?></font></a>
                            <span>
                        </td>
                    </tr>
                    
                    </tbody>
                </table>
        </div>
        <?php  } ?>

        <!-- BEGIN JCART -->
        <div id="jcart">
            <?php echo htmlspecialchars($jcart->display_cart(), ENT_QUOTES, 'UTF-8');?>
        </div>
        <!-- END JCART -->
        
        <div class="my-info">
            <div id="cart_anchor" type="hidden"></div>
            <form method="post" action="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&c=orderpreview&app=4tschool'; ?>" id="orderInfo">
                <table width="100%" class="menu-express">
                    <tbody>
                    <tr>
                        <td align="left">
                             <input type="button" value="清空" name="clearCart" id="clearCart" class="fancybox" style="margin:0px;background-color:#EC7B48">
                        </td>
                        <td align="right">

                            <?php  if($schoolInfo['openorder'] == 1 ) {?>
                            <input type="submit" value="结算" name="confirmOrder" id="confirmOrder" class="fancybox" style="margin:0px">
                            <?php  } ?>
                        </td>
                    </tr>

                    <?php  if(!empty($promotionalShopList) && $aa){ ?>
                    <tr class="promotional-manage">
                        <td colspan="2">
                            <strong>
                                你可能喜欢的店铺推荐
                            </strong>
                        </td>
                    </tr>
                    <tr class="promotional-content">
                        <td colspan="2">
                            <div>
                                <ul style="width:285px">
                                    <?php foreach ($promotionalShopList as $key => $item) {
  if($item['isopen']){?>
                                    <a target="_blank" href="<?php echo Wekit::app()->baseUrl,'/','school-', rawurlencode($item['schoolid']),'-4tschool-shopdetails-run-', rawurlencode($item['shopid']),'?app=4tschool'; ?>">
                                        <li class="<?php echo htmlspecialchars($item['isopen']==1?"":"shop-closed", ENT_QUOTES, 'UTF-8');?>" style="background-color:#FFF1ED">
                                            <div class="hot-shops">
                                                <div class="hot-shops-img">
                                                    <img class="<?php echo htmlspecialchars($item['isopen']==1?"":"shop-logo", ENT_QUOTES, 'UTF-8');?>" alt="<?php echo htmlspecialchars($item['shopname'], ENT_QUOTES, 'UTF-8');?>" src="<?php echo htmlspecialchars($item['imageurl'], ENT_QUOTES, 'UTF-8');?>">
                                                </div>
                                                <div class="hot-shops-info">
                                                    <span class="name"><?php echo htmlspecialchars($item['shopname'], ENT_QUOTES, 'UTF-8');?></span><br/>
                                                    <span class="description"><?php echo htmlspecialchars($item['description'], ENT_QUOTES, 'UTF-8');?></span>
                                                </div>
                                            </div>
                                            <div class="shop-status">
                                                <div style="float:left">
                                                <span class=<?php echo htmlspecialchars($item['isopen']==1?"status-open":"status-closed", ENT_QUOTES, 'UTF-8');?> title=<?php echo htmlspecialchars($item['isopen']==1?"该商家正在营业中":"该商家已经打烊", ENT_QUOTES, 'UTF-8');?>><?php echo htmlspecialchars($item['isopen']==1?"营":"烊", ENT_QUOTES, 'UTF-8');?></span>
                                                <?php  if($item['isopen']==1){ 
  if($item['openorder']==1){ ?>
                                                <span class="order-open" title="该商家支持送外卖">外</span>
                                                <?php  } 
  if($item['hasterminal']==1 && $schoolInfo['openorder'] == 1){ ?>
                                                <span class="terminal-open" title="该商家支持在线下单">订</span>
                                                <?php  } ?>
                                                </div>
                                                <div style="float:right">
                                                    <span><?php echo htmlspecialchars($item['startingprice'], ENT_QUOTES, 'UTF-8');?>元起送</span>
                                                    <a href="<?php echo Wekit::app()->baseUrl,'/','school-', rawurlencode($schoolInfo['schoolid']),'-4tschool-shopdetails-showphone-', rawurlencode($item['shopid']),'?app=4tschool'; ?>" target="_blank">
                                                    <img alt="diancanyo.com - 点餐哟" width="14px" height="14px" title="商家电话" src="themes/extres/4tschool/images/Phone_page.png">
                                                    </a>
                                                </div>    
                                                <?php  } ?>
                                            </div>
                                        </li>
                                    </a>
                                    <?php }else{?>
                                        暂无推荐
                                    <?php }
 }?>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <?php  } ?>
                    </tbody>

                </table>
            <input type="hidden" name="csrf_token" value="<?php echo WindSecurity::escapeHTML(Wind::getComponent('windToken')->saveToken('csrf_token')); ?>"/></form>
        </div>
    </div>
</body>
<script type="text/javascript" src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/4tschool/js/jquery-ui.js"></script>
<script>
    $(function () {
        $("#add_favorites").click(function (event) {
            event.preventDefault();
            //not login
            if ($("#add_favorites").attr("href") == 0){
                location.href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=u&c=login'; ?>";
                return;
            }

            var postUrl = $(".bookmarkShopUrl").val();
            $.post(postUrl,
                    $('#schoolordersForm').serialize(),
                    function (msg) {
                        if (msg) {
                            $("#mark").remove();
                            $("#marked").show();
                        }
                    });
        });
    });

    //菜品列表背景色设置
    $(".step-shop-menu").hover(function()
    {
        $(this).attr("style","background-color:#FFE4D8");
    },
    function()
    {
        $(this).attr("style","background-color:''");
    });

    $(".step-incidentally-menu").hover(function()
    {
        $(this).attr("style","background-color:#FFE4D8");
    },
    function()
    {
        $(this).attr("style","background-color:''");
    });


    $(function () {

        $("#accordion").accordion({
            collapsible: true,
            heightStyle: "content"
        });

        // Hover states on the static widgets
        $("#dialog-link, #icons li").hover(
                function () {
                    $(this).addClass("ui-state-hover");
                },
                function () {
                    $(this).removeClass("ui-state-hover");
                }
        );
    });

    $(function () {
        var tab_wrap = $('.J_tab_wrap');
        Wind.use('tabs', function () {
            tab_wrap.each(function () {
                $(this).find('.J_tabs_nav').first().tabs($(this).find('div.J_tabs_contents').first().children('div'));
            });
        });
    });

    var added = false;
    $(function () {
        var mid = $("#addToCart").val();
        if (mid != '') {
            $("[name='my-item-id']").each(function () {
                if (added) return;
                if ($(this).val() == mid) {
                    $(this).parent().find("[name='my-add-button']").trigger('click');
                    added = true;
                }
            });
        }
    });

    $(".ctgmenu").click(function () {
        var tag = $(this);

        $(".ctgmenu").each(function () {
            $(this).attr('class', 'ctgmenu');
        });


        $(tag).attr('class', 'ctgmenu ctgactive');

        $(".li-first").each(function () {
            if ($(tag).attr('curindex') == $(this).attr('id').substring(4))
                $(this).css('display', 'block');
            else
                $(this).css('display', 'none');
        });
    });

    //clear the shopping cart
    $("#clearCart").click(function () {
        $.ajax({
            type: "POST", dataType: "text", async: false, url: "<?php echo htmlspecialchars($BASE_URL, ENT_QUOTES, 'UTF-8');?>",
            data: {"jcartEmpty": "1"},
            success: function (data) {
                $('#jcart').html(data);
                repositionCart();
            },
            error: function (res, msg, err) {
                alert(err);
            }
        });
    });


    //check order information
    $("#orderInfo").submit(function () {
        if ($("#merchandiseCount").val() == 0) {
            alert("您的餐车还没有餐品.");
            return false;
        }
        return true;
    }); 

    $(function(){
        var anchor="<?php echo htmlspecialchars($anchor, ENT_QUOTES, 'UTF-8');?>";
        if(anchor!="")
        {
            $("html,body").animate({scrollTop:$("#"+anchor).offset().top-100},0)
        }
    });

    $(function(){
        $(".step-shop-menu").live("click",function(event){
            if(event.target.tagName.toLowerCase() != 'input' && event.target.tagName.toLowerCase() != 'a')
            $(this).find("[name='my-add-button']").trigger("click");
        });
    });
</script>
</html>