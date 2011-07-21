<?php
/**
 * Copyright 2009-2010, Cake Development Corporation (http://cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2009-2010, Cake Development Corporation (http://cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<?php
if ($allowAddByAuth):
	if ($isAddMode && $allowAddByAuth): ?>
		<?php
		echo $commentWidget->element('form', array('comment' => (!empty($comment) ? $comment : 0)));
	else:
		if (empty($this->params[$adminRoute]) && $allowAddByAuth):
			echo $commentWidget->link(__d('comments', 'Add Comment', true), am($url, array('comment' => 0)), array('class' => 'comment-cta'));
		endif;
	endif;
else: ?>
<p class="message ui-state-highlight ui-corner-all">You must be logged in to submit a comment.</p>
<?php endif;

if (!$isAddMode || $isAddMode):
	//echo $commentWidget->element('paginator');
	echo $tree->generate(${$viewComments}, array(
		'callback' => array(&$commentWidget, 'treeCallback'),
		'model' => 'Comment',
		'class' => 'tree-block'));
endif;

?>
<?php echo $this->Html->image('/comments/img/indicator.gif', array('id' => 'busy-indicator',
 'style' => 'display:none;')); ?>
