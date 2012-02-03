<?php $product = $this->Love->extractRow('Product', $product); ?>
<div class="product-list-medium">
    <h4><?php echo $this->Link->product($product, $this->Love->productImage($product, 128) . $product['name'], array('escape' => false)); ?></h4>
    <p><?php echo $this->Love->plural($product['inventory_count'], '', '1 User', '{n} Users'); ?></p>
</div>