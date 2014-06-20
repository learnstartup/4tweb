function pageLoad()
{
	if(isRedirect())
	{
			var a=$.cookie("uniID");
			location.href="/area/"+a}
}

function isRedirect()
{
var b=$.cookie("uniID"),a=$.cookie("preURL");
$.cookie("uniID")!=null&&$.cookie("uniID")!=""&&$.cookie("uniName")!=null&&$.cookie("preURL")!=null&&$.cookie("preURL").indexOf("html")<0&&a.indexOf("default")<0;
if(b!=null&&b!="")
{
if(a!=null&&a!=""&&(a.indexOf("html")>=0||a.indexOf("index")>=0))
{
	return false
}
else
{return true}
}else
{return false}
}

function chooseThis(a)
{
liLeft=a.position().left+10;
eWidth=a.width();
$(".triangle").css({display:"block",left:liLeft+0.5*eWidth+"px"})
}

function ChooseCity(a)
{
$(".body_top span").eq(0).html("").addClass("back").css("background","url(../images/back.png) no-repeat");
$("#city").html(a.html()).css("background","#F5F5F5").attr("class",a.attr("class")).removeClass("topspan").siblings("span").addClass("topspan");
chooseThis($("#city"));
$(".cities").hide(10);
$(".allareas").show();
$("#"+a.attr("class")).show().siblings("ul").hide(10);
$("#schools").hide(10);
$(".body_top img").hide(10)
}

$(function()
{
if($.browser.msie)
{
if($.browser.version=="6.0")
{
	$(document.body).append('<div id="ie6_bg"></div><div id="ie6_tip"><div id="ie6_sorry">对不起，您的浏览器版本过低，您可以尝试：</div><div id="ie6_wap" onclick="goWap();">访问简洁版点餐哟</div><div id="ie6_update" onclick="upBrow();">升级浏览器</div></div>')
}
else
{
	if($.browser.version=="7.0")
	{
		$("#city,#area,#shoparea").css("margin-top","6px");

		$(".body_top span").eq(0).css({top:"2px",position:"relative"})}

	}
}

FindPosition();

	$(".shoparea a").hover(function(){
		$(this).css({background:"#FD7837"})},function(){
		$(this).css({background:"no-repeat"})
	});

	$(".cities li").find("span").bind("click",function(){
		ChooseCity($(this));
		$(".back").hover(function(){

			if($(this).html()=="")
			{
				$(this).css("background","url(../images/back-hover.png) no-repeat")
			}},function(){
				if($(this).html()=="")
				{
					$(this).css("background","url(../images/back.png) no-repeat")
				}
		});
	});

	$(".back").live("click",back);

	$(".areas li").find("span").bind("click",function(){
		$targer=$("#schools #"+$(this).attr("class")).find(".shoparea");
		$(".body_top img").eq(0).show();
		$("#area").html($(this).html()).css("background","#F5F5F5").removeClass("topspan").siblings("span").addClass("topspan");
		$("#city").addClass("choose").siblings().removeClass("choose");
		chooseThis($("#area"));
		$(".allareas").hide(10);
		$("#schools").show();
		$(".shoparea").css({padding:"0px 10px 0px 0px"}).find("ul").show().find("li").css({border:"0px","margin-left":"10px"}).addClass("shopareali").find("a").css("background","no-repeat");
		$(".shoparea ul").css("margin-left","-11px");
		$("#schools #"+$(this).attr("class")).show().siblings("ul").hide(10);
		if($targer.length>0)
		{
			var b="<li class='tip'><div><em class='div_schoole'>大学</em><div  class='divhr'></div></div></li>";
			var a="<li class='tip'><div ><em class='div_shoparea'>商圈</em><div  class='divhr'></div></div></li>";

			$(".tip").remove();
			$targer.eq(0).before(a);$targer.eq($targer.length-1).after(b);
			$targer.eq($targer.length-1).css({border:"0px","margin-bottom":"-13px"});$(".tip").css("border",0);
			if($.browser.version=="7.0")
			{
				$(".divhr").addClass("div_hrIE");
				$(".shoparea li").css({"margin-left":"0px","margin-right":"8px"})
			}
			else
			{
				$(".divhr").addClass("div_hr")
			}
			
			$(".Sub_body").width("735px")
		}
	});

	$(".shoparea ul").find("a").bind("click",function(){
		$(".body_top img").eq(1).show();

		$("#schools").hide(10);$(".shopareas").show();

		$(".shopareas #"+$(this).attr("class")).show().siblings("ul").hide(10);

		$("#shoparea").html($(this).html()).css("background","#F5F5F5").removeClass("topspan").siblings("span").addClass("topspan");
		$("#area").addClass("choose").siblings().removeClass("choose");
		chooseThis($("#shoparea"))
	});

	$("#city").live("click",function(){
		livecity()
	});

	$("#area").live("click",function(){
		livearea()
	});

});

