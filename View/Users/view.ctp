<?php
// Users Age
$age = $this->Love->age($user['User']['dob']);
?>
<h1 class="profile-title"><?php echo $user['User']['username']; ?></h1>
<div class="user-column c1">
    <?php echo $this->Gravatar->image($user['User']['email'], array('size' => 128, 'class' => 'gravatar')); ?>
    <p>Joined <?php echo $this->Time->timeAgoInWords($user['User']['created']); ?></p>
    <p><?php echo number_format($user['User']['profile_hits']); ?> profile views.</p>
</div>
<div class="user-column c2">
    <table class="settings-table">
        <tr>
            <?php if (!empty($user['User']['real_name'])): ?>
                <th>Real Name</th>
                <td><?php echo $user['User']['real_name']; ?></td>
            </tr>
        <?php endif; ?>

        <?php if ($age): ?>
            <tr>
                <th>Age</th>
                <td><?php echo $age; ?></td>

            </tr>
        <?php endif; ?>

        <?php if (!empty($user['User']['location'])): ?>
            <tr>
                <th>Location</th>
                <td><?php echo $user['User']['location']; ?></td>
            </tr>
        <?php endif; ?>

        <?php if (!empty($user['User']['website'])): ?>
            <tr>
                <th>Website</th>
                <td><?php echo $this->Html->link($user['User']['website'], $user['User']['website'], array('class' => 'external')); ?></td>
            </tr>
        <?php endif; ?>
        <tr>
            <th>Last Seen</th>
            <td><?php echo $this->Time->timeAgoInWords($user['User']['last_activity']); ?></td>
        </tr>
    </table>
</div>
<div class="user-column c3">
    <p class="user-bio">
        <?php if (!empty($user['User']['bio'])): ?>
            <?php echo $user['User']['bio'] ?>
        <?php else: ?>
            <em>No bio entered.</em>
        <?php endif; ?>
    </p>
</div>