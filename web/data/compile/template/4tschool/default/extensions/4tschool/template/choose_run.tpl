<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="description" content="点餐哟 – 全国最大的开源在线外卖点餐平台,公益的平台帮助大学生创业,手机APP，微信轻松下订单,尽在点餐哟！">
<meta name="keywords" content="开源外卖网站,大学生创业平台,点餐, 外卖平台, 外卖,外卖网,网上订餐,高校外卖,外卖电话,高校周边餐厅,全国最大的开源外卖网">

<link href="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/4tschool/css/choose.css" rel="stylesheet" type="text/css">
<title>点餐哟开源公益外卖平台 -大学生创业平台,点餐, 外卖, 网络订餐</title>
<script src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/4tschool/js/jquery-1.7.1.min.js" type="text/javascript"></script>
<script src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/4tschool/js/jquery.cookie.js" type="text/javascript"></script>
   
</head>
<body onload="pageLoad()">
    <div class="top">
        <span>
          <?php  if ($loginUser->uid <= 0) { ?>
          您好! 欢迎来到点餐哟开源外卖平台 
            <a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=u&c=login'; ?>"><font>[登录]</font></a> <a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=u&c=register'; ?>"><font>[注册]</font></a>
          <?php  } else { ?>
          欢迎来到点餐哟开源外卖平台,
            <a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&c=schoolorder&a=myorder&app=4tschool'; ?>"><?php echo htmlspecialchars($loginUser->username, ENT_QUOTES, 'UTF-8');?></a> <a
                href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=u&c=login&a=logout'; ?>"><font>[登出]</font></a>
          <?php  } ?>
        </span>
    </div>
    <div class="Main_body">
      <div class="titleimg">
        <img src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/4tschool/images/logo.png">
      </div>
	  <div style="margin-left:330px">
		<h2>这可能是你见过的最完整的开源外卖平台</h2>
		<ul>
			<li>1. Web, 微信，APP三位一体，覆盖所有用户使用习惯</li>
			<li>2. 商家终端, 区域代理模式功能支持</li>
			<li>3. 百度推送, 微信推送全覆盖</li>
			<li>4. 支持大学生免费创业(独立微信号运营, 无需服务器费用, 社区开源成员维护)</li>
			<li>5. 在GITHUB查看本项目<a style="color:red" target="_blank" href="https://github.com/learnstartup/4tweb">去看看</a></li>
		</ul>
	  </div>
      <div class="Sub_body" style="height:386px">
          <div class="body_top">
            <span style="" class="topspan">请选择您所在区域</span>
            <img src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/4tschool/images/dot.png">
            </span>
            <img src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/4tschool/images/dot.png">
            <span id="shoparea" style="" class="topspan">
            </span>
            <a class="triangle" style="display: block; left: 59px;"></a>
          </div>
          <div class="Main_subbody"  style="height:auto;background-color:white">
               <div class="allareas" style="">
                  <ul class="areas" id="nc" style="display: block;">
                      <li>
                        <a style="width:500px;color:#333333" href="<?php echo Wekit::app()->baseUrl,'/','school-11045-4tschool-index-run?app=4tschool'; ?>" title="江西师范大学科学技术学院(老校区)外卖点餐">
                          <span class="" style="width:500px">
                           江西师范大学科学技术学院(老校区)开源外卖平台
                          </span>
                        </a>
                      </li>
                      <li>
                        <a style="width:500px;color:#333333" href="<?php echo Wekit::app()->baseUrl,'/','school-1001292-4tschool-index-run?app=4tschool'; ?>" title="江西省南昌大学[南院]外卖点餐">
                        <span class="" style="width:500px">
                           江西省南昌大学南院校区开源外卖平台
                        </span>
                        </a>  
                      </li>
                      <li>
                        <a style="width:500px;color:#333333" href="<?php echo Wekit::app()->baseUrl,'/','school-1001293-4tschool-index-run?app=4tschool'; ?>" title="江西交通学院外卖点餐">
                        <span class="" style="width:500px">
                           江西交通学院开源外卖平台
                        </span>
                        </a>  
                      </li>
                      <li>
                        <a style="width:500px;color:#333333" href="<?php echo Wekit::app()->baseUrl,'/','school-1001294-4tschool-index-run?app=4tschool'; ?>" title="江西机电学院外卖点餐">
                        <span class="" style="width:500px">
                           江西机电学院开源外卖平台
                        </span>
                        </a>  
                      </li>
                      <li>
                        <a style="width:500px;color:#333333" href="<?php echo Wekit::app()->baseUrl,'/','school-1001295-4tschool-index-run?app=4tschool'; ?>" title="江西机电学院外卖点餐">
                        <span class="" style="width:500px">
                           江西财经大学[蛟桥]开源外卖平台
                        </span>
                        </a>  
                      </li>
                      <li>
                        <a style="width:500px;color:#333333" href="<?php echo Wekit::app()->baseUrl,'/','school-11033-4tschool-index-run?app=4tschool'; ?>" title="江西农业大学外卖点餐">
                        <span class="" style="width:500px">
                           江西农业大学开源外卖平台
                        </span>
                        </a>  
                      </li>
                      <li>
                        <a style="width:500px;color:#333333" href="<?php echo Wekit::app()->baseUrl,'/','school-11016-4tschool-index-run?app=4tschool'; ?>" title="南昌航空大学外卖点餐">
                        <span class="" style="width:500px">
						南昌航空大学开源外卖平台
						</span>
                        </a>
                      </li>
                      <li>
                        <a style="width:500px;color:#333333" href="<?php echo Wekit::app()->baseUrl,'/','school-93242-4tschool-index-run?app=4tschool'; ?>" title="江西理工学院外卖点餐">
                        <span class="" style="width:500px">
                           江西理工学院开源外卖平台
                        </span>
                        </a>  
                      </li>
                      <li>
                        <a style="width:500px;color:#333333" href="<?php echo Wekit::app()->baseUrl,'/','school-1001296-4tschool-index-run?app=4tschool'; ?>" title="江西财大外卖点餐">
                        <span class="" style="width:500px">
                           江西财大(枫林)开源外卖平台
                        </span>
                        </a>  
                      </li>

                      <li>
                        <a style="width:500px;color:#333333" href="<?php echo Wekit::app()->baseUrl,'/','school-1001297-4tschool-index-run?app=4tschool'; ?>" title="江西财大外卖点餐">
                        <span class="" style="width:500px">
                           江西财大(麦庐)开源外卖平台
                        </span>
                        </a>  
                      </li>

                      <li>
                        <a style="width:500px;color:#333333" href="<?php echo Wekit::app()->baseUrl,'/','school-11009-4tschool-index-run?app=4tschool'; ?>" title="华东交通大学外卖点餐">
                        <span class="" style="width:500px">
                           华东交通大学开源外卖平台
                        </span>
                        </a>  
                      </li>

                  </ul>
               </div>
               <div class="list" id="schools" style="display:none">
                  <ul id="nc-hgtx" style="display: block;">
                      <li style="width:800px">
                        <a style="width:500px" href="<?php echo Wekit::app()->baseUrl,'/','school-11045-4tschool-index-run?app=4tschool'; ?>" title="江西师范大学科学技术学院(老校区)外卖点餐"> 
                        <span style="width:500px">
                          江西师范大学科学技术学院(老校区)开源外卖平台
                        <span>  
                        </a>
                      </li>
                  </ul>
               </div>
          </div>
      </div>
      <div class="footer" style="display:none">
        <p class="firenf_link">
            友情链接: <a target="_blank" href="http://www.phpwind.net">PHPWind 社区</a>
        </p>
           <div class="hr"></div>
        <p class="last">
            Copyright © 2013 点餐哟外卖平台 All Rights Reserved
        </p>
    </div>
    </div>
    
        <input name="findschool" type="hidden" id="findschool">
        <input name="findcity" type="hidden" id="findcity" value="南昌,nc">
    <script src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/4tschool/js/fenxiangyo_nav.js" type="text/javascript">
    </script>
    <script type="text/javascript">
      var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
      document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F3bf15cf5566f3927e165b2d12ea5534e' type='text/javascript'%3E%3C/script%3E"));
    </script>
</body>
</html>