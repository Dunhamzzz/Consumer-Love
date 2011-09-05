<?php
// Register Widgets
$pageWidgets = array(
	'product_meta' => array($product['Product'])
);

if(!empty($product['Tweet'])) {
	$pageWidgets['twitter'] = array('tweets' => $product['Tweet']);
}
$this->set(compact('pageWidgets'));
?>
<p>Start a a new discussion thread on <?php echo $product['Product']['name'];?>.</p>
<?php echo $this->element('forms/thread'); ?>