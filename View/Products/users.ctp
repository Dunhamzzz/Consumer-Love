<?php
$this->set('pageWidgets', array('product_meta'));
?><h1>Users who follow <?php echo $this->Link->product($product); ?></h1>
<?php if(!empty($users)): ?>
<ul class="users-list">
	<?php foreach($users as $user): ?>
	<li>
		<?php echo $this->Link->user(
			$user,
			$this->Gravatar->image($user['User']['email'], array('size' => 32, 'class' => 'gravatar')) . htmlspecialchars($user['User']['username']) . '<span class="meta">since ' . $this->Time->niceShort($user['Inventory']['created']) . '</span>',
			array('escape' => false)
		);?>
	</li>
	<?php endforeach; ?>
</ul>
<?php else: ?>
	<p>No users have this product.</p>
<?php endif; ?>