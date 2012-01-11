<?php

$pageWidgets = array('product_admin' => array('product' => $this->request->data['Product']));
$this->set(compact('pageWidgets'));
?><h1>Edit <?php echo $this->Link->product($product); ?></h1>
<?php echo $this->element('forms/product'); ?>
<div class="admin-help">
<?php if(!empty($this->request->data['Product']['logo'])) {
	echo '<p>The current image is displayed below:<br/><br/>';
	echo $this->Love->productImage($product, 128);
} else {
	echo '<p>Be sure to upload an image for this product!</p>';
}
?>
</div>