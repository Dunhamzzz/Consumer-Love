<h1><?php echo $title_for_layout; ?></h1>
<?php echo $this->element('pagination/basic'); ?>
<table id="forum-listing">
<?php foreach ($forums as  $product): ?>
    <?php echo $this->element('forums/forumbit', array('product' => $product)); ?>
<?php endforeach; ?>
</table>
<?php echo $this->element('pagination/basic'); ?>
