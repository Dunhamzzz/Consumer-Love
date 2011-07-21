<div><?php if(count($top5Products) !== 0):?>
<ul>
<?php foreach($top5Products as $product):?>
	<li class="product-row"><?php
		echo $this->Link->product($product, $love->productImage($product).$product['Product']['name'], array('escape' => false)); ?></li>
<?php endforeach; ?>
</ul>
<span class="top5-footnote"><?php echo $love->categoryLink($top5Category['Category'], 'View More in '.$top5Category['Category']['name']);?></span>
<?php else: ?>
<span class="top5-not-found">No products found!</span>
<?php endif;?></div>