<?php
echo $this->Form->create('Category');
echo $this->Form->inputs(array('id', 'parent_id', 'name', 'description'));
echo $this->Form->end('Save');?>
