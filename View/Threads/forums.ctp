<h1><?php echo $title_for_layout; ?></h1>
<?php echo $this->element('pagination/basic'); ?>
<ul id="forum-listing">
<?php foreach ($forums as  $product): ?>
    <?php echo $this->element('forums/forumbit', array('product' => $product)); ?>
<?php endforeach; ?>
</ul>
<?php echo $this->element('pagination/basic'); ?>
