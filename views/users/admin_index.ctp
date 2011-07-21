<table class="admin-table">
	<thead>
	<tr>
		<th>Username</th>
		<th>Registered</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($users as $user):?>
		<tr>
			<td><?php echo $user['User']['username']; ?></td>
			<td><?php echo $user['User']['created']; ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>