if (top.location!= self.location) {
	top.location = self.location.href;
}

$(function() {
	// This hides popped-up stuff, use with 
	$(document.body).click(function() {
	    $('.hide-on-body-click').hide();
	    $('.nav-triangle').removeClass('on');
	});
	
	// User options dropdown
	$('.nav-triangle').click(function(e) {
		$('#user-options').toggle();
		$(this).toggleClass('on');
		e.stopPropagation();
	});
	
	$('#user-options').click(function(e){
		e.stopPropagation();
	});
	
	// Product Page Tabs	
	$('#product-tabs').tabs();
	
	// Placeholders
	$('[placeholder]').focus(function() {
		var input = $(this);
		if (input.val() == input.attr('placeholder')) {
			input.val('');
			input.removeClass('placeholder');
		}
	}).blur(function() {
		var input = $(this);
		if (input.val() == '' || input.val() == input.attr('placeholder')) {
			input.addClass('placeholder');
			input.val(input.attr('placeholder'));
		}
	}).blur().parents('form').submit(function() {
		$(this).find('[placeholder]').each(function() {
			var input = $(this);
			if (input.val() == input.attr('placeholder')) {
				input.val('');
			}
		})
	});
	
	// Login/Register Dialog
	var $loginBox = $('#register-login');
	if($loginBox.length) {
		$loginBox.dialog({
			autoOpen: false,
			draggable: false,
			resizable: false,
			width: 660
		});
		$('.guest').click(function(event) {
			event.preventDefault();
			event.stopImmediatePropagation();
			
			$loginBox.dialog('open');
			
		});
	}
	
	// Toggle Inventory
	$('.toggle-inventory').click(function(e) {
		e.preventDefault();
		$.ajax({
			url: $(this).attr('href'),
			dataType: 'text',
			context: $(this),
			success: function(response) {
				if(response < 0) {
					alert('Something went wrong while processing your request.');
				} else {
					var total = $('.num-products').text() * 1;
					if(response != '1') {
						$(this).removeClass('in');
						$('.num-products').text(total - 1);
					} else {
						$(this).addClass('in');
						$('.num-products').text(total + 1);
					}
				}
			}
		});
	});
	
	$('#product .toggle-inventory').hover(function() {
		if($(this).hasClass('in')) {
			$('.toggle-text', this).text('Remove?');
		}
	},function() {
		$('.toggle-text', this).text('Inventory');
	});
	
	// Inventory page remove
	$('.inventory-options .remove').click(function(e) {
		e.preventDefault();
		$.ajax({
			url: $(this).attr('href'),
			dataType: 'text',
			context: $(this),
			success: function(response) {
				if(response < 0) {
					alert('Something went wrong while processing your request.');
				} else {
					$(this).closest('.product').fadeOut();
				}
			}
		});
	});
	
	// Homepage
	if($('#home').length) {
		$('#home').tabs();
	}
	
	// Homepage Autosuggest
	var $suggestLanding = $('#suggest-landing');
	var landingPersist = false;
	var suggestDelay = false;
	
	$('#suggest').keyup(function(e) {
		if (e.keyCode > 40 || e.keyCode == 8) { //If a letter or backspace
			if(this.value.length >= 2) {
				$(this).addClass('loading');
				clearTimeout(suggestDelay);
				var query = this.value;
				suggestDelay = setTimeout( function() {
					$.ajax({
						url: '/products/autocomplete',
						type: 'get',
						data: { 'q' : query },
						dataType: 'html',
						success: function(data) {
							$('#suggest').removeClass('loading');
							$suggestLanding.html(data).fadeIn();
						}
					});
				}, 200);

			} else {
				$suggestLanding.fadeOut('fast');
			}
		}
		
	})
	
	.focus(function() {
		if($(this).val() == 'Search for a product or brand') {
			$(this).val('').removeClass('idle');
		}
		
		if($(this).val().length) {
			$suggestLanding.fadeIn('fast');
		}
	})
	
	.blur(function() {
		if(this.value.length) {
			if(landingPersist == false) {
				$suggestLanding.fadeOut('fast');
			}
		} else {
			$(this).val('Search for a product or brand').addClass('idle');
			$suggestLanding.fadeOut('fast');
		}
	})
	
	// Turn autocomplete off and close chain.
	.attr('autocomplete', 'off');
	
	// Keep the suggestions box open
	$suggestLanding.mouseover( function() {
		landingPersist = true;
	})
	
	.mouseout(function(){
		landingPersist = false;
	})
	
	$('.top5select').attr('autocomplete', 'off').change(function() {
		var $landing = $(this).next('div');
		$landing.fadeOut('fast');
		$landing.load('/products/top5/'+$(this).val() + ' .top5', function() {
			$(this).fadeIn('fast');
		});
	});
	
	// Reviews
	$('.add-review').click(function(event) {
		event.preventDefault();
		$('#reviews .inner').load($(this).attr('href'));
	});
	
	// Category product shuffle
	$('#product-paginate select').change(function(){
		var $dest = $('.products-list');
		$.ajax({
			url: window.location.pathname,
			type: 'POST',
			dataType: 'html',
			data: $('#product-paginate').serialize(),
			success: function(response) {
				var $list = 
				$(response)
					.filter('.products-list')
					.addClass('new-products')
					.hide()
					.insertAfter($dest)
				;
				
				$dest.quicksand($('.new-products div'));
				$list.remove();
			}
		});
	});
	
	// Signup Check Username
	if($('#signup').length) {
		var usernameTimer = false;
		
		$('#signup .signup-username').keyup(function(e) {
			if (e.keyCode > 40 || e.keyCode == 8) { //If a letter or backspace
				if(this.value.length >= 2) {
					$(this).addClass('loading');
					$(this).removeClass('valid').removeClass('invalid');
					clearTimeout(usernameTimer);
					var query = this.value;
					usernameTimer = setTimeout( function() {
						$.ajax({
							url: '/users/checkUsername.json',
							type: 'get',
							data: { 'username' : query },
							dataType: 'text',
							context: $('.signup-username'),
							success: function(taken) {
								$(this).removeClass('loading');
								if(taken == 1) {
									$(this).addClass('valid').removeClass('invalid');
								} else {
									$(this).removeClass('valid').addClass('invalid');
								}
							}
						});
					}, 500);
	
				}
			}
			
		});
	}
	
	// Product View Thread Form
	$('#threads .thread-form').hide();
	$('.show-thread-form').click(function(e) {
		if($('#threads .thread-form').length) {
			e.preventDefault();
			$('#threads .thread-form').slideToggle();
		}
	});
	
	$('.edit-post').click(function(e){
		$('li#post-'+ $(this).data('id') + ' .post-content').load($(this).attr('href') + ' #PostReplyForm');
		e.preventDefault();
	});
	
});

//Text Area Expander
$.fn.TextAreaExpander = function(minHeight, maxHeight) {

	var hCheck = !($.browser.msie || $.browser.opera);

	// resize a textarea
	function ResizeTextarea(e) {

		// event or initialize element?
		e = e.target || e;

		// find content length and box width
		var vlen = e.value.length, ewidth = e.offsetWidth;
		if (vlen != e.valLength || ewidth != e.boxWidth) {

			if (hCheck && (vlen < e.valLength || ewidth != e.boxWidth)) e.style.height = "0px";
			var h = Math.max(e.expandMin, Math.min(e.scrollHeight, e.expandMax));

			e.style.overflow = (e.scrollHeight > h ? "auto" : "hidden");
			e.style.height = h + "px";

			e.valLength = vlen;
			e.boxWidth = ewidth;
		}

		return true;
	};

	// initialize
	this.each(function() {

		// is a textarea?
		if (this.nodeName.toLowerCase() != "textarea") return;

		// set height restrictions
		var p = this.className.match(/expand(\d+)\-*(\d+)*/i);
		this.expandMin = minHeight || (p ? parseInt('0'+p[1], 10) : 0);
		this.expandMax = maxHeight || (p ? parseInt('0'+p[2], 10) : 99999);

		// initial resize
		ResizeTextarea(this);

		// zero vertical padding and add events
		if (!this.Initialized) {
			this.Initialized = true;
			$(this).css("padding-top", 0).css("padding-bottom", 0);
			$(this).bind("keyup", ResizeTextarea).bind("focus", ResizeTextarea);
		}
	});

	return this;
};