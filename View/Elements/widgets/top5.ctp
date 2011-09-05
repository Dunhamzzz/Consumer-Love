<?php
$top5SelectOptions = array(
	'label' => false,
	'div' => false,
	'class' => 'top5select'
);
echo $this->Form->create('Product'); ?>
<h3>Top Products In...</h3>
<?php echo $this->Form->input('category_id', array_merge($top5SelectOptions, array('selected' => $top5Category['Category']['id']))); ?>
<div class="top5">
	<div>
	<?php if(count($top5Products) !== 0):?>
	<ul>
	<?php foreach($top5Products as $product):?>
		<li class="product-row"><?php
			echo $this->Link->product($product, $this->Love->productImage($product).$product['Product']['name'], array('escape' => false)); ?></li>
	<?php endforeach; ?>
	</ul>
	<span class="top5-footnote"><?php echo $this->Link->category($top5Category['Category'], 'View More in '.$top5Category['Category']['name']);?></span>
	<?php else: ?>
	<span class="top5-not-found">No products found!</span>
	<?php endif;?></div>
</div>
<?php echo $this->Form->end(); ?>