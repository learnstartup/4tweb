var bmapTimer = false;
$(document).ready(function () {
	setInterval('autoScroll(".scroll")', 1800);

	$(".ctgmenu").click(function(){
		var curindex =$(this).attr('curindex');
		$('.ctgmenu').removeClass('ctgactive');
		$('#market').removeClass('ctgactive');
		$(this).addClass('ctgactive');
		$('.li-first').hide();
		$('#list'+curindex).show();

	});

	$("#market").click(function(){
		$('.ctgmenu').removeClass('ctgactive');
		$(this).addClass('ctgactive');
		$('.li-first').hide();
		$('#supermarket').show();
	});

	$('#search-item-box').focus(function(){
		$(this).val()=='请输入菜品名称'?$(this).val(''):null;
	});
	$('#search-item-box').blur(function(){
		$(this).val()==''?$(this).val('请输入菜品名称'):null;
	});
	
//	$('#s_keyword').focus(function(){
//		$(this).val()==ADDRESS_TIP?$(this).val(''):null;
//	});
//
//	$('#s_keyword').blur(function(){
//		$(this).val()==''?$(this).val(ADDRESS_TIP):null;
//	});
//
//	$('#mkey').focus(function(){
//		$(this).val()==ADDRESS_TIP?$(this).val(''):null;
//	});
//
//	$('#mkey').blur(function(){
//		$(this).val()==''?$(this).val(ADDRESS_TIP):null;
//	});
	
//	$('#m_keyword').focus(function(){
//		$(this).val()=='如：蛋炒粉'?$(this).val(''):null;
//	});
//
//	$('#m_keyword').blur(function(){
//		$(this).val()==''?$(this).val('如：蛋炒粉'):null;
//	});
//
//	$('#s_keyword').val('如：张三饼店, 老牛小吃');
//	$('#m_keyword').val('如：蛋炒粉');

	$('#search-item-box').keyup(function(){

		var val = $(this).val()
		$(".step-shop-menu").hide();
		$(".step-shop-menu").each(function(){
			if($(this).attr("itemname").indexOf(val)!=-1)
			{
				$(this).show();
			}
		})
	});
	
	$("input[name='keyword']").bind("keydown", function (e) {
	    var key = e.which;
	    if (key == 13) {
	    	$('#idx_search_input').click();
	    }
	});
	
	$('#idx_search_input').click(function(){
		var keyval = $('#search_keyword').val();
		if (keyval == '如：蛋炒粉') { 
			alert('请输入商家名/菜名。'); 
		} else { 
			window.location = FANDIAN_SCRIPT_URL+'vendor/search/keyword/'+encodeURIComponent(keyval);
		}
	});
	
	$('#banner').slidesjs({
		preload: true,
		preloadImage: '../images/loading.gif',
		play: 3000,
		pause: 2500,
		hoverPause: true
	});

	$("input[name='address']").bind("keydown", function (e) {
		
		$('#CoordGuid').val('');
	    var key = e.which;
	    if (key == 13) {
	    	$('#gonext').click();
			$('#gonext').attr('disabled',false);
	    }
	});
	
	$("input[name='maddress']").bind("keydown", function (e) {
		$('#stepadd').val($(this).val());
		$('#CoordGuid').val('');
	    var key = e.which;
	    if (key == 13) {
	    	$('#gonext').click();
			$('#gonext').attr('disabled',false);
	    }
	});
	
	$('#gonext').click(function(){MapSearch();});
	
    $().UItoTop({ easingType:'easeOutQuart' });
   
	
	$(".select-city").hover(function (e) {
        if ($("#sle-area").css("display") == "none") {
            $("#sle-area").show();
        }
        else {
            $("#sle-area").hide();
        }
    });
	
	 $(".area").hover(function () {
		
        $(this).find(".area-ul").show();
		$(this).find(".location").addClass("arrowdown")
		
    }, function () {
        $(this).find(".area-ul").hide();
		$(this).find(".location").removeClass("arrowdown")
		
    });
	
	 $(".area ul li").hover(function () {
		
        $(this).find(".areashow").show();
		$(this).addClass("lihover");
    }, function () {
        $(this).find(".areashow").hide();
		$(this).removeClass("lihover");
    });
	 
	 $('.captcha').click(function(){
		 $(this).attr('src',FANDIAN_BASE_URL+'service/image/captcha?'+Math.random());
	 });
	 
	  /*tab*/
	  $("ul.tabs li").click(function () {
		  $("ul.tabs li").removeClass("active");
		  $(this).addClass("active");
		  $(".tab_content").hide();
	      var tindex = $(this).attr("tab");
	      $('#tab'+tindex).toggle();

	      // alert($(this).attr("tab"));
	      var type=$(this).attr("tab")==1?'s':'m';
	      $("#searchType").val(type);

          var target, replacement;
          var action=$("#searchForm").attr('action');
          if(type=='s'){
              target='c=merchandiselist';
              replacement='c=shoplist';
          }else{
              target='c=shoplist';
              replacement='c=merchandiselist';
          }
          reg=new RegExp(target,'i');
          $("#searchForm").attr('action',action.replace(reg,replacement));
	  }); 

	  $(".btn_submit").click(function(){
	  	var head=$("#searchType").val();
	  	var keyword=$("#"+head+"_keyword").val();
	  	var action=$("#searchForm").attr("action");
	  	action+="&type="+head+"&keyword="+keyword;
	  	$("#searchForm").attr("action",action);
	  	// $("#keyword").val($("#"+head+"_keyword").val());
	  });

	  //submit feedback by AJAX
	  $("#submit-feedback").click(function(){
		  $(this).attr("disabled",true);
		  $('#sloading').show();
		  var content = $("#content").val();
		  var scode = $("#scode").val();
		  
		  $.post(FANDIAN_SCRIPT_URL+"feedback/do",{content:content,scode:scode},function(result)
		  {
			  $('#info').html(result);
			  $('#captcha').click();
			  $('#sloading').hide();
			  $("#submit-feedback").attr("disabled",false);
		  });
	  });
	  
	  //forget padssword
	  $('#forget-pwd').click(function(){
		  location.href=FANDIAN_BASE_URL+'member/resetpwd'; 
	  });
	  
	  //register
	  $('#UserName').blur(function(){
		  ValidateRegisterElement($(this).attr('id'),$(this).val());
	  });
	  $('#Cell').blur(function(){
		  ValidateRegisterElement($(this).attr('id'),$(this).val());
	  });
	  $('#Email').blur(function(){
		  ValidateRegisterElement($(this).attr('id'),$(this).val());
	  });
	  
	  $('#PassWord').blur(function(){
		pass = $('#PassWord').val();
		if (pass.length<6) {
			$('#error_PassWord').show().removeClass('success').addClass('rerror').html('密码长度必须大于等于6个字符');
		} else {
			$('#error_PassWord').show().removeClass('rerror').addClass('success').html('');
		}
	  });
	  $('#PassWord2').blur(function(){
		pass = $('#PassWord').val();
		pass2 = $('#PassWord2').val();
		
		if (pass!=pass2) {
			$('#error_PassWord2').show().removeClass('success').addClass('rerror').html('两次输入的密码不一致');
		} else if (1) {
			$('#error_PassWord2').hide().removeClass('rerror').addClass('success').html('');
		}
	  });
	  
	  $('#RealName').blur(function(){
		var realname = $('#RealName').val();
		if (realname.length<2) {
			$('#error_RealName').show().removeClass('success').addClass('rerror').html('请填写有效的真实姓名');
		} else {
			$('#error_RealName').removeClass('rerror').addClass('success').html('');
		} 
	  });
	  
	  //register form submit
	  $("#reg_form").submit(function(e){ 
		  return ValidateRegister(); 
	  });
	  
	  $("#msearch").click(function(){
		 if($("#mkey").val() == ADDRESS_TIP )
		 {
			 alert('请先填写您的送餐地址！');
			 return false;
		 }else{
			 RELOAD = false;
			 Fandian_Service_BaiduPlace($('#stepadd').val(), function(){
				if (bmap==null) {
					Fandian_LoadBaiduMapScript('Fandian_RenderAddressMap');
				} else {
					Fandian_RenderAddressMap();
				}
				if (!bmapTimer) {
					bmapTimer = setInterval(Fandian_MoveMapCenter, 500);
				}
			});
		 }
	  });
	  
	  $("#repos").click(function(){
		  RESEARCH = false;
		  $('#gonext').click();
	  });
	  
	  //收藏
	  $("#collect").click(function(){
		  try {
			    window.external.addFavorite($("#collect").attr("href"), document.title);
		  } catch (e) {
				try {
					window.sidebar.addPanel(document.title, $("#collect").attr("href"), '');
				} catch (e) {}
		  }
		  return false; 
	  });
	  
	  //清空购物车
	  $("#ClearOrder").click(function(){
		  $.ajax({
				type: "POST",dataType : "text",async : false,url: FANDIAN_BASE_URL+"vendor/jcart-relay",
				data: {"empty" : "1"},
				success: function(data){$('#jcart').html(data);scall();},
				error : function(res,msg,err) {alert(msg);}
			});
	  });
	  
	 $("input[name='OrderExpressTime']").click(function(){
		if($(this).val()==0)
		{
			if(VENDOR_IN_SERVICE)
			{
				$("#OrderExpressTimePreSettings").hide();
			}else
			{
				alert('还没到商家营业时间，你只能通过预订，谢谢！')
				$("input[name='OrderExpressTime']").attr("checked",'1');
				$("#OrderExpressTimePreSettings").show();
			}
			
		}else
		{
			$("#OrderExpressTimePreSettings").show();
		}
	 });
	 
	 $("#submitOrder").submit(function(){
		$("#submitButton").attr('disabled',true); 
		$('#sloading').show();
		$("#submitButton").val("正在提交，请稍后...");
		return true;
	 });
	 
	 $('.ctgspan').click(function(){
		var ctgname= $(this).html();
		$('.ctgspan').removeClass('active');
		$(this).addClass('active');
		
		if(ctgname=='全部')
		{
			$(".area-vendor").show();
		}else{
			$(".area-vendor").hide();
			$(".area-vendor").each(function(){

				if($(this).attr("ctgname").indexOf(ctgname)!=-1)
				{
					$(this).show();
				}
			});
		}
		
	});
	$('.area-ul li').mouseenter(function(){
		$(".area-vendor").show();
		
	});
});
var RESEARCH = true;
var STEP_RESULT = false;
var THIS_ADDRESS = '';
var THIS_COORDGUID = '';
var ADDRESS_TIP = '如：张三饼店, 老牛小吃';

