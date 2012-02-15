<h1><?php echo $title_for_layout; ?></h1>
<?php echo $this->element('pagination/basic'); ?>
<ul id="forum-listing">
<?php foreach ($forums as  $product): ?>
    <li><?php echo $this->Link->forum($product); ?>
        <?php pr($product); ?>
    </li>
<?php endforeach; ?>
</ul>
<?php echo $this->element('pagination/basic'); ?>
