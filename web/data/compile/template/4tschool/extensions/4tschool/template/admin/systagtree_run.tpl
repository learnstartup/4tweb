<!doctype html>
<html>
<head>
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

</head>
<body>
<div class="wrap">
	<!-- <div class="nav">
	<ul class="cc">
        	<li class="<?php echo htmlspecialchars($navType=='sm'?'current':'', ENT_QUOTES, 'UTF-8');?>"><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?app=4tschool&m=app&c=manage'; ?>">系统管理</a></li>
        	<li class="<?php echo htmlspecialchars($navType=='t'?'current':'', ENT_QUOTES, 'UTF-8');?>"><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?app=4tschool&m=app&c=tag'; ?>">标签管理</a></li>
        	<li class="<?php echo htmlspecialchars($navType=='sa'?'current':'', ENT_QUOTES, 'UTF-8');?>"><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?app=4tschool&m=app&c=schoolarea'; ?>">学校区域管理</a></li>
        	<li class="<?php echo htmlspecialchars($navType=='m'?'current':'', ENT_QUOTES, 'UTF-8');?>"><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?isall=all&app=4tschool&m=app&c=merchandise'; ?>">商品管理</a></li>
                <li class="<?php echo htmlspecialchars($navType=='p'?'current':'', ENT_QUOTES, 'UTF-8');?>"><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?app=4tschool&m=app&c=promo'; ?>">商家活动管理</a></li>
                <li class="<?php echo htmlspecialchars($navType=='mni'?'current':'', ENT_QUOTES, 'UTF-8');?>"><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?app=4tschool&m=app&c=merchandise&a=noitem'; ?>">商品缺货列表</a></li>
                <li class="<?php echo htmlspecialchars($navType=='sp'?'current':'', ENT_QUOTES, 'UTF-8');?>"><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?app=4tschool&m=app&c=schoolpeople'; ?>">学校管理</a></li>
                <li class="<?php echo htmlspecialchars($navType=='st'?'current':'', ENT_QUOTES, 'UTF-8');?>"><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?app=4tschool&m=app&c=systagtree'; ?>">分类结构管理</a></li>
                <li class="<?php echo htmlspecialchars($navType=='b'?'current':'', ENT_QUOTES, 'UTF-8');?>"><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?app=4tschool&m=app&c=boutique'; ?>">精品推荐管理</a></li>
                <li class="<?php echo htmlspecialchars($navType=='a'?'current':'', ENT_QUOTES, 'UTF-8');?>"><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?app=4tschool&m=app&c=announce'; ?>">公告管理</a></li>
                <li class="<?php echo htmlspecialchars($navType=='cateweekreport'?'current':'', ENT_QUOTES, 'UTF-8');?>"><a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?app=4tschool&m=app&c=cateweekreport'; ?>">美食周报</a></li>
	</ul>
</div> -->
	<div class="h_a">
	<input type="hidden" id="ajaxUrl_switch_type" value="<?php echo Wekit::app()->baseUrl,'/','admin.php?app=4tschool&m=app&c=systagtree&a=getSysTagTreeVersionByType'; ?>">
		类型：
    <select id="selType">
	  <?php foreach($treeType as $key => $value) {?>
			<option <?php if($key == 0) echo "selected=selected"; ?> value="<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8');?>" ><?php echo htmlspecialchars($value, ENT_QUOTES, 'UTF-8');?>
			</option>
	  <?php }?>
    </select>		
		版本：
    <select id="selVersion">
	  <?php foreach($treeVersion as $key => $value) {?>
			<option <?php if($key == count($treeVersion)) echo "selected=selected"; ?> value="<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8');?>" ><?php echo htmlspecialchars($value, ENT_QUOTES, 'UTF-8');?>
			</option>
	  <?php }?>
    </select>
        <input type="hidden" id="ajaxUrl_create" value="<?php echo Wekit::app()->baseUrl,'/','admin.php?app=4tschool&m=app&c=systagtree&a=createNewType'; ?>">    
		创建新类型：
		<input id="txtCreateNewType" />
	    <button id="btnCreateNewType">Create</button>
	</div>
	
  <div style="margin:5px">
  <input type="hidden" id="ajaxUrl_save" value="<?php echo Wekit::app()->baseUrl,'/','admin.php?app=4tschool&m=app&c=systagtree&a=saveAsNewVersion'; ?>">
  <input type="hidden" id="ajaxUrl_switch_ver" value="<?php echo Wekit::app()->baseUrl,'/','admin.php?app=4tschool&m=app&c=systagtree&a=getSysTagTreeById'; ?>">
  <input type="hidden" id="sysTagTree" value="<?php echo htmlspecialchars($treeList, ENT_QUOTES, 'UTF-8');?>">
  <!-- <label id='debug'>debug:</label> -->
  </div>
  <div style="width:750px">
   <div style = "width:380px;min-height:150px;background-color:#E6E6E6;float:left">
   	<div>
      <select id="txtNode">
	      <?php foreach($tagList as $key => $value) {?>
			<option value="<?php echo htmlspecialchars($value['id'], ENT_QUOTES, 'UTF-8');?>" ><?php echo htmlspecialchars($value['name'], ENT_QUOTES, 'UTF-8');?>
			</option>
	      <?php }?>
      </select>
      <button id="btnCreateNode">Create</button>
      <span>Search:</span>
      <input id="txtQuery" value=""/>
   	</div>
   	  <span style="color:red">Current Version</span>
 	  <div id = "tree_current"> </div>
      <span>版本描述:</span>
      <input id="txtDescription"/>
      <button id="btnSave">Save</button>
   </div>
   <div style = "width:350px;min-height:150px;background-color:#E6E6E6; float:right">
   	  <span style="color:red">Latest Version</span>
 	  <div id = "tree_latest"></div>
   </div>
  </div>
