<div class="user-card">
<?php
	echo $this->Gravatar->image($user['User']['email'], array('size' => 64, 'class' => 'gravatar'));
	echo $user['User']['username'];
?>
</div>