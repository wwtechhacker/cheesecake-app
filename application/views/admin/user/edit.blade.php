<form action="" method="POST" accept-charset="utf-8">
	<?php 
		$meta = Sentry::user($user['id'])->get('metadata');
	?>
	
	<label for="email">Email Address</label>
	<input type="text" name="email" value="{{ $user['email'] }}" id="email"/><br />
	
	<label for="username">Username</label>
	<input type="text" name="username" value="{{ $user['username'] }}" id="username"/><br />
	
	<label for="first_name">First Name</label>
	<input type="text" name="first_name" value="{{ $meta['first_name'] }}" id="first_name"/><br />
	
	<label for="last_name">Last Name</label>
	<input type="text" name="last_name" value="{{ $meta['last_name'] }}" id="last_name"/><br />

	<p><input type="submit" value="Continue"/></p>
</form>