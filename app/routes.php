<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('home', array(
		'cdn_path' => 'https://dl.dropboxusercontent.com/u/584602/freeflow.me/imgs/art/'));
});

Route::get('/detail/{id}', function($id)
{
	 if (empty($id)) {
	 	return Redirect::to('/');
	 }

	return View::make('detail', array(
		'id' => $id,
		'cdn_path' => 'https://dl.dropboxusercontent.com/u/584602/freeflow.me/imgs/art/'));
})
->where('id', '\d+');