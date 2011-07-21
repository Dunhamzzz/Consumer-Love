<?php
// Register Widgets
$pageWidgets = array(
	'product_meta' => array($product['Product'])
);

if(!empty($product['Tweet'])) {
	$pageWidgets['twitter'] = array('tweets' => $product['Tweet']);
}
$this->set(compact('pageWidgets'));
if(isset($userData) && $userInventory) {
	$inInventory = in_array($product['Product']['id'], array_keys($userInventory));
} else {
	$inInventory = false;
}

$this->Html->addCrumb($product['Product']['name']);
?>
<div id="product" class="product-section">
	<?php echo $this->Love->inventoryButton($product['Product']['id'], $inInventory); ?>
	<div id="product-description">
		<p><?php echo nl2br($product['Product']['description_formatted'] ?: $product['Product']['description']); ?></p>
	</div>
</div>

<div id="reviews" class="product-section">
	<h2>Reviews</h2>
	<p class="description">You can write what you think of <?php echo $product['Product']['name'];?> here, it can be long, short or just a rant!</p>
	<?php if(isset($userData)): ?>
	<?php else: ?>
	<a class="guest">You must be logged in to add a review.</a>
	<?php endif; ?>
</div>
<div id="threads" class="product-section">
	<h2><?php echo $this->Link->forum($product['Product']['slug']); ?></h2>
	<?php echo $this->Button->thread($product['Product']['id']); ?>
	<p class="description">
		Here is our discussion forum on all things about <?php echo $product['Product']['name']; ?>.
	</p>
	<?php echo $this->element('forums/threads'); ?>
</div>