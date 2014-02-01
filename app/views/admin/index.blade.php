@extends('layouts.admin.master')
@section('content')
<h1>All Posts ({{ $posts->count() }})</h1>

<!-- will be used to show any messages -->
@if (Session::has('message'))
	<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

<table class="table table-striped table-bordered table-condensed">
	<thead>
		<tr>
			<td>ID</td>
			<td>Name</td>
			<td>Thumbnail</td>
			<td>Date Posted</td>
			<td>Has Wallpaper?</td>
			<td>For Sale?</td>
			<td>Delete</td>
		</tr>
	</thead>
	<tbody>
	@foreach($posts as $post)
		<tr>
			<td>{{ $post->id }}</td>
			<td><b>{{ $post->name }}</b></td>
			<td><a href="admin/{{ $post->id }}/edit"><img width="80" height="80" src="{{ $cdn_path . $post->filename}}_560.jpg"></a></td>
			<td>{{ TimeAgo::time_passed($post->created_at) }}</td>
			<td>
				@if ( $post->hasWallpaper )
					<div class="btn btn-success"></div>
				@else
					<div class="btn btn-warning"></div>
				@endif
			</td>
			<td>
				@if ( $post->hasBuyOptions )
					<div class="btn btn-success"></div>
				@else
					<div class="btn btn-warning"></div>
				@endif
			</td>
			<td>
				{{ Form::open(array('url' => 'admin/' . $post->id)) }}
					{{ Form::hidden('_method', 'DELETE') }}
					{{ Form::submit('x', array('class' => 'btn btn-danger')) }}
				{{ Form::close() }}
			</td>
		</tr>
	@endforeach
	</tbody>
</table>
@stop

