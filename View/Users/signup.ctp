<?php
// This page shouldn't have distractions
$this->set('disableDistractions', true);
?>
<h2>Create an Account</h2>
<p>Create an account at Consumer Love and start building your inventory today!</p>
<div id="signup-wrapper">
	<?php echo $this->Form->create('User', array('action' => 'signup', 'id' => 'signup')); ?>
	<?php echo $this->Form->inputs(array(
	'legend' => false,
	'fieldset' => false,
	'username' => array(
		'placeholder' =>__('Username'),
		'autocomplete' => 'off',
		'id' => 'username',
                'class' => 'signup-username'
	),
	'password' => array('placeholder' => __('Password'), 'autocomplete' => 'off', 'id' => false),
	'password_confirm' => array('label' => __('Confirm Password'), 'type' => 'password', 'placeholder' => __('Confirm Password')),
	'email' => array('placeholder' => __('Email'), 'type' => 'email'),
	'tos' => array('label' => 'Terms and Conditions')
	));
	echo $this->Form->submit(__('Sign Up'), array('class' => 'cta'));
	echo $this->Form->end(); ?>
</div>