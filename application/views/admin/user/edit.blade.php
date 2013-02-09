<form action="" method="POST" accept-charset="utf-8">
	
	<label for="email">Email Address</label>
	<input type="text" name="email" value="{{ $user->email }}" id="email"/><br />
	
	<label for="username">Username</label>
	<input type="text" name="name" value="{{ $user->name }}" id="name"/><br />
	
	<label for="last_name">Password</label>
	<input type="password" name="password" value="" id="password"/><br />

	<p><input type="submit" value="Edit User"/></p>
</form>
