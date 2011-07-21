<h2><?php __('Products');?></h2>
<p>Here is a list of all the products/brands currently listed on Consumer Love.</p>
<table class="admin-table" cellpadding="0" cellspacing="0">
<tr>
		<th><?php echo $this->Paginator->sort('name');?></th>
		<th>Categories</th>
		<th><?php echo $this->Paginator->sort('description');?></th>
		<th class="actions"><?php // __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($products as $product):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
<tr<?php echo $class;?>>
	<td>
		<?php echo $love->productImage($product); ?>
		<?php echo $love->productLink($product); ?>
		<?php echo $html->link($html->image('icons/page_white_edit.png'), array('action' => 'edit', $product['Product']['id']), array('escape' => false)); ?>
	</td>
	<td>
		<ul><?php foreach($product['Category'] as $category): ?>
			<li><?php echo $category['name']; ?></li>
		<?php endforeach; ?></ul>
	</td>
	<td><?php echo $this->Text->truncate($product['Product']['description'], 40); ?>&nbsp;</td>
	<td class="actions">
		<?php //echo $html->link($html->image('icons/bin_closed.png'), array('action' => 'delete', $product['Product']['id']), array('escape' => false), sprintf(__('Are you sure you want to delete # %s?', true), $product['Product']['id'])); ?>
	</td>
</tr>
<?php endforeach; ?>
</table>
<p><?php
echo $this->Paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>

<div class="paging">
	<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $this->Paginator->numbers();?>
 |
	<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
</div>
