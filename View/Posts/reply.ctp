<?php
// Register Widgets
$this->set('pageWidgets', array(
    'product_meta' => array('product' => $product)
));
?>
<h1>Reply to Thread</h1>
<p>
    You are replying to the thread <em><?php echo $this->Link->thread($thread); ?></em>
    for <?php echo $this->Link->Product($product); ?>.
</p>
<?php echo $this->element('forms/post'); ?>