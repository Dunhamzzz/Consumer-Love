<?php
// Register Widgets
$pageWidgets = array(
	'product_meta' => array($product['Product'])
);

if(!empty($product['Tweet'])) {
	$pageWidgets['twitter'] = array('tweets' => $product['Tweet']);
}
$this->set(compact('pageWidgets'));

$this->Html->addCrumb($thread['Product']['name'], array(
	'controller' => 'products', 'action' => 'view', 'productSlug' => $thread['Product']['slug']));
$this->Html->addCrumb('Forum', array('action' => 'all', 'productSlug' => $thread['Product']['slug']));
?>
<h2><?php echo $thread['Thread']['title']; ?></h2>
<p class="thread-description">Posted in our <?php echo $this->Link->forum($thread['Product']['slug'], $thread['Product']['name'].' forum');?>.</p>
<ul class="posts">
<?php foreach($posts as $post): ?>
	<?php echo $this->element('forums/postbit', array('post' => $post)); ?>
<?php endforeach; ?>
</ul>
<div class="post-actions">
	<?php echo $this->Html->link('Reply',
		array('controller' => 'posts', 'action' => 'reply', $thread['Thread']['id']),
		array('class' => 'cta reply'))
	;?>
</div>
<h2>Post a Reply</h2>
<?php echo $this->element('forms/post'); ?>