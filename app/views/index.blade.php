@extends('layouts.master')
@section('content')
<ul id="tmbs" class="row grid">
@foreach($posts as $post)
	@if ($post->id === $count)
    	<li class="column grid-first"><a href="/{{ $post->filename }}"><img src="{{ $cdn_path . $post->filename}}_560.jpg"></a></li>
	@elseif ($post->id === $count-1)
		<li class="column grid1 alt1 alt2"><a href="/{{ $post->filename }}"><img src="{{ $cdn_path . $post->filename}}_560.jpg"></a></li>
	@elseif ($post->id === $count-2)
		<li class="column grid1"><a href="/{{ $post->filename }}"><img src="{{ $cdn_path . $post->filename}}_560.jpg"></a></li>
	@elseif ($post->id === $count-3)
		<li class="column grid1 alt2"><a href="/{{ $post->filename }}"><img src="{{ $cdn_path . $post->filename}}_560.jpg"></a></li>
	@elseif ($post->id === $count-4)
		<li class="column grid1 alt1"><a href="/{{ $post->filename }}"><img src="{{ $cdn_path . $post->filename}}_560.jpg"></a></li>
	@else
		<li class="column grid1"><a href="/{{ $post->filename }}"><img src="{{ $cdn_path . $post->filename}}_560.jpg"></a></li>
	@endif
@endforeach
</ul>
@stop