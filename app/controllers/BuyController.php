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
			'token'			=> 'required',
			'email'			=> 'required|email',
			'card'			=> 'required|array',
			'coupon_id'		=> 'alpha_num',
			'coupon_value'	=> 'required_with:coupon_id|numeric'
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
				$token			= Input::get('token');
				$email			= Input::get('email');
				$card			= Input::get('card');
				$coupon_id		= Input::get('coupon_id');
				$coupon_value	= Input::get('coupon_value');
				$applyDiscount	= false;

				// shipping address country check (we will charge the proper ammount)
				$shipping	= $this->_getShipping($card['address_country']);
				$items		= Cart::content();
				$desc		= "";
				foreach ($items as $item) {
					$desc .= "(" . $item->qty . "x - #" . $item->post->id . " " . $item->name . " " . $item->options->desc . ") ";
				}

				// See if we have this customer already by email. If so save this charge to their Stripe Customer account.
				$customer = Customer::where('email', $email)->first();

				// If we don't have this customer, create a new one with Stripe and with our DB.
				if(!$customer) {
					$customer = Stripe_Customer::create(array(
						'email' => $email,
						'card'  => $token
					));

					// build a customer and save
					// should sanitize all of this data as we are taking it from the stripe callback as fact.
					$newCustomer = new Customer;
					$newCustomer->name = isset($card['name']) ? $card['name'] : '';
					$newCustomer->email = $email;
					$newCustomer->stripe_id = $customer->id;
					$newCustomer->address_line1 = isset($card['address_line1']) ? $card['address_line1'] : '';
					$newCustomer->address_line2 = isset($card['address_line2']) ? $card['address_line2'] : '';
					$newCustomer->address_city = isset($card['address_city']) ? $card['address_city'] : '';
					$newCustomer->address_state = isset($card['address_state']) ? $card['address_state'] : '';
					$newCustomer->address_zip = isset($card['address_zip']) ? $card['address_zip'] : '';
					$newCustomer->address_country = isset($card['address_country']) ? $card['address_country'] : '';
					$newCustomer->save();

					$customer = $newCustomer;
				}

				// reference total
				$total = Cart::total() * 100; // stripe wants no decimals

				// See if we have a coupon in the session, and pull it (remove it while getting its value)
				$coupon = Session::get('coupon');

				// A user has entered a valid coupon at some point since its in the session
				if($coupon) {
					// check if it matches the one sent to us
					if($coupon->id == $coupon_id && $coupon->value == $coupon_value) {
						// correct relationship of coupon id to value. apply it.
						$discount = $total * ($coupon->value/100);
						$total = $total - $discount;

						// store it in there customer table, new or old customers
						$coupons_used = unserialize($customer->coupons_used);

						// if the unserialized value is an array, push onto it or direct assign it as a serialized array.
						if(is_array($coupons_used)) {
							array_push($coupons_used, $coupon->id);
						} else {
							$coupons_used = array($coupon_id);
						}

						$customer->coupons_used = serialize($coupons_used);
						$customer->save();
					}

					// forget session value regardless.
					Session::forget('coupon');
				}

				$metadata = array('uid' => $customer->id);

				if($coupon) {
					$metadata['coupon_id'] = $coupon->id;
					$metadata['coupon_value'] = $coupon->value;
				}

				$charge = Stripe_Charge::create(array(
					'customer'		=> $customer->stripe_id,
					'amount'		=> $total + $shipping,
					'description'	=> $desc,
					'currency'		=> 'usd',
					'metadata'		=> $metadata
				));
				
				return '{"success":"charged"}';

			} catch(Stripe_CardError $e) {
				// Payment failed
				return '{"error":"Your Payment has failed. Your Credit Card may have been declined."}';
			}
		}
	}

	public function validateCoupon()
	{
		$rules = array(
			'coupon' => 'required|alpha_num'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the input
		if ($validator->fails()) {
			return '{"error":"validator failure."}';
		} else {
			$coupon	= strtolower(trim(Input::get('coupon')));

			// hit stripe and ask if the coupon is valid
			try {
				$coupon = Stripe_Coupon::retrieve($coupon);

				// store the coupon code and value in the session to be used if they check out, clear this out eventually?
				Session::put('coupon', (object) array('id' => $coupon->id, 'value' => $coupon->percent_off));

				return '{"success":"' . $coupon->percent_off . '"}';

			} catch(Stripe_InvalidRequestError $e) {
				return '{"error":"invalid coupon."}';
			}
		}
		
		return '{"error":"invalid coupon."}';
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