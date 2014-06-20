<?php  if ($count > 0) { ?>
<span style="float:right;padding:3px;font-size:15px;color:blue">共查询到<?php echo htmlspecialchars($count, ENT_QUOTES, 'UTF-8');?>条记录,涉及金额<strong style="color:red"><?php echo htmlspecialchars($orderTotalMoney, ENT_QUOTES, 'UTF-8');?>元</strong>,每页显示<?php echo htmlspecialchars($perPage, ENT_QUOTES, 'UTF-8');?>条 </span>
<?php  } ?>

<ul class="myddorder_list">
		
	   <?php  if ($orderList) { 
  if ($showcheckbox) { ?>
	   <div style="display:none">
	   			<input name=checkAll class="checkAll" type="checkbox">全选/全不选</checkbox>
	   	</div>		
	   			<?php  } 
 foreach ($orderList as $key => $item) {?>
	   <li class="myddorder_list_li" onmouseout="this.style.background='#ffffff'" onmouseover="this.style.background='#ffffff'" style="background-image: none; background-position: initial initial; background-repeat: initial initial;">
			<?php  if($item['status']==2||$item['status']==3||$item['status']==4){ ?>
			<div class="dmoney">
				<span>确认收货后可获得点币<?php echo htmlspecialchars($item['deservedpointcoin'], ENT_QUOTES, 'UTF-8');?>(<?php echo htmlspecialchars($item['deservedpointcoin']/10, ENT_QUOTES, 'UTF-8');?>元RMB)</span>
			</div>
			<?php  } ?>	   	
	   	<div class="orderinfo">
	   		<span class="list_input">
	   			<?php  if ($showcheckbox) { ?>
	   			<div style="display:none">
	   			<input name=checkeditem[<?php echo htmlspecialchars($item['id'], ENT_QUOTES, 'UTF-8');?>]} class="checkSingle" type="checkbox"></checkbox>
	   			</div>
	   			<?php  } ?>
	   		</span>
	   		<span class="list_order"><a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&c=schoolorder&a=orderitem&orderid=', rawurlencode($item['id']),'&app=4tschool'; ?>" >订单号:<?php echo htmlspecialchars($item['ordernumber'], ENT_QUOTES, 'UTF-8');?></a></span>
	   		<span class="list_name">收货人:<?php echo htmlspecialchars($item['towho'], ENT_QUOTES, 'UTF-8');?></span>
	   		<span class="list_name">客户电话:<?php echo htmlspecialchars($item['tomobile'], ENT_QUOTES, 'UTF-8');?></span>
			<span class="list_way">流水号:<?php echo htmlspecialchars($item['sequence'], ENT_QUOTES, 'UTF-8');?></span>
			<span class="list_total"><strong style="color:red">共计: ￥<?php echo htmlspecialchars($item['ordermoney'], ENT_QUOTES, 'UTF-8');?></strong></span>
			<span class="list_time"> <?php echo htmlspecialchars($item['orderdate'], ENT_QUOTES, 'UTF-8');?></span>
			<span class="list_operation">

				<?php  if (!$finishedStatus[$item['status']]) { ?>
				<strong  style="color:red">
				<?php  } 
 echo htmlspecialchars($allStatus[$item['status']], ENT_QUOTES, 'UTF-8');
  if ($allowChangeResponsible) { ?>
				<a href="" class="mr10 assignSingle" title="点击分配或者更改"><?php echo htmlspecialchars($item['deliveruser'] ==''?'[点击分配]':$item['deliveruser'], ENT_QUOTES, 'UTF-8');?></a>
				<?php  } else { ?>
				<!-- <?php echo htmlspecialchars($item['deliveruser'] ==''?'[无配送人]':$item['deliveruser'], ENT_QUOTES, 'UTF-8');?> -->
				<?php  } 
  if (!$finishedStatus[$item['status']]) { ?>
				</strong>
				<?php  } 
  if ($item['firstorder']) { ?>
				<strong style="color:#4966D1">
					(首次下单)
				</strong>
				<?php  } ?>

			</span>

			<span class="list_estimatedelivery" style="padding:8px;">
				配送地址: <?php echo htmlspecialchars($item['to'], ENT_QUOTES, 'UTF-8');?>
				
			</span>
			<span class="list_note" style="padding-left:5px;"><strong style="color:red">备注: <?php echo htmlspecialchars($item['note']==""?"无":$item['note'], ENT_QUOTES, 'UTF-8');?></strong></span>
			<?php  if(($item['status']==2||$item['status']==3||$item['status']==4)&&$needConfirm){ ?>
			<input type="button" class="btnSearch" name="confirmOrder" value="确认收货" style="float:right;margin-right:10px">
			<?php  } 
 if(!$defaultShowPhone){?>
			<span style="background-color:#FFFB75">商家电话：<?php echo htmlspecialchars($item['phonenumber'], ENT_QUOTES, 'UTF-8');?>,<?php echo htmlspecialchars($item['contactnumber'], ENT_QUOTES, 'UTF-8');?></span>
			<?php }?>
			</div>
			<?php  if(($item['status']==2||$item['status']==3||$item['status']==4)&&$needConfirm){ ?>
			<div id="commentAndConfirmOrder" name="commentAndConfirmOrder" class="order-comment" style="display:none">
					<input type="hidden" name="confirmOrderUrl" value="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&c=schoolorder&a=doSaveComment&app=4tschool'; ?>">
					<input type="hidden" name="orderId" value="<?php echo htmlspecialchars($item['id'], ENT_QUOTES, 'UTF-8');?>">
					<input type="hidden" name="shopId" value="<?php echo htmlspecialchars($item['shopid'], ENT_QUOTES, 'UTF-8');?>">					
					<div class="root">
						<div class="time">
							<lable>送餐速度(分钟)</lable><br/>
						</div>
                        <div id="note_wrapper" name="note_wrapper">
                            <div class="note-bubble" id="note_bubble" style="width:305px;margin-left:50px;margin-top:-10px">
                                <div class="quick-notes clearfix" id="quick_notes">
                                    <a class="bubble-triangle" time="15">火箭</a>
                                    <a time="30">飞机</a>
                                    <a time="45">汽车</a>
                                    <a time="60">步行</a>
                                    <a time="120">爬行</a>
                                </div>
                            </div>
                            <input type="button" value="-" class="ui-btn-green" name="decrease" style="width:10%">
                            <input type="text" value="" id="deliveryTime" name="deliveryTime" readonly="readonly">
                            <input type="button" value="+" class="ui-btn-green" name="increase" style="width:10%">
                        </div>						
					</div>
					<div class="root">
						<div class="comment">
							<label>评论</label><br/>
						</div>
						<textarea name="comment"></textarea>
					</div>
					<div class="root">
						<div class="confirm">
							<label>确认评价</label><br/>
						</div>
						<input id="confirmOrderBtn" name="confirmOrderBtn" class="ui-btn-violet" type="button" value="提交">
					</div>
			</div>
			<?php  } ?>
			<br/>
			<div style="float:left">
			<table border="0" cellpadding="0" cellspacing="0" class="tabl_merch orderitemtable">  	 
			            <tbody>
			            	<?php  if ($orderItems) { 
 foreach ($orderItems as $key => $orderitem) {
  if ($orderitem['orderid'] == $item['id']) { ?>
			            	<tr onmouseout="this.style.background='none'" onmouseover="this.style.background='#f4f4f4'" >
			            		<td class="tab_w">
			            			<input type="hidden" name="shopids[]" value="<?php echo htmlspecialchars($orderitem['shopid'], ENT_QUOTES, 'UTF-8');?>">
			            		</td>
			            		<td class="tab_w1">
			            			<a name="productname" href="<?php echo Wekit::app()->baseUrl,'/','school-', rawurlencode($schoolId),'-4tschool-shopdetails-run-', rawurlencode($orderitem['shopid']),'?app=4tschool'; ?>" target="" title="<?php echo htmlspecialchars($orderitem['name'], ENT_QUOTES, 'UTF-8');?>"><?php echo htmlspecialchars($orderitem['shopname'], ENT_QUOTES, 'UTF-8');?> -- <?php echo htmlspecialchars($orderitem['quatity'], ENT_QUOTES, 'UTF-8');
 echo htmlspecialchars($orderitem['unit'], ENT_QUOTES, 'UTF-8');
 echo htmlspecialchars($orderitem['mname'], ENT_QUOTES, 'UTF-8');?> -- (<?php echo htmlspecialchars($orderitem['sequence'], ENT_QUOTES, 'UTF-8');?>)</a>
			            			<?php  if ($orderitem['promoUsed'] != '') { ?>
			            				<br/>
			            				<strong style="color:red"><?php echo htmlspecialchars($orderitem['promoUsed'], ENT_QUOTES, 'UTF-8');?></strong>

			            			<?php  } ?>
			            		</td>
			            		
			            		<td class="tab_w7">积分:<?php echo htmlspecialchars($orderitem['integral'], ENT_QUOTES, 'UTF-8');?></td>
			            		<td><span>单价:￥<?php echo htmlspecialchars($orderitem['price'], ENT_QUOTES, 'UTF-8');?>(<?php echo htmlspecialchars($orderitem['packingprice']==0?"无外卖费用":"含外卖费用", ENT_QUOTES, 'UTF-8');?>)</span></td>
			            		<td class="list_total"><strong>&nbsp;共计￥<?php echo htmlspecialchars($orderitem['totalMoney'], ENT_QUOTES, 'UTF-8');?>

			            		</strong>
			            		</td>
			            		<td>
			            			&nbsp;<strong style="color:red"><?php echo htmlspecialchars($allStatus[$orderitem['status']]==""?"已授理":$allStatus[$orderitem['status']], ENT_QUOTES, 'UTF-8');?></strong> &nbsp;

			            			 <?php  if ($allowChangeItem) { 
  if ($orderitem['status']=="-1") { ?>
			            				<a href="<?php echo Wekit::app()->baseUrl,'/','index.php?m=app&c=schoolorder&a=changeItem&orderid=', rawurlencode($item['id']),'&orderItemId=', rawurlencode($orderitem['id']),'&app=4tschool'; ?>" class="changeItem">进行换货>></input>

			            			<?php  } 
  } ?>

			            		</td>
			            </tr>
			            <?php  } 
 }
  } else { ?>
						<span class="noresult">没有符合条件的结果！</span>
						<?php  } ?>
			 </tbody>
			</table>
			</div>
	   </li>
	   <?php }
  } else { ?>
			<span class="noresult">没有符合条件的结果！</span>
		<?php  } ?>
	</ul>
	<script type="text/javascript">

		$(".checkAll").click(function(event)
		{
			if($(".checkAll").attr("checked") == "checked")
			{
				$(".checkSingle").each(function(i,item)
				{
					$(item).click();
					$(item).attr("checked","checked");
				});
			}
			else
			{
				$(".checkSingle").each(function(i,item)
				{
					$(item).removeAttr("checked");
				});
			}
		});

		$(".checkSingle").click(function(event)
		{
			var allChecked = true;

			$(".checkSingle").each(function(i,item)
			{
				
				if($(item).attr("checked") != "checked")
				{
					allChecked = false;
				}
			});

			if(allChecked)
				$(".checkAll").attr("checked","checked");
			else
				$(".checkAll").removeAttr("checked");
			
		});

		$("[name='confirmOrder']").click(function(event) {
			$(this).closest(".myddorder_list_li").find("#commentAndConfirmOrder").toggle("normal");
		});

		$("[name='deliveryTime']").focus(function () {
			$(this).closest("#note_wrapper").find("#note_bubble").show();
		});
					

		$("body").on("click", function (e) {
			if ($("[name='note_wrapper']").length>0) {
				$("[name='note_wrapper']").each(function(index, el) {
					if (!$(this).has(e.target).length) {
						$(this).find("#note_bubble").hide();
					}					
				});
			};
		});

		$("#quick_notes > a").on("click", function () {
			var timeObj=$(this).closest("#note_wrapper").find("[name='deliveryTime']");
			var time = $(timeObj).val();
			var selected = $(this).attr("time");
			if (time==selected) {
				return false
			}
			$(timeObj).val(selected);
		});

		$("[name='confirmOrderBtn']").click(function(event) {
			$(this).attr({"disabled":"disabled"});
			$(this).css("background-color","#D6D6D6");
			$(this).val("正在提交..");

			var containerObj=$(this).closest("#commentAndConfirmOrder");
			var url=$("[name='confirmOrderUrl']").val();
			var oid=$(containerObj).find("[name='orderId']").val();
			var sid=$(containerObj).find("[name='shopId']").val();
			var time=$(containerObj).find("#deliveryTime").val();
			var cmt=$(containerObj).find("[name='comment']").val();
			$.post(url, {orderId:oid,shopId:sid,deliveryTime:time,comment:cmt}, function(r) {
				$(containerObj).toggle("normal");
				window.location.href=r;
			});
		});

		var maxTime=120;
		var minTime=10;
		$("[name='increase']").click(function(event) {
			var timeObj=$(this).closest("#note_wrapper").find("[name='deliveryTime']");
			var time=parseInt($(timeObj).val());
			if (isNaN(time)) {
				$(timeObj).val(minTime);
				return;
			};
			var increaseTime=time+1;
			if (increaseTime>maxTime) {
				increaseTime=maxTime;
			};
			$(timeObj).val(increaseTime);
		});

		$("[name='decrease']").click(function(event) {
			var timeObj=$(this).closest("#note_wrapper").find("[name='deliveryTime']");
			var time=parseInt($(timeObj).val());
			if (isNaN(time)) {
				$(timeObj).val(minTime);
				return;
			};			
			var decreaseTime=time-1;
			if (decreaseTime<minTime) {
				decreaseTime=minTime;
			};
			$(timeObj).val(decreaseTime);
		});		

	</script>
