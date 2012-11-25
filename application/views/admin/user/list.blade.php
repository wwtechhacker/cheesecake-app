<table border="1" cellspacing="5" cellpadding="5">
	<tr>
		<th>ID</th>
		<th>Username</th>
		<th>Real Name</th>
		<th>Actions</th>
	</tr>
	<?php foreach($users as $user){ ?>\
	<?php $metadata = Sentry::user($user["id"])->get('metadata') ?>
	<tr>
		<td>{{ $user["id"] }}</td>
		<td>{{ $user["username"] }}</td>
		<td><?php echo $metadata["first_name"]." ".$metadata["last_name"]; ?></td>
		<td>
			<?php 
				echo HTML::link_to_route('admin.user.edit','[EDIT]',$user["id"]);
				if($user["id"] != 1)
					echo HTML::link_to_route('admin.user.delete','[DELETE]',$user["id"]);
			?>
		</td>
	</tr>
	<?php } ?>
</table>