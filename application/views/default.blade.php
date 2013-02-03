<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>{{ $title }}</title>

	<?php 
		echo Asset::container('bootstrapper')->styles();
		echo Asset::container('bootstrapper')->scripts();
		echo HTML::style('css/main.css');
	?>
</head>
<body>
	<div class="row-fluid">
		<div class="span6 offset3">
			{{ $content }}
		</div>
	</div>
</body>
</html>