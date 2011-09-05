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
		'label' => false,
		'placeholder' =>'Username',
		'autocomplete' => 'off',
		'id' => 'username',
	),
	'password' => array('label' => false, 'placeholder' => 'password', 'autocomplete' => 'off', 'id' => false),
	'password_confirm' => array('label' => false, 'type' => 'password'),
	'email' => array('label' => false, 'placeholder' => 'Email', 'type' => 'email'),
	'tos' => array('label' => 'Terms and Conditions')
	));
	echo $this->Form->submit('Sign Up', arraY('class' => 'cta'));
	echo $this->Form->end(); ?>
</div>