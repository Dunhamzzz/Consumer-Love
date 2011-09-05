<?php $escapedTerm = $this->Html->tag('strong', $term, array('escape' => true));?>
<?php if(!empty($products)): ?>
	<p><strong>Products</strong></p>
	<ul class="suggestions">
	<?php foreach($products as $product): ?>
		<li><?php echo $this->Link->product($product, $this->Love->productImage($product).$product['Product']['name'], array('escape' => false));?></li>
	<?php endforeach; ?>
	</ul>
<?php endif; ?>
<?php if(!empty($categories)): ?>
	<p><strong>Categories</strong></p>
	<ul class="suggestions basic">
	<?php foreach($categories as $category): ?>
		<li><?php echo $this->Love->categoryLink($category);?></li>
	<?php endforeach; ?>
	</ul>
<?php endif; ?>
<?php if(empty($products) && empty($categories)) :?>
<p class="suggest-cta">We couldn't find anything called <?php echo $escapedTerm;?>, but you can <?php echo $this->Html->Link('setup a new page here', array('controller' => 'products', 'action' => 'suggest', '?' => 'suggestion='.$term))?>. </p>
<?php else: ?>
<p class="suggest-cta">Not the <?php echo $escapedTerm;?> you were looking for? <?php echo $this->Html->Link('Setup a new page here', array('controller' => 'products', 'action' => 'suggest', '?' => $term))?>.</p>
<?php endif;?>