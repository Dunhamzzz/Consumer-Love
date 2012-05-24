<ul class="threads">
    <?php foreach ($threads as $thread): ?>
        <li title="<?php echo $thread['Post'][0]['content']; ?>">
            <span class="thread-info">
                <span class="thread-link">
                    <?php
                    echo $this->Html->link($thread['Thread']['title'], array(
                        'controller' => 'threads',
                        'action' => 'view',
                        'productSlug' => $product['Product']['slug'],
                        'threadSlug' => $thread['Thread']['slug']
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
        </li>
<?php endforeach; ?>
</ul>