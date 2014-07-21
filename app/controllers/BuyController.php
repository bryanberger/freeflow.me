<?php

/* TODO
 *
 * Add tag filtering & date filtering
 *
 */

class BuyController extends \BaseController {
	
	public function showCart()
	{	
		// meta
		$meta = (object) array(
			'title' 		=> 'Your Shopping Cart - Freeflow.me - 1 Art Piece Daily. A Project from Bryan Berger',
			'image_url' 	=> 'assets/imgs/vader_560.jpg' // my fav

		);

		// arguments
		$args = array(
			'meta'  		=> $meta,
			'cart'			=> Cart::content(),
			'cart_count'	=> Cart::count(),
			'total'			=> Cart::total()
		);

    	return View::make('buy.cart', $args);
	}

	public function addItemToCart($id)
	{
		$post = Post::find($id);

		if (is_null($post))	{
			return Redirect::to('/');
		}

		$rules = array(
			'size' => array('required', 'regex:/^(small|large)$/')
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the input
		if ($validator->fails()) {
			Session::flash('message', 'An error occurred trying to add this project...please tweet @bryanberger for assistance');
			
			return Redirect::to('/')
				->withErrors($validator)
				->withInput();
		} else {
			$size	= Input::get('size');
			$price	= (($size == 'small') ? Config::get('prices.small.price') : Config::get('prices.large.price'));
			$desc	= (($size == 'small') ? Config::get('prices.small.name') : Config::get('prices.large.name')) . " Limited Edition Lustre Finish Print";
			$uniqueId = $post->id."_".$size;

			// check if already in cart, if so add quanity increment
			$rowIds = Cart::search( array('id' => $uniqueId) ); 

			if($rowIds) {
				// we should have a single item that matches
				$this->incrementQty($rowIds[0]);
			} else {
				// new item associate with the post model, access variables from the model as $item->post->filename
				Cart::associate('Post')->add($uniqueId, $post->name, 1, $price, 
					array(
						'size'  => $size,
						'desc'	=> $desc
					)
				);
			}
		}

		return '{"success":'.Cart::count().'}';
	}

	public function incrementQty($rowId) {
		$qty = Cart::get($rowId)->qty + 1;
		Cart::update($rowId, $qty);
	}

	public function updateItemInCart($rowId)
	{
		// find the item
		$rowIds = Cart::search( array('id' => $rowId) );

		// redirect if item doesn't exist
		if(!$rowIds) {
			Session::flash('message', 'Sorry...that item is not in your cart, please try to add it again or tweet @bryanberger for assistance');
			return Redirect::to('/buy/cart');
		}

		$rules = array(
			'qty' => array('required', 'integer')
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the input
		if ($validator->fails()) {
			Session::flash('message', 'An error occurred trying to update this item...please tweet @bryanberger for assistance');
			
			return Redirect::to('/')
				->withErrors($validator)
				->withInput();
		} else {
			// update this item in the cart
			$qty = Input::get('qty');
			//return $qty;
			Cart::update($rowIds[0], $qty);
		}

		return '{"success":'.Cart::count().'}';		
	}
	
	public function removeItemFromCart($rowId)
	{
		// find the item
		$rowIds = Cart::search( array('id' => $rowId) );

		// redirect if item doesn't exist
		if(!$rowIds) {
			Session::flash('message', 'Sorry...that item is not in your cart, please try to add it again or tweet @bryanberger for assistance');
			return Redirect::to('/buy/cart');
		}

		Cart::remove($rowIds[0]);

		return '{"success":'.Cart::count().'}';
	}

	public function destroy()
	{
		Cart::destroy();
		return '{"success":0}';	
	}

	public function checkout()
	{
		$rules = array(
			'token'		=> 'required',
			'email'		=> 'required|email',
			'card'		=> 'required|array'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the input
		if ($validator->fails()) {
			Session::flash('message', 'Payment failed...please tweet @bryanberger for assistance');
			
			return Redirect::to('/')
				->withErrors($validator)
				->withInput();
		} else {
			try {
				$token		= Input::get('token');
				$email		= Input::get('email');
				$card		= Input::get('card');
				$customer	= "";
				// shipping address country check (we will charge the proper ammount)
				$shipping	= $this->_getShipping($card['address_country']);
				$items		= Cart::content();
				$desc		= "";
				foreach ($items as $item) {
					$desc .= "(" . $item->qty . "x - " . $item->name . " " . $item->options->desc . ") ";
				}

				if($card['id']) {
					$customer = $card;
				} else {
					$customer = Stripe_Customer::create(array(
						'email' => $email,
						'card'  => $token
					));
				}

				$charge = Stripe_Charge::create(array(
					'customer'		=> $customer->id,
					'amount'		=> (Cart::total()*100) + $shipping,
					'description'	=> $desc,
					'currency'		=> 'usd'
				));
				
				//Session::put('purchased_download_id', $download->id);
				return '{"success":"charged"}';

			} catch(Stripe_CardError $e) {
				// Payment failed
				return false;
				//return Redirect::to('/buy/cart')->with('message', 'Your payment has failed.');		
			}
		}

		//return '{"success":1}'; // success or fail page
		//return View::make('buy.success');
	}

	private function _getShipping($country)
	{
		$country = strtolower($country);

		if($country === "united states") {
			return Config::get('prices.shipping.us');
		} else if($country === "canada") {
			return Config::get('prices.shipping.ca');
		} else {
			return Config::get('prices.shipping.international');
		}
	}

}