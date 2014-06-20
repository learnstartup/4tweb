
// jCart v1.3
// http://conceptlogic.com/jcart/

$(function() {

	var JCART = (function() {

		// This script sends Ajax requests to config-loader.php and relay.php using the path below
		// We assume these files are in the 'jcart' directory, one level above this script
		// Edit as needed if using a different directory structure
		var path = 'src/extensions/4tschool/controller/jcart-1.3/jcart',
			container = $('#jcart'),
			token = $('[name=jcartToken]').val(),
			tip = $('#jcart-tooltip');

		var config = (function() {
			var config = null;
			$.ajax({
				url: path + '/config-loader.php',
				data: {
					"ajax": "true"
				},
				dataType: 'json',
				async: false,
				success: function(response) {
					config = response;
				},
				error: function() {
					alert('Ajax error: Edit the path in jcart.js to fix.');
				}
			});
			return config;
		}());

		var setup = (function() {
			if(config.tooltip === true) {
				tip.text(config.text.itemAdded);
	
				// Tooltip is added to the DOM on mouseenter, but displayed only after a successful Ajax request
				$('.jcart [type=submit]').mouseenter(
					function(e) {
						var x = e.pageY + 25,
							y = e.pageX + -10;
						$('body').append(tip);
						tip.css({top: y + 'px', left: x + 'px'});
					}
				)
				.mousemove(
					function(e) {
						var y = e.pageY + 25,
						x = e.pageX + -10;
						tip.css({top: y + 'px', left: x + 'px'});
					}
				)
				.mouseleave(
					function() {
						tip.hide();
					}
				);
			}

			// Remove the update and empty buttons since they're only used when javascript is disabled
			// $('#jcart-buttons').remove();

			// Default settings for Ajax requests
			$.ajaxSetup({
				type: 'POST',
				url: path + '/relay.php',
				success: function(response) {
					// Refresh the cart display after a successful Ajax request
					container.html(response);
					$('#jcart-buttons').remove();
				},
				// See: http://www.maheshchari.com/jquery-ajax-error-handling/
				error: function(x, e) {
					var s = x.status, 
						m = '异步调用错误: ' ; 
					if (s === 0) {
						m += '当前网络状况不稳定.';
					}
					if (s === 404 || s === 500) {
						m += s;
					}
					if (e === 'parsererror' || e === 'timeout') {
						m += e;
					}
					alert(m);
				}
			});
		}());

		// Check hidden input value
		// Sent via Ajax request to jcart.php which decides whether to display the cart checkout button or the PayPal checkout button based on its value
		// We normally check against request uri but Ajax update sets value to relay.php

		// If this is not the checkout the hidden input doesn't exist and no value is set
		var isCheckout = $('#jcart-is-checkout').val();

		function add(form) {
			// Input values for use in Ajax post
			var itemQty = form.find('[name=' + config.item.qty + ']'),
				itemAdd = form.find('[name=' + config.item.add + ']');

		    var marTop=$(itemAdd).offset().top;
		    var marLeft=$(itemAdd).offset().left+50;
		    var div="<div id='div_diamond' style='z-index:99;border-radius:5px;background:#FF4400;height:20px;width:20px;position:absolute;margin-top:"
                 +marTop
                 +"px;margin-left:"
                 +marLeft
                 +"px;'></div>";
            $("body").prepend(div); 

            var moveTop=$("#cart_anchor").offset().top-$("#div_diamond").offset().top;
            var moveLeft=$("#cart_anchor").offset().left-$("#div_diamond").offset().left;
            $("#div_diamond").animate({top:"+="+moveTop+"px",left:"+="+moveLeft+"px"},500,
            	function(){
            		$("#div_diamond").remove();
            		// Add the item and refresh cart display
            		$.ajax({
            			data: form.serialize() + '&' + config.item.add + '=' + itemAdd.val(),
            			success: function(response) {

            			  // Momentarily display tooltip over the add-to-cart button
            			  if (itemQty.val() > 0 && tip.css('display') === 'none') {
            			  	  tip.fadeIn('100').delay('400').fadeOut('100');
            			  }

            			  container.html(response);
            			  $('#jcart-buttons').remove();

            			  repositionCart();
            		      }
            	    });
            	}
            );
		}

		function mobileAdd(form){
			// Input values for use in Ajax post
			var itemQty = form.find('[name=' + config.item.qty + ']'),
				itemAdd = form.find('[name=' + config.item.add + ']');

			// Add the item and refresh cart display
			$.ajax({
				data: form.serialize() + '&' + config.item.add + '=' + itemAdd.val(),
				success: function(response) {

					// Momentarily display tooltip over the add-to-cart button
					if (itemQty.val() > 0 && tip.css('display') === 'none') {
						tip.fadeIn('100').delay('400').fadeOut('100');
					}

					container.html(response);		
					$('#orderedTotalCount').text((parseInt($('#orderedTotalCount').text())+1));			
				}
			});
		}

		function update(input) {
			// The id of the item to update
			var updateId = input.parent().find('[name="jcartItemId[]"]').val();

			// The new quantity
			var newQty = input.val();

			if(newQty > 90)
			{
				alert("单品不能超过90份噢, 帮您设置成最大90份吧");
				newQty = 90;
				input.val(newQty);
			}

			disableButtons();

			// As long as the visitor has entered a quantity
			if (newQty) {

				// Update the cart one second after keyup
				var updateTimer = window.setTimeout(function() {

					// Update the item and refresh cart display
					$.ajax({
						data: {
							"jcartUpdate": 1, // Only the name in this pair is used in jcart.php, but IE chokes on empty values
							"itemId": updateId,
							"itemQty": newQty,
							"jcartIsCheckout": isCheckout,
							"jcartToken": token
						},
						complete: function(){

						// Handle the complete event
						enableButtons();
						
						}
					});
				}, 1000);
			}

			// If the visitor presses another key before the timer has expired, clear the timer and start over
			// If the timer expires before the visitor presses another key, update the item
			input.keydown(function(e){
				if (e.which !== 9) {
					window.clearTimeout(updateTimer);
				}	
			});
		}

		function remove(link) {
			// Get the query string of the link that was clicked
			var queryString = link.attr('href');
			queryString = queryString.split('=');

			// The id of the item to remove
			var removeId = queryString[1];

			disableButtons();

			// Remove the item and refresh cart display
			$.ajax({
				type: 'GET',
				data: {
					"jcartRemove": removeId,
					"jcartIsCheckout": isCheckout
				},
				complete: function(){

				// Handle the complete event
				enableButtons();
				repositionCart();
				}

			});
		}

		function disableButtons()
		{
			$("#confirmOrder").attr("disabled","disabled"); 
			$("#confirmOrder").css("background-color:grey");

			//clearCart
			$("#clearCart").attr("disabled","disabled"); 
			$("#clearCart").css("background-color:grey");
		}

		function enableButtons()
		{
			$("#confirmOrder").removeAttr("disabled");
			$("#confirmOrder").css("background-color:red");

			//clearCart
			$("#clearCart").removeAttr("disabled");
			$("#clearCart").css("background-color:red");
		}


		// Add an item to the cart
		$('.jcart').submit(function(e) {
			add($(this));
			e.preventDefault();
		});

		$('.jcart_mobile').submit(function(e){
			mobileAdd($(this));
			e.preventDefault();
		});

		// Prevent enter key from submitting the cart
		container.keydown(function(e) {
			if(e.which === 13) {
				e.preventDefault();
			}
		});

		// Update an item in the cart
		container.delegate('[name="jcartItemQty[]"]', 'keyup', function(){
			update($(this));
		});

		// Remove an item from the cart
		container.delegate('.jcart-remove', 'click', function(e){
			remove($(this));
			e.preventDefault();
		});

	}()); // End JCART namespace

    //Reposition Cart
    var divTop,divLeft,divWidth,divHeight,docHeight,docWidth;
    window.repositionCart=function()
    {
    	
    	var marLeft=($('body').width()-$('.sdrow').width())/2;

        divHeight=$("#sidebar").height();

        divWidth=$("#sidebar").width()+marLeft;

        docHeight=$('body').height();

        docWidth=$('body').width();

        $("#sidebar").css('top',(docHeight + $(document).scrollTop() - divHeight)+"px");

        $("#sidebar").css('left',(docWidth + $(document).scrollLeft() - divWidth)+"px");
    }
    repositionCart();    
    window.onload = repositionCart;
    window.onresize = repositionCart;
    window.onscroll = repositionCart;
}); // End the document ready function