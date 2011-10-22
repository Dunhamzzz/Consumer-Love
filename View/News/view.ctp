<?php
// Register Widgets
$pageWidgets = array(
	'product_meta' => array($product['Product']),
	'product_submit' => array($product['Product'])
);

if(!empty($product['Tweet'])) {
	$pageWidgets['twitter'] = array('tweets' => $product['Tweet']);
}
$this->set(compact('pageWidgets'));

?><h1><?php echo htmlspecialchars($news['News']['title']); ?></h1>
<?php pr($news); ?>