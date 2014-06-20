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

    <link rel="stylesheet" href="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/4tschool/css/styles.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/4tschool/css/jcart.css" type="text/css" media="screen">
</head>
<body>
<div class="spacer"></div>
<div class="spacer"></div>
<div class="spacer"></div>
<div class="row">
    <div id="wrapper" class="twelvecol">
        <div id='jcart'>
            <?php echo htmlspecialchars($jcart->display_cart(), ENT_QUOTES, 'UTF-8');?>
        </div>
    </div>
    <?php  if($promotionList) { ?>
    <div class="my-info">
        <p class="site-title">商家活动(<span>您的餐车满足以下购物活动, 赶快下单吧</span>)</p>


        <ul class="promo description">
            <?php  foreach ($promotionList as $item) { ?>
            <li>
                <span><?php echo htmlspecialchars($item['ShopName'], ENT_QUOTES, 'UTF-8');?></span>
                限时活动, 满
                <span><?php echo htmlspecialchars($item['Meet'], ENT_QUOTES, 'UTF-8');?>元</span>
                ,
                <span><?php echo htmlspecialchars($item['MerchandiseName'], ENT_QUOTES, 'UTF-8');?></span>
                立减
                <span><?php echo htmlspecialchars($item['Deduct'], ENT_QUOTES, 'UTF-8');?>元</span>.
            </li>
            <?php  } ?>
        </ul>
        <ul class="promo bigfont">
            <li>
                您实际应支付价格为:<span>￥<?php echo htmlspecialchars($totalPrice, ENT_QUOTES, 'UTF-8');?></span>
            </li>
        </ul>
    </div>
    <?php  } 
  if($itemCount!=0) { ?>
    <div class="my-info">
        <p class="site-title">常用送餐地址</p>
        <ul id="myOrderInfoList">
            <?php  if($orderInfoList) { 
  foreach ($orderInfoList as $item) { ?>
            <li><input type="radio" name="orderInfo" <?php echo htmlspecialchars(Pw::ifcheck($item['isdefault'] == 1), ENT_QUOTES, 'UTF-8');?>><span><?php echo htmlspecialchars($item['rname'], ENT_QUOTES, 'UTF-8');?>, <?php echo htmlspecialchars($item['raddress'], ENT_QUOTES, 'UTF-8');?>, <?php echo htmlspecialchars($item['rphone'], ENT_QUOTES, 'UTF-8');?></span>
            </li>
            <?php  } 
  } 
  else { ?>
            <li class="empty">
            <span>您还没有设置收货地址，将使用您的注册信息为默认收获地址。管理您的常用收货地址请到<span
                    class="prompt">[我的订餐->送餐地址]</span>。</span>
            </li>
            <?php  } ?>
        </ul>
    </div>
    <div class="my-info">
        <p class="site-title">配送信息</p>
        <?php  if($userId <= 0) { ?>
        <p>
            <span style="color:red;margin-left:20px;">您还没有登陆, 登陆后可以享受到积分兑换等贴心的服务, <a class="quicklogin">[登陆]</a>&nbsp;<a class="quickregist">[注册账号]</a></span><br>

        </p>
        <?php  } ?>
        <form method="post" action="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&c=orderpreview&a=makeorder&app=4tschool'; ?>" id="submitOrder">
            <input type='hidden' name='merchandisesInfo' value='<?php echo htmlspecialchars($merchandisesInfo, ENT_QUOTES, 'UTF-8');?>'>
            <input type='hidden' name='appliedPrice' value='<?php echo htmlspecialchars($totalPrice, ENT_QUOTES, 'UTF-8');?>'>
            <table width="100%" class="menu-express">
                <tbody>
                <tr>
                    <td>姓名(必填)</td>
                    <td><input type="text" value="<?php echo htmlspecialchars($orderInfo['rname'], ENT_QUOTES, 'UTF-8');?>" id="orderContactor" name="orderContactor"></td>
                </tr>
                <tr>
                    <td>手机号码(必填)</td>
                    <td><input type="text" value="<?php echo htmlspecialchars($orderInfo['rphone'], ENT_QUOTES, 'UTF-8');?>" id="orderPhone" name="orderPhone"></td>
                </tr>
                <tr>
                    <td>送餐地址(必填)</td>
                    <td>
                        <input type="text" value="<?php echo htmlspecialchars($orderInfo['raddress'], ENT_QUOTES, 'UTF-8');?>" id="orderAddress" name="orderAddress">
                    </td>
                </tr>

                <?php  if($userId > 0) { ?>
                <tr>
                    <td></td>
                    <td>
                        <div>
                            <a id="addNewAddress"><span style="color: #F87D0B;">[点击保存收货地址]</span></a>
                        </div>
                        <div id="addedSuccessful" style="display: none">
                            <font color="#FF4400"><span>[保存成功]</span></font>
                        </div>
                    </td>
                </tr>
                <?php  } ?>
                <tr>
                    <td>备注</td>
                    <td>
                        <div id="note_wrapper">
                            <div class="note-bubble" id="note_bubble">
                                <div class="quick-notes clearfix" id="quick_notes">
                                    <a class="bubble-triangle">不吃辣</a>
                                    <a>辣一点</a>
                                    <a>多加米</a>
                                    <a>么零钱</a>
                                </div>
                            </div>
                            <input type="text" value="" id="orderRemark" name="orderRemark">
                        </div>
                    </td>
                </tr>
                <tr  style="display:none">
                    <td valign="top">送餐时间</td>
                    <td>
                        <input type="radio" checked="checked" value="0" name="orderExpressTime">尽快
                        <input type="radio" value="1" name="orderExpressTime">预订
                        <input type="hidden" id="addNewAddressUrl" name="addNewAddressUrl"
                               value="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&c=myaccount&a=updateOrderAddress&app=4tschool'; ?>">

                        <div style="display:none" id="orderExpressTimePreSettings">
                            <select id="order_pre_hour" name="orderHour">
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                                <option selected="selected" value="17">17</option>
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                                <option value="21">21</option>
                            </select>点
                            <select id="order_pre_minute" name="orderMinutes">
                                <option value="0">00</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="40">40</option>
                                <option selected="selected" value="50">50</option>
                            </select>分
                        </div>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td style="display:<?php if(empty($orderShopList)){echo 'none';} ?>">

                        <a  style="text-decoration: underline;" id="goback" name="goback" onclick="javascript:history.back();">
                        <span>返回修改</span></a>
                        <?php  if(empty($shopnamestring)) { ?>
                        &nbsp;&nbsp;
                        <input type="submit" value="<?php echo htmlspecialchars($userId > 0?'确定订单':'不注册直接下单', ENT_QUOTES, 'UTF-8');?>" name="confirmOrder" id="confirmOrder" class="fancybox">
                         <?php  } 
  if(!empty($shopnamestring)) { ?>
                        <div>
                            <span>抱歉！你您下单的过程中, 商家</span> <span style="color:red">"<?php echo htmlspecialchars($shopnamestring, ENT_QUOTES, 'UTF-8');?>"</span><br/>由于繁忙, 关闭了在线下单通道, 您可以</span><br/>
                            <span><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&c=orderpreview&clear=clear&app=4tschool'; ?>" style="color:#3388cc">清空该店商品</a></span>
                            继续下单</td>
                        <div>
                        <?php  } ?>
                        <div class="clear"></div>

                        </h3>
                        <div class="spacer"></div>
                        <div class="spacer"></div>
                </tr>
                </tbody>
            </table>
        <input type="hidden" name="csrf_token" value="<?php echo WindSecurity::escapeHTML(Wind::getComponent('windToken')->saveToken('csrf_token')); ?>"/></form>
    </div>
    <?php  } 
  else { ?>
    <!--<div class="shoppingcart_general_none">您的餐车还是空的哟，-->
    <!--<a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&app=4tschool'; ?>">去点餐&gt;&gt;</a>-->
    <!--</div>-->
    <?php  } ?>
