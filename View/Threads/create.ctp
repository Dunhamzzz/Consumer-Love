<?php
$pageWidgets = array(
	'product_meta' => array($product['Product'])
);

if(!empty($product['Tweet'])) {
	$pageWidgets['twitter'] = array('tweets' => $product['Tweet']);
}
$this->set(compact('pageWidgets'));
?>
<?php echo $this->element('products/header-tabs', array('current' => 'forum')); ?>
<h1><?php echo $product['Product']['name'];?> Forum/Create Thread</h1>
<p>Ask a question or start a new discussion thread about <?php echo $product['Product']['name'];?>.</p>
<?php echo $this->element('forms/thread'); ?>