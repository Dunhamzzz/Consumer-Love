<h1>Edit Your Settings</h1>
<?php echo $this->Form->create('User', array('class' => 'settings')); ?>

<?php echo $this->Form->input('email'); ?>

<?php echo $this->Form->input('bio'); ?>
<?php echo $this->Form->end('Save'); ?>