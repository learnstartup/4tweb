<?php if (!function_exists("FORUM_LIST_TABLE_MORE_ACROSS")) {function FORUM_LIST_TABLE_MORE_ACROSS($cateForum,$forumList){?>
<div class="ct">
	<table width="100%" summary="横排版块排序">
<?php 
$i = 0;
foreach ($forumList as $_id => $_item) {
	$i ++;
	$_class = $_item['icon'] ? '' : ($_item['todayposts'] > 0 ? 'new' : 'old');

 if ($i == 1) {?>
		<tr>
	<?php }?>
			<th class="<?php echo htmlspecialchars($_class, ENT_QUOTES, 'UTF-8');?>">
	<?php if($_item['icon']) {?>
				<a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=thread&fid=', rawurlencode($_id); ?>" target="_blank"><img alt="forumlogo" src="<?php echo htmlspecialchars(Pw::getPath($_item['icon']), ENT_QUOTES, 'UTF-8');?>" class="fl mr10"></a>
	<?php }?>
				<h3 class="fname"><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=thread&fid=', rawurlencode($_id); ?>"><?php echo $_item['name'];?></a><?php if ($_item['todayposts']) {?><span class="org fn">(今日<?php echo htmlspecialchars($_item['todayposts'], ENT_QUOTES, 'UTF-8');?>)</span><?php }?></h3>
				主题：<?php echo htmlspecialchars($_item['threads'], ENT_QUOTES, 'UTF-8');?>，帖子：<?php echo $_item['threads'] + $_item['posts'];?><br>
				<?php if ($_item['lastpost_time']) {?>最后回复：<a href="<?php echo Wekit::app()->baseUrl,'/','read.php?tid=', rawurlencode($_item['lastpost_tid']),'&fid=', rawurlencode($_id),'&page=e'; ?>#a" rel="nofollow"><span class="time"><?php echo htmlspecialchars(Pw::time2str($_item['lastpost_time'], 'auto'), ENT_QUOTES, 'UTF-8');?></span></a><?php }?>
			</th>
	<?php if ($i % $cateForum['across'] == 0) { $i = 0; ?>
		</tr>
	<?php } 
 } 
 if ($i > 0) { ?>
		</tr>
<?php }?>
	</table>
</div>

<?php }}?>
<?php if (!function_exists("FORUM_LIST_TABLE_ONE_ACROSS")) {function FORUM_LIST_TABLE_ONE_ACROSS($cateForum,$forumList){?>
<div class="ct">
	<table width="100%" summary="竖排版块排序">
	<col />
	<col width="100" />
	<col width="250" />
<?php foreach ($forumList as $_id => $_item) {
$_class = $_item['icon'] ? '' : ($_item['todayposts'] > 0 ? 'new' : 'old');
?>
	<tr>
		<th class="<?php echo htmlspecialchars($_class, ENT_QUOTES, 'UTF-8');?>">
	<?php if($_item['icon']) {?>
			<a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=thread&fid=', rawurlencode($_id); ?>" target="_blank"><img src="<?php echo htmlspecialchars(Pw::getPath($_item['icon']), ENT_QUOTES, 'UTF-8');?>" class="fl mr10" alt="forumlogo" /></a>
	<?php }?>
			<h3 class="fname"><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=bbs&c=thread&fid=', rawurlencode($_id); ?>"><?php echo $_item['name'];?></a><?php if ($_item['todayposts']) {?><span class="org fn">(今日<?php echo htmlspecialchars($_item['todayposts'], ENT_QUOTES, 'UTF-8');?>)</span><?php }?></h3>
			<p class="descrip"><?php echo $_item['descrip'];?></p>
<?php if ($_item['manager']) {?>
			<p class="descrip">版主：
	<?php foreach ($_item['manager'] as $name) {?>
			<a class="J_user_card_show" data-username="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8');?>" href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=space&username=', rawurlencode($name); ?>"><?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8');?> </a>
	<?php }?>
			</p>
<?php } ?>
		</th>
		<td><em class="org"><?php echo htmlspecialchars($_item['threads'], ENT_QUOTES, 'UTF-8');?></em>&nbsp;/&nbsp;<?php echo $_item['threads'] + $_item['posts'];?></td>
		<td class="last">
			<?php if($_item['lastpost_time']){?>
			<a href="<?php echo Wekit::app()->baseUrl,'/','read.php?tid=', rawurlencode($_item['lastpost_tid']),'&fid=', rawurlencode($_id); ?>" class="s4"><?php echo htmlspecialchars($_item['lastpost_info'], ENT_QUOTES, 'UTF-8');?></a><br />最后回复：<a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=space&username=', rawurlencode($_item['lastpost_username']); ?>" class="last_name J_user_card_show" data-username="<?php echo htmlspecialchars($_item['lastpost_username'], ENT_QUOTES, 'UTF-8');?>"><?php echo htmlspecialchars($_item['lastpost_username'], ENT_QUOTES, 'UTF-8');?></a><a href="<?php echo Wekit::app()->baseUrl,'/','read.php?tid=', rawurlencode($_item['lastpost_tid']),'&fid=', rawurlencode($_id),'&page=e'; ?>#a" aria-label="最后回复时间" title="跳转到最后一个楼层" class="last_name" rel="nofollow"><?php echo htmlspecialchars(Pw::time2str($_item['lastpost_time'], 'auto'), ENT_QUOTES, 'UTF-8');?></a>
			<?php }?>
		</td>
	</tr>
<?php }?>
	</table>
</div>

<?php }}?>