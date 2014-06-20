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