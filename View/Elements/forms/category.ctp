<?php
echo $this->Form->create('Category', array('class' => 'admin-form writing', 'action' => 'edit'));
echo $this->Form->input('id');
echo $this->Form->input('parent_id', array('label' => __('Parent'), 'class' => 'category'));
echo $this->Form->input('name', array('class' => 'long-text'));
echo $this->Form->input('description');
echo $this->Form->end('Save');?>