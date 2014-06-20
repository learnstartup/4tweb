var ADM_DIV="ADAREA",ADM_LOADED=false,ADM_O1,ADM_O2,AD,ADM_Ver="1.0",ADM_S=new Array(),ADM_RESIZE=new Array(),ADM_F="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0";var ADM_CE=document.all?1:(document.getElementById?0:-1);document.write("<div id='"+ADM_DIV+"'></div>");function InitSchedule(){ADM_S.sort(ADM_sort);for(iAI=0;iAI<ADM_S.length;iAI++)ADM_S[iAI].i=iAI;}function ADM_sort(a,b){return(a.p>b.p)?1:((a.p==b.p)?0:-1);}

function ADM_Start(o){if(eval("typeof("+o.t+"_main)")=="function") eval(o.t+"_main(o)");}

function DoSchedule(){var p=-1;for(dAI=0;dAI<ADM_S.length;dAI++){switch(ADM_S[dAI].s){case 0:if(p==-1)p=ADM_S[dAI].p;if(p==ADM_S[dAI].p){ADM_S[dAI].s=1;ADM_Start(ADM_S[dAI]);break;}case 1:setTimeout("DoSchedule()",300);return;default :}}}if(ADM_CE>-1){window.onload=function ADM_PUSH(){if(!ADM_LOADED){ADM_LOADED=true;InitSchedule();DoSchedule();}}
window.onresize=function(){for(oAI=0;oAI<ADM_RESIZE.length;oAI++)eval(ADM_RESIZE[oAI]);}}function WriteAd(id,s){var o0=document.getElementById(id);if(o0==null){o0=document.createElement("div");o0.id=id;if(ADM_CE==1)document.getElementById(ADM_DIV).insertAdjacentElement("beforeBegin",o0);else document.getElementById(ADM_DIV).insertBefore(o0,null);}o0.innerHTML=s;}

function AddSchedule(oo){if(oo!=null && oo instanceof ADM)ADM_S[ADM_S.length]=oo;}

function ADM(t,p){this.t=t;this.p=p;this.s=0;this.i=0;this.style="position:absolute;";}

function ADM_Check(o){return o.CookieHour && ADM_CheckCookie(o.t+o.p+location.host.substring(0,location.host.indexOf(".")),o);}

function ADM_CheckCookie(E,o){var Now=new Date();var s=String(Now.getYear())+String(Now.getMonth()+1)+String(Now.getDate());if(ADM_GetCookie(E)==s)return true;else{Now.setTime(Now.getTime()+(parseFloat(typeof(o.CookieHour)=="undefined"?24:parseFloat(o.CookieHour))*60*60*1000));ADM_SetCookie(E,s,Now);return false;}}

function ADM_GetCookie(n){var args=n+"=";var aLength=args.length,cLength=document.cookie.length,AAi=0;while(AAi<cLength){var AAj=AAi+aLength;if(document.cookie.substring(AAi, AAj)==args)return ADM_GetCookieVal(AAj);AAi=document.cookie.indexOf(" ", AAi)+1;if(AAi==0)break;}return null;}

function ADM_GetCookieVal(offset){var endstr=document.cookie.indexOf(";", offset);if(endstr==-1)endstr=document.cookie.length;return unescape(document.cookie.substring(offset, endstr));}

function ADM_SetCookie(name, value){var argv=ADM_SetCookie.arguments;var argc=ADM_SetCookie.arguments.length;var expires=(argc>2)?argv[2]:null;var path=(argc>3)?argv[3]:null;var domain=(argc>4)?argv[4]:null;var secure=(argc>5)?argv[5]:false;document.cookie=name+"="+escape(value)+((expires==null)?"":("; expires="+expires.toGMTString()))+((path==null)?"":("; path="+path))+((domain==null)?"":("; domain="+domain))+((secure==true)?"; secure":"");}

function ADM_Media(a,w,h,o,id,href){var s="";if(a.indexOf(".swf")!=-1){if(ADM_CE==1){s="<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='"+ADM_F +"' id='"+((id==null)?o.t:id)+"' width='"+w+"' height='"+h+"' ";if(o.style)s+=" style='"+o.style+"'";if(o.extfunc)s+=" "+o.extfunc+" ";s+=" ><param name='movie' value='"+a+"'>";if(o.play)s+="<param name='play' value='"+o.play+"'>";if(o.wmode&&o.wmode!="")s+="<param name='wmode' value='"+o.wmode+"'>";if(typeof(o.loop)!="undefined")s+="<param name='loop' value='"+o.loop+"'>";s+="<param name='quality' value='autohigh'></object>";}else{s="<embed ";if(o.style)s+=" style='"+o.style+"'";if(o.extfunc)s+=" "+o.extfunc+" ";s+=" src='"+a+"'"+" quality='autohigh' id='"+((id==null)?o.t:id)+"' name='"+((id==null)?o.t:id)+"' width='"+w+"' height='"+h+"' ";if(o.wmode&&o.wmode!="")s+=" wmode='"+o.wmode+"' ";if(typeof(o.loop)!="undefined")s+=" loop='"+o.loop+"' ";s+="type='application/x-shockwave-flash' pluginspage='http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash'></embed>";}}else if(a.indexOf(".gif")!=-1||a.indexOf(".jpg")!=-1){s="<a href='"+((href==null)?o.href:href)+"' target='_blank'><img ";if(o.style)s+=" style='"+o.style+"'";if(o.extfunc)s+=" "+o.extfunc+" ";s+=" id='"+((id==null)?o.t:id)+"' src='"+a+"' border='0' width='"+w+"' height='"+h+"'></a>";}return s;}

function ADM_Close(o,n){ADM_S[o].s=2;var OBJ=document.getElementById(n);if(OBJ)OBJ.style.display="none";}

function FULL_main(o){if(ADM_Check(o)){o.s=2;return;}var IS_Find=false;if(o.StartTime.length==o.EndTime.length && o.EndTime.length==o.src.length && o.src.length==o.href.length){for(FAi=0;FAi<o.src.length;FAi++){var ST=new Date(o.StartTime[FAi]);var ET=new Date(o.EndTime[FAi]);var NT=new Date();if((ST<=ET)&&(NT<ET)&&(NT>=ST)){var OBJ=document.getElementById("scroll_banner");if(OBJ!=null){self.scroll(0,0);OBJ.style.display="block";o.style="";OBJ.innerHTML=ADM_Media(o.src[FAi],778,350,o,"",o.href[FAi]);IS_Find=true;setTimeout("ADM_Close("+o.i+",'scroll_banner')",isNaN(parseInt(o.timeout))?5000:parseInt(o.timeout));return;}else{o.s=2;return;}}}if(!IS_Find)ADM_Close(o.i,"scroll_banner");}}