</div>

	<?php $__tplPageCount=(int)$count;
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
	<a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?page=', rawurlencode($_page_i),'&m=u&c=manage'; 
 echo htmlspecialchars($args ? '&' . http_build_query($args) : '', ENT_QUOTES, 'UTF-8');?>" class="pages_pre J_pages_pre">&laquo;&nbsp;上一页</a>
	<?php  if ($_page_min > 1) { 
		$_page_i = 1;		
	?>
	<a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?page=', rawurlencode($_page_i),'&m=u&c=manage'; 
 echo htmlspecialchars($args ? '&' . http_build_query($args) : '', ENT_QUOTES, 'UTF-8');?>">1...</a>
	<?php  } 
  for ($_page_i = $_page_min; $_page_i < $__tplPageCurrent; $_page_i++) { 
	?>
	<a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?page=', rawurlencode($_page_i),'&m=u&c=manage'; 
 echo htmlspecialchars($args ? '&' . http_build_query($args) : '', ENT_QUOTES, 'UTF-8');?>"><?php echo htmlspecialchars($_page_i, ENT_QUOTES, 'UTF-8');?></a>
	<?php  } 
  } ?>
	<strong><?php echo htmlspecialchars($__tplPageCurrent, ENT_QUOTES, 'UTF-8');?></strong>
<?php  if ($__tplPageCurrent < $_page_max) { 
  for ($_page_i = $__tplPageCurrent+1; $_page_i <= $_page_max; $_page_i++) { 
	?>
	<a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?page=', rawurlencode($_page_i),'&m=u&c=manage'; 
 echo htmlspecialchars($args ? '&' . http_build_query($args) : '', ENT_QUOTES, 'UTF-8');?>"><?php echo htmlspecialchars($_page_i, ENT_QUOTES, 'UTF-8');?></a>
	<?php  } 
  if ($_page_max < $__tplPageTotal) { 
		$_page_i = $__tplPageTotal;
	?>
	<a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?page=', rawurlencode($_page_i),'&m=u&c=manage'; 
 echo htmlspecialchars($args ? '&' . http_build_query($args) : '', ENT_QUOTES, 'UTF-8');?>">...<?php echo htmlspecialchars($__tplPageTotal, ENT_QUOTES, 'UTF-8');?></a>
	<?php  }
		$_page_i = $__tplPageCurrent+1;
	?>
	<a href="<?php echo Wekit::app()->baseUrl,'/','admin.php?page=', rawurlencode($_page_i),'&m=u&c=manage'; 
 echo htmlspecialchars($args ? '&' . http_build_query($args) : '', ENT_QUOTES, 'UTF-8');?>" class="pages_next J_pages_next">下一页&nbsp;&raquo;</a>
<?php  } ?>
</div>
<?php } ?>
	
</div>
<script src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','js'), ENT_QUOTES, 'UTF-8');?>/pages/admin/common/common.js?v<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>"></script>
<script type="text/javascript" src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>/4tschool/js/plugins/jstree.js">
</script>
<script type="text/javascript">
var baseJson = [
    {
		title : 'root'
	}
];

