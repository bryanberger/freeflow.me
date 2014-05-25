@extends('layouts.master')
@section('content')

<script src="https://checkout.stripe.com/checkout.js"></script>

<div class="grid3 detail-col">
	<img src="{{ $cdn_path }}840/{{ $post->filename }}_840.jpg" alt="{{ $post->name }}" width="840">
</div>
<div class="grid2 details detail-col">
	<div class="title">
		<h2>{{ $post->name }}</h2>
		<ul>
			@if (isset($prev))
				<li class="prev"><a href="{{ $prev->filename }}"><span class="sprite icnArrowLeft"></span>older</a></li>
			@endif
			@if (isset($next))
				<li class="next"><a href="{{ $next->filename }}">newer<span class="sprite icnArrowRight"></span></a></li>
			@endif
		</ul>
	</div>

	<p title="the time this post was created" class="date">This piece was created roughly <span>{{ TimeAgo::time_passed($post->created_at) }}</span> and is #{{ $post->sequence_number }} of {{ $max_days }}</p>
	
	<ul class="tags">
	@foreach ($post->tags as $tag)
		<li class="tag">{{ $tag }}</li>
	@endforeach
	</ul>

	<hr>

	@if ($post->hasBuyOptions)
		<table class="buy-options" border="0" cellpadding="0" cellspacing="0">
		  <tbody>
			<tr>
			  <td class="title" colspan="2"><b>Print Options:</b></td>
			</tr>
			<tr class="first">
			  <td class="print-size">{{ Config::get('prices.small.name') }}</td>
			  <td class="print-price">{{ Config::get('prices.small.pretty_price') }}</td>
			  <td><button class="btn" data-type="small" data-name="{{ Config::get('prices.small.name') }}" data-pretty-price="{{ Config::get('prices.small.pretty_price') }}" data-price="{{ Config::get('prices.small.price') }}" href="#">Add to Cart</button></td>
			</tr>
			<tr>
			 <td class="print-size">{{ Config::get('prices.large.name') }}</td>
			  <td class="print-price">{{ Config::get('prices.large.pretty_price') }}</td>
			  <td><button class="btn" data-type="large" data-name="{{ Config::get('prices.large.name') }}" data-pretty-price="{{ Config::get('prices.large.pretty_price') }}" data-price="{{ Config::get('prices.large.price') }}" href="#">Add to Cart</button></td>
			</tr>
		  </tbody>
		</table>
		<p class="print-desc">All prints are printed on Kodak Professional Endura Paper with a Lustre finish and half-inch white border. The total printed area is 11x11 / 23x23 inches. All prints are protected by foam and encased inside of a thick packing tube to ensure their safe delivery.</p>
		<table class="shipping" border="0" cellpadding="0" cellspacing="0">
		  <tbody>
			<tr>
			  <td class="title" colspan="2"><b>Shipping cost:</b></td>
			</tr>
			<tr>
			  <td class="shipping-location">USA</td>
			  <td class="shipping-price" align="right">+ $7.00</td>
			</tr>
			<tr>
			  <td class="shipping-location">International</td>
			  <td class="shipping-price" align="right">+ $26.00</td>
			</tr>
		  </tbody>
		</table>
	@else
		<p class="sale-not-avail">
		Prints coming soon. <br><br>
		All prints will be printed on High quality Kodak Professional Endura Paper with a Lustre finish. A half inch white border
		will be added.<br><br>
		Available print sizes: 12x12in. and 24x24in.
		</p>
	@endif

	<hr>

	@if ($post->hasWallpaper)
		<p>
			<a class="download" download data-name="{{ $post->filename }}" title="Download Wallaper" href="{{ $cdn_path . 'wp/' .$post->filename . '_2560x1440.jpg' }}">
				<span class="sprite icnDownload"></span>Download Wallpaper</a> (2560x1440)
		</p>
	@endif

<!--
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
-->

</div>
@stop