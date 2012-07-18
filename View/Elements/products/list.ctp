<div class="products-list">
	<?php foreach($products as $product): ?>
	<div 
		class="product"
		data-id="<?php echo $product['Product']['slug'];?>"
		data-inventory="<?php echo $product['Product']['inventory_count']; ?>">
		<span class="inventory-count"> <?php echo $this->Love->plural($product['Product']['inventory_count'], '', '1 User', '{n} Users'); ?></span>
		<?php echo $this->Love->productImage($product); ?>
		<h2><?php echo $this->Link->product($product);?></h2>
		<p><?php echo $this->Text->truncate($product['Product']['description_formatted'], 150, array('html' => true)); ?></p>
	</div>
	<?php endforeach; ?>
</div>