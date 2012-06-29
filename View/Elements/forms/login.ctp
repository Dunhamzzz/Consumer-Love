<?php
echo $this->Form->create('User', array('action' => 'login', 'id' => 'login'));
echo $this->Form->inputs(array(
	'legend' => false,
	'fieldset' => false,
	'username' => array('label' => false, 'placeholder' => 'Username / Email', 'maxlength' => false),
	'password' => array('label' => false, 'placeholder' => 'Password'),
        'remember' => array('type' => 'checkbox', 'label' => 'Remember')
));

echo $this->Form->hidden('User.return_to', array('value' => isset($returnTo) ? $returnTo : $this->here));
echo $this->Form->end('Sign In');