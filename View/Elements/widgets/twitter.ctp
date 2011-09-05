<h4>On Twitter</h4>
<ul>
	<?php foreach($tweets as $tweet):?>
	<li><?php echo $this->Text->autoLinkUrls($tweet['text']); ?></li>
	<?php endforeach; ?>
</ul>