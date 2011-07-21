<?php echo $this->Form->create('Review'); ?>
	<?php echo $this->Form->input('product_id', array('type' => 'hidden', 'value' => $productId ));?>
	<?php echo $this->Form->input('rating'); ?>
	<?php echo $this->Form->input('pros'); ?>
	<?php echo $this->Form->input('cons'); ?>
	<?php echo $this->Form->input('body'); ?>

<?php echo $this->Form->end('Submit Review'); ?>