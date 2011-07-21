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
<div class="thread-actions">
	<?php echo $this->Button->thread($product['Product']['id']); ?>
</div>
<div id="threads"></div>
<ul class="posts">
<?php foreach($posts as $post): ?>
	<li id="post-<?php echo $post['Post']['id'];?>">
		<div class="post-meta">
			<?php echo $this->Time->timeAgoInWords($post['Post']['created']); ?>
			<?php if($userData['User']['id'] == $post['Author']['id'] || $isAdmin): ?>
				<?php echo $this->Html->link('Edit',
					array('controller' => 'posts', 'action' => 'edit', $post['Post']['id']),
					array('class' => 'edit-post',' title' => 'edit')
				); ?>
			<?php endif; ?>
		</div>
		<div class="post-author">
			<?php echo $this->Love->userLink($post['Author']); ?><br />
			<?php echo $post['Author']['post_count']; ?> posts<br/>
			<?php echo $this->Gravatar->image($post['Author']['email'], array('size' => 64, 'class' => 'gravatar'));?>
		</div>
		<div class="post-content">
			<p><?php echo nl2br($post['Post']['content']); ?></p>
		</div>
		<div class="post-actions">
			<?php echo $this->Html->link('Reply',
				array('controller' => 'posts', 'action' => 'reply', $thread['Thread']['id']),
				array('class' => 'cta reply'))
			;?>
		</div>
	</li>
<?php endforeach; ?>
</ul>
<?php echo $this->element('forms/post'); ?>