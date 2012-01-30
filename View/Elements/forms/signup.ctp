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
	'password' => array(
		'label' => false,
		'placeholder' => '********',
		'autocomplete' => 'off',
		'id' => false,
		'value' => ''
	),
	'email' => array(
		'label' => false,
		'placeholder' => 'Email',
		'autocomplete' => 'off',
		'type' => 'email'
	),
	'tos' => array('label' => 'Terms and Conditions')
));
echo $this->Form->end('Create my account');
