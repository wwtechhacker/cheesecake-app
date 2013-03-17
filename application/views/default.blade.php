<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>{{ $title }}</title>

		{{ Asset::container('bootstrapper')->styles() }}
		{{ Asset::container('bootstrapper')->scripts() }}
		{{ HTML::style('css/main.css') }}
</head>
<body>
	<div class="row-fluid">
		<div class="span6 offset3" id="title">
			<h1>CHEESECAKE.DEV</h1>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6 offset3">
			{{ $content }}
		</div>
	</div>
</body>
</html>