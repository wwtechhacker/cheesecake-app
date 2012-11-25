<?php 
	if(Session::has('error'))
	{
		echo Session::get('error')."<br /><br />";
	}
	else
		echo "Lulz<br /><br />";
?>

<form action="" method="post" accept-charset="utf-8">
	<label for="username">Username</label>
	<input type="text" name="username" value="" id="username"/>
	
	<label for="password">Password</label>
	<input type="password" name="password" value="" id="password"/>
	
	<label for="remember">Remember Me?</label>
	<input type="checkbox" name="remember" value="1" id="remember"/>
	
	<p><input type="submit" value="Login"/></p>
</form>