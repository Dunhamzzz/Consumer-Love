<div class="recpatcha">
	<p>As you are a fairly inexperienced face to Consumer Love, would you mind filling in this captcha for us?</p>
	<?php echo $this->Recaptcha->display(); ?>
	<?php if(isset($recaptchaInvalid)): ?>
		<p class="error-message">Please complete the captcha above by filing in the two words you see above.</p>
	<?php endif;?>
</div>