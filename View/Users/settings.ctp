<h1>Edit Your Settings</h1>
<p>You can update parts of your Consumer Love profile here.</p>
<?php echo $this->Form->create('User', array('class' => 'settings')); ?>
<?php echo $this->Form->inputs(array(
    'fieldset' => false,
    'real_name' => array(
            'after' => '<span>Your real name, this will only be visible on your profile.</span>'
        ),
    'email' => array(
        'after' => '<span>Your email address, this is the address we will mail password reminders to.</span>'
    ),
    'website',
    'bio' => array(
        'after' => '<span>Write a few details about yourself to be dispalyed on your profile.</span>'
    ),
    'dob' => array('label' => 'Date of Birth'),
    'location',
    'private_inventory' => array('label' => 'Keep your inventory private?')
    
));?>
<?php echo $this->Form->end('Save'); ?>