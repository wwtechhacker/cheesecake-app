<table border="1" cellspacing="5" cellpadding="5">
	<tr>
		<th>ID</th>
		<th>Email</th>
		<th>Name</th>
		<th>Actions</th>
	</tr>
	@foreach($users as $user)
		<tr>
			<td>{{ $user->id }}</td>
			<td>{{ $user->email }}</td>
			<td>{{ $user->name }}</td>
			<td>
				{{ HTML::link_to_route('admin.user.edit','[EDIT]',$user->id) }}
				@if($user->id != 1 and $user->id != Auth::user()->id)
					{{ HTML::link_to_route('admin.user.delete','[DELETE]',$user->id) }}
				@endif
			</td>
		</tr>
	@endforeach
</table>