</div>
</body>
<script>
Wind.use('jquery', 'global', 'validate', 'emailAutoMatch', function(){
    $(function () {

        $("#addNewAddress").click(function (event) {
            event.preventDefault();

            var checkResult = deliveryValidation();
            if(false == checkResult)
                return;

            var postUrl = $("#addNewAddressUrl").val();
            $.post(postUrl,
                    {txt_ship_man: $("#orderContactor").val(), txt_addr_detail: $("#orderAddress").val(), txt_ship_tel: $("#orderPhone").val(), csrf_token: GV['TOKEN']},
                    function (result) {
                        result = eval("(" + result + ")");
                        if (result.success) {
                            $("#addNewAddress").toggle();
                            $("#addedSuccessful").toggle();
                            var element = "<li><input type='radio' name='orderInfo'><span>" + $("#orderContactor").val() + ', ' + $("#orderAddress").val() + ', ' + $("#orderPhone").val() + "</span></li>";
                            if ($("#myOrderInfoList li:first").attr("class") == "empty") {
                                $("#myOrderInfoList li:first").remove();
                            }
                            $("#myOrderInfoList").append(element);
                        }
                        else {
                            if (result.data == "数据已经存在")
                                alert("该地址已存在");
                            else
                                alert(result.data);
                        }
                    });
        });
    });

    $("input[name='orderInfo']").live('click', function () {
        var selectedorder = $(this).next().text().split(',');
        $("#orderContactor").val($.trim(selectedorder[0]));//name
        $("#orderAddress").val($.trim(selectedorder[1]));//address
        $("#orderPhone").val($.trim(selectedorder[2]));//phone

        if ($("#addNewAddress").is(":hidden")) {
            $("#addNewAddress").toggle();
            $("#addedSuccessful").toggle();
        }
    });

    //check order information
    $("#submitOrder").submit(function () {

        $("#confirmOrder").attr("disabled","disabled");

        var checkResult = deliveryValidation();
        if(false == checkResult)
        {
            $("#confirmOrder").removeAttr("disabled");
            return checkResult;
        }

        if($("#formstatus").val() == 'no'){
            alert("亲, 没有达到起送价不可以送噢.");
            $("#confirmOrder").removeAttr("disabled");
            return false;
        }

        if(GV.U_ID <= 0){

            if(confirm("确定直接下单吗?") == true)
            {
                return true;
            }
            else
                return false;
        }

        return true;
    });

    var VENDOR_IN_SERVICE = 1;
    $("input[name='orderExpressTime']").click(function () {
        if ($(this).val() == 0) {
            if (VENDOR_IN_SERVICE) {
                $("#orderExpressTimePreSettings").hide();
            } else {
                alert('还没到商家营业时间，你只能通过预订，谢谢！')
                $("input[name='orderExpressTime']").attr("checked", '1');
                $("#orderExpressTimePreSettings").show();
            }
        } else {
            $("#orderExpressTimePreSettings").show();
        }
    });

    //clear the shopping cart
    $("#clearCart").click(function () {
        $.ajax({
            type: "POST", dataType: "text", async: false, url: "<?php echo htmlspecialchars($BASE_URL, ENT_QUOTES, 'UTF-8');?>",
            data: {"jcartEmpty": "1"},
            success: function (data) {
                window.location.replace(window.location.href);
            },
            error: function (res, msg, err) {
                alert(err);
            }
        });
    });

    $("#orderRemark").focus(function () {
                $("#note_bubble").show();
            }
    );

    $("body").on("click", function (e) {
        if (!$("#note_wrapper").has(e.target).length) {
            $("#note_bubble").hide();
        }
    });

    $("#quick_notes > a").on("click", function () {
        var remark = $("#orderRemark").val(), selected = $(this).text();
        if (remark.indexOf(selected) >= 0) {
            return false
        }
        var v = remark + " " + selected + " ";
        $("#orderRemark").val(v);
    });

    $(".quicklogin").click(function(e)
    {
        e.preventDefault();
        //check if already login, if no, then popup to login/register
        if(GV.U_ID <= 0){

            var result = Wind.Util.quickLogin(window.location.href);
            $(".wind_dialog_mask").show();
            $(".fastlogin_logintab").click();
        }
    });

    //quickregist
    $(".quickregist").click(function(e)
    {
        e.preventDefault();
        //check if already login, if no, then popup to login/register
        if(GV.U_ID <= 0){

            var result = Wind.Util.quickLogin(window.location.href);
            $(".wind_dialog_mask").show();
            $(".fastlogin_registertab").click();
        }
    });

    function deliveryValidation()
    {
        if ($("#orderContactor").val() == "") {
            alert("请填写接收人姓名.");
            return false;
        }

        if (!(/^1[3|4|5|8][0-9]\d{8}$/.test($("#orderPhone").val()))) {
            alert("你输入的手机号有误.");
            return false;
        }

        if ($("#orderAddress").val() == "") {
            alert("请填写送餐地址.");
            return false;
        }
    }

});
</script>
</html>