<div id="products-list">
	<?php foreach($products as $product): ?>
	<div data-id="<?php echo $product['Product']['slug'];?>">
		<?php echo $love->productImage($product); ?>
		<h2><?php echo $love->productLink($product);?></h2>
		<p><?php echo $this->Text->truncate($product['Product']['description_formatted'], 80, array('html' => true)); ?></p>
	</div>
	<?php endforeach; ?>
</div>