<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Laravel: A Framework For Web Artisans</title>
	<meta name="viewport" content="width=device-width">
	{{ HTML::style('laravel/css/style.css') }}
</head>
<body>
	<div class="wrapper">
		<header>
			<h1>Laravel <?php if(!is_null(Auth::user()) and Auth::user()->has_role('administrator'))
									echo " FOR ADMINS, BITCH."; 
								else echo " bro d'fuck?"; ?></h1>
			<h2>A Framework For Web Artisans</h2>

			<p class="intro-text" style="margin-top: 45px;">
				Into text?
			</p>
		</header>
		<div role="main" class="main">
			<div class="home">
				<h2>Learn the terrain.</h2>

				<p>
					You've landed yourself on our default home page. The route that
					is generating this page lives at:
				</p>

				<pre>{{ path('app') }}routes.php</pre>

				<p>And the view sitting before you can be found at:</p>

				<pre>{{ path('app') }}views/home/index.blade.php</pre>

				<h2>Grow in knowledge.</h2>

				<p>
					Learning to use Laravel is amazingly simple thanks to
					its {{ HTML::link('docs', 'wonderful documentation') }}.
				</p>

				<h2>Create something beautiful.</h2>

				<p>
					Now that you're up and running, it's time to start creating!
					Here are some links to help you get started:
				</p>

				<ul class="out-links">
					@if(Auth::guest())
						<li>{{ HTML::link_to_route('auth.register','Register') }}</li>
						<li>{{ HTML::link_to_route('auth.login','Login') }}</li>
					@else
						<li>{{ HTML::link_to_route('auth.logout','Logout') }}</li>
						@if(Auth::user()->has_role('administrator'))
							<li>{{ HTML::link_to_route('admin.panel','Admin Panel') }}</li>
						@endif
					@endif
					<li>{{ HTML::link_to_route('forum.home','Forums') }}</li>
				</ul>
			</div>
		</div>
	</div>
</body>
</html>
