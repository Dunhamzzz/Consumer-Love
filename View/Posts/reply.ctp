<?php
// Register Widgets
$pageWidgets = array(
	'product_meta' => array($thread['Product'])
);
$this->set(compact('pageWidgets'));
?>
<p>
	You are replying to the thread <em><?php echo $this->Link->thread($thread); ?></em>
 for <?php echo $this->Link->Product($thread['Product']); ?>.
</p>
<?php echo $this->element('forms/post'); ?>