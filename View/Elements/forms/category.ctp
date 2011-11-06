<?php
echo $this->Form->create('Category');
echo $this->Form->input('id');
echo $this->Form->input('parent_id', array('label' => __('Parent')));
echo $this->Form->input('name');
echo $this->Form->input('description');
echo $this->Form->end('Save');?>