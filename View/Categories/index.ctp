<ul id="category-list">
<?php foreach($categories as $category): ?>
<li><?php echo $this->Link->category($category); ?><?php if(!empty($category['children'])): ?>
	<ul>
	<?php foreach($category['children'] as $child): ?>
		<li><?php echo $this->Link->category($child); ?></li>
	<?php endforeach; ?>
	</ul>
<?php endif; ?></li>
<?php endforeach; ?>
</ul>