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
Route::get('/', 'ViewController@showIndex');

// Admin Routes
Route::group(array('before' => 'auth.basic'), function(){
	Route::resource('admin', 'AdminController');
});

// Site Map
Route::get('sitemap', 'SitemapController@show');

// Stripe
Route::post('/buy/{id}', 'BuyController@addItemToCart')->where('id', '[0-9]+');
Route::post('/buy/update/{rowId}', 'BuyController@updateItemInCart')->where('rowId', '[a-z0-9_]+');
Route::post('/buy/remove/{rowId}', 'BuyController@removeItemFromCart')->where('rowId', '[a-z0-9_]+');
Route::post('/buy/validate', 'BuyController@validateCoupon');
Route::post('/buy/checkout', 'BuyController@checkout');
Route::post('/buy/destroy', 'BuyController@destroy');
Route::get('/buy/cart', 'BuyController@showCart');

// detail routes
Route::get('{name}', array(
	'as' 	 => 'post',
	'uses'	 => 'ViewController@showDetail'))
		->where('name', '[a-z0-9]+');
Route::get('{name}/download', 'ViewController@download')->where('name', '[a-z0-9]+');