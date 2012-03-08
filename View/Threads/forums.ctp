<h1><?php echo $title_for_layout; ?></h1>
<?php echo $this->element('pagination/basic'); ?>
<table id="forum-listing">
<?php foreach ($forums as  $product): ?>
	<tr>
	    <td>
			<?php echo $this->Link->forum($product, $this->Love->productImage($product) . $product['Product']['name'], array('escape' => false)); ?>
			</td>
			<td>
	       		<?php ?>
		</td>
	    </td>
	</tr>
<?php endforeach; ?>
</table>
<?php echo $this->element('pagination/basic'); ?>
