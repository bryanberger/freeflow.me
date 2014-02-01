@extends('layouts.master')
@section('content')
<ul id="tmbs" class="row grid">
@for ($i = 0; $i < $count; $i++)
	<?php $post = $posts->get($i); ?>

	@if ($i === 0)
		<li class="column grid-first"><a href="/{{ $post->filename }}"><img src="{{ $cdn_path . $post->filename}}_560.jpg"></a></li>
	@elseif ($i === 1)
		<li class="column grid1 alt1 alt2"><a href="/{{ $post->filename }}"><img src="{{ $cdn_path . $post->filename}}_560.jpg"></a></li>
	@elseif ($i === 2)
		<li class="column grid1"><a href="/{{ $post->filename }}"><img src="{{ $cdn_path . $post->filename}}_560.jpg"></a></li>
	@elseif ($i === 3)
		<li class="column grid1 alt2"><a href="/{{ $post->filename }}"><img src="{{ $cdn_path . $post->filename}}_560.jpg"></a></li>
	@elseif ($i === 4)
		<li class="column grid1 alt1"><a href="/{{ $post->filename }}"><img src="{{ $cdn_path . $post->filename}}_560.jpg"></a></li>
	@else
		<li class="column grid1"><a href="/{{ $post->filename }}"><img src="{{ $cdn_path . $post->filename}}_560.jpg"></a></li>
	@endif

@endfor
</ul>
@stop