<div class="product-list-medium">
    <h4><?php echo $this->Link->product($product); ?></h4>
    <?php echo $this->Love->productImage($product, 128); ?>
    <?php echo $this->Love->plural($product['Product']['inventory_count'], '', '1 User', '{n} Users'); ?>
</div>