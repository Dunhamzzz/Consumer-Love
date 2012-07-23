<?php $this->set('pageWidgets', array('product_meta')); ?>
<h1>Submit <?php echo $this->Link->product($product); ?> News</h1>
<p>Use this form to report upcoming news about <?php echo $this->Link->product($product); ?> and improve your Consumer Love score.</p>
<?php echo $this->Form->create('News', array('class' => 'writing'));?>
	<?php echo $this->Form->input('product_id', array('type' => 'hidden')); ?>
	<?php echo $this->Form->input('title', array('class' => 'long-text', 'label' => __('Headline'))); ?>
	<?php echo $this->Form->input('content_raw', array('label' => __('News'))); ?>
<?php echo $this->Form->end('Submit'); ?>