function back()
{
	var a=$(".body_top span").filter(function(){return $(this).html()!=""}).length;
	switch(a)
	{
		case 1:
			BackCity();
			break;
		case 2:
			livecity();
			break;
		case 3:
			livearea();
			break;
	}

	window.event.cancelBubble=true
}

function livecity()
{
	ChooseCity($("#city"));
	$(".shopareas").hide(10);$("#area").html("").css("background","#E7E4E1");
	$("#shoparea").html("").css("background","#E7E4E1");$(".body_top img").eq(0).hide(10)
}

function livearea()
{
	$(".body_top img").eq(1).hide(10);
	$(".shopareas").hide(10);chooseThis($("#area"));$("#schools").show();
	$(".shopareas").hide(10);
	$("#shoparea").html("").css("background","#E7E4E1");
	$("#area").removeClass("topspan").siblings("span").addClass("topspan")
}

function FindPosition()
{
	if($("#findcity").val()!="")
	{
		var b=window.document.width;
		var g=window.document.height;
		var a="",f="",e="",c="";

		if($("#findschool").val()!="")
		{
			var d=$("#findschool").val().split(",");
			a=d[0];
			f=d[1];
			c=" <a href='"+f+".html' id='position'>"+a+"</a>"
		}
		else
		{
			var d=$("#findcity").val().split(",");
			a=d[0];
			f=d[1];
			c=" <a class='"+f+"' id='position'>"+a+"</a>";
			$("#position").live("click",function(){
				$(".Guess,.Guess_detail,.Guess_Info").remove();$("."+f).click()
			})
		}

		e="   <div class='Guess'></div><div class='Guess_detail'></div><div class='Guess_Info'><div id='Guess'><img src='../images/loc.png' /><span>我们猜您在</span>"+c+"<div class='Error'>没猜对&nbsp;?<a id='showall'>显示全部>></a></div></div></div>";

		$(".for_guess").append(e);

		$(".Guess").width(b);

		$(".Guess").height(g);

		$(".Guess").addClass("GuessStyle");
		$(".Guess_detail").addClass("Guess_detailStyle");
		if($.browser.msie)
		{
			if($.browser.version=="7.0"||$.browser.version=="8.0")
			{
				$(".Guess").removeClass("GuessStyle").addClass("IEGuess");
				$(".Guess_detail").removeClass("Guess_detailStyle").addClass("IEGuess_detail")
			}
		}

		$("#showall").live("click",function(){
			$(".Guess,.Guess_detail,.Guess_Info").remove();
			BackCity()
		})
	}
}

function BackCity()
{
	$(".body_top img").hide(10);
	$(".body_top span").html("").css("background","").eq(0).html("请选择所在城市").removeClass("back");
	chooseThis($(".body_top span").eq(0));
	$(".cities").show();
	$("#schools,.allareas").hide(10);
	$(".shopareas").hide(10)
}
