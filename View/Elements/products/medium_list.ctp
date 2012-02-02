<?php $product = $this->Love->extractRow('Product', $product); ?>
<div class="product-list-medium">
    <?php echo $this->Love->productImage($product, 128); ?>
    <h4><?php echo $this->Link->product($product); ?></h4>
    <p><?php echo $this->Love->plural($product['inventory_count'], '', '1 User', '{n} Users'); ?></p>
</div>