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

$_actionLinks = array();
if (!empty($displayUrlToComment)) {
	$_actionLinks[] = sprintf('<a href="%s">%s</a>', $urlToComment . '/' . $comment['Comment']['slug'], __d('comments', 'View', true));
}

if (!empty($isAuthorized)) {
	$_actionLinks[] = $commentWidget->link(__d('comments', 'Reply', true), array_merge($url, array('comment' => $comment['Comment']['id'], '#' => 'comment' . $comment['Comment']['id'])));
	$_actionLinks[] = $commentWidget->link(__d('comments', 'Quote', true), array_merge($url, array('comment' => $comment['Comment']['id'], 'quote' => 1, '#' => 'comment' . $comment['Comment']['id'])));
	if (!empty($isAdmin)) {
		if (empty($comment['Comment']['approved'])) {
			$_actionLinks[] = $commentWidget->link(__d('comments', 'Publish', true), array_merge($url, array('comment' => $comment['Comment']['id'], 'comment_action' => 'toggleApprove', '#' => 'comment' . $comment['id'])));
		} else {
			$_actionLinks[] = $commentWidget->link(__d('comments', 'Unpublish', true), array_merge($url, array('comment' => $comment['Comment']['id'], 'comment_action' => 'toggleApprove', '#' => 'comment' . $comment['Comment']['id'])));
		}
	}
}

$_userLink = $comment[$userModel]['username'];
?>
<div class="comment<?php echo (!empty($userModel) && isset($userData) && $comment['UserModel']['id'] == $userData['User']['id']) ? ' mine' : ''?>">
	<?php echo $this->Gravatar->image($comment['UserModel']['email'], array('size' => 32, 'class' => 'gravatar')); ?>
	<div class="header">
		<a name="comment<?php echo $comment['Comment']['id'];?>"><?php echo $comment['Comment']['title'];?></a>
		<span class="author"><?php echo $this->Love->userLink($comment['UserModel']);?> <?php echo $time->timeAgoInWords($comment['Comment']['created']); ?></span>
	</div>
	<p class="body"><?php echo $cleaner->bbcode2js($comment['Comment']['body']);?></p>
	<div class="actions"><?php echo join('&nbsp;', $_actionLinks);?></div>
</div>