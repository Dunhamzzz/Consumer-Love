<?php
// Register Widgets
$pageWidgets = array(
	'product_meta' => array($product['Product'])
);

if(!empty($product['Tweet'])) {
	$pageWidgets['twitter'] = array('tweets' => $product['Tweet']);
}
$this->set(compact('pageWidgets'));
?>
<p>Start a a new discussion thread on <?php echo $product['Product']['name'];?>.</p>
<?php echo $this->Form->create('Thread', array('action' => 'create', 'class' => 'thread-form')); ?>
<?php echo $this->Form->input('product_id', array('type' => 'hidden', 'value' => $product['Product']['id'])); ?>
<?php echo $this->Form->input('title', array('label' => 'Title or Question', 'class' => 'thread-title')); ?>
<?php echo $this->Form->input('content', array('type' => 'textarea', 'label' => false)); ?>
<?php echo $this->Form->submit('Submit New Thread', array('class' => 'cta')); ?>
<?php echo $this->Form->end(); ?>