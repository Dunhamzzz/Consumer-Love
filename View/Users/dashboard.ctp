<?php
$pageWidgets = array();

if(isset($latestInventory)) {
	$pageWidgets['inventory'] = array('inventory' => $latestInventory);
} else {
	$pageWidgets['inventory_empty'] = array();
}

$pageWidgets['top5'] = array();

$this->set(compact('pageWidgets'));
?>
<h2>Your Activity Feed</h2>
<p>What's going on with the products and services you own.</p>
<?php if(!empty($news)): ?>
<div class="timeline">
	<?php foreach($news as $newsItem): ?>
	<article>
		<?php echo $this->Link->news($newsItem); ?>
		<?php pr($newsItem); ?>
	</article>
	<?php endforeach; ?>
</div>
<?php else: ?>
<p>Here be a message encouraging you to fill ya inventory!</p>
<?php endif; ?>