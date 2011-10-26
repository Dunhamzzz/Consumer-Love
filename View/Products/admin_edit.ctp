<?php

$pageWidgets = array('product_admin' => array('product' => $this->request->data['Product']));
$this->set(compact('pageWidgets'));
?><h1><?php echo $this->Link->product($this->request->data, __('Edit %s', $this->request->data['Product']['name'])); ?></h1>
<?php echo $this->element('forms/product'); ?>
<div class="admin-help">
<?php if(!empty($this->request->data['Product']['logo'])) {
	echo '<p>The current image is displayed below:<br/><br/>';
	echo $this->Love->productImage($this->request->data, 128);
} else {
	echo '<p>Be sure to upload an image for this product!</p>';
}
?>
</div>