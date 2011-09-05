<p>Here you can manage the categories on Consumer Love.</p>
<ul>
<?php foreach($categories as $parentCategory): ?>
	<li><?php echo $this->Link->category($parentCategory['Category']);?> <?php echo $this->Html->link(
			$this->Html->image('icons/pencil.png', array('class' => 'inline-icon')),
			array(
				'action' => 'admin_edit',
				$parentCategory['Category']['id']
			),
			array(
				'escape' => false
			)
		);?>
	<?php if(!empty($parentCategory['children'])):?>
		<ul>
		<?php foreach ($parentCategory['children'] as $childCategory):?>
			<li><?php echo $this->Link->category($childCategory['Category']);?> <?php echo $this->Html->link(
			$this->Html->image('icons/pencil.png', array('class' => 'inline-icon')),
			array(
				'action' => 'admin_edit',
				$childCategory['Category']['id']
			),
			array(
				'escape' => false
			)
		);?></li>
		<?php endforeach; ?>
		</ul>
	<?php endif;?>
	</li>
<?php endforeach; ?>
</ul>