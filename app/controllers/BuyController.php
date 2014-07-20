<?php

/* TODO
 *
 * Add tag filtering & date filtering
 *
 */

class BuyController extends \BaseController {
	
	public function showCart()
	{	
		// show all items in the cart

		// meta
		$meta = (object) array(
			'title' 		=> 'Shopping Cart - Freeflow.me - 1 Art Piece Daily. A Project from Bryan Berger',
			'image_url' 	=> 'assets/imgs/vader_560.jpg' // my fav

		);

		// arguments
		$args = array(
			'meta'  	=> $meta,
		);

    	return View::make('buy.cart', $args);
	}

	public function addItemToCart()
	{
		// add this item to the cart class
	}

	public function updateItemInCart()
	{
		// update this item in the cart
	}

	public function placeOrder($id)
	{
		$post = Post::find($id);

		if (is_null($post))	{
			return Redirect::to('/');
		}

		$rules = array(
			'token'		=> 'required',
			'email'		=> 'required|email',
			'desc'		=> 'required',
			'printType'	=>	array('required', 'regex:/^(small|large)$/')
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the input
		if ($validator->fails()) {
			Session::flash('message', 'Payment failed...please tweet @bryanberger for assistance');
			//return $validator->messages();
			
			return Redirect::to('/')
				->withErrors($validator)
				->withInput();
		} else {
			$token		= Input::get('token');
			$email		= Input::get('email');
			$printType	= Input::get('printType');
			$desc		= Input::get('desc');

			$customer = Stripe_Customer::create(array(
				'email' => $email,
				'card'  => $token
			));

			$charge = Stripe_Charge::create(array(
				'customer' => $customer->id,
				'amount'   => (($printType == 'small') ? Config::get('prices.small.price') : Config::get('prices.large.price'))
								+ Config::get('prices.shipping.usa'),
				'description' => $name . " | " . $desc,
				'currency' => 'usd'
			));
		}

		return 'success';
	    //return View::make('buy.index', array('post' => $post));
	}

}