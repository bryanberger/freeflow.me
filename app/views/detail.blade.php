@extends('layouts.master')
@section('content')

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
			  <td class="print-size">12x12 in</td>
			  <td class="print-price">$8.00</td>
			  <td><button class="btn" href="#">Buy now</button></td>
			</tr>
			<tr>
			  <td class="print-size">24x24 in</td>
			  <td class="print-price">$36.00</td>
			  <td><button class="btn" href="#">Buy now</button></td>
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
</div>
@stop