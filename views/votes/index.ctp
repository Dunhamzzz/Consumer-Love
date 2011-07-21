<?php
$this->Paginator->options(array(
	'update' => '#content'
));

$todaysDate = date('Ymd');

?>
<h2>Manage Your Votes</h2>
<p>View the votes you've made on Consumer Love since voting began, you can edit or delete todays votes.</p>
<?php if(!empty($votes)): ?>
<div class="pagination">
<?php echo $this->Paginator->prev('Previous');?>
<?php echo $this->Paginator->numbers(); ?>
<?php echo $this->Paginator->next('Next'); ?>
</div>
<div id="votes">
	<?php foreach($votes as $vote):
		$voteTimestamp = strtotime($vote['Vote']['created']);
		$voteDate = date('Ymd', $voteTimestamp);
		
		if(!isset($lastDay) || date('Ymd', $voteTimestamp) != $lastDay) {
			$lastDay = date('Ymd', $voteTimestamp);
			echo '</div><div><h3>'.date($userData['User']['date_format'], $voteTimestamp).'</h3>';
		}
	?>
	<div class="product-row <?php echo $vote['Vote']['score'] > 0 ? 'love' : 'hate'; ?>">
		<?php echo $love->productLink($vote['Product'], $love->productImage($vote['Product']), array('escape' => false)); ?>
		<span class="score"><?php echo abs($vote['Vote']['score']); ?></span>
		Voted <?php echo $vote['Vote']['score'];?> on <?php echo $love->productLink($vote['Product']); ?>
		<span class="time"><?php echo $this->Time->timeAgoInWords($vote['Vote']['modified']);?></span>
		<?php if($voteDate == $todaysDate): ?>
			<?php echo $this->Html->image('icons/cancel.png', array(
				'url' => array('controller' => 'votes', 'action' => 'delete', $vote['Vote']['id']),
				'title' => 'Remove'
			));?>
		<?php endif; ?>
	</div>
	<?php endforeach; ?>
	<?php echo $this->Paginator->counter(); ?>
<?php else: ?>
<p>You have not made any votes on Consumer Love yet! Be sure to find your favourite products and show them some love!</p>
<?php endif; ?>
</div>
<?php echo $this->Js->writeBuffer(); ?>