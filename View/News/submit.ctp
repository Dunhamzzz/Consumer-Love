<h1>Submit News</h1>
<?php echo $this->Form->create('News');?>
	<?php echo $this->Form->input('product_id', array('empty' => true)); ?>
	<?php echo $this->Form->input('title'); ?>
	<?php echo $this->Form->input('content'); ?>
<?php echo $this->Form->end('Submit'); ?>