<h1>Edit Your Settings</h1>
<p>You can update parts of your Consumer Love profile here.</p>
<?php echo $this->Form->create('User', array('class' => 'settings')); ?>
<?php
echo $this->Form->inputs(array(
    'fieldset' => false,
    'real_name' => array(
        'after' => '<span>Your real name, this will only be visible on your profile.</span>'
    ),
    'email' => array(
        'after' => '<span>Your email address, this is the address we will mail password reminders to.</span>'
    ),
    'website',
    'bio' => array(
        'after' => '<span>Write a few details about yourself to be displayed on your profile.</span>'
    ),
    'dob' => array(
        'label' => 'Date of Birth',
        'minYear' => date('Y') - 80,
        'maxYear' => date('Y'),
        'dateFormat' => 'DMY'
    ),
    'location',
    'private_inventory' => array('label' => 'Private Inventory',
        'after' => '<span>Tick here to keep your inventory hidden from other users of Consumer Love.</span>')
));
?>
<?php echo $this->Form->end('Save'); ?>