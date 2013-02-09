<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>{{ $title }}</title>

	<?php 
		echo Asset::container('bootstrapper')->styles();
		echo Asset::container('bootstrapper')->scripts();
		echo HTML::style('css/main.css');
		echo HTML::script('js/dump.js');
		echo HTML::style('css/admin.css');
	?>

	
</head>
<body>
	{{ $content }}
</body>
</html>