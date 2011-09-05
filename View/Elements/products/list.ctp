<div class="products-list">
	<?php foreach($products as $product): ?>
	<div data-id="<?php echo $product['Product']['slug'];?>">
		<?php echo $this->Love->productImage($product); ?>
		<h2><?php echo $this->Link->product($product);?></h2>
		<p><?php echo $this->Text->truncate($product['Product']['description_formatted'], 80, array('html' => true)); ?></p>
	</div>
	<?php endforeach; ?>
</div>