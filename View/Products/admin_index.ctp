<p>Here is a list of all the products/brands currently listed on Consumer Love.</p>
<?php echo $this->element('pagination/basic'); ?>
<table class="admin-table" cellpadding="0" cellspacing="0">
<thead>
<tr>
		<th><?php echo $this->Paginator->sort('name');?></th>
		<th>Categories</th>
		<th><?php echo $this->Paginator->sort('description');?></th>
</tr>
</thead>
<tbody>
<?php foreach ($products as $product): ?>
<tr>
	<td class="title">
		<?php echo $this->Love->productImage($product); ?>
		<?php echo $this->Link->product($product); ?>
		<?php echo $this->Html->link($this->Html->image('icons/page_white_edit.png'), array('action' => 'edit', $product['Product']['id']), array('escape' => false)); ?>
	</td>
	<td>
		<?php echo $this->Love->listProductCategories($product); ?>
	</td>
	<td><?php echo $this->Text->truncate($product['Product']['description'], 40); ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<?php echo $this->element('pagination/basic'); ?>
<p><?php
echo $this->Paginator->counter(array(
'format' => 'Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%'
));
?></p>