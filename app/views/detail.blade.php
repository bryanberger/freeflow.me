@extends('layouts.master')
@section('content')

<div class="grid3">
	<img src="{{ $cdn_path }}840/{{ $post->filename }}_840.jpg">
</div>
<div class="grid2 details">
	<h2>{{ $post->name }}</h2>
	<h3>Tags: {{ $post->tags }}</h3>
	<p>Created {{ TimeAgo::time_passed($post->created_at) }}</p>
	<dl>
		<dt>Prices:</dt>
		<dd>
			<ul>
				<li>12in = $24.00</li>
				<li>24in = $32.00</li>
			</ul>
		</dd>
	</dl>
	<p>Some default description text about the print paper quality and shipping information</p>

	@if ($post->hasWallpaper)
	<p>{{ link_to($cdn_path . 'wp/' .$post->filename . '_2560x1440.jpg', "Download Wallpaper (2560x1440)") }}</p>
	@endif

	<ul>
		@if (isset($prev))
			<li><a href="{{ $prev->filename }}">Previous</a></li>
		@endif
		@if (isset($next))
			<li><a href="{{ $next->filename }}">Next</a></li>
		@endif
	</ul>
</div>
@stop