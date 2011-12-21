<?php
// Users Age
$age = $this->Love->age($user['User']['dob']);
?>
<h1 class="profile-title"><?php echo $user['User']['username']; ?></h1>
<div class="user-column c1">
    <?php echo $this->Gravatar->image($user['User']['email'], array('size' => 128, 'class' => 'gravatar'));?>
    <p>Joined <?php echo $this->Time->timeAgoInWords($user['User']['created']); ?></p>
    <p><?php echo number_format($user['User']['profile_hits']); ?> profile views.</p>
</div>
<div class="user-column c2">
    <dl>
        <?php if(!empty($user['User']['real_name'])): ?>
        <dt>Real Name</dt>
        <dd><?php echo $user['User']['real_name']; ?></dd>
        <?php endif; ?>
        
        <?php if($age): ?>
        <dd>Age</dd>
        <dt><?php echo $age; ?></dt>
        <?php endif; ?>

		<?php if(!empty($user['User']['location'])): ?>
		<dd>Location</dd>
		<dt><?php echo $user['User']['location'];?></dt>
        <?php endif; ?>

		<?php if(!empty($user['User']['website'])): ?>
		<dd>Website</dd>
		<dt><?php echo $this->Html->link($user['User']['website'], $user['User']['website'], array('class' => 'external'));?></dt>
        <?php endif; ?>

		<dd>Last Seen</dd>
		<dt><?php echo $this->Time->timeAgoInWords($user['User']['last_activity']); ?></dt>
    </dl>
</div>
<div class="user-column c3">
	<p class="user-bio">
	<?php if(!empty($user['User']['bio'])): ?>
		<?php echo $user['User']['bio']?>
	<?php else: ?>
		<em>No bio entered.</em>
	<?php endif; ?>
	</p>
</div>