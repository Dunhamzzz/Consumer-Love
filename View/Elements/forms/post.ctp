<?php
echo $this->Form->create('Post', array('action' => 'reply', 'class' => 'writing thread-form'));
echo $this->Form->input('id');
echo $this->Form->input('thread_id', array('type' => 'hidden', 'value' => $thread['Thread']['id']));
echo $this->Form->input('content', array('label' => false));
if(isset($requireCaptcha)) {
	echo $this->element('forms/recaptcha');
}
echo $this->Form->submit('Submit', array('class' => 'cta save'));
echo $this->Form->end();