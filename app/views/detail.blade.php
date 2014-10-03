@extends('layouts.master')
@section('content')

<section class="details-container">
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

		@if($post->palette)
		<ul class="palette">
		@foreach ($post->palette as $hex)
			<li class="color" style="background-color:{{ $hex }}" title="{{ $hex }}"></li>
		@endforeach
		</ul>
		@endif

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
					<td>
						<div class="button">
							<a class="addtocart" data-size="small" data-id="{{ $post->id }}">
								<div class="add">Add to Cart</div>
								<div class="added">Added!</div>
							</a>
						</div>
					</td>
				</tr>
				<tr>
				 <td class="print-size">{{ Config::get('prices.large.name') }}</td>
				  <td class="print-price">{{ Config::get('prices.large.pretty_price') }}</td>
					<td>
						<div class="button">
							<a class="addtocart" data-size="large" data-id="{{ $post->id }}">
								<div class="add">Add to Cart</div>
								<div class="added">Added!</div>
							</a>
						</div>
					</td>
				</tr>
			  </tbody>
			</table>
			<p class="print-desc">All prints are printed on Kodak Professional Endura Paper with a Lustre finish and half-inch white border. The total printed area is 11x11 / 23x23 inches. All prints are protected by foam and encased inside of a thick packing tube to ensure their safe delivery.</p>
			
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
				<a class="download btn" download data-name="{{ $post->filename }}" title="Download Wallaper" href="{{ $cdn_path . 'wp/' .$post->filename . '_2560x1440.jpg' }}">
					<span class="sprite icnDownload"></span>Download FREE Wallpaper</a> (2560x1440)
			</p>
		@endif
	</div>
</section>

<section class="extras">
	<h3>In case you missed a few:</h3>
	<ul id="tmbs" class="row grid">
	@for ($i = 0; $i < count($prev4); $i++)
		<?php $p = $prev4[$i]; ?>
		@if(is_object($p))
			<li class="column grid1"><a href="/{{ $p->filename }}"><img src="{{ $cdn_path . $p->filename}}_560.jpg"></a></li>
		@endif
	@endfor
	</ul>
</section>
@stop