$(document).ready(function () {
	//get tree with the latest version
	var json;

	if ($("#sysTagTree").val()!="null")
	   json=$.parseJSON($.parseJSON($("#sysTagTree").val()).json);

	if (json) {
		    // var json=$.parseJSON($.parseJSON(r).json);
		    buildTree($("#tree_current"),json,false);
		    buildTree($("#tree_latest"),json,false);
	};


	//search in the tree
	$("#txtQuery").keyup(function (e) {
		var keyword;
		var key = (e.keyCode) || (e.which) || (e.charCode);//兼容IE(e.keyCode)和Firefox(e.which)
		if (key==13) {
		   keyword = $(this).val();
		}
		else if (key==27) {
		   $(this).val("");
		   keyword=$(this).val();
		};
		$("#tree_current").jstree("search", keyword);
	});

	//save the tree as a new version
	$("#btnSave").click(function () {
		if ($("#tree_current").children().length==0) {alert("无效的版本，请重新选择！");return;};

		var description=$("#txtDescription").val();
		if (description.length==0) {alert("请填写版本描述！");return;};		

		var type=$.trim($("#selType").find("option:selected").text());

		var tree = $("#tree_current").jstree("get_json", -1);

		//if the title of root node is "root", not include
		if (tree[0].title=="root") tree=tree[0].children;

		var ajaxUrl = $("#ajaxUrl_save").val();
		$.post(ajaxUrl,{"data":tree,"des":description,"type":type}, function (r) {
			if (r>0) {alert("保存成功")};
			location.replace(location.href);
		});
	});

	//create a new node in the tree
	$("#btnCreateNode").click(function () {

		var node={title : $("#txtNode").find("option:selected").text(),
		          a_attr:{id:$("#txtNode").val()}
		         };

		var tree=$.jstree.reference($("#tree_current"));

		tree.create_node(tree.get_selected(),node,"last",function(new_node){
			var n=new_node;
		});

		if (tree.is_closed(tree.get_selected())) {
			tree.open_node(tree.get_selected());
		};

	});

    //switch type
	$("#selType").change(function(){
		var type=$.trim($(this).find("option:selected").text());
		var ajaxUrl = $("#ajaxUrl_switch_type").val();

		$.post(ajaxUrl,{"type":type}, function (r) {
			if (r)  $("#selVersion").find("option").remove();

			var treeVersionList=$.parseJSON(r);

			for(var i in treeVersionList)
			{
			   $("<option value='"+treeVersionList[i].id+"'>"+treeVersionList[i].value+"</option>").appendTo($("#selVersion"));							
			}

			$("#selVersion").trigger('change');
		});			
	});	
    
    //switch version
	$("#selVersion").change(function(){
		var id=$(this).find("option:selected").val();
		var ajaxUrl = $("#ajaxUrl_switch_ver").val();

		$.post(ajaxUrl,{"id":id}, function (r) {		    
		    var json=$.parseJSON($.parseJSON(r).json);
		    buildTree($("#tree_current"),json,true);
		    buildTree($("#tree_latest"),json,true);
		});			
	});
     
    function buildTree(obj,data,isRebuild)
    {
          	if (isRebuild) {
          		$(obj).off('mousedown','a');
          		$(obj).jstree('destroy');
          	};
          	
            $(obj).jstree({
	            "json" : {
		            "data" : data
	            },
	            "search" : {
		            "case_sensitive" : true,
		            "show_only_matches" : false
	            },

	            "plugins" : ["json", "ui", "dnd", "crrm", "search", "contextmenu"]

            }).bind("select_node.jstree", function (e, element) {
	            if (element.node.context.attributes['href'] != undefined)
		            var href = element.node.context.attributes['href'].nodeValue;
	            // if (href!='#')window.open(data.node.context.attributes['href'].nodeValue);
            });

		    var tree=$.jstree.reference($(obj));

		    tree.refresh();
    }

    $("#btnCreateNewType").click(function(){
    	var type=$("#txtCreateNewType").val();
    	if (type.length==0) {alert("请填写类型名称！");return;};
    	var ajaxUrl=$("#ajaxUrl_create").val();	

    	$.post(ajaxUrl,{"type":type, "data":baseJson},function(r){
    		if (r>0) {    			
    			alert("创建成功");
    			location.replace(location.href);
    		};
    	});
    });

});
</script>
</body>
</html>