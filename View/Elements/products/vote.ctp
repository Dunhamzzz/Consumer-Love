<?php echo $this->Form->create('Inventory', array('class' => 'vote-form', 'controller' => 'inventories', 'action' => 'score')); ?>
<?php echo $this->Form->input('product_id', array('value' => $product['Product']['id'], 'type' => 'hidden')); ?>
<?php echo $this->Form->submit('&hearts; Love It', array('class' => 'loveit', 'div' => false, 'name' => 'score', 'escape' => false)); ?>
<?php echo $this->Form->submit('Hate It', array('class' => 'hateit', 'div' => false, 'name' => 'score')); ?>

<?php echo $this->Form->end(); ?>

<?php /*echo $this->Form->postLink('Love It', array(
	'controller' => 'inventories',
	'action' => 'score',
	'id' => $this->data['Inventory']['id'],
	'score' => 1
));*/?>