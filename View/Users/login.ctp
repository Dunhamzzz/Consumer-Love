<h2>Login to ConsumerLove</h2>
<?php
echo $this->Form->create('User', array('action' => 'login'));
echo $this->Form->inputs(array(
	'legend' => false,
	'fieldset' => false,
	'username' => array('label' => 'Username/Email', 'placeholder' => 'Username / Email', 'class' => 'login-username', 'maxlength' => false),
	'password' => array('placeholder' => 'password', 'id' => 'login-password'),
        'remember' => array('type' => 'checkbox', 'label' => 'Remember')
));

echo $this->Form->hidden('User.return_to', array('value' => isset($returnTo) ? $returnTo : $this->here));
echo $this->Form->end('Sign In');