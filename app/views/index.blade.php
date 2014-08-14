@extends('layouts.master')
@section('content')
<ul id="tmbs" class="row grid">
@for ($i = 0; $i < $count; $i++)
	<?php $p = $posts->get($i); ?>

@if($posts->getCurrentPage() === 1)
	@if ($i === 0)
		<li class="column grid-first"><a href="/{{ $p->filename }}"><div class="title"><div><span class="num">#{{ $p->id }}</span>{{" : $p->name"}}</div></div><img src="{{ $cdn_path . $p->filename}}_560.jpg"></a></li>
	@elseif ($i === 1)
		<li class="column grid1 alt1 alt2"><a href="/{{ $p->filename }}"><div class="title"><div><span class="num">#{{ $p->id }}</span>{{" : $p->name"}}</div></div><img src="{{ $cdn_path . $p->filename}}_560.jpg"></a></li>
	@elseif ($i === 2)
		<li class="column grid1"><a href="/{{ $p->filename }}"><div class="title"><div><span class="num">#{{ $p->id }}</span>{{" : $p->name"}}</div></div><img src="{{ $cdn_path . $p->filename}}_560.jpg"></a></li>
	@elseif ($i === 3)
		<li class="column grid1 alt2"><a href="/{{ $p->filename }}"><div class="title"><div><span class="num">#{{ $p->id }}</span>{{" : $p->name"}}</div></div><img src="{{ $cdn_path . $p->filename}}_560.jpg"></a></li>
	@elseif ($i === 4)
		<li class="column grid1 alt1"><a href="/{{ $p->filename }}"><div class="title"><div><span class="num">#{{ $p->id }}</span>{{" : $p->name"}}</div></div><img src="{{ $cdn_path . $p->filename}}_560.jpg"></a></li>
	@else
		<li class="column grid1"><a href="/{{ $p->filename }}"><div class="title"><div><span class="num">#{{ $p->id }}</span>{{" : $p->name"}}</div></div><img src="{{ $cdn_path . $p->filename}}_560.jpg"></a></li>
	@endif
@else
	<li class="column grid1"><a href="/{{ $p->filename }}"><div class="title"><div><span class="num">#{{ $p->id }}</span>{{" : $p->name"}}</div></div><img src="{{ $cdn_path . $p->filename}}_560.jpg"></a></li>
@endif

@endfor
</ul>
<section class="centered">{{ $posts->links(); }}</section>
@stop