<h2>New Post</h2>
<?php
echo $this->Form->create('Thread', array('action' => 'create', 'class' => 'writing thread-form'));
echo $this->Form->input('product_id', array(
    'type' => 'hidden',
    'value' => $product['Product']['id']
));

echo $this->Form->input('title', array(
    'label' => false,
    'class' => 'thread-title long-text',
    'placeholder' => 'Question or Discussion Title'
));

echo $this->Form->input('content', array('type' => 'textarea', 'label' => false)); ?>
<div class="thread-form-footer">
	<?php echo $this->Form->submit('Submit New Thread', array('class' => 'cta', 'div' => false )); ?>
</div>
<?php echo $this->Form->end(); ?>