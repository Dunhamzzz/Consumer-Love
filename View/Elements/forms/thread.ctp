<?php echo $this->Form->create('Thread', array('action' => 'create', 'class' => 'thread-form')); ?>
<?php echo $this->Form->input('product_id', array('type' => 'hidden', 'value' => $product['Product']['id'])); ?>
<?php echo $this->Form->input('title', array('label' => 'Title or Question', 'class' => 'thread-title')); ?>
<?php echo $this->Form->input('content', array('type' => 'textarea', 'label' => false)); ?>
<div class="thread-form-footer">
	<label for="tweetthis">Tweet This</label><input id="tweetthis" name="tweetthis" value="1" type="checkbox"/>
	<?php echo $this->Form->submit('Submit New Thread', array('class' => 'cta', 'div' => false )); ?>
</div>
<?php echo $this->Form->end(); ?>