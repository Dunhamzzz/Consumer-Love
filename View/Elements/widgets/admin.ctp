<h3>Admin Functions</h3>
<ul>
	<li><?php echo $this->Html->link('All Products', array('controller' => 'products', 'action' => 'all', 'admin' => true, 'plugin' => false)); ?></li>
	<li><?php echo $this->Html->link('Add Product', array('controller' => 'products', 'action' => 'new', 'admin' => true, 'plugin' => false)); ?></li>
	<?php if(isset($product)):?>
	<li><?php echo $this->Html->link('Edit Product', array('controller' => 'products', 'action' => 'edit', 'admin' => true, 'plugin' => false, $product['Product']['id'])); ?>
	<?php endif; ?>
	<li><?php echo $this->Html->link('Manage Categories', array('controller' => 'categories', 'action' => 'index', 'admin' => true));?></li>
	<li><?php echo $this->Html->link('Add Category', array('controller' => 'categories', 'action' => 'new', 'admin' => true));?>
        <li><?php echo $this->Html->link('Manage Threads', array(
            'controller' => 'threads',
            'action' => 'index',
            'admin' => true,
        )); ?></li>
</ul>