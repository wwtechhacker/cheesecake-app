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
	Route::get('admin/user', array(
		'as' => 'admin.user.list', 'uses' => 'admin.user@list', 'permission' => 'admin.user'));
	Route::any('admin/user/edit/(:num)', array(
		'as' => 'admin.user.edit', 'uses' => 'admin.user@edit', 'permission' => 'admin.user'));
	Route::get('admin/user/delete/(:num)', array(
		'as' => 'admin.user.delete', 'uses' => 'admin.user@delete', 'permission' => 'admin.user'));
});

Route::any('login', array('as' => 'auth.login', 'uses' => 'user@login'));
Route::get('logout', array('as' => 'auth.logout', 'uses' => 'user@logout'));

//
//		FORUMS
//

Route::get('forums', array('as' => 'forum.home', 'uses' => 'forum@index'));
Route::get('forums/board/(:any)', array('as' => 'forum.board', 'uses' => 'forum@board'));
Route::get('forums/board/(:num)/thread/(:num)/(:any?)', array(
	'as' => 'forum.board.thread', 'uses' => 'forum@thread'));

//
//		END FORUMS
//

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
	$route_perm = Request::route()->action["permission"];
	
	
	if (!Sentry::check()) 
				return Redirect::to_route('auth.login');
	else if(!Sentry::user()->has_access($route_perm))
				return Redirect::home()->with('error','Access failure.');
});