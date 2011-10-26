<h3><?php echo $product['name']; ?> Options</h3>
<?php echo $this->Form->postLink(
		'Delete',
		array('action' => 'delete', 'admin' => true, $this->request->data['Product']['id']),
		array(),
		'Delete this product?'
	);?>