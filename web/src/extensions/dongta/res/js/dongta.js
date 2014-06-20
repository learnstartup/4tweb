;(function(){
	
	Wind.ready(function(){
		if (!GV.U_ID) return;
		$('.J_dongta_act').on('click', function(e) {
			e.preventDefault();
			var $this = $(this),
				uid = $this.data('uid');
			if ($('#J_dongta_act').length > 0) {
				$('#J_dongta_act').show();
				pos($('#J_dongta_act'), $this);
				$('#J_dongta_act').find('li').data('uid', uid)
				return;
			}
			Wind.css(GV.JS_EXTRES + '/dongta/css/act.css', function() {
				$.get($this.attr('href'), function(data) {
					$data = $(data);
					$data.appendTo($('body'));
					pos($data, $this);


					$data.find('li').data('uid', uid).on('click', function() {
						$data.hide();
						$.post(URL_DONGTA, {
							act : $(this).data('id'),
							uid : $(this).data('uid')
						},
						function(data) {
							if (data.state == 'success') {
								Wind.Util.resultTip({
									error : false,
									msg : data.message[0],
									follow : $this
								});
							} else {
								Wind.Util.resultTip({
									error : true,
									msg : data.message[0],
									follow : $this
								});
							}
						},
						'json');
					});
					$(document.body).on('mousedown',function(e) {
						//$data.hide();
					});
				});
			});
		});

		function pos(elem, btn) {
			var top = btn.offset().top,
				left = btn.offset().left;
			if (top - $(document).scrollTop() + elem.height() > $(window).height()) {
				top -= elem.height();
			} else {
				top += btn.height();
			}
			if (left + elem.width() > $(window).width()) {
				left -= elem.width() - btn.width();
			}
			elem.css({
				top : top,
				left : left
			});
		}
	});

})();