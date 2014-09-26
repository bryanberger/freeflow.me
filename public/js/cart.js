$(function(){
	var shippingRate = 26.00; 
	var fadeTime = 125;
	var total;

	function updateQuantityIcon(val) {
		if(val == 0) {
			$('.cart-quantity').hide();
			return;
		}

		$('.cart-quantity').fadeOut(250, function(){
			$(this).fadeIn(250);
			$('.cart-quantity').text(val);
		});
	}

	// Trigger animation on Add to Cart button click
	function addtocartclick() {
		$(this).addClass('active');
		$('.addtocart').off( "click");

		$.ajax({
			url: 'buy/' + $(this).data('id'),
			type: 'post',
			data: {size: $(this).data('size')},
			success: function(data) {
				json = JSON.parse(data);

				if (typeof json.success !== 'undefined' && $.isNumeric(json.success)) {
					//console.log("Item Added!");
					updateQuantityIcon(json.success);
				} else {
					//console.log("Item Failed");
				}
			},
			error: function(data) {
				//console.log("Ajax Error!");
			}
		}); // end ajax call


		setTimeout(function () {
			$('.addtocart').removeClass('active');
			$('.addtocart').on('click',addtocartclick);
		}, 1000);
	}
	$('.addtocart').on('click', addtocartclick);

	// Checkout click handler
	$('.checkout').on('click', function(){

		if($('.country').val() == "--") {

			// highlight error
			$('.country').addClass('highlight');

			// error
			$(this).addClass('animated shake');
			setTimeout(function(){
				$('.checkout').removeClass('animated shake');
			}, 1000);

			return;
		}

		$('.country').removeClass('highlight');

		var desc;
		var handler = StripeCheckout.configure({
			key: stripeToken,
			shippingAddress: true,
			billingAddress: false,
			allowRememberMe: true,
			zipCode: true,
			image: "http://freeflow.me/assets/imgs/secure.png",
			token: function(token, args) {
				$.ajax({
					url: '/buy/checkout',
					type: 'post',
					data: {token: token.id, email: token.email, card:token.card},
					success: function(data) {
						json = JSON.parse(data);

						if (typeof json.success !== 'undefined') {
							ga('send', 'event', 'buy', 'checkout', 'complete');
							$('.shopping-cart').html('<h3><span>Success!</span> Check your email for your order confirmation.</h3><p>We use a 3rd party printing company to produce the freeflows. Typically orders will take 5-10 business days for a complete turnaround.</p><p>The smaller 12x12" prints ship flat. The larger 24x24" prints ship in a heavy duty tube. We will send you an email with your tracking number once it has shipped!</p>');
							removeAllItems();
						} else {
							ga('send', 'event', 'buy', 'checkout', 'error');
							//console.log("Success Error...");
						}

					},
					error: function(data) {
						ga('send', 'event', 'buy', 'checkout', 'error');
						//console.log("Ajax Error...");
					}
				});			  
			}
		});

		// call buy service
		handler.open({
			name: 'Freeflow.me',
			description: $('.cart-quantity').text() + ' print(s) ($' + total + ')',
			amount: total * 100
		});

		return false;
	});

	/* Assign actions */
	$('.product-quantity input').change( function() {
	  updateQuantity(this);
	});

	$('.product-quantity input').keyup( function() {
	  updateQuantity(this);
	});

	$('.product-removal button').click( function() {
	  removeItem(this);
	});

	$('select.country').change( function() {
		if($(this).val() != "--") {
			$('.country').removeClass('highlight');
		} else {
			$('.country').addClass('highlight');
		}

	  	recalculateCart();
	});


	/* Recalculate cart */
	function recalculateCart()
	{
	  var subtotal = 0;
	  
	  /* Sum up row totals */
	  $('.product').each(function () {
	    subtotal += parseFloat($(this).children('.product-line-price').text());
	  });

	  // calc shipping
	  country = $('.country').val();
	  if(country === "US") {
	  	shippingRate = 7.00;
	  } else if(country === "CA") {
	  	shippingRate = 15.00;
	  } else if(country === "--") {
	  	shippingRate = 0.00;
	  } else {
	  	shippingRate = 26.00;
	  }
	  
	  /* Calculate totals */
	 // var tax = subtotal * taxRate;
	  var shipping = (subtotal > 0 ? shippingRate : 0);
	  //var total = subtotal + tax + shipping;
	  total = subtotal + shipping;
	  
	  /* Update totals display */
	  $('.totals-value').fadeOut(fadeTime, function() {
	    $('#cart-subtotal').html(subtotal.toFixed(2));
	   // $('#cart-tax').html(tax.toFixed(2));
	    $('#cart-shipping').html(shipping.toFixed(2));
	    $('#cart-total').html(total.toFixed(2));
	    if(total == 0){
	      $('.checkout').fadeOut(fadeTime);
	    }else{
	      $('.checkout').fadeIn(fadeTime);
	    }
	    $('.totals-value').fadeIn(fadeTime);
	  });
	}


	/* Update quantity */
	function updateQuantity(quantityInput)
	{
	  /* Calculate line price */
	  var productRow = $(quantityInput).parent().parent();
	  var price = parseFloat(productRow.children('.product-price').text());
	  var quantity = $(quantityInput).val();
	  var linePrice = price * quantity;
	  
	  /* Update line price display and recalc cart totals */
	  productRow.children('.product-line-price').each(function () {
	    $(this).fadeOut(fadeTime, function() {
	      $(this).text(linePrice.toFixed(2));
	      recalculateCart();
	      $(this).fadeIn(fadeTime);
	    });
	  });  

		// update service
		$.ajax({
			url: '/buy/update/' + productRow.data('id'),
			type: 'post',
			data: {qty: quantity},
			success: function(data) {
				json = JSON.parse(data);

				if (typeof json.success !== 'undefined' && $.isNumeric(json.success)) {
					//console.log("Item Quantity updated!");
					updateQuantityIcon(json.success);
				} else {
					//console.log("Item Quantity Error...");
				}

			},
			error: function(data) {
				//console.log("Ajax Error!");
			}
		});
	}


	/* Remove item from cart */
	function removeItem(removeButton)
	{
	  /* Remove row from DOM and recalc cart total */
	  var productRow = $(removeButton).parent().parent();
	  productRow.slideUp(fadeTime, function() {
	    productRow.remove();
	    recalculateCart();
	  });

		// remove single item
		$.ajax({
			url: '/buy/remove/' + productRow.data('id'),
			type: 'post',
			success: function(data) {
				json = JSON.parse(data);

				if (typeof json.success !== 'undefined' && $.isNumeric(json.success)) {
					//console.log("Item Removed!");
					updateQuantityIcon(json.success);
				} else {
					//console.log("Item Removed Error...");
				}

			},
			error: function(data) {
				//console.log("Ajax Error!");
			}
		});
	}


	function removeAllItems()
	{
		// destroy cart
		$.ajax({
			url: '/buy/destroy/',
			type: 'post',
			success: function(data) {
				json = JSON.parse(data);

				if (typeof json.success !== 'undefined' && $.isNumeric(json.success)) {
					//console.log("Items Removed!");
					$('.product').each(function () {
						$(this).remove();
					});
					updateQuantityIcon(json.success);
				} else {
					//console.log("Items Removed Error...");
				}

			},
			error: function(data) {
				//console.log("Ajax Error!");
			}
		});
	}

	recalculateCart();
});