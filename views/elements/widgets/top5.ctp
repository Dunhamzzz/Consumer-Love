<?php
$top5SelectOptions = array(
	'label' => false,
	'div' => false,
	'class' => 'top5select'
);
echo $this->Form->create('Product'); ?>
<h4>Top Products In...</h4>
<div class="top5">
	<?php echo $this->Form->input('category_id', array_merge($top5SelectOptions, array('selected' => $top5Category['Category']['id']))); ?>
	<?php echo $this->element('api/top5');?>
</div>
<?php echo $this->Form->end(); ?>