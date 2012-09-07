<?php
$this->Html->script('jquery.scrolltofixed.min', array('inline' => false));

// Register Widgets
$pageWidgets = array(
    'product_meta' => array($product['Product'])
);

if (!empty($product['Tweet'])) {
    $pageWidgets['twitter'] = array('tweets' => $product['Tweet']);
}
$this->set(compact('pageWidgets'));

$this->Html->addCrumb($thread['Product']['name'], array(
    'controller' => 'products', 'action' => 'view', 'productSlug' => $thread['Product']['slug']));
$this->Html->addCrumb('Forum', array('action' => 'all', 'productSlug' => $thread['Product']['slug']));
?>
<h1 id="thread-title"><?php echo $thread['Thread']['title']; ?></h1>
<p class="thread-description">Posted in our <?php echo $this->Link->forum($thread['Product']['slug'], $thread['Product']['name'] . ' forum'); ?>.</p>
<?php echo $this->element('pagination/basic', array('class' => 'thread-pagination')); ?>
<ul id="posts">
    <?php foreach ($posts as $post): ?>
        <?php echo $this->element('forums/postbit', array('post' => $post)); ?>
    <?php endforeach; ?>
</ul>
<?php echo $this->element('pagination/basic'); ?>
<?php if (isset($userData)) : ?>
    <h3>Post a Reply</h3>
    <?php echo $this->element('forms/post'); ?>
    <?php if($userData['admin']): ?>
        <h3>Admin Controls</h3>
        <ul>
            <li><?php
        echo $this->Form->postLink(__('Delete Thread'), array(
            'action' => 'delete',
            $thread['Thread']['id']
                ), array('confirm' => __('Are you sure you wish to delete this thread?')));
        ?></li>
        </ul>
    <?php elseif ($userData['id'] == $thread['Thread']['user_id']): ?>
        <h2>Thread Owner Controls</h2>
        <ul>
            <li><?php
        echo $this->Form->postLink(__('Delete Thread'), array(
            'action' => 'delete',
            $thread['Thread']['id']
                ), array('confirm' => __('Are you sure you wish to delete this thread?')));
        ?></li>
        </ul>
    <?php endif; ?>
<?php endif; ?>