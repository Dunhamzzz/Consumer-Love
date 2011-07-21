<?php echo $this->Love->productImage($product, 128); ?>
<dl>
	<dt>Categories</dt>
	<dd><?php echo $love->listProductCategories($product);?></dd>
	<?php if(!empty($product['Product']['website_url'])) :?>
	<dt>Website</dt>
	<dd><?php echo $this->Html->link($product['Product']['website_url'], $product['Product']['website_url']); ?></dd>
	<?php endif;?>
	<?php if(!empty($product['Product']['twitter'])) :?>
	<dt>Twitter</dt>
	<dd><?php echo $this->Html->link('@'.$product['Product']['twitter'], 'http://www.twitter.com/'.$product['Product']['twitter']); ?>
	<?php endif;?>
</dl>