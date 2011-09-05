<?php echo $this->Form->create('Post', array('action' => 'reply/'.$thread['Thread']['id'], 'class' => 'thread-form')); ?>
<?php echo $this->Form->input('thread_id', array('type' => 'hidden', 'value' => $thread['Thread']['id'])); ?>
<?php echo $this->Form->input('content', array('label' => 'Post A Reply')); ?>
<?php if(isset($requireCaptcha)) {
	echo $this->element('forms/recaptcha');
} ?>
<?php echo $this->Form->end('Post Reply'); ?>