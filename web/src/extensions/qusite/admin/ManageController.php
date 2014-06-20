<?php
Wind::import('APPS:admin.library.AdminBaseController');
/**
 * 后台访问入口
 *
 * @author 杨周 <yzhou91@aliyun-inc.com> QQ:89652519
 * @copyright ©2003-2103 phpwind.com
 * @license http://www.yhcms.com
 * @package wind
 */

class ManageController extends AdminBaseController {
	public $page = 1;
	public $perpage = 20;

    public function run() {
 		$service = Wekit::load('config.PwConfig');
 		list($schoolid) = $this->getInput(array('schoolid'), 'get');
 		$allSchool = $this->_get4TSchoolDS()->getOpenedSchools();
        $allSchool = array_values($allSchool);

 		$schoolnametag = empty($schoolid)?'qusite':'qusite_'.$schoolid;
 		$config = $service->getValues($schoolnametag);
 		$this->setOutput($allSchool, 'allSchool');
 		$this->setOutput($schoolid, 'schoolid');
		$this->setOutput($config, 'config');
    }
    
	
 	public function doSetAction() {
 		$arr = $this->getInput('config', 'post');
		$qqsuit=$this->qqsuit($arr['qq'],$arr['style'],$arr['tel'],$arr['isopen']);
		$qqsuit_js=$this->qqsuit_js($arr['qq'],$arr['style'],$arr['tel'],$arr['isopen']);
		if(empty($arr['schoolid']))
		{
			$this->_getyhcmsDs()->writeover("themes/extres/qusite/config.php","<?php\r\n\$_qqsuit=array(\r\n'qqsuit' =>'".$qqsuit."'\r\n);\r\n?>");
			$this->_getyhcmsDs()->writeover("themes/extres/qusite/qusite.js","$qqsuit_js");
			$config = new PwConfigSet('qusite');
		}
		else
		{
			$this->_getyhcmsDs()->writeover("themes/extres/qusite/config_".$arr['schoolid'].".php","<?php\r\n\$_qqsuit=array(\r\n'qqsuit' =>'".$qqsuit."'\r\n);\r\n?>");
			$this->_getyhcmsDs()->writeover("themes/extres/qusite/qusite_".$arr['schoolid'].".js","$qqsuit_js");
			$config = new PwConfigSet('qusite_'.$arr['schoolid']);
		}
		
 		
 		foreach($arr as $k => $v){
 			if(!$v)$v=0;
			$config->set($k, $v)->flush();
 		}
		
		$this->showMessage('设置成功');
 	}
	
   public function qqsuit($content,$type,$tel,$open){
	  $html ='<link href="/themes/extres/qusite/'.$type.'/qq.css" rel="stylesheet" type="text/css" /><DIV id="floatTools" class="folat_server">
 <DIV class="floatL"><A id="aFloatTools_Show" class="btnOpen" title="查看在线客服" onclick="QQ_Tool_Whow();" href="javascript:void(0);">展开</A> 
<A id="aFloatTools_Hide"  style="display:none" class="btnCtn" title="关闭在线客服" onclick="QQ_Tool_Hide();" href="javascript:void(0);">收缩</A> </DIV>
<DIV id="divFloatToolsView" class="floatR" style="display:none">
    <DIV class="tp"></DIV>
    <DIV class="cn">
      <UL>
        <LI class="top">
          <H3 class="titZx">QQ咨询</H3>
        </LI>';
      $b=explode('|',$content);
	  foreach ($b as $key => $value) { 
	  $v=explode(':',$value);
	  if($v[1]!=''){
	     $html .="<LI><SPAN class=\"icoZx\">$v[0]</SPAN></LI>";
		 $o=explode(',',$v[1]);
		  foreach ($o as $key => $value) { 
		  $r=explode('-',$value);
	     $html .= "<LI><img border=\"0\" src=\"http://wpa.qq.com/pa?p=2:$r[1]:45\" />&nbsp;&nbsp;<a href=\"http://wpa.qq.com/msgrd?v=3&uin=$r[1]&site=qq&menu=yes\" target=\"_blank\">$r[0]</a></LI>";
		 }
		 }
		 } 
      $html .='</UL>
      <UL>
        <LI>
          <H3 class="titDh">电话咨询</H3>
        </LI>';
		$t=explode(',',$tel);
	  foreach ($t as $key => $val) { 
        $html .='<LI><SPAN class="icoTl">'.$val.'</SPAN> </LI>';
	  }
	$html .='</UL>
    </DIV>
  </DIV>
</DIV>
<script src="/themes/extres/qusite/js/kefu.js"></script>';
         if($open){
			  return $html; 
	  }
	  }
  public function qqsuit_js($content,$type,$tel,$open){
	  $html ='document.writeln("<link href=\"themes\/extres\/qusite\/'.$type.'\/qq.css\" rel=\"stylesheet\" type=\"text\/css\" \/><DIV id=\"floatTools\" class=\"folat_server\">");
document.writeln(" <DIV class=\"floatL\"><A id=\"aFloatTools_Show\" class=\"btnOpen\" title=\"查看在线客服\" onclick=\"QQ_Tool_Whow();\" href=\"javascript:void(0);\">展开<\/A> ");
document.writeln("<A id=\"aFloatTools_Hide\"  style=\"display:none\" class=\"btnCtn\" title=\"关闭在线客服\" onclick=\"QQ_Tool_Hide();\" href=\"javascript:void(0);\">收缩<\/A> <\/DIV>");
document.writeln("<DIV id=\"divFloatToolsView\" class=\"floatR\" style=\"display:none\">");
document.writeln("    <DIV class=\"tp\"><\/DIV>");
document.writeln("    <DIV class=\"cn\">");
document.writeln("      <UL>");
document.writeln("        <LI class=\"top\">");
document.writeln("          <H3 class=\"titZx\">QQ咨询<\/H3>");
document.writeln("        <\/LI>';
  $b=explode('|',$content);
	  foreach ($b as $key => $value) { 
	  $v=explode(':',$value);
	  if($v[1]!=''){
	     $html .='<LI><SPAN class=\"icoZx\">'.$v[0].'</SPAN></LI>';
		 $o=explode(',',$v[1]);
		  foreach ($o as $key => $value) { 
		  $r=explode('-',$value);
	     $html .= '<LI><img border=\"0\" src=\"http://wpa.qq.com/pa?p=2:'.$r[1].':45\" />&nbsp;&nbsp;<a href=\"http://wpa.qq.com/msgrd?v=3&uin='.$r[1].'&site=qq&menu=yes\" target=\"_blank\">'.$r[0].'</a></LI>';
		 }
		 }
		 } 
$html .='<\/UL>");
document.writeln("      <UL>");
document.writeln("        <LI>");
document.writeln("          <H3 class=\"titDh\">电话咨询<\/H3>");
document.writeln("        <\/LI>';
$t=explode(',',$tel);
	  foreach ($t as $key => $val) { 
        $html .='<LI><SPAN class=\"icoTl\">'.$val.'</SPAN> </LI>';
	  }
$html .='<\/UL>");
document.writeln("    <\/DIV>");
document.writeln("  <\/DIV>");
document.writeln("<\/DIV>");
document.writeln("<script src=\"themes\/extres\/qusite\/js\/kefu.js\"><\/script>")';
         if($open){
			  return $html; 
	  }
	  }
   
	private function _getyhcmsDs() {
        return Wekit::load('SRC:extensions.qusite.service.yhcms');
    }

    private function _get4TSchoolDS()
    {
        return Wekit::load('EXT:4tschool.service.school.App_School');
    }
		
}

?>