<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Simply tell Laravel the HTTP verbs and URIs it should respond to. It is a
| breeze to setup your application using Laravel's RESTful routing and it
| is perfectly suited for building large applications and simple APIs.
|
| Let's respond to a simple GET request to http://example.com/hello:
|
|		Route::get('hello', function()
|		{
|			return 'Hello World!';
|		});
|
| You can even respond to more than one URI:
|
|		Route::post(array('hello', 'world'), function()
|		{
|			return 'Hello World!';
|		});
|
| It's easy to allow URI wildcards using (:num) or (:any):
|
|		Route::put('hello/(:any)', function($name)
|		{
|			return "Welcome, $name.";
|		});
|
*/

Route::group(array('before' => 'auth'), function()
{
	Route::get('admin', array('as' => 'admin', 'uses' => 'admin@index'));
	Route::get('admin/user', array(
				'as' => 'admin.user.list', 
				'uses' => 'admin.user@list'));
	Route::any('admin/user/edit/(:num)', array(
				'as' => 'admin.user.edit', 
				'uses' => 'admin.user@edit'));
	Route::get('admin/user/delete/(:num)', array(
				'as' => 'admin.user.delete', 'uses' => 
				'admin.user@delete'));
});

Route::any('login', array(
				'as' => 'auth.login', 
				'uses' => 'user@login'));
Route::get('logout', array(
				'as' => 'auth.logout', 
				'uses' => 'user@logout'));
Route::any('register', array(
				'as' => 'auth.register', 
				'uses' => 'user@register'));

//
//		FORUMS
//

// Forum home
Route::get('forums', array(
				'as' => 'forum.home', 
				'uses' => 'forum@index'));
// Viewing the boards of a category
Route::get('forums/category/(:num)', array(
				'as' => 'forum.category', 
				'uses' => 'forum@category'));
// Viewing the threads of a board
Route::get('forums/board/(:num)', array(
				'as' => 'forum.board', 
				'uses' => 'forum@board'));
// Posting a new thread to a board
Route::any('forums/thread/new/(:num)', array(
				'as' => 'forum.thread.new', 
				'before' => 'auth', 
				'uses' => 'forum@newThread'));
// Viewing a thread
Route::get('forums/thread/(:num)', array(
				'as' => 'forum.thread', 
				'uses' => 'forum@thread'));
// Posting a new reply to a thread
Route::any('forums/thread/reply/(:num)', array(
				'as' => 'forum.thread.reply', 
				'before' => 'auth', 
				'uses' => 'forum@newReply'));

// Toggle the lock on a thread
Route::any('forums/thread/(:num)/lock', array(
				'as' => 'forum.thread.lock',
				'before' => 'auth',
				'uses' => 'forum@lockThread'));

//
//		END FORUMS
//

Route::get('test', function()
{
	return Authority::can('create','User') ? "yes" : "no";
});

Route::get('/', function()
{
	return View::make('home.index');
});

/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application.
|
*/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Router::register('GET /', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::filter('before', function()
{
	// Do stuff before every request to your application...

	if(Request::route()->bundle != "docs")
	{
		$exclude_requests = array('auth.login','auth.logout','auth.register','register');
		
		if(array_key_exists("as",Request::route()->action))
		{
			if(!in_array(Request::route()->action["as"],$exclude_requests))
			{
				Session::put('page',Request::route()->uri);
			}
		}
	}
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if(!Auth::check())
	{
		return Redirect::to_route('auth.login');
	}
	/*
	$route_perm = Request::route()->action["permission"];
	
	
	if (!Sentry::check()) 
				return Redirect::to_route('auth.login');
	else if(!Sentry::user()->has_access($route_perm))
				return Redirect::home()->with('error','Access failure.');
				*/
});