var RELOAD = true;
function autoScroll(obj) {
    $(obj).find(".list").animate({
        marginTop:"-25px"
    }, 500, function () {
       $(this).css({marginTop:"0px"}).find("li:first").appendTo(this);
    })
}
function ChoosedFromUsed(Address, CoordGuid,CoordName,CoordLongitude,CoordLatitude)
{
	THIS_ADDRESS = Address;
	THIS_COORDGUID = CoordGuid;
	Fandian_SetCookie('address', Address);
	Fandian_SetCookie('coord_guid', CoordGuid);
	Fandian_SetCookie('coord_name', CoordName);
	Fandian_SetCookie('longitude', CoordLongitude);
	Fandian_SetCookie('latitude', CoordLatitude);
	window.location = FANDIAN_BASE_URL+'vendor';
}

function MapSearch()
{
	THIS_ADDRESS   = $('#stepadd').val();
	THIS_COORDGUID = $('#CoordGuid').val();

	if (THIS_COORDGUID != '' && RESEARCH) {
		window.location = FANDIAN_BASE_URL + 'vendor';
	} else {
		$("#mkey").val(THIS_ADDRESS);
		MapSearchBox();
	}
}

function MapSearchBox(){
	$(".inline").colorbox({
		
		href:'#modal_address_map',
		title:"将地图拖动到您所在的区域<input type='hidden' id='address_confirm' name='address_confirm' value='确定' onclick='Fandian_ChooseFirstCoord();' />",
		inline:true, 
		width:"820px",
		height:"550px",
		//onOpen:function(){},
		onLoad:function(){
			if(RELOAD)
			{
				Fandian_Service_BaiduPlace($('#mkey').val(), function(){
					if (bmap==null) {
						Fandian_LoadBaiduMapScript('Fandian_RenderAddressMap');
					} else {
						Fandian_RenderAddressMap();
					}
					if (!bmapTimer) {
						bmapTimer = setInterval(Fandian_MoveMapCenter, 500);
					}
				});
			}
		},
		//onComplete:function(){},
		//onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
		onClosed:function(){ 
			RELOAD = true;
			if (bmapTimer) {
				clearInterval(bmapTimer);
			}
			$('#gonext').attr('disabled',false);
		 }
	});
}
function ValidateRegisterElement(key,val)
{
	$('#error_'+key).html("<img src='"+FANDIAN_BASE_URL+"images/ac_loading.gif' alt='loading' />");

	$.get(FANDIAN_SCRIPT_URL+'register/validate?key='+encodeURIComponent(key)+'&val='+encodeURIComponent(val),function(response){
		var r = eval('(' + response + ')');
		
		if (r.success>0) {
			$('#error_'+key).removeClass('rerror').addClass('success');
		} else {
			$('#error_'+key).removeClass('success').addClass('rerror');
		}

		$('#error_'+key).html(r.msg);
	});
}


