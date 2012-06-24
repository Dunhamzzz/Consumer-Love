<?php

// Register Widgets
$pageWidgets = array(
    'product_meta' => array($product['Product']),
    'product_submit' => array($product['Product'])
);

if (!empty($product['Tweet'])) {
    $pageWidgets['twitter'] = array('tweets' => $product['Tweet']);
}
$this->set(compact('pageWidgets'));
echo $this->element('products/header-tabs', array('current' => 'gallery'));
?>
<h1><?php echo $this->Link->product($product), ' ', __('Gallery'); ?></h1>