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
				<li class="prev"><a href="{{ $prev->filename }}"><span class="sprite icnArrowLeft"></span>previous</a></li>
			@endif
			@if (isset($next))
				<li class="next"><a href="{{ $next->filename }}">next<span class="sprite icnArrowRight"></span></a></li>
			@endif
		</ul>
	</div>

	<p title="the time this post was created" class="date">This piece was created <span>{{ TimeAgo::time_passed($post->created_at) }}</span> and is #{{ $post->sequence_number }} of {{ $max_days }}</p>
	
	<ul class="tags">
	@foreach ($post->tags as $tag)
		<li class="tag">{{ $tag }}</li>
	@endforeach
	</ul>

	<hr>

	@if ($post->hasBuyOptions)
		<dl class="sale">
			<dt>For Sale</dt>
			<dd>
				<ul>
					<li>12in = $24.00</li>
					<li>24in = $32.00</li>
				</ul>
			</dd>
		</dl>
		<p class="print-desc">Printed on 70# Satin Premium Photo Paper. Each size is limited to numbered edition of 100. Includes half-inch white border. Total printed area: 11x11 / 23x23 inches. All prints are ensconced in deluxe padding before being tucked into heavy duty packing tubes to ensure their safe delivery to you.</p>
		<table class="shipping" border="0" cellpadding="0" cellspacing="0">
		  <tbody>
			<tr>
			  <td class="title" colspan="2"><b>Shipping cost:</b></td>
			</tr>
			<tr>
			  <td class="shipping-location">USA</td>
			  <td align="right">+ $10.00</td>
			</tr>
			<tr>
			  <td class="shipping-location">International</td>
			  <td align="right">+ $35.00</td>
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