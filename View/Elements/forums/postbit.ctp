<li id="post-<?php echo $post['Post']['id'];?>" <?php if(isset($userData) && $userData['id'] == $post['Author']['id']) echo 'class="mine"';?>>
	<div class="post-meta">
		<?php echo $this->Gravatar->image($post['Author']['email'], array('size' => 64, 'class' => 'gravatar'));?>
		<?php echo $this->Link->user($post['Author']); ?><br />
		<?php echo $post['Author']['post_count']; ?> posts<br/>
	
	
		<time><?php echo $this->Time->timeAgoInWords($post['Post']['created']); ?></tim>
	</div>
	<div class="post-content">
		<p><?php echo nl2br($post['Post']['content']); ?></p>
		<?php if(isset($userData) && $userData['id'] == $post['Author']['id'] || (isset($isAdmin) && $isAdmin == true)): ?>
		<p>
			<?php echo $this->Html->link('Edit',
				array('controller' => 'posts', 'action' => 'edit', $post['Post']['id']),
				array('class' => 'edit-post',' title' => 'edit', 'data-id' => $post['Post']['id'])
			); ?>
		<?php endif; ?>
		</p>
	</div>
</li>