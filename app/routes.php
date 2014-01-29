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

// Main index
Route::get('/', 'HomeController@showIndex');

// Admin Routes
Route::group(array('before' => 'auth.basic'), function(){
    Route::resource('admin', 'AdminController');
});

// Route::get('admin', array('before' => 'auth.basic',
//             'uses' => 'AdminController@showIndex'));

// Route::get('admin/edit/{id}', 'AdminController@showEdit')->where('id', '\d+');



// detail routes
Route::get('{name}', function($name)
{
	 if (empty($name)) {
	 	return Redirect::to('/');
	 }

	return View::make('detail', array(
		'id' => $name,
		'cdn_path' => 'https://dl.dropboxusercontent.com/u/584602/freeflow.me/imgs/art/'));
})
->where('name', '[a-z]+');

