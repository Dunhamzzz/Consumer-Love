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
        
    </dl>
</div>