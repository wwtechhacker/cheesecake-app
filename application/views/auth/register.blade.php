<?php 
	if(Session::has('error'))
	{
		echo Session::get('error')."<br /><br />";
	}
?>

<form action="" method="post" accept-charset="utf-8">
	<label for="username">Email</label><br />
	<input type="text" name="email" value="" id="email"/><br />
	
	<label for="password">Password</label><br />
	<input type="password" name="password" value="" id="password"/><br />

	<label for="name">Username</label><br />
	<input type="text" name="name" value="" id="name"><br />
	
	<p><input type="submit" value="Login"/></p>
</form>
