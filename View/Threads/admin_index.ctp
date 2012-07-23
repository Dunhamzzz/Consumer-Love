<h1><?php echo __('Forum Admin'); ?></h1>
<?php echo $this->element('pagination/basic'); ?>
<form action="/admin/threads/actions" method="POST">
<ul class="threads">
<?php foreach($threads as $thread): ?>
    <li title="<?php echo $thread['FirstPost']['content']; ?>">
        <span class="thread-info">
            <span class="thread-link">
                <?php
                echo $this->Html->link($thread['Thread']['title'], array(
                    'controller' => 'threads',
                    'action' => 'view',
                    'productSlug' => $thread['Product']['slug'],
                    'threadSlug' => $thread['Thread']['slug'],
                    'admin' => false
                ));
                ?></span>
            <span class="thread-meta">
                Posted by <?php echo $this->Link->user($thread['User']); ?> <?php echo $this->Time->timeAgoInWords($thread['Thread']['created']); ?>
            </span>
        </span>
        <ul class="lastpost-info">
            <li><?php echo $thread['Thread']['post_count'] > 2 ? $thread['Thread']['post_count'] . ' replies' : $thread['Thread']['post_count'] == 2 ? '1 reply' : 'No replies'; ?></li>
            <li><?php echo $this->Time->timeAgoInWords($thread['Thread']['modified']); ?></li>
        </ul>
        <input type="checkbox" name="threadId[]" value="<?php echo $thread['Thread']['id']; ?>">
    </li>
<?php endforeach; ?>
</ul>
<?php echo $this->element('pagination/basic'); ?>
    <input type="submit" name="action" value="Delete">
</form>
<script>
    
</script>