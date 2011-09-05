<h1><?php echo $title_for_layout; ?></h1>
<?php
$this->Html->addCrumb($product['Product']['name'], array(
	'controller' => 'products', 'action' => 'view', 'productSlug' => $product['Product']['slug']));
$this->Html->addCrumb($product['Product']['name'].' Forum');
?>
 
<p>
	Welcome to our <?php echo $product['Product']['name'];?> forum, where you can post discussions, questions and queries - and hopefully get them answered!
</p>
<?php if(!empty($threads)): ?>
	<?php echo $this->element('forums/threads'); ?>
<?php else: ?>
<p>There are no threads yet.</p>
<?php endif; ?>