function ValidateRegister()
{
	flag = false;

	username = $('#UserName').val();
	password = $('#PassWord').val();
	password2 = $('#PassWord2').val();
	realname = $('#RealName').val();
	email =$('#Email').val();
	cell = $('#Cell').val();
	captcha = $('#Captcha').val();

	var error = 0;
	if (username=='') {
		$('#error_UserName').removeClass('success').addClass('rerror').html('请填写您的用户名');
		error = 1;
	}

	if (password=='') {
		$('#error_PassWord').removeClass('success').addClass('rerror').html('请填写您的密码');
		error = 1;
	} else if (password!=password2) {
		$('#error_PassWord2').removeClass('success').addClass('rerror').html('两次输入的密码不一致');
		error = 1;
	}

	if (realname=='') {
		$('#error_RealName').removeClass('success').addClass('rerror').html('请填写您的姓名');
		error = 1;
	}

	if (email=='') {
		$('#error_Email').removeClass('success').addClass('rerror').html('请填写您的Email地址');
		error = 1;
	}

	if (cell=='') {
		$('#error_Cell').removeClass('success').addClass('rerror').html('请填写您的手机号码');
		error = 1;
	}

	if (captcha=='') {
		$('#error_Captcha').removeClass('success').addClass('rerror').html('请填写验证码');
		error = 1;
	}

	if (error == 0) {
		flag = true;
	}
	
	return flag;
}


