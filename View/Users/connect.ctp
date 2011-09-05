<p>Thanks for logging into Consumer Love with Facebook Connect. To
	continue, you must select a username to represent yourself around the
	site.</p>
<?php echo $this->Form->create('User') ?>
<?php echo $this->Form->input('username', array('label' => 'Choose Username')); ?>
<?php echo $this->Form->end('Choose Username'); ?>