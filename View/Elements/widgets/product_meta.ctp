<dl>
	<dt><a title="Click to find out how we work out a products popularity on Consumer Love">Popularity</a></dt>
	<dd><?php echo $product['Product']['inventory_count'];?></dd>
	<dt>Categories</dt>
	<dd><?php echo $this->Love->listProductCategories($product);?></dd>
	<?php if(!empty($product['Product']['website_url'])) :?>
	<dt>Website</dt>
	<dd><?php echo $this->Html->link($product['Product']['website_url'], $product['Product']['website_url']); ?></dd>
	<?php endif;?>
	<?php if(!empty($product['Product']['twitter'])) :?>
	<dt>Twitter</dt>
	<dd><?php echo $this->Html->link('@'.$product['Product']['twitter'], 'http://www.twitter.com/'.$product['Product']['twitter']); ?>
	<?php endif;?>
</dl>