function GetDateStr(AddDayCount) {
    var dd = new Date();
    dd.setDate(dd.getDate()+AddDayCount);//获取AddDayCount天后的日期
    PRE_YEAR = dd.getFullYear();
    PRE_MONTH = dd.getMonth()+1;//获取当前月份的日期
    PRE_DAY = dd.getDate();
}

/**
 * 检查预定时间是否在商家营业时间范围内容
 * 
 */
function CheckPreTime()
{
	result = false;
	
	var day = $('#order_pre_day').val();
	GetDateStr(parseInt(day));
	
	var pre_hour   = $('#order_pre_hour').val();
	var pre_minute = $('#order_pre_minute').val();
	var pre_date = new Date();

	pre_date.setFullYear(PRE_YEAR);
	pre_date.setMonth(PRE_MONTH-1);
	pre_date.setDate(PRE_DAY);
	pre_date.setHours(pre_hour);
	pre_date.setMinutes(pre_minute);
	pre_date.setSeconds(0);
	var pre_time = pre_date.getTime();
	
	var now = new Date();
	var nowt = now.getTime();
	var now_year = now.getFullYear();
	var now_month = now.getMonth();
	var now_day = now.getDate();

	if (nowt<pre_time) {
		for (var i in VENDOR_SERVICE_TIME) {
			var _offset = 1;
			start = VENDOR_SERVICE_TIME[i].start;
			end = VENDOR_SERVICE_TIME[i].end;
			
			start_hour = parseInt(start.substr(0,2));
			end_hour = parseInt(end.substr(0,2));
			
			sdate = new Date();
			edate = new Date();
			
			for(var j=0;j<3;j++) {
				sdate.setTime(pre_time+(j-1)*JS_ONE_DAY);
				sdate.setHours(start_hour);
				sdate.setMinutes(parseInt(start.substr(3,2)));
				sdate.setSeconds(0);
				stime = sdate.getTime();
				
				if (start_hour>end_hour) {
					edate.setTime(pre_time+j*JS_ONE_DAY);
				} else {
					edate.setTime(pre_time+(j-1)*JS_ONE_DAY);
				}
				edate.setHours(end_hour);
				edate.setMinutes(parseInt(end.substr(3,2)));
				edate.setSeconds(0);
				etime = edate.getTime();	
				
				if (pre_time>stime && pre_time<etime) {
					result = true;
				}
			}
		}
	}

	if(!result)
	{
		alert("预定时间不在商家服务时间范围内，或者不在我们外送的服务时间范围内！请重设。");
	}
	return result;
}

/**
 * 检查预定时间是否在业务营业时间范围内
 * 
 */
