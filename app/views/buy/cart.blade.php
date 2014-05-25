@extends('layouts.master')
@section('content')

<script src="https://checkout.stripe.com/checkout.js"></script>

<h2>Shopping Card Example</h2>
<div ng:controller="CartForm">
    <table class="table">
        <tr>
            
            <th>Description</th>
            <th>Qty</th>
            <th>Cost</th>
            <th>Total</th>
            <th></th>
        </tr>
        <tr ng:repeat="item in invoice.items">
            <td><input type="text" ng:model="item.description"class="input-small"></td>           
            <td><input type="number" ng:model="item.qty" ng:required class="input-mini"></td>
            <td><input type="number" ng:model="item.cost" ng:required class="input-mini"></td>
            <td>{{item.qty * item.cost | currency}}</td>
            <td>
                [<a href ng:click="removeItem($index)">X</a>]
            </td>
        </tr>
        <tr>
            <td><a href ng:click="addItem()" class="btn btn-small">add item</a></td>
            <td></td>
            <td>Total:</td>
            <td>{{total() | currency}}</td>
        </tr>
    </table>
</div>



<script>
	$(function(){
	  var printType;
	  var handler = StripeCheckout.configure({
		key: '@stripeKey',
		shippingAddress: true,
		billingAddress: false,
		allowRememberMe: true,
		token: function(token, args) {

		  console.log(token, args);

		  $.ajax({
			  url: 'buy/{{ $post->id }}',
			  type: 'post',
			  data: {token: token.id, email: token.email, printType: printType},
			 //  success: function(data) {
				// if (data == 'success') {
				// 	console.log("Card successfully charged!");
				// }
				// else {
				// 	console.log("Success Error!");
				// }

			 //  },
			 //  error: function(data) {
				// console.log("Ajax Error!");
			 //  }
			}); // end ajax call

		  
		}
	  });


		$('.btn').click(function() {

			printType = $(this).data('type');

			handler.open({
				name: '{{ $post->name }}',
				description: $(this).data('name') + ' Print - ' + $(this).data('pretty-price'),
				amount: $(this).data('price')
			});

			return false;
	  	});
	});
</script>


</div>
@stop