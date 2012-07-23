<?php
// Users Age
$age = $this->Love->age($user['User']['dob']);
?>
<h1 class="profile-title"><?php echo $user['User']['username']; ?></h1>
<div id="bio">
    <div class="user-column c1">
        <?php echo $this->Gravatar->image($user['User']['email'], array('size' => 128, 'class' => 'gravatar')); ?>
        <p>Joined <?php echo $this->Time->timeAgoInWords($user['User']['created']); ?></p>
        <p><?php echo number_format($user['User']['profile_hits']); ?> profile views.</p>
    </div>
    <div class="user-column c2">
        <table class="settings-table">
            <tr>
                <?php if (!empty($user['User']['real_name'])): ?>
                    <th>Real Name</th>
                    <td><?php echo $user['User']['real_name']; ?></td>
                </tr>
            <?php endif; ?>

            <?php if ($age): ?>
                <tr>
                    <th>Age</th>
                    <td><?php echo $age; ?></td>

                </tr>
            <?php endif; ?>

            <?php if (!empty($user['User']['location'])): ?>
                <tr>
                    <th>Location</th>
                    <td><?php echo $user['User']['location']; ?></td>
                </tr>
            <?php endif; ?>

            <?php if (!empty($user['User']['website'])): ?>
                <tr>
                    <th>Website</th>
                    <td><?php echo $this->Html->link($user['User']['website'], $user['User']['website'], array('class' => 'external')); ?></td>
                </tr>
            <?php endif; ?>
            <tr>
                <th>Last Seen</th>
                <td><?php echo $this->Time->timeAgoInWords($user['User']['last_activity']); ?></td>
            </tr>
        </table>
    </div>
    <div class="user-column c3">
        <p class="user-bio">
            <?php if (!empty($user['User']['bio'])): ?>
                <?php echo $user['User']['bio'] ?>
            <?php else: ?>
                <em>No bio entered.</em>
            <?php endif; ?>
        </p>
    </div>
</div>
<div class="tabs-wrapper">
    <div class="tab-list-wrapper">
        <ul id="user-tabs" class="tabs">
            <li><a href="#overview">Overview</a></li>
            <li><a href="#inventory">Inventory</a></li>
            <li><a href="#news">News</a></li>
            <li><a href="#forum">Discussions</a></li>
        </ul>
    </div>
    <section id="overview">
        <h2>Overview</h2>
        <div id="latest-love" class="page-widget">
            <?php if (!empty($latestLove)): ?>
                <ul class="product-list">
                    <?php foreach ($latestLove as $product): ?>
                        <li><? debug($product); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>

            <?php endif; ?>
        </div>
    </section>

    <section id="inventory">
        <h2><?php echo $this->Link->inventory($user, __('Inventory (%s)', $user['User']['inventory_count']), array('escape' => false)); ?></h2>
        <?php if (!empty($inventory)): ?>
            <div class="product-list-medium-wrapper">
                <?php foreach ($inventory as $product): ?>
                    <?php echo $this->element('products/medium_list', array('product' => $product)); ?>
                <?php endforeach; ?>
            </div>
        <p><?php echo $this->Link->inventory($user, __('View all %s products in %ss inventory', $user['User']['inventory_count'], $user['User']['username']), array('escape' => false)); ?></p>
        <?php else: ?>
            <p><?php echo $user['User']['username']; ?> has nothing in their inventory yet!</p>
        <?php endif; ?>
    </section>

    <section id="news">
        <h2>News Articles</h2>
    </section>

    <section id="forum">
        <h2>Latest Forum Posts</h2>
        <?php if (!empty($latestPosts)): ?>
        <? debug($latestPosts);?>
            <ul>
                <?php foreach ($latestPosts as $post): ?>
                    <li>
                        <blockquote><?php echo $post['Post']['content']; ?></blockquote>
                        on <?php echo $this->Link->thread($post); ?>
                        in <?php echo $this->Link->forum($post, $post['Thread']['Product']['name']); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p><em><?php echo $user['User;']['name']; ?> has not participated in our forum yet.</em></p>
        <?php endif; ?>
    </section>
</div>