function CheckServicePreTime()
{
	result = false;
	var day = $('#order_pre_day').val();
	GetDateStr(parseInt(day));
	
	var pre_hour   = $('#order_pre_hour').val();
	var pre_minute = $('#order_pre_minute').val();
	var pre_date = new Date();

	pre_date.setFullYear(PRE_YEAR);
	pre_date.setMonth(PRE_MONTH-1);
	pre_date.setDate(PRE_DAY);
	pre_date.setHours(pre_hour);
	pre_date.setMinutes(pre_minute);
	pre_date.setSeconds(0);
	var pre_time = pre_date.getTime();
	
	_start = new Date();
	_start.setFullYear(PRE_YEAR);
	_start.setMonth(PRE_MONTH-1);
	_start.setDate(PRE_DAY);
	_start.setHours(SERVICE_SERVICE_TIME.sh);
	_start.setMinutes(SERVICE_SERVICE_TIME.sm);
	_start_time = _start.getTime();
	
	_end_time = _start_time + SERVICE_SERVICE_TIME.et - SERVICE_SERVICE_TIME.st;

	if (pre_time>=_start_time && pre_time<=_end_time) {
		result = true;
	} else {
		_end = new Date();
		_end.setFullYear(PRE_YEAR);
		_end.setMonth(PRE_MONTH-1);
		_end.setDate(PRE_DAY);
		_end.setHours(SERVICE_SERVICE_TIME.eh);
		_end.setMinutes(SERVICE_SERVICE_TIME.em);
		
		_end_time = _end.getTime();
		_start_time = _end_time - SERVICE_SERVICE_TIME.et + SERVICE_SERVICE_TIME.st;
		if (pre_time>=_start_time && pre_time<=_end_time) {
			result = true;
		}
	}
}


function scall(){
	var footer_top =$('#footer').offset().top;
	var sidebar_height = document.getElementById("sidebar").offsetHeight;		
	var scrolltop = getScrollTop();
	var sheight = scrolltop + sidebar_height;

	if(scrolltop > sidebar_top && sheight < footer_top && sidebar_height <clientheight)
	{
		$("#sidebar").css('top',scrolltop - sidebar_top);
	}else if( sheight > footer_top )
	{
		$("#sidebar").css('top',scrolltop - sidebar_top-(sheight-footer_top));
	}else if(sidebar_height > clientheight && scrolltop > sidebar_top ){
		$("#sidebar").css('top',scrolltop - sidebar_top-(sidebar_height-clientheight));
	}else{
		$("#sidebar").css('top',0);
	}

	if(IS_TABTOP)
	{
		if(scrolltop > catab_top)
		{
			$("#catab").css('top',scrolltop - catab_top);
		} else
		{
			$("#catab").css('top',0);
		}
	}
}

function getScrollTop()
{
    var scrollTop=0;
    if(document.documentElement&&document.documentElement.scrollTop)
    {
        scrollTop=document.documentElement.scrollTop;
    }
    else if(document.body)
    {
        scrollTop=document.body.scrollTop;
    }
    return scrollTop;
}

this.screenshotPreview = function(){	
	xOffset = 10;
	yOffset = 10;
	$("a.screenshot").hover(function(e){
		this.t = this.title;
		this.title = "";	
		var c = (this.t != "") ? "<br/>" + this.t : "";
		$("body").append("<p id='screenshot'><img src='"+ this.rel +"' />"+ c +"</p>");								         
		$("#screenshot")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px")
			.fadeIn("fast");						
    },
	function(){
		this.title = this.t;	
		$("#screenshot").remove();
    });	
	$("a.screenshot").mousemove(function(e){
		$("#screenshot")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px");
	});			
};

/**
* 检测字符串是否是GUID
* @param string
*/
function Fandian_IsGuid(string)
{
return !!(/^([A-F0-9]{8})-([A-F0-9]{4})-([A-F0-9]{4})-([A-F0-9]{4})-([A-Z0-9]{12})$/.test(string));
} 

function SwitchFavoriteStatus(dom)
{
	if (Fandian_IsGuid(FANDIAN_UID) && Fandian_IsGuid(VENDOR_GUID)) {
		if (!VENDOR_IS_FAVORITED) {
			$.get(FANDIAN_BASE_URL+'member/favorites/add_vendor?VendorGuid='+VENDOR_GUID,function(response){
				VENDOR_IS_FAVORITED = true;
				$(dom).html('取消收藏');
				$('#vendor_favorites_count').html(parseInt($('#vendor_favorites_count').html())+1);
			});
		} else {			
			$.get(FANDIAN_BASE_URL+'member/favorites/del_vendor?VendorGuid='+VENDOR_GUID,function(response){
				VENDOR_IS_FAVORITED = true;
				$(dom).html('收藏');
				$('#vendor_favorites_count').html(parseInt($('#vendor_favorites_count').html())-1);
			});
		}
	} else {
		alert('请先登录！');
	}
}