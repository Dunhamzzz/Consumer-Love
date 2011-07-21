// Product View and Voting
	var $numToday = $('#num-today');
	var $lover = $('#love-voter');
	var $hater = $('#hate-voter');
	var $loveCounter = $('.count', $lover);
	var $hateCounter = $('.count', $hater);
	var $loveToday = $('#love-today');
	var $hateToday = $('#hate-today');
	var $today = $('#today');
	var oneup = '<span class="oneup">+1</span>';
	var onedown = '<span class="onedown">-1</span>';
	
	// Favourites
	$('.star').click(function(e) {
		//e.preventDefault();
		//$.ajax($(this).attr('href'));
	});
	// Register/login
	$('#register-login').dialog({
		autoOpen: false,
		width: 760,
		resizable: false,
		draggable: false,
		modal: true

	});
	
	$('.guest').click(function(e){
		$('#register-login').dialog('open');
		e.preventDefault();
	});
	
	// Voting
	var delay = false;
	$('.voter').click(function(){
		var doin = $(this).hasClass('love') ? 'love' : 'hate';
		
		// Check if they have reached voting limit
		if($numToday.text() == 0
			&& (doin == 'love' && $hateCounter.text() == 0 || doin == 'hate' && $loveCounter.text() == 0)
		) {
			// No votes left
			//alert('dick face');
		} else {
			clearTimeout(delay);
			
			// Update Score and states
			if(doin == 'love') {
				if($hateCounter.text() != 0) {
					// Take votes from counter, add them back to total, minus the vote we just made
					$numToday.text($numToday.text() * 1 + $hateCounter.text() * 1);
					$hateCounter.text(0);
					$hateToday.text($hateToday.attr('data-reset'));
				}
				
				// Add one to love, reset hate
				$loveCounter.text($loveCounter.text() * 1 + 1);
				$loveToday.text($loveToday.text() * 1 + 1);
				$lover.addClass('on').removeClass('off');
				$hater.addClass('off').removeClass('on');
				score = $loveCounter.text();
				
				// 1UP Animation
				$('#todays-scores').append($(oneup).animate({ 
					top:'-=20px', 
					opacity:'toggle' 
				}, 'slow', function(){
					$(this).remove()
				}));
			} else {
				if($loveCounter.text() != 0) {
					// Take votes from counter, add them back to total
					$numToday.text($numToday.text() * 1 + $loveCounter.text() * 1);
					$loveCounter.text(0);
					$loveToday.text($loveToday.attr('data-reset'));
				}
				$hateCounter.text($hateCounter.text() * 1 + 1);
				$hateToday.text($hateToday.text() * 1 + 1);
				$hater.addClass('on').removeClass('off');
				$lover.addClass('off').removeClass('on');
				score = $hateCounter.text();
				
				// 1 Down Animation
				$('#todays-scores').append($(onedown).animate({ 
					bottom:'-=20px', 
					opacity:'toggle' 
				}, 'slow', function(){
					$(this).remove()
				}));
			}
			
			// Take one off numToday.
			$numToday.text($numToday.text() * 1 - 1);
			
			// Update Todays Score
			$today.text($loveToday.text() - $hateToday.text() * 1);
			
			delay = setTimeout(function() {
				$.ajax({
					url: '/votes/vote.json',
					type: 'POST',
					data: {ak: cl_ak, pid: cl_pid, s: score, c: doin},
					dataType: 'json',
					success: function(response) {
						if(typeof response.e == 'undefined') {
							$numToday.text(response.remaining);
						} else {
							if(response.e.type = 'limit') {
								$numToday.text(0);
							}
							$counter.text(response.e.count);
							alert(response.e.msg);
						}
					}
				});
			}, 300);
		}
	});