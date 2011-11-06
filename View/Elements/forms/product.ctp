<?php echo $this->Form->create('Product',array('type' => 'file', 'class' => 'admin-form writing'));?>
<?php
echo $this->Form->input('id');
echo $this->Form->input('name');
echo $this->Form->input('parent_id', array('label' => __('Parent')));
echo $this->Form->input('description');
echo $this->Form->input('Category');
echo $this->Form->input('logo', array('type' => 'file'));
echo $this->Form->input('website_url');
echo $this->Form->input('twitter');
echo $this->Form->end('Save');
?>