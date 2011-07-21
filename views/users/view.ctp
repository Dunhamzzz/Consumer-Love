<h1><?php echo $user['User']['username']; ?></h1>
<?php echo $this->Gravatar->image($user['User']['email'], array('size' => 128, 'class' => 'gravatar'));?>