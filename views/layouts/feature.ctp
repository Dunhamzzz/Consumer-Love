<!DOCTYPE html>
<?php echo $this->Facebook->html(); ?>
<head>
	<meta charset="utf-8" />
	<title><?php echo $title_for_layout;?></title>
<?php
	echo $this->Html->meta('icon');
	echo $this->Html->script(array(
		'https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js',
		'global'
	));
	echo $this->Html->css(array(
		'style',
		'feature'
	));

	echo $scripts_for_layout;
	//echo $this->element('external/google_analytics');
?>
</head>
<body>
<div class="container">
	<div id="header">
		<h1><span>Consumer Love <span class="heart">&hearts;</span></span></h1>
		<?php
		if(!isset($disableDistractions)) {
			echo $this->Form->create('User', array(
				'controller' => 'users',
				'action' => 'login',
				'id' => 'login',
				'inputDefaults' => array('label' => false, 'div' => false),
			));
			echo $this->Form->inputs(array(
				'legend' => false,
				'fieldset' => false,
				'username',
				'password',
			));
			echo $this->Form->submit('Sign In', array('div' => false, 'class' => 'submit'));
			echo $this->Form->input('remember', array('type' => 'checkbox', 'label' => 'Remember Me', 'div' => true));
			echo $this->Form->end();
		} else { ?>
			<div id="login-register">
				Have an account? <?php echo $this->Html->link('Sign In', array('controller' => 'users', 'action' => 'login')); ?>
			</div>
		<?php }	?>
	</div>
	<div id="content">
		<?php echo $content_for_layout; ?>
	</div>
	<div id="footer">
		<p>Copyright &copy; 2011 consumerlove.org<br/>System time is <?php echo date('G:i');?></p>
	</div>
</div>
<?php echo $this->Js->writeBuffer(); ?>
</body>
</html>