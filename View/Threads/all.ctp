<?php 
// Register Widgets
$pageWidgets = array(
	'product_meta' => array($product['Product']),
	'product_submit' => array($product['Product'])
);

if(!empty($product['Tweet'])) {
	$pageWidgets['twitter'] = array('tweets' => $product['Tweet']);
}
$this->set(compact('pageWidgets'));
echo $this->element('products/header-tabs', array('current' => 'forum'));
?><h1><?php echo $title_for_layout; ?></h1>
<?php
$this->Html->addCrumb($product['Product']['name'], array(
	'controller' => 'products', 'action' => 'view', 'productSlug' => $product['Product']['slug']));
$this->Html->addCrumb($product['Product']['name'].' Forum');
?>
<p>
	Welcome to our <?php echo $this->Link->product($product);?> forum, where you can post discussions, questions and queries - and hopefully get them answered!
</p>
<?php echo $this->element('forms/thread'); ?>
<?php if(!empty($threads)): ?>
    <?php echo $this->element('forums/threads'); ?>
<?php else: ?>
<p>There are no threads yet.</p>
<?php endif; ?>