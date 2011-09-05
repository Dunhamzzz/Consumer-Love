<h1><?php echo $title_for_layout; ?></h1>
<?php if(isset($privateInventory)): ?>
<p><strong><?php echo $user['username'];?></strong> has set their inventory to private.</p>
<?php else: ?>

<?php if($userData['id'] == $user['User']['id']): ?>
<p><?php echo $this->Paginator->counter(array(
'format' => 'You have %count% items in your inventory. Showing page %page% of %pages%.'
)); ?></p>
<?php else: ?>
<p><?php echo $user['User']['username'].$this->Paginator->counter(array(
'format' => ' has %count% items in their inventory. Showing page %page% of %pages%.'
)); ?></p>
<?php endif; ?>
<div class="products-list">
	<?php foreach($products as $product): ?>
	<div data-id="<?php echo $product['Product']['slug'];?>">
		<?php echo $this->Love->productImage($product); ?>
		<h2><?php echo $this->Link->product($product);?></h2>
		<p><?php echo $this->Text->truncate($product['Product']['description_formatted'], 80, array('html' => true)); ?></p>
	</div>
	<?php endforeach; ?>
</div>
<?php echo $this->element('pagination/basic'); ?>
<?